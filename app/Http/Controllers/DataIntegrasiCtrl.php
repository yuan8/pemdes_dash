<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Nahid\JsonQ\Jsonq;
use Carbon\Carbon;
use Auth;
use HP;
class DataIntegrasiCtrl extends Controller
{

	public $agent;
	public function __construct() {
		  $this->middleware(function ($request, $next) {
		        $this->agent = Auth::guard('api')->user();

       			 return $next($request);
   		 });
    	
    }

	



	public function get_data_desa($tahun,$id,Request $request){
		$data=DB::table('tb_data as dt')->where('dt.id',$id)
        ->leftJoin('tb_data_detail_map as dtm','dtm.id_data','=','dt.id')
        ->leftJoin('master_table_map as map','map.id','=','dtm.id_map')
        ->selectRaw("dt.*,dtm.id_map,map.inheritance,map.start_level,map.stop_level,map.table")
        ->where('type','INTEGRASI')->first();

        
        if($data){
        	$maping=HP::level_build($data,$request->kode_daerah,!$data->inheritance,0);

	        	$maping['column'][]=$maping['level_data']['child']['column_name'].' as name ';
	        	$maping['column'][]=$maping['level_data']['child']['column_id'].' as id';
	        	
        		$maping['column'][]="da.stapem as status_desa";
        		$maping['column'][]="da.nmkabkota as nama_kota";
        		$maping['column'][]="da.nmkecamatan as nama_kecamatan";



        	
        	


	        $data_query=
	        DB::table($maping['level_data']['child']['table'].' as da')
			->join($maping['data_table'],
				[
				[
					DB::raw("left(dt.kode_desa,".($maping['level_data']['child']['count']==0?2:$maping['level_data']['child']['count']).")"),
					'=',
					$maping['level_data']['child']['column_id']
				],
				['dt.tahun','=',DB::raw($tahun)]
				]
			)
			->selectRaw(implode(',',$maping['column']))
			->groupBy($maping['level_data']['child']['column_id'])
			->orderBy($maping['level_data']['child']['column_id'],'asc')
			->where('dt.tahun','=',DB::raw($tahun))
			->where('dt.kode_desa','like',DB::raw("'".$maping['level_data']['kode_daerah'].'%'."'"))
			->get();


		}

		return view('show_data.view.table_desa')->with([
			'data'=>$data_query,
			'table_meta'=>$maping,
			''
		]);


	}

