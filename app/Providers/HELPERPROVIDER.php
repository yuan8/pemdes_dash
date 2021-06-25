<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Storage;
use DB;
use Auth;
class HELPERPROVIDER extends ServiceProvider
{

	static function user_role($role){
		switch ($role) {
			case 1:

				return [
					'text'=>'SUPERADMIN',

				];
				# code...
				break;
			case 2:
				return [
					'text'=>'WALIDATA DAERAH',
					
				];
				# code...
				break;
			
			default:
				# code...
				break;
		}
	}
	static function gen_map($e,$context=1,$kdparent=null){

		if($kdparent==null and $context==1){
			$kdparent='00';
		}else if($kdparent==null and $context==2){
			$kdparent='000000000000';

		}

		$level_need=strlen((string)$kdparent.'');
		


		$table=(array)DB::table('master_table_map')->where('key_view',$e)->first();
		if($table){
			$tb=$table;
			$row=DB::table('master_column_map')->where('id_ms_table',$table['id']);

			if((!Auth::check() ) AND (!Auth::Guard('api')->check()) ){
				$row=$row->where('auth',false);
			}

			if(($table['start_level']<6 ) and ($level_need<6)){
				$row=$row->where('aggregate_type','!=','NONE');

			}

			if($context==1){
				$row=$row->where('dashboard',true);
			}

			if($context==0){
				$row=$row->where('validate',true);
			}

			$row=$row->get();

			$tb['columns']=[];
			$tb['view_']=[];

			foreach ($row as $key => $d) {
				$tb['columns'][$d->name_column]=(array)$d;
			}

			foreach ([2,4,6,10] as $key => $l) {
				foreach ([0,1,2,3] as $d => $ro) {
					$e=DB::table('master_view_method')
					->where('level',$l)
					->where('row',$ro)
					->where('id_ms_table',$table['id'])->get()->pluck('type')->toArray();
					if($e){
					$tb['view_'][$l][$ro]=$e;

					}
				}
					
				
				
				# code...
			}
					
			

		}



		return $tb;
	}

	static function maping_row($data,$map,$ROW=9,$COLUMN=8){

		$DATA=[];
		$POINTER_ROW=$ROW;

		$keys=array_keys($map['columns']);
		foreach ($data as $key => $row) {
			$POINTER_ROW+=1;
			$POINTER_COLUMN=$COLUMN;
			foreach ($row as $keyc => $c) {
					if($keyc=='id_desa'){
						$DATA[$key][$keyc]=[
							'name'=>'KODE DESA',
							'satuan'=>'',
							'type'=>'META',
							'pointer_r'=>$POINTER_ROW,
							'pointer_c'=>1,
							'value'=>$c,
							'aggregate_type'=>'NONE',
							'name_column'=>$keyc
						];
					}
					if($keyc=='name'){
						$DATA[$key][$keyc]=[
							'name'=>'NAMA DAERAH',
							'satuan'=>'',
							'type'=>'META',
							'pointer_r'=>$POINTER_ROW,
							'pointer_c'=>4,
							'value'=>$c,
							'aggregate_type'=>'NONE',
							'name_column'=>$keyc
						];
					}

					if($keyc=='jenis_daerah'){
						$DATA[$key][$keyc]=[
							'name'=>'JENIS DAERAH',
							'satuan'=>'',
							'type'=>'META',
							'pointer_r'=>$POINTER_ROW,
							'pointer_c'=>5,
							'value'=>$c,
							'aggregate_type'=>'NONE',
							'name_column'=>$keyc
						];
					}

					
					if($keyc=='name_kecamatan'){
						$DATA[$key][$keyc]=[
							'name'=>'NAMA KECAMATAN',
							'satuan'=>'',
							'type'=>'META',
							'pointer_r'=>$POINTER_ROW,
							'pointer_c'=>6,
							'value'=>$c,
							'aggregate_type'=>'NONE',
							'name_column'=>$keyc
						];
					}
					if($keyc=='name_kota'){
						$DATA[$key][$keyc]=[
							'name'=>'NAMA KOTA/KAB',
							'satuan'=>'',
							'value'=>$c,
							'type'=>'META',
							'pointer_r'=>$POINTER_ROW,
							'pointer_c'=>7,
							'aggregate_type'=>'NONE',
							'name_column'=>$keyc
						];
					}
					else if($keyc=='valid_date'){

						$DATA[$key][$keyc]=[
							'name'=>'VALID DATE',
							'satuan'=>'',
							'type'=>'META',
							'pointer_r'=>$POINTER_ROW,
							'pointer_c'=>3,
							'value'=>$c,
							'aggregate_type'=>'NONE',
							'name_column'=>$keyc
						];
						
					}
					else if($keyc=='status_validasi'){
						$DATA[$key][$keyc]=[
							'name'=>'STATUS VALIDASI',
							'satuan'=>'',
							'type'=>'META',
							'value'=>$c,
							'pointer_r'=>$POINTER_ROW,
							'pointer_c'=>2,
							'aggregate_type'=>'NONE',
							'name_column'=>$keyc
						];

					}else if(in_array($keyc, $keys)){
						$DATA[$key][$keyc]=$map['columns'][$keyc];

						$DATA[$key][$keyc]['value']=static::nformat($c);
						$DATA[$key][$keyc]['type']='DATA';
						$DATA[$key][$keyc]['pointer_r']=$POINTER_ROW;
						$DATA[$key][$keyc]['pointer_c']=$POINTER_COLUMN;
						$POINTER_COLUMN+=1;


					}
			}
			# code...
		}

		return $DATA;

	}

