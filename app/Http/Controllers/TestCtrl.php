<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use YDB;
use HPV;
use MyHash;
use Auth;
use Carbon\Carbon;
class TestCtrl extends Controller
{
	public function offline_donwload(Request $request){
		$data=json_decode(base64_decode($request->data),true);
		// dd($data);
		header('Content-disposition: attachment; filename=' . $data['title'].'.html');
		header('Content-type: text/html');

		return view('view_data.chart_offline')->with([
			'level'=>$data['level'],
			'title'=>$data['title'],
			'type'=>$data['type'],
			'data_type'=>$data['data_type'],
		])->render();

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

	public function tb($tahun,$id,$slug=null){
		$data=[];

		return view('test')->with('data',MyHash::$pass_map);


		foreach(DB::table('dash_ddk_pendidikan')->first() as $k=>$d){
			$data[]=[
							'name'=>str_replace('_', ' ', $k),
							'tag'=>$k,
							'aggregate'=>'sum',
							'satuan'=>'Jiwa'
			];
		}

		return '<pre> '.str_replace('}',']',(str_replace('{','[',str_replace(':', '=>', json_encode($data,JSON_PRETTY_PRINT))))).'</pre>';

	}

	public function index($tahun,$table,Request $request){
		
		$meta_data=DB::table('data as d')->where('table_view',$table);

		if(!Auth::check()){
			$meta_data=$meta_data->where('d.auth',false);
		}

		$meta_data=$meta_data->first();

		if(!$meta_data){
			if($request->data_akses){

			}else{
				return view('view_data.api_no_access');
			}
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



			$select='kd.'.$level['table_kode']." as id, kd.".$level['table_name']." as name ".($level['count']!=10?", (select count(distinct(dds.kode_bps)) from master_desa as dds where left(dds.kode_bps,".$level['count'].") = kd.".$level['table_kode']." ) as jumlah_desa , count(distinct(data.kode_desa)) as jumlah_data_desa":'');

			foreach (array_values($meta_table['columns']) as $key => $value) {
				$OP=HPV::translate_operator($value['aggregate_type']);
				$select.=" , ".$OP[1]." data.".$value['name_column'].$OP[2].' as data_'.$key." , '".$value['satuan']."' as data_".$key."_satuan";

			}


			$data=DB::table($level['table'].' as kd')
			->leftjoin('validasi_confirm as cfm',[
				[DB::raw("left(cfm.kode_desa,".$level['count'].")"),'=',DB::RAW("kd.".$level['table_kode'])],
				['cfm.table','=',DB::raw("'".$table."'")],
				['cfm.tahun','=',DB::raw($tahun-1)]
			])
			->leftjoin($meta_table['table'].' as data',[
				[DB::raw("(data.kode_desa)"),'=','cfm.kode_desa'],['data.tahun','=',DB::raw($tahun-1)]])
			->selectRaw($select)
			->groupBy(('kd.'.$level['table_kode']) )
			->whereRaw('(kd.'.$level['table_kode']." <> '0' and kd.".$level['table_kode']." <> '00') ")
			->get();


			$data_type=[
				'data'=>$data
			];

			$data_type['series']=static::data_series($meta_table['key_view'],$data,$meta_table,$level)['data'];
			$data_type['series_map']=static::data_map($meta_table['key_view'],$data,$meta_table,$level)['data'];


			$meta_entity=$meta_table['view_'][$level['count']];

			$datenow=Carbon::now()->format('d F Y');
			
			$id_c='chart_id_'.rand(0,100).'_'.date('Ymdhi');

			$return='<div class="row " id="'.$id_c.'">';
			foreach ($meta_entity as $key => $value) {
				foreach($value as $v){
					foreach ($v as $keyc => $vi) {
						$return.='<div class="table-responsive ch col-md-'.(12/count($v)).' col-lg-'.(12/count($v)).'">'.view('view_data.'.$vi)->with([
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
			}
			$return.='</div>
			';


			
			return ($return!='')?$return:'TIDAK TERDAPAT DATA';

		}

	}


	
	public static function data_series($table,$data,$map,$level){

		$D=[];

		$satuan=[];

		foreach($data as $d){
			$d=(Array)$d;
			foreach (array_values($map['columns']) as $k => $m) {
				# code...
				if(!isset($D[$m['name_column']])){
					$D[$m['name_column']]=[
						'name'=>(HPV::translate_operator($m['aggregate_type']))[0].' '.$m['name'],
						'data'=>[]

					];
				}

				if(!isset($satuan[$d['data_'.$k.'_satuan']])){
					$satuan[$d['data_'.$k.'_satuan']]=$d['data_'.$k.'_satuan'];
				}

				$SATUAN_X=array_values($satuan);

				$D[$m['name_column']]['data'][]=[
					'id'=>$d['id'],
					'name'=>$d['name'],
					'y'=>(float)$d['data_'.$k]??0,
					'value'=>(float)$d['data_'.$k]??0,
					'satuan'=>$d['data_'.$k.'_satuan'],
					'route'=>($level['count'])?route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'table'=>$table,'kdparent'=>$d['id']]):null,
					'next_dom'=>$level['count'],
					'yAxis'=>array_search($d['data_'.$k.'_satuan'], $SATUAN_X)

				];

			}
		}



		return [
			'yAxis'=>[


			],
			'data'=>
			array_values($D)
		];

	}


	public static function data_map($table,$data,$map,$level){

		$D=[];

		$satuan=[];

		foreach($data as $d){
			$d=(Array)$d;

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
				'route'=>($level['count'])?route('visual.data.table',['tahun'=>$GLOBALS['tahun_access'],'table'=>$table,'kdparent'=>$d['id']]):null,
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