	public function get_data($tahun,$id,Request $request){

		$data=DB::table('tb_data as dt')->where('dt.id',$id)
        ->leftJoin('tb_data_detail_map as dtm','dtm.id_data','=','dt.id')
        ->leftJoin('master_table_map as map','map.id','=','dtm.id_map')
        ->selectRaw("dt.*,dtm.id_map,map.inheritance,map.start_level,map.stop_level,map.table")
        ->where('type','INTEGRASI')->first();

        if($data){
        	$maping=HP::level_build($data,$request->kode_daerah,!$data->inheritance,0);


        	$maping['column'][]=$maping['level_data']['child']['column_name'].' as name ';
        	$maping['column'][]=$maping['level_data']['child']['column_id'].' as id';
        	if($maping['level_data']['child']['count']!=10){
        		$maping['column'][]="(select count(distinct(jd.kddesa)) from master_desa as jd where left(jd.kddesa,".$maping['level_data']['child']['count'].") =da.".$maping['level_data']['child']['column_id']." ) as jumlah_desa";

        		$maping['column'][]="count(distinct(dt.kode_desa)) as jumlah_data_desa";
        	}else{
        		$maping['column'][]="da.stapem as status_desa";
        		$maping['column'][]="da.nmkabkota as nama_kota";
        		$maping['column'][]="da.nmkecamatan as nama_kecamatan";



        	}
        	


	        $data_query=
	        DB::table($maping['level_data']['child']['table'].' as da')
			->join($maping['data_table'],
				[
				[
					DB::raw("left(dt.kode_desa,".($maping['level_data']['child']['count']==0?2:$maping['level_data']['child']['count']).")"),
					'=',
					$maping['level_data']['child']['column_id']
				],
				['dt.tahun','=',DB::raw($tahun)]
				]
			)
			->selectRaw(implode(',',$maping['column']))
			->groupBy($maping['level_data']['child']['column_id'])
			->orderBy($maping['level_data']['child']['column_id'],'asc')
			->where('dt.tahun','=',DB::raw($tahun))
			->where('dt.kode_desa','like',DB::raw("'".$maping['level_data']['kode_daerah'].'%'."'"))
			->get();






			
			$data_type=[];
			$data_type['series']=static::data_series(null,$data_query,$maping,$maping['level_data']['child'],$data->id,'INT');
			$data_type['series_map']=static::data_map(null,$data_query,$maping,$maping['level_data']['child'],$data->id,'INT');

			$data_type['data_sort']=static::rekap_data($data_query,$maping,4);
			$data_type['data']=$data_query;




			
			if(isset($maping['view_'][$maping['level_data']['child']['count']==0?2:$maping['level_data']['child']['count']])){
			$meta_entity=$maping['view_'][$maping['level_data']['child']['count']==0?2:$maping['level_data']['child']['count']];

			}else{
				$meta_entity=[];
			}



			$id_c='chart_id_'.rand(0,100).'_'.date('Ymdhi');
			$return='<div class="row " id="'.$id_c.'">';
			if(count($meta_entity)==0){
				$return.='<div class="col-md-12"><h4 class="text-center">DATA TIDAK TERSEDIA</h4></div>';
			}

			$datenow=Carbon::now()->format('d F Y');


			foreach ($meta_entity as $key => $value) {
				foreach($value as $v){

						$return.='<div class="table-responsive ch col-md-'.(12/count($value)).' col-lg-'.(12/count($value)).'">'.view('show_data.view.'.$v)->with([
						'data_type'=>$data_type,
						'title'=>strtoupper($data->title.' '.$maping['level_data']['daerah']),
						'subtitle'=>'Capaian Tahun '.($tahun).' - '.$datenow,
						'level'=>$maping['level_data']['child']['count']==0?2:$maping['level_data']['child']['count'],
						'level_meta'=>$maping['level_data']['child'],
						'kdparent'=>$maping['level_data']['kode_daerah'],
						'pemda'=>'',
						'table_meta'=>$maping,
						'data'=>$data,
						'tahun_capaian'=>$tahun,
					])->render().'</div>';
					
				}
			}
			$return.='</div>
			';

			return $return;
        }







	}

    public function build_sql(){



    }


    static function sort_data($data,$sort='DESC'){
		if(count($data)){
			if($sort=='DESC'){
			uasort($data,function($a,$b){
				if ($a['value']==$b['value']){
					return 0;
				}else{
					return ($a['value']<$b['value'])?1:-1;

				} 
			});
		}else{
			uasort($data,function($a,$b){
				if ($a['value']==$b['value']){
					return 0;
				}else{
					return ($a['value']<$b['value'])?-1:1;

				} 
			});
		}
		$data= array_values($data);

		}

		return $data;
	}

	static function rekap_data($data,$map,$get=4){
		$data='{"data":'.json_encode($data).'}';
		$jsonq = new Jsonq($data);

		$data=$jsonq->from('data');
		$columns=$map['columns'];
		$columns=array_values($columns);

		$sum=[];


		foreach ($columns as $key => $value) {
				if(!in_array($value['aggregate_type'],['NONE'])){
					$x=$value;
					$x['value']=$jsonq->sum('data_'.$key);
					$x['y']=$x['value'];
					$sum[$key]=$x;
				}

		}

		$sum=static::sort_data($sum,'DESC');
		
		$else=[];
		foreach ($sum as $key => $value) {
			if($key>$get){

				if(!in_array($value['aggregate_type'],['NONE'])){
					if(!isset($else[$value['satuan']])){
						$else[$value['satuan']]=[
							'name'=>$value['name'].' Lainya ('.$value['satuan'].')',
							'value'=>(float)$value['value'],
							'y'=>(float)$value['y'],
							'key'=>'...',
							'satuan'=>$value['satuan'],
							'name_column'=>'',
							'auth'=>0,
							'dashboard'=>1,
							'validate'=>1,
							'aggregate_type'=>$value['aggregate_type']
						];
					}else{
						$else[$value['satuan']]['value']+=(float)$value['value'];
						$else[$value['satuan']]['y']+=(float)$value['y'];

					}
				}
			}
		}	

		$else=array_values($else);


		return [
			'else_max'=>$else,
			'max'=>array_slice($sum,0, $get),
			'min'=>array_slice(static::sort_data($sum,'ASC'),$get)
		] ;

	}