	static function route_data($data){

		if($data->delivery_type=='CONTROLLER'){
			return route($data->table_view,['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>static::slugify($data->name)]);
		}

		switch ($data->type) {
			case 'INTEGRASI':
				return route('get.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>static::slugify($data->name)]);
				# code...
				break;
			case 'FILE':
				return route('query.data.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>static::slugify($data->name)]);
				# code...
				break;
			case 'NEWS':
				return route($data->table_view??'index',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>static::slugify($data->name)]);
				# code...
				break;
			
			default:
				# code...
				break;
		}
	}

	public static function role_list(){
		$data=[
			[
				'val'=>1,
				'text'=>'SUPERADMIN'
			],
			[
				'val'=>2,
				'text'=>'ADMIN PUSAT'
			],
			[
				'val'=>3,
				'text'=>'ADMIN REGIONAL'
			],
			[
				'val'=>4,
				'text'=>'ADMIN KOTA/KAB'
			],


		];
		return $data;
	}

	public static function role_user($role=null,$u=null){
		$data=[];
		switch ($role) {
			case 1:
			$data['text']='SUPERADMIN';

				# code...
				break;
			case 2:
			$data['text']='ADMIN PUSAT';

				# code...
				break;
			case 3:
			$data['text']='ADMIN REGIONAL';

				# code...
				break;
			case 4:
			$data['text']='USER DAERAH';
					if($u){
						if($u->walidata){
						$data['text']='<b>WALIDATA</b>';

						}else if($u->main_daerah){
							$data['text']='<b>ADMIN</b>';

						}else{
							$data['text']='<b>PRODUSEN DATA</b>';

						}

						$data['text'].=' '.$u->nama_daerah_handle();

					}

			

				# code...
				break;
			
			default:
				# code...
				break;
		}

		return $data;

	}

	public static function slugify($text)
	{
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, '-');

	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);

	  // lowercase
	  $text = strtolower($text);

	  if (empty($text)) {
	    return 'n-a';
	  }

	  return $text;
	}


	// static function table_data($table=null){
	// 	$tb= [
	// 		'dash_potensi_iklim_tanah_erosi'=>[
	// 			'name'=>'Data Potensi Iklim Tanah Erosi',
	// 			'table'=>'dash_potensi_iklim_tanah_erosi',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]
	// 		],
	// 		'dash_potensi_jenis_lahan'=>[
	// 			'table'=>'dash_potensi_jenis_lahan',
	// 			'name'=>'Data Potensi Jenis Lahan',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]

	// 		],
	// 		'dash_potensi_jumlah_penduduk'=>[
	// 			'table'=>'dash_potensi_jumlah_penduduk',
	// 			'name'=>'Data Potensi Jumlah Penduduk',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]

	// 		],
	// 		'dash_potensi_kepemilikan_lahan_pertanian'=>[
	// 			'table'=>'dash_potensi_kepemilikan_lahan_pertanian',
	// 			'name'=>'Data Potensi Kepemilikan Tanah Pertanian',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]

	// 		],
	// 		'dash_potensi_lembaga_kemasyarakatan'=>[
	// 			'table'=>'dash_potensi_lembaga_kemasyarakatan',
	// 			'name'=>'Data Potensi Lembaga Kemasyarakatan',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]

	// 		],
	// 		'dash_potensi_lembaga_pemerintahan'=>[
	// 			'table'=>'dash_potensi_lembaga_pemerintahan',
	// 			'name'=>'Data Potensi Lembaga Pemerintah',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]
	// 		],

	// 		'dash_potensi_luas_wilayah'=>[
	// 			'table'=>'dash_potensi_luas_wilayah',
	// 			'name'=>'Data Potensi Luas Wilayah',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]

	// 		],
	// 		'dash_potensi_umur_penduduk'=>[
	// 			'table'=>'dash_potensi_umur_penduduk',
	// 			'name'=>'Data Potensi Umur Penduduk',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]

	// 		],
	// 		'jumlah_penduduk_dan_kk'=>[
	// 			'table'=>'jumlah_penduduk_dan_kk',
	// 			'name'=>'Data Jumlah Penduduk dan kk',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]

	// 		],
	// 		'nama_kades_prodes'=>[
	// 			'table'=>'nama_kades_prodes',
	// 			'name'=>'Data Nama Kepala Desa',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]

	// 		],
	// 		'dash_ddk_pekerjaan'=>[
	// 			'name'=>'Data DKK Pekerjaan',
	// 			'table'=>'dash_ddk_pekerjaan',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]
	// 		],
	// 		'dash_ddk_pendidikan'=>[
	// 			'name'=>'Data DKK Tingkat Pendidikan',
	// 			'table'=>'dash_ddk_pendidikan',
	// 			'view_'=>[
	// 				2=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				4=>[
	// 					['bar','map'],
	// 					['table']
	// 				],
	// 				7=>[
	// 					['bar'],
	// 					['table']
	// 				],
	// 				10=>[
	// 					['bar'],
	// 					['table']
	// 				]
	// 			]
	// 		],
			

	// 	];

	// 	if($table){
	// 		return $tb[$table];
	// 	}else{
	// 		return array_values($tb);
	// 	}

		
	// }

	static function vdata($key){
		if(in_array($key, ['desa','kabkota','provinsi','kecamatan','kode_dagri'])){
			return 0;
		}else{
			return 1;
		}
	}

	static function nformat($val,$key=null,$d=0){
		if(in_array($key, ['kode_desa'])){
			return $val;

		}else{

			if(is_numeric($val)){
				// $after_dot=explode('.',(string)$val);
				// $d=isset($after_dot[1])?(int)$after_dot[1]:0;
				// if($d>=0){
				// 	return number_format($val,0,',','.');

				// }else{
				// 	return number_format($val,2,',','.');

				// }
					return number_format($val,$d,',','.');


		}else{
			return $val;
			}
		}
		
	}

	static function data_set(Array $data){
		$dataArray=[];
		if(file_exists(public_path($data['document_path']))){
			if(file_exists(public_path('/storage/publication/DATASET_JSON/'.($data['year']).'/'.$data['id'].'.json'))){
				$D=file_get_contents(public_path('/storage/publication/DATASET_JSON/'.($data['year']).'/'.$data['id'].'.json'));
				$dataArray=json_decode($D,true);
				return $dataArray;

			}else{
				$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path($data['document_path']));
				foreach ($spreadsheet->getSheetNames() as $i => $value) {
					# code...
					$sheet=$spreadsheet->setActiveSheetIndex($i);
					$dataArray[$value]=$sheet->toArray();
				}
				
				Storage::put('public/publication/DATASET_JSON/'.$data['id'].'.json',json_encode($dataArray));

				return $dataArray;
			}
		}

		return [];
	}

