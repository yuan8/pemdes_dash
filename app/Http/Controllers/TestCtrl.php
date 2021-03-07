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
class TestCtrl extends Controller
{
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
			'subtitle'=>'Capaian Tahun '.($tahun-1).' - '.$datenow,
		])->render().view('view_data.table')->with([
			'level'=>$data['level'],
			'title'=>$data['title'],
			'type'=>$data['type'],
			'data_type'=>$data['data_type'],
			'level_meta'=>$data['level_meta'],
			'table_meta'=>$data['table_meta'],
			'only1level'=>true,
			'subtitle'=>'Capaian Tahun '.($tahun-1).' - '.$datenow])
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

			return view('view_data.test')->with('data',$data);

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
				$nama_pemda=$meta_data->name.' Per Provinsi';
			}




			$select= "cfm.id as id_cmf, "."'".$id."'".' as id_data,'.' kd.'.$level['table_kode']." as id, kd.".$level['table_name']." as name ".($level['count']!=10?", (select count(distinct(dds.kode_bps)) from master_desa as dds where left(dds.kode_bps,".$level['count'].") = kd.".$level['table_kode']." ) as jumlah_desa , count(distinct(data.kode_desa)) as jumlah_data_desa":'');

			foreach (array_values($meta_table['columns']) as $key => $value) {
				$OP=HPV::translate_operator($value['aggregate_type']);
				$select.=" , ".$OP[1]." data.".$value['name_column'].$OP[2].' as data_'.$key." , '".$value['satuan']."' as data_".$key."_satuan";

			}


			$data=[];

			$paginate=50;
		    Paginator::currentPageResolver(function ()  {
		        return 1;
		    });
			$x=DB::table(DB::raw("(select *  from ".$level['table']." as ddd where ddd.".$level['table_kode']." like '".($level['kode']?$level['kode'].'%':"%")."') as kd"))

			->leftjoin('validasi_confirm as cfm',[
				['cfm.kode_desa','=',$level['table_kode']],
				['cfm.table','=',DB::raw("'".$table."'")],
				['cfm.tahun','=',DB::raw($tahun-1)]
			])
			->leftjoin(DB::raw("(select * from ".$meta_table['table']." as dxdx where dxdx.kode_desa like '".($level['kode']?$level['kode'].'%':"%")."') as data"),
				[
				[DB::raw("(data.kode_desa)"),'=','cfm.kode_desa'],['data.tahun','=',DB::raw($tahun-1)]])
			->selectRaw($select)
			->groupBy(('kd.'.$level['table_kode']) )
			->whereRaw('(kd.'.$level['table_kode']." <> '0' and kd.".$level['table_kode']." <> '00') ")
			->orderBy('kd.'.$level['table_kode'], 'asc')
			->paginate($paginate)->toArray();

			$data=$x['data'];

			if($paginate<$x['total']){

				for ($p=2;$p<=$x['last_page'];$p++) {
					$_REQUEST['page']=$p;
					 Paginator::currentPageResolver(function () use ($p)  {
				        return $p;
				    });

					$y=DB::table(DB::raw("(select *  from ".$level['table']." as ddd where ddd.".$level['table_kode']." like '".($level['kode']?$level['kode'].'%':"%")."') as kd"))

					->leftjoin('validasi_confirm as cfm',[
						['cfm.kode_desa','=',$level['table_kode']],
						['cfm.table','=',DB::raw("'".$table."'")],
						['cfm.tahun','=',DB::raw($tahun-1)]
					])
					->leftjoin(DB::raw("(select * from ".$meta_table['table']." as dxdx where dxdx.kode_desa like '".($level['kode']?$level['kode'].'%':"%")."') as data"),
						[
						[DB::raw("(data.kode_desa)"),'=','cfm.kode_desa'],['data.tahun','=',DB::raw($tahun-1)]])
					->selectRaw($select)
					->groupBy(('kd.'.$level['table_kode']) )
					->whereRaw('(kd.'.$level['table_kode']." <> '0' and kd.".$level['table_kode']." <> '00') ")
					->orderBy('kd.'.$level['table_kode'], 'asc')
					->paginate($paginate)->toArray();
					$data=array_merge($data,$y['data']);
				}
			}
			


			$data_type=[
				'data'=>$data
			];

			$data_type['series']=static::data_series($meta_table['key_view'],$data,$meta_table,$level,$id);
			$data_type['series_map']=static::data_map($meta_table['key_view'],$data,$meta_table,$level,$id);


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
						'subtitle'=>'Capaian Tahun '.($tahun-1).' - '.$datenow,
						'level'=>$level['count'],
						'level_meta'=>$level,
						'kdparent'=>$level['kode'],
						'table_meta'=>$meta_table,
						'tahun_capaian'=>$tahun-1,
					])->render().'</div>';
					
				}
			}
			$return.='</div>
			';


			
			return ($return!='')?$return:'TIDAK TERDAPAT DATA';

		}

	}


	
	public static function data_series($table,$data,$map,$level,$md){

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
						'data'=>[]

					];
				}


				

				$D[$m['name_column']]['data'][]=[
					'id'=>$d['id'],
					'name'=>$d['name'],
					'y'=>(float)$d['data_'.$k]??0,
					'value'=>(float)$d['data_'.$k]??0,
					'satuan'=>$d['data_'.$k.'_satuan'],
					'route'=>($level['count'])?route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'table'=>$table,'kdparent'=>$d['id']]):null,
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


	public static function data_map($table,$data,$map,$level,$md){

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

			$data_map=[[
				'name'=>'Keterisian Data',
				'y'=>(float)$d['jumlah_data_desa']!=0?HPV::nformat((float)((float)$d['jumlah_data_desa']/(float)$d['jumlah_desa'])*100??0,null,3):0,
				'value'=>(float)$d['jumlah_data_desa']!=0?HPV::nformat((float)((float)$d['jumlah_data_desa']/(float)$d['jumlah_desa'])*100??0,null,3):0,
				'satuan'=>'%',
				]
			];
			foreach (array_values($map['columns']) as $k => $m) {
				# code...
				
				$data_map[]=[
					'name'=>(HPV::translate_operator($m['aggregate_type']))[0].' '.$m['name'],
					'y'=>(float)$d['data_'.$k]??0,
					'value'=>(float)$d['data_'.$k]??0,
					'satuan'=>$d['data_'.$k.'_satuan'],
				];

			}
			$D[]=[

				'name'=>$d['name'],
				'id'=>$d['id'],
				'value'=>((float)$d['jumlah_data_desa']!=0)?((float)((float)$d['jumlah_data_desa']/(float)$d['jumlah_desa'])*100??0):0,
				'y'=>((float)$d['jumlah_data_desa']!=0)?((float)((float)$d['jumlah_data_desa']/(float)$d['jumlah_desa'])*100??0):0,
				'route'=>($level['count'])?route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$md,'table'=>$table,'kdparent'=>$d['id']]):null,
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