    public static function data_series($table,$data,$map,$level,$md,$jenis='INT'){

		$D=[];

		$satuan=[];
		$SATUAN_X=[];
		foreach($data as $d){
			$d=(Array)$d;
			foreach (array_values($map['columns']) as $k => $m) {
				if(!isset($satuan[$m['satuan']])){
					$satuan[$m['satuan']]=$m['satuan'];
				}

				$SATUAN_X=array_values($satuan);

				# code...
				if(!isset($D[$k])){
					$D[$k]=[
						'name'=>$m['name'],
						'yAxis'=>array_search($m['satuan'], $SATUAN_X),
						'visible'=>($k>config('proepdeskel.chart.series.max_series_show',5))?false:true,
						'data'=>[]

					];
				}

				$ROUTE_NEXT=null;


				if($jenis=='INT'){
					$ROUTE_NEXT=$level['count']!=10?route('vs.data.integrasi',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'kode_daerah'=>$d['id']]):null;
				}else{
					$ROUTE_NEXT=($level['count'])?route('vs.data.visual',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'kdparent'=>$d['id']]):null;
				}


				

				$D[$k]['data'][]=[
					'id'=>$d['id'],
					'name'=>$d['name'],
					'y'=>(float)$d['data_'.$k]??0,
					'value'=>(float)$d['data_'.$k]??0,
					'satuan'=>$d['data_'.$k.'_satuan'],
					'route'=>$ROUTE_NEXT,
					'next_dom'=>$level['count']!=10?$level['child']['count']:null,

				];


			}

		}

		$yAxis=[];

		foreach ($SATUAN_X as $key => $y) {
			$yAxis[]=[
				'gridLineDashStyle'=>((($key+1)%2)==0)?'longdash':'solid',
				'label'=>[
					'format'=>'{value} '.$y
				],
				'title'=>[
					'text'=>$y
				],
				'opposite'=>((($key+1)%2)==0)?1:0,
			];
		}


		return [
			'yAxis'=>$yAxis,
			'data'=>
			array_values($D)
		];
	}


	public static function data_map($table,$data,$map,$level,$md,$jenis='INT'){

		$D=[];

		$satuan=[];

		foreach($data as $d){
			$d=(Array)$d;
			if(!isset($d['jumlah_desa'])){
				$d['jumlah_desa']=1;
			}


			if(!isset($d['jumlah_data_desa'])){
				$d['jumlah_data_desa']=1;
			}

			$data_map=[];
			$data_map[0]=[
				'name'=>'Keterisian Data',
				'y'=>(((float)$d['jumlah_data_desa']!=0) AND ((float)$d['jumlah_desa']!=0) )?(
					((float)$d['jumlah_data_desa'])/((float)$d['jumlah_desa'])*100
				):0,
				'satuan'=>'%',
				
			];
			$data_map[0]['value']=(float)$data_map[0]['y'];

			$data_map[1]=[
				'name'=>'Jumlah Desa',
				'y'=>(((float)$d['jumlah_desa'])),
				'value'=>(((float)$d['jumlah_desa'])),
				'satuan'=>'Desa',
			];
			$data_map[2]=[
				'name'=>'Jumlah Desa Terdata',
				'y'=>(((float)$d['jumlah_data_desa'])),
				'value'=>(((float)$d['jumlah_data_desa'])),
				'satuan'=>'Desa',
			];



			
			$ROUTE_NEXT='';

			if($jenis=='INT'){
					$ROUTE_NEXT=$level['count']!=10?route('vs.data.integrasi',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'kode_daerah'=>$d['id']]):null;
				}else{
					$ROUTE_NEXT=($level['count'])?route('vs.data.visual',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'kdparent'=>$d['id']]):null;
				}


			$D[]=[

				'name'=>$d['name'],
				'id'=>$d['id'],
				'value'=>$data_map[0]['y'],
				'y'=>$data_map[0]['y'],
				'route'=>$ROUTE_NEXT,
				'next_dom'=>$level['count']!=10?$level['child']['count']:null,
				'data_map'=>$data_map
			];

		}




		return [
			'yAxis'=>[

			],
			'data'=>
			array_values($D)
		];
	}
}