	static function level($kodepemda,$levelbind=null){
		$cc=strlen($kodepemda);
		if($levelbind){
			$cc=strlen($levelbind);
		}

		if($cc<2){
			$cc=0;
		}else if($cc>6){
			$cc=6;
		}


		switch ($cc) {
			case 0:
				$data= [
					'table'=>'provinsi',
					'table_name'=>'nmprovinsi',
					'table_kode'=>'kdprovinsi',
					'level'=>'Provinsi',
					'count'=>2,
					'parent'=>[

					],
					'kode'=>$kodepemda



				];
				# code...
				break;

			case 2:
				$data=  [
					'table'=>'kabkota',
					'table_name'=>'nmkabkota',
					'table_kode'=>'kdkabkota',
					'level'=>'Kab/Kota',
					'count'=>4,
					'parent'=>[
						'table'=>'provinsi',
						'table_name'=>'nmprovinsi',
						'table_kode'=>'kdprovinsi',
						'level'=>'Provinsi',
					],
					'kode'=>$kodepemda


				];
				# code...
				break;
			case 4:
				$data= [
					'table'=>'kecamatan',
					'table_name'=>'nmkecamatan',
					'table_kode'=>'kdkecamatan',
					'level'=>'Kecamatan',
					'count'=>6,
					'kode'=>$kodepemda,
					'parent'=>[
						'table'=>'kabkota',
						'table_name'=>'nmkabkota',
						'table_kode'=>'kdkabkota',
						'level'=>'Kab/Kota',
					]


				];
				# code...
				break;
			case 6:
				$data=  [
					'table'=>'master_desa',
					'table_name'=>'desa',
					'table_kode'=>'kode_bps',
					'level'=>'Desa',
					'count'=>10,
					'kode'=>$kodepemda,
					'parent'=>[
						'table'=>'kecamatan',
						'table_name'=>'nmkecamatan',
						'table_kode'=>'kdkecamatan_permen',
						'level'=>'Kecamatan',
					]

				];
				# code...
				break;
			
			default:

				return false;
				# code...
				break;
		}

		

		return $data;
	}
	

