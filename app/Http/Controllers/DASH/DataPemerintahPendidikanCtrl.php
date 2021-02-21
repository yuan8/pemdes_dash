<?php

namespace App\Http\Controllers\DASH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class DataPemerintahPendidikanCtrl extends Controller
{

	public function index(Request $request){

		return view('dash.potensi.pemerintahan.pendidikan');
	}

	public function get_jp_provinsi(){


		$DATA=[
			

		];

		$dd=DB::table('provinsi as p')
		->leftJoin('dash_potensi_lembaga_pemerintahan as d','p.kdprovinsi','=',DB::RAW("left(d.kode_desa,2)"))
		->selectRaw(
			"	p.kdprovinsi as kodepemda,
				max(p.nmprovinsi) as name,
				count(distinct(d.kode_desa)) as jumlah_desa,
				count((case when (Pendidikan_Kepala_Desa_Lurah='SLTP') then 1 else null end ))  as KADES_PEN_SMP,
				count((case when (Pendidikan_Kepala_Desa_Lurah='SLTA') then 1 else null end ))  as KADES_PEN_SMA,
				count((case when (Pendidikan_Kepala_Desa_Lurah='SD') then 1 else null end ))  as KADES_PEN_SD,
				count((case when (Pendidikan_Kepala_Desa_Lurah='S1') then 1 else null end ))  as KADES_PEN_S1,
				count((case when (Pendidikan_Kepala_Desa_Lurah='S2') then 1 else null end ))  as KADES_PEN_S2,
				count((case when (Pendidikan_Kepala_Desa_Lurah='S3') then 1 else null end ))  as KADES_PEN_S3,
				count((case when (Pendidikan_Kepala_Desa_Lurah='DIPL') then 1 else null end ))  as KADES_PEN_DIPLOMA,
				count((case when (Pendidikan_Sekretaris_Desa_Kelurahan='SLTP') then 1 else null end ))  as SEKDES_PEN_SMP,
				count((case when (Pendidikan_Sekretaris_Desa_Kelurahan='SLTA') then 1 else null end ))  as SEKDES_PEN_SMA,
				count((case when (Pendidikan_Sekretaris_Desa_Kelurahan='SD') then 1 else null end ))  as SEKDES_PEN_SD,
				count((case when (Pendidikan_Sekretaris_Desa_Kelurahan='S1') then 1 else null end ))  as SEKDES_PEN_S1,
				count((case when (Pendidikan_Sekretaris_Desa_Kelurahan='S2') then 1 else null end ))  as SEKDES_PEN_S2,
				count((case when (Pendidikan_Sekretaris_Desa_Kelurahan='S3') then 1 else null end ))  as SEKDES_PEN_S3,
				count((case when (Pendidikan_Sekretaris_Desa_Kelurahan='DIPL') then 1 else null end ))  as SEKDES_PEN_DIPLOMA,
				count((case when (pendidikan_Kepala_Urusan_Seksi_Umum='SLTP') then 1 else null end ))  as 'KAUR / KASI_PEN_SMP',
				count((case when (pendidikan_Kepala_Urusan_Seksi_Umum='SLTA') then 1 else null end ))  as 'KAUR / KASI_PEN_SMA',
				count((case when (pendidikan_Kepala_Urusan_Seksi_Umum='SD') then 1 else null end ))  as 'KAUR / KASI_PEN_SD',
				count((case when (pendidikan_Kepala_Urusan_Seksi_Umum='S1') then 1 else null end ))  as 'KAUR / KASI_PEN_S1',
				count((case when (pendidikan_Kepala_Urusan_Seksi_Umum='S2') then 1 else null end ))  as 'KAUR / KASI_PEN_S2',
				count((case when (pendidikan_Kepala_Urusan_Seksi_Umum='S3') then 1 else null end ))  as 'KAUR / KASI_PEN_S3',
				count((case when (pendidikan_Kepala_Urusan_Seksi_Umum='DIPL') then 1 else null end ))  as 'KAUR / KASI_PEN_DIPLOMA'

			"
		)->
		whereNotIn('p.kdprovinsi',['0','00'])
		->groupBy('p.kdprovinsi')->get();
		foreach ($dd as $key => $value) {
			$value=(ARRAY)$value;
			foreach ($value as $key1 => $d) {
				if(strpos($key1,'_PEN_')){
				$n=explode('_',$key1);
				if(!isset($DATA[$n[0]][$value['kodepemda']])){
					$DATA[$n[0]][$value['kodepemda']]=[
						'name'=>$value['name'],
						'id'=>$value['kodepemda'],
						'route'=>route('d.potensi.pem.pendidikan.k',['kodepemda'=>$value['kodepemda']]),
						'data'=>[
							'JUMLAH_DESA'=>
							[
								'name'=>'JUMLAH DESA',
								'value'=>$value['jumlah_desa'],
								'y'=>$value['jumlah_desa'],
								'satuan'=>'Desa'
							],
							'SD'=>[
								'name'=>'SD',
								'value'=>0,
								'y'=>0,
								'satuan'=>'Jiwa'
							],
							'SMP'=>[
								'name'=>'SMP',
								'value'=>0,
								'y'=>0,
								'satuan'=>'Jiwa'
							],
							'SMA'=>[
								'name'=>'SMA',
								'value'=>0,
								'y'=>0,
								'satuan'=>'Jiwa'
							],
							'DIPLOMA'=>[
								'name'=>'DIPLOMA',
								'value'=>0,
								'y'=>0,
								'satuan'=>'Jiwa'
							],
							'S1'=>[
								'name'=>'S1',
								'value'=>0,
								'y'=>0,
								'satuan'=>'Jiwa'
							],
							'S2'=>[
								'name'=>'S2',
								'value'=>0,
								'y'=>0,
								'satuan'=>'Jiwa'
							],
							'S3'=>[
								'name'=>'S3',
								'value'=>0,
								'y'=>0,
								'satuan'=>'Jiwa'
							]
						]
					];



				}
			
				$DATA[$n[0]][$value['kodepemda']]['data'][$n[2]]=
				[
					'name'=>$n[2],
					'y'=>(float)$d,
					'value'=>(float)$d,
					'satuan'=>isset($DATA[$n[0]][$value['kodepemda']]['data'][$n[2]]['satuan'])?$DATA[$n[0]][$value['kodepemda']]['data'][$n[2]]['satuan']:''
				];
				

				// if(!isset($DATA[$n[0]][$n[2]])){
					
				// 	$DATA[$n[0]][$n[2]]=[
				// 		'name'=>$n[2],
				// 		'satuan'=>'Jiwa',
				// 		'data'=>[]
				// 	];
				// }

				// $DATA[$n[0]][$n[2]]['data'][$value['kodepemda']]=[
				// 	'name'=>$value['name'],
				// 	'id'=>$value['kodepemda'],
				// 	'y'=>(float)$d,
				// 	'value'=>(float)$d
				// ];



			}
				# code...
			}
			

			
		}

		$return='';
		foreach ($DATA as $key => $d){
			foreach ($d as $key1 => $value) {
				$DATA[$key][$key1]['data']=array_values($value['data']);
			}
			$DATA[$key]=array_values($DATA[$key]);


			$return.=view('chart.table_2_axis')->with([
				'series'=>$DATA[$key],
				'chart'=>[
					'chart.bar',
					'chart.table_2_axis'
				],
				'title'=>'PENDIDIKAN '.$key.' PER PROVINSI'

			]);


		}



		return $return;



	}

}