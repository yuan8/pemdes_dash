<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use YDB;
use HPV;
use MyHash;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Nahid\JsonQ\Jsonq;
class TestCtrl extends Controller
{

	public function req(Request $request){

		dd($request->all());

	}



	public function tt(){
		$x=DB::connection('mysql')->table('dash_potensi_iklim_tanah_erosi')->first();

		foreach($x as $k=>$v){
			if(!in_array($k,['kode_desa','tahun','tanggal','bulan'])){
				DB::table('master_column_map')->insertOrIgnore([
				'name_column'=>$k,
				'aggregate_type'=>'SUM',
				'name'=>strtoupper(str_replace('_', ' ', $k)),
				'satuan'=>'Km2',
				'auth'=>0,
				'dashboard'=>1,
				'validate'=>1,
				'id_user'=>1,
				'id_ms_table'=>10
				
			]);
			}
		}

		// $x=DB::table('dash_potensi_luas_wilayah')->get();

		// foreach($x as $k=>$v){
		// 	// if(!in_array($k,['kode_desa','tahun','tanggal','bulan'])){
		// 	// 	DB::table('master_column_map')->insertOrIgnore([
		// 	// 	'name_column'=>$k,
		// 	// 	'aggregate_type'=>'SUM',
		// 	// 	'name'=>strtoupper(str_replace('_', ' ', $k)),
		// 	// 	'satuan'=>'Jiwa',
		// 	// 	'auth'=>0,
		// 	// 	'dashboard'=>1,
		// 	// 	'validate'=>1,
		// 	// 	'id_user'=>1,
		// 	// 	'id_ms_table'=>7
				
		// 	// ]);
		// 	// }

		// 	DB::table('dash_potensi_jenis_lahan')->insertOrIgnore([
		// 		'table'=>'dash_potensi_jenis_lahan',
		// 		'kode_desa'=>$v->kode_desa,
		// 		'id_user'=>1,
		// 		'tahun'=>2021,
		// 		'tanggal_validasi'=>Carbon::now(),
			
		// 	]);
		// }

		dd('s');
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
				if(in_array($value['aggregate_type'],['SUM','COUNT','COUNT_DISTINCT'])){
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
				if(in_array($value['aggregate_type'],['SUM','COUNT','COUNT_DISTINCT'])){
					if(!isset($else[$value['satuan']])){
						$else[$value['satuan']]=[
							'name'=>$map['name'].' Lainya ('.$value['satuan'].')',
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

	public function offline_donwload($tahun,Request $request){
		$data=json_decode(base64_decode($request->data),true);
		header('Content-disposition: attachment; filename=' . $data['title'].'.html');
		header('Content-type: text/html');
		$datenow=Carbon::now()->format('d F Y');
		$GLOBALS['tahun_access']=$tahun;
		return view('view_data.chart_offline')->with([
			'level'=>$data['level'],
			'title'=>$data['title'],
			'type'=>$data['type'],
			'data_type'=>$data['data_type'],
			'lavel_meta'=>$data['level_meta'],
			'table_meta'=>$data['table_meta'],
			'subtitle'=>'Capaian Tahun '.($tahun).' - '.$datenow,
		])->render().view('view_data.table')->with([
			'level'=>$data['level'],
			'title'=>$data['title'],
			'type'=>$data['type'],
			'data_type'=>$data['data_type'],
			'level_meta'=>$data['level_meta'],
			'table_meta'=>$data['table_meta'],
			'only1level'=>true,
			'subtitle'=>'Capaian Tahun '.($tahun).' - '.$datenow])
		->render();


	}



	public function view($tahun,$id,$slug=null){

		$data=DB::table('data as d')
		->join('category as c',[['c.id','=','d.organization_id'],['c.type','=',DB::raw("'INSTANSI'")]])
		->selectRaw("d.*, c.name as i_name,c.id as i_id,c.type as i_type")
		->where(['d.id'=>$id,'d.type'=>'INTEGRASI']);
		$data=$data->first();

	
		if($data){

			if(!Auth::check()){
				if($data->auth!=false){
					$GLOBALS['ab_message']=['title'=>$data->name];
					return abort('401');
				}
			}

			return view('view_data.test')->with(['data'=>$data,'hm'=>true]);

		}else{
			$GLOBALS['ab_message']=['title'=>$data->name];
			return abort('404')->with('title',$data->name);
		}

	}

	
	public function index($tahun,$id,$table,Request $request){
		$meta_data=DB::table('data as d')->where('id',$id);
		if(!Auth::check()){
			$meta_data=$meta_data->where('d.auth',false);
		}

		$meta_data=$meta_data->first();

		if(!$meta_data){

				return view('view_data.api_no_access');
		}


		$meta_table=HPV::gen_map($meta_data->table_view,1);

		if(!$meta_table){
			return abort(404);
		}
			

		$table=$meta_table['table'];



		$level=HPV::level($request->kdparent??null);

		if($meta_table and $level){
			if($request->kdparent){
			$nama_pemda=((array)DB::table($level['parent']['table'])
			->selectRaw($level['parent']['table_name'].' as name')->where($level['parent']['table_kode'],$request->kdparent)->first())['name'];
			}else{
				$nama_pemda='Per Provinsi';
			}




			$select= 
			// "cfm.id as id_cmf, ".
			"'".$id."'".' as id_data,'.' kd.'.$level['table_kode']." as id, kd.".$level['table_name']." as name ".($level['count']!=10?", (select count(distinct(dds.kode_bps)) from master_desa as dds where left(dds.kode_bps,".$level['count'].") = kd.".$level['table_kode']." ) as jumlah_desa , count(distinct(data.kode_desa)) as jumlah_data_desa":'');

			foreach (array_values($meta_table['columns']) as $key => $value) {
				$OP=HPV::translate_operator($value['aggregate_type']);
				$select.=" , ".$OP[1]." data.".$value['name_column'].$OP[2].' as data_'.$key." , '".$value['satuan']."' as data_".$key."_satuan";

			}



			$data=[];

			$paginate=200;
		    Paginator::currentPageResolver(function ()  {
		        return 1;
		    });


		    DB::enableQueryLog();
			$x=DB::table(DB::raw("(select *  from ".$level['table']." as ddd where ddd.".$level['table_kode']." like '".($level['kode']?$level['kode'].'%':"%")."') as kd"))

			// ->leftjoin('validasi_confirm as cfm',[
			// 	[DB::RAW("LEFT(cfm.kode_desa,".$level['count'].")"),'=',$level['table_kode']],
			// 	['cfm.table','=',DB::raw("'".$table."'")],
			// 	['cfm.tahun','=',DB::raw($tahun)]
			// ])
			->leftjoin(DB::raw("(select * from ".$meta_table['table']." as dxdx where dxdx.kode_desa like '".($level['kode']?$level['kode'].'%':"%")."') as data"),
				[
				[DB::raw("left(data.kode_desa,".$level['count'].")"),'=','kd.'.$level['table_kode']],['data.tahun','=',DB::raw($tahun)]])
			->selectRaw($select)
			->groupBy(('kd.'.$level['table_kode']) )
			->whereRaw('(kd.'.$level['table_kode']." <> '0' and kd.".$level['table_kode']." <> '00') ")
			->orderBy('kd.'.$level['table_kode'], 'asc')
			->paginate($paginate)->toArray();
			// $dd=(array)(DB::getQueryLog());
			// return ($dd[1]['query']);




			$data=$x['data'];

			if($paginate<$x['total']){

				for ($p=2;$p<=$x['last_page'];$p++) {
					$_REQUEST['page']=$p;
					 Paginator::currentPageResolver(function () use ($p)  {
				        return $p;
				    });

					$y=DB::table(DB::raw("(select *  from ".$level['table']." as ddd where ddd.".$level['table_kode']." like '".($level['kode']?$level['kode'].'%':"%")."') as kd"))

					->leftjoin('validasi_confirm as cfm',[
						[DB::RAW("LEFT(cfm.kode_desa,".$level['count'].")"),'=',$level['table_kode']],
						['cfm.table','=',DB::raw("'".$table."'")],
						['cfm.tahun','=',DB::raw($tahun)]
					])
					->leftjoin(DB::raw("(select * from ".$meta_table['table']." as dxdx where dxdx.kode_desa like '".($level['kode']?$level['kode'].'%':"%")."') as data"),
						[
						[DB::raw("(data.kode_desa)"),'=','cfm.kode_desa'],['data.tahun','=',DB::raw($tahun)]])
					->selectRaw($select)
					->groupBy(('kd.'.$level['table_kode']) )
					->whereRaw('(kd.'.$level['table_kode']." <> '0' and kd.".$level['table_kode']." <> '00') ")
					->orderBy('kd.'.$level['table_kode'], 'asc')
					->paginate($paginate)->toArray();
					$data=array_merge($data,$y['data']);
				}
			}
			
			// return ($data);

			$data_type=[
				'data'=>$data
			];


			$data_type['series']=static::data_series($meta_table['key_view'],$data,$meta_table,$level,$id);
			$data_type['series_map']=static::data_map($meta_table['key_view'],$data,$meta_table,$level,$id);

			$data_type['data_sort']=static::rekap_data($data,$meta_table,4);




			$meta_entity=isset($meta_table['view_'][$level['count']])?$meta_table['view_'][$level['count']]:[];
			$datenow=Carbon::now()->format('d F Y');
			
			$id_c='chart_id_'.rand(0,100).'_'.date('Ymdhi');
			$return='<div class="row " id="'.$id_c.'">';
			if(count($meta_entity)==0){
				$return.='<div class="col-md-12"><h4 class="text-center">DATA TIDAK TERSEDIA</h4></div>';
			}
			foreach ($meta_entity as $key => $value) {
				foreach($value as $v){
						$return.='<div class="table-responsive ch col-md-'.(12/count($value)).' col-lg-'.(12/count($value)).'">'.view('view_data.'.$v)->with([
						'data_type'=>$data_type,
						'title'=>strtoupper($meta_data->name),
						'subtitle'=>'Capaian Tahun '.($tahun).' - '.$datenow,
						'level'=>$level['count'],
						'level_meta'=>$level,
						'kdparent'=>$level['kode'],
						'pemda'=>$nama_pemda,
						'table_meta'=>$meta_table,
						'tahun_capaian'=>$tahun,
					])->render().'</div>';
					
				}
			}
			$return.='</div>
			';


			
			return ($return!='')?$return:'TIDAK TERDAPAT DATA';

		}

	}


	
	public static function data_series($table,$data,$map,$level,$md,$jenis='INT'){

		$D=[];

		$satuan=[];

		foreach($data as $d){
			$d=(Array)$d;
			foreach (array_values($map['columns']) as $k => $m) {
				if(!isset($satuan[$m['satuan']])){
					$satuan[$m['satuan']]=$m['satuan'];
				}

				$SATUAN_X=array_values($satuan);

				# code...
				if(!isset($D[$m['name_column']])){
					$D[$m['name_column']]=[
						'name'=>(HPV::translate_operator($m['aggregate_type']))[0].' '.$m['name'],
						'yAxis'=>array_search($m['satuan'], $SATUAN_X),
						'visible'=>($k>2)?false:true,
						'data'=>[]

					];
				}

				if($jenis=='INT'){
					$ROUTE_NEXT=($level['count'])?route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'table'=>$table,'kdparent'=>$d['id']]):null;
				}else{
					$ROUTE_NEXT=($level['count'])?route('visual.dataset',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'kdparent'=>$d['id']]):null;
				}
				

				$D[$m['name_column']]['data'][]=[
					'id'=>$d['id'],
					'name'=>$d['name'],
					'y'=>(float)$d['data_'.$k]??0,
					'value'=>(float)$d['data_'.$k]??0,
					'satuan'=>$d['data_'.$k.'_satuan'],
					'route'=>$ROUTE_NEXT,
					'next_dom'=>$level['count'],

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
				$d['jumlah_data_desa']=$d['id_cmf']?1:0;
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
			foreach (array_values($map['columns']) as $k => $m) {
				# code...
				
				if(strtoupper($d['data_'.$k.'_satuan'])=='DESA'){
					if($level['count']==10){
						$d['data_'.$k.'_satuan']='-';
						$d['data_'.$k]=($d['data_'.$k]?'Ada':'Tidak');
					}
				}

				$data_map[]=[
					'name'=>(HPV::translate_operator($m['aggregate_type']))[0].' '.$m['name'],
					'y'=>(float)$d['data_'.$k]??0,
					'value'=>(float)$d['data_'.$k]??0,
					'satuan'=>$d['data_'.$k.'_satuan'],
				];

			}

			if($jenis=='INT'){
				$ROUTE_NEXT=($level['count'])?route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'table'=>$table,'kdparent'=>$d['id']]):null;
			}else{
				$ROUTE_NEXT=($level['count'])?route('visual.dataset',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'kdparent'=>$d['id']]):null;
			}
			$D[]=[

				'name'=>$d['name'],
				'id'=>$d['id'],
				'value'=>$data_map[0]['y'],
				'y'=>$data_map[0]['y'],

				'route'=>$ROUTE_NEXT,
				'next_dom'=>$level['count'],
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