	static function operator(){
		return ['SUM','COUNT_YA','COUNT_ADA','COUNT_TIDAK','AVERAGE','MIN','MAX','COUNT','COUNT_DISTINCT','COUNT_EXIST','NONE'];
	}

	static function translate_operator($op){
		switch (strtoupper($op)) {
			case 'SUM':
				return ['Jumlah','sum(',')'];
				# code...
				break;
			case 'COUNT_ADA':
				return ['Jumlah',"count(CASE WHEN 'ada'= ",' then 1 else null end)'];
				# code...
				break;
			case 'COUNT_YA':
				return ['Jumlah',"count(CASE WHEN 'ya'= ",' then 1 else null end)'];
				# code...
				break;
			case 'COUNT_TIDAK':
				return ['Jumlah',"count(CASE WHEN 'tidak'= ",' then 1 else null) end'];
				# code...
				break;
			case 'AVERAGE':
				return ['Rata Rata','avg(',')'];
				break;

			case 'MIN':
				return ['Nilai Tertrendah','min(',')'];
				# code...
				break;
			case 'MAX':
				return ['Nilai Tertinggi','min(',')'];
				# code...
				break;
			case 'COUNT':
				return ['Jumlah','count(',')'];
				# code...
				break;
			case 'COUNT_DISTINCT':
				return ['Jumlah','count(distinct(','))'];
				# code...
				break;
			case 'COUNT_EXIST':
				return ['Jumlah','count(CASE WHEN (','>0) THEN 1 ELSE NULL END)'];
				# code...
				break;
			
			default:
				# code...
				return ['','',''];

				break;
		}
	} 


}