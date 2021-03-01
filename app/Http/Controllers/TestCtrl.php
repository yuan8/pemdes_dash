<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use YDB;
use HPV;
class TestCtrl extends Controller
{


	public function view($tahun,$id,$slug=null){
		$data=DB::table('data')->where(['id'=>$id,'type'=>'TABLE'])->first();
		if($data){
			return view('view_data.test')->with('data',$data);
		}

	}

	public function tb($tahun,$id,$slug=null){
		$data=[];
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
		$map=HPV::table_agre($table);
		$level=HPV::level($request->kdparent??null);


		if($map and $level){
			$meta_table=HPV::table_data($table);

			if($request->kdparent){
			$nama_pemda=((array)DB::table($level['parent']['table'])
			->selectRaw($level['parent']['table_name'].' as name')->where($level['parent']['table_kode'],$request->kdparent)->first())['name'];
			}else{
				$nama_pemda=$meta_table['name'].' Per Provinsi';
			}


			$select='kd.'.$level['table_kode']." as id, kd.".$level['table_name']." as name ".($level['count']!=10?", (select count(distinct(dds.kode_bps)) from master_desa as dds where left(dds.kode_bps,".$level['count'].") = kd.".$level['table_kode']." ) as jumlah_desa , count(distinct(data.kode_desa)) as jumlah_data_desa":'');

			foreach ($map['entity'] as $key => $value) {
				$OP=HPV::translate_operator($value['aggregate']);

				$select.=" , ".$OP[1]."data.".$value['tag'].$OP[2].' as data_'.$key.", '".$value['satuan']."' as data_".$key."_satuan";
			}

			$data=DB::table($level['table'].' as kd')
			->leftjoin('validasi_confirm as cfm',[
				[DB::raw("left(cfm.kode_desa,".$level['count'].")"),'=',DB::RAW("kd.".$level['table_kode'])],
				['cfm.table','=',DB::raw("'".$table."'")],
				['cfm.tahun','=',DB::raw($tahun)]
			])
			->leftjoin($map['table'].' as data',[
				[DB::raw("(data.kode_desa)"),'=','cfm.kode_desa'],['data.tahun','=',DB::raw($tahun)]])
			->selectRaw($select)
			->groupBy(('kd.'.$level['table_kode']) )
			->whereRaw('(kd.'.$level['table_kode']." <> '0' and kd.".$level['table_kode']." <> '00') ")
			->get();


			$data_type=[
				'data'=>$data
			];

			$data_type['series']=static::data_series($table,$data,$map,$level)['data'];
			$data_type['series_map']=static::data_map($table,$data,$map,$level)['data'];

			$meta_entity=$meta_table['view_'][$level['count']];
				
			$return='<h3 class="text-center "><b>'.$nama_pemda.'</b></h3><hr><div class="row">';
			foreach ($meta_entity as $key => $value) {
				foreach($value as $v){
					$return.='<div class="table-responsive col-md-'.(12/count($value)).' col-lg-'.(12/count($value)).'">'.view('view_data.'.$v)->with([
						'data_type'=>$data_type,
						'title'=>$meta_table['name'],
						'level'=>$level['count'],
						'level_meta'=>$level,
						'kdparent'=>$level['kode'],
						'table_meta'=>$map,
					])->render().'</div>';
				}
			}
			$return.='</div>';


			
			return ($return!='')?$return:'TIDAK TERDAPAT DATA';

		}

	}


	
	public static function data_series($table,$data,$map,$level){

		$D=[];

		$satuan=[];

		foreach($data as $d){
			$d=(Array)$d;
			foreach ($map['entity'] as $k => $m) {
				# code...
				if(!isset($D[$m['tag']])){
					$D[$m['tag']]=[
						'name'=>(HPV::translate_operator($m['aggregate']))[0].' '.$m['name'],
						'data'=>[]

					];
				}

				if(!isset($satuan[$d['data_'.$k.'_satuan']])){
					$satuan[$d['data_'.$k.'_satuan']]=$d['data_'.$k.'_satuan'];
				}

				$SATUAN_X=array_values($satuan);

				$D[$m['tag']]['data'][]=[
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
			foreach ($map['entity'] as $k => $m) {
				# code...
				
				$data_map[]=[
					'name'=>(HPV::translate_operator($m['aggregate']))[0].' '.$m['name'],
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