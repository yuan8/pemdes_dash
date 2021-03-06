<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Storage;
use DB;
use Auth;
class HELPERPROVIDER extends ServiceProvider
{
	static function gen_map($e,$context=1){

		$table=(array)DB::table('master_table_map')->where('key_view',$e)->first();
		if($table){
			$tb=$table;
			$row=DB::table('master_column_map')->where('id_ms_table',$table['id']);
			if(!Auth::check()){
				$row=$row->where('auth',false);
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

			foreach ([2,4,7,10] as $key => $l) {
				$tb['view_'][$l][0]=[
					DB::table('master_view_method')
					->where('level',$l)
					->where('row',0)
					->where('id_ms_table',$table['id'])->get()->pluck('type')->toArray()
				];
				
				$tb['view_'][$l][1]=[
					DB::table('master_view_method')
					->where('level',$l)
					->where('row',1)
					->where('id_ms_table',$table['id'])->get()->pluck('type')->toArray()
				];
				# code...
			}
					
			

		}



		return $tb;
	}

	static function maping_row($data,$map,$ROW=8,$COLUMN=8){

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
							'name'=>'STATUS DAERAH',
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
						$POINTER_COLUMN+=2;


					}
			}
			# code...
		}

		return $DATA;

	}

	static function route_data($data){
		switch ($data->delivery_type) {
			case 'AUTOMATION':
				return route('get.data.table',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>static::slugify($data->name)]);
				# code...
				break;
			case 'DATASET':
				return route($data->table_view??'index',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>static::slugify($data->name)]);
				# code...
				break;
			case 'VISUALISASI':
				return route($data->table_view??'index',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>static::slugify($data->name)]);
				# code...
				break;
			
			default:
				# code...
				break;
		}
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


	static function table_data($table=null){
		$tb= [
			'dash_potensi_iklim_tanah_erosi'=>[
				'name'=>'Data Potensi Iklim Tanah Erosi',
				'table'=>'dash_potensi_iklim_tanah_erosi',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]
			],
			'dash_potensi_jenis_lahan'=>[
				'table'=>'dash_potensi_jenis_lahan',
				'name'=>'Data Potensi Jenis Lahan',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]

			],
			'dash_potensi_jumlah_penduduk'=>[
				'table'=>'dash_potensi_jumlah_penduduk',
				'name'=>'Data Potensi Jumlah Penduduk',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]

			],
			'dash_potensi_kepemilikan_lahan_pertanian'=>[
				'table'=>'dash_potensi_kepemilikan_lahan_pertanian',
				'name'=>'Data Potensi Kepemilikan Tanah Pertanian',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]

			],
			'dash_potensi_lembaga_kemasyarakatan'=>[
				'table'=>'dash_potensi_lembaga_kemasyarakatan',
				'name'=>'Data Potensi Lembaga Kemasyarakatan',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]

			],
			'dash_potensi_lembaga_pemerintahan'=>[
				'table'=>'dash_potensi_lembaga_pemerintahan',
				'name'=>'Data Potensi Lembaga Pemerintah',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]
			],

			'dash_potensi_luas_wilayah'=>[
				'table'=>'dash_potensi_luas_wilayah',
				'name'=>'Data Potensi Luas Wilayah',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]

			],
			'dash_potensi_umur_penduduk'=>[
				'table'=>'dash_potensi_umur_penduduk',
				'name'=>'Data Potensi Umur Penduduk',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]

			],
			'jumlah_penduduk_dan_kk'=>[
				'table'=>'jumlah_penduduk_dan_kk',
				'name'=>'Data Jumlah Penduduk dan kk',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]

			],
			'nama_kades_prodes'=>[
				'table'=>'nama_kades_prodes',
				'name'=>'Data Nama Kepala Desa',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]

			],
			'dash_ddk_pekerjaan'=>[
				'name'=>'Data DKK Pekerjaan',
				'table'=>'dash_ddk_pekerjaan',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]
			],
			'dash_ddk_pendidikan'=>[
				'name'=>'Data DKK Tingkat Pendidikan',
				'table'=>'dash_ddk_pendidikan',
				'view_'=>[
					2=>[
						['bar','map'],
						['table']
					],
					4=>[
						['bar','map'],
						['table']
					],
					7=>[
						['bar'],
						['table']
					],
					10=>[
						['bar'],
						['table']
					]
				]
			],
			

		];

		if($table){
			return $tb[$table];
		}else{
			return array_values($tb);
		}

		
	}

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

	static function level($kodepemda){
		switch (strlen($kodepemda)) {
			case 0:
				return [
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
				return [
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
				return [
					'table'=>'kecamatan',
					'table_name'=>'nmkecamatan',
					'table_kode'=>'kdkecamatan',
					'level'=>'Kecamatan',
					'count'=>7,
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
			case 7:
				return [
					'table'=>'master_desa',
					'table_name'=>'desa',
					'table_kode'=>'kode_bps',
					'level'=>'Desa',
					'count'=>10,
					'kode'=>$kodepemda,
					'parent'=>[
						'table'=>'kecamatan',
						'table_name'=>'nmkecamatan',
						'table_kode'=>'kdkecamatan',
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
	}
	static function table_agre($table){
		switch ($table) {
			case 'dash_ddk_pekerjaan':
				return [

					'table'=>$table,
					'entity'=>[
						[
					        "name"=>"Petani",
					        "tag"=>"Petani",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Buruh Tani",
					        "tag"=>"Buruh_Tani",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Buruh Migran",
					        "tag"=>"Buruh_Migran",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pegawai Negeri Sipil",
					        "tag"=>"Pegawai_Negeri_Sipil",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pengrajin",
					        "tag"=>"Pengrajin",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pedagang barang kelontong",
					        "tag"=>"Pedagang_barang_kelontong",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Peternak",
					        "tag"=>"Peternak",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Nelayan",
					        "tag"=>"Nelayan",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Montir",
					        "tag"=>"Montir",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Dokter swasta",
					        "tag"=>"Dokter_swasta",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Perawat swasta",
					        "tag"=>"Perawat_swasta",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Bidan swasta",
					        "tag"=>"Bidan_swasta",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Ahli Pengobatan Alternatif",
					        "tag"=>"Ahli_Pengobatan_Alternatif",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"TNI",
					        "tag"=>"TNI",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"POLRI",
					        "tag"=>"POLRI",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pengusaha kecil  menengah dan besar",
					        "tag"=>"Pengusaha_kecil__menengah_dan_besar",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Guru swasta",
					        "tag"=>"Guru_swasta",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Dosen swasta",
					        "tag"=>"Dosen_swasta",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Seniman artis",
					        "tag"=>"Seniman_artis",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pedagang Keliling",
					        "tag"=>"Pedagang_Keliling",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Penambang",
					        "tag"=>"Penambang",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Kayu",
					        "tag"=>"Tukang_Kayu",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Batu",
					        "tag"=>"Tukang_Batu",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Cuci",
					        "tag"=>"Tukang_Cuci",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pembantu rumah tangga",
					        "tag"=>"Pembantu_rumah_tangga",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pengacara",
					        "tag"=>"Pengacara",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Notaris",
					        "tag"=>"Notaris",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Dukun Tradisional",
					        "tag"=>"Dukun_Tradisional",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Arsitektur Desainer",
					        "tag"=>"Arsitektur_Desainer",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Karyawan Perusahaan Swasta",
					        "tag"=>"Karyawan_Perusahaan_Swasta",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Karyawan Perusahaan Pemerintah",
					        "tag"=>"Karyawan_Perusahaan_Pemerintah",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Wiraswasta",
					        "tag"=>"Wiraswasta",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Konsultan Manajemen dan Teknis",
					        "tag"=>"Konsultan_Manajemen_dan_Teknis",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tidak Mempunyai Pekerjaan Tetap",
					        "tag"=>"Tidak_Mempunyai_Pekerjaan_Tetap",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Belum Bekerja",
					        "tag"=>"Belum_Bekerja",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pelajar",
					        "tag"=>"Pelajar",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Ibu Rumah Tangga",
					        "tag"=>"Ibu_Rumah_Tangga",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Purnawirawan Pensiunan",
					        "tag"=>"Purnawirawan_Pensiunan",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Perangkat Desa",
					        "tag"=>"Perangkat_Desa",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Buruh Harian Lepas",
					        "tag"=>"Buruh_Harian_Lepas",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pemilik perusahaan",
					        "tag"=>"Pemilik_perusahaan",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pengusaha perdagangan hasil bumi",
					        "tag"=>"Pengusaha_perdagangan_hasil_bumi",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Buruh jasa perdagangan hasil bumi",
					        "tag"=>"Buruh_jasa_perdagangan_hasil_bumi",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pemilik usaha jasa transportasi dan perhubungan",
					        "tag"=>"Pemilik_usaha_jasa_transportasi_dan_perhubungan",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Buruh usaha jasa transportasi dan perhubungan",
					        "tag"=>"Buruh_usaha_jasa_transportasi_dan_perhubungan",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pemilik usaha informasi dan komunikasi",
					        "tag"=>"Pemilik_usaha_informasi_dan_komunikasi",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Buruh usaha jasa informasi dan komunikasi",
					        "tag"=>"Buruh_usaha_jasa_informasi_dan_komunikasi",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Kontraktor",
					        "tag"=>"Kontraktor",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pemilik usaha jasa hiburan dan pariwisata",
					        "tag"=>"Pemilik_usaha_jasa_hiburan_dan_pariwisata",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Buruh usaha jasa hiburan dan pariwisata",
					        "tag"=>"Buruh_usaha_jasa_hiburan_dan_pariwisata",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pemilik usaha hotel dan penginapan lainnya",
					        "tag"=>"Pemilik_usaha_hotel_dan_penginapan_lainnya",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Buruh usaha hotel dan penginapan lainnya",
					        "tag"=>"Buruh_usaha_hotel_dan_penginapan_lainnya",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pemilik usaha warung  rumah makan dan restoran",
					        "tag"=>"Pemilik_usaha_warung__rumah_makan_dan_restoran",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Dukun paranormal supranatural",
					        "tag"=>"Dukun_paranormal_supranatural",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Jasa pengobatan alternatif",
					        "tag"=>"Jasa_pengobatan_alternatif",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Sopir",
					        "tag"=>"Sopir",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Usaha jasa pengerah tenaga kerja",
					        "tag"=>"Usaha_jasa_pengerah_tenaga_kerja",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Jasa penyewaan peralatan pesta",
					        "tag"=>"Jasa_penyewaan_peralatan_pesta",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pemulung",
					        "tag"=>"Pemulung",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pengrajin industri rumah tangga lainnya",
					        "tag"=>"Pengrajin_industri_rumah_tangga_lainnya",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Anyaman",
					        "tag"=>"Tukang_Anyaman",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Jahit",
					        "tag"=>"Tukang_Jahit",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Kue",
					        "tag"=>"Tukang_Kue",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Rias",
					        "tag"=>"Tukang_Rias",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Sumur",
					        "tag"=>"Tukang_Sumur",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Jasa Konsultansi Manajemen dan Teknis",
					        "tag"=>"Jasa_Konsultansi_Manajemen_dan_Teknis",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Juru Masak",
					        "tag"=>"Juru_Masak",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Karyawan Honorer",
					        "tag"=>"Karyawan_Honorer",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pialang",
					        "tag"=>"Pialang",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pskiater Psikolog",
					        "tag"=>"Pskiater_Psikolog",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Wartawan",
					        "tag"=>"Wartawan",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Cukur",
					        "tag"=>"Tukang_Cukur",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Las",
					        "tag"=>"Tukang_Las",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Gigi",
					        "tag"=>"Tukang_Gigi",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Tukang Listrik",
					        "tag"=>"Tukang_Listrik",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pemuka Agama",
					        "tag"=>"Pemuka_Agama",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Anggota Legislatif",
					        "tag"=>"Anggota_Legislatif",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Kepala Daerah",
					        "tag"=>"Kepala_Daerah",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Apoteker",
					        "tag"=>"Apoteker",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Presiden",
					        "tag"=>"Presiden",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Wakil presiden",
					        "tag"=>"Wakil_presiden",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Anggota mahkamah konstitusi",
					        "tag"=>"Anggota_mahkamah_konstitusi",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Anggota kabinet kementrian",
					        "tag"=>"Anggota_kabinet_kementrian",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Duta besar",
					        "tag"=>"Duta_besar",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Gubernur",
					        "tag"=>"Gubernur",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Wakil bupati",
					        "tag"=>"Wakil_bupati",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pilot",
					        "tag"=>"Pilot",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Penyiar radio",
					        "tag"=>"Penyiar_radio",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Pelaut",
					        "tag"=>"Pelaut",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Peneliti",
					        "tag"=>"Peneliti",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Satpam Security",
					        "tag"=>"Satpam_Security",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Wakil Gubernur",
					        "tag"=>"Wakil_Gubernur",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Bupati walikota",
					        "tag"=>"Bupati_walikota",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Akuntan",
					        "tag"=>"Akuntan",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					    [
					        "name"=>"Biarawati",
					        "tag"=>"Biarawati",
					        "aggregate"=>"sum",
					        "satuan"=>"Jiwa"
					    ],
					]
				];
				# code...
				break;

			case 'dash_potensi_jumlah_penduduk':
				return [

					'table'=>$table,
					'entity'=>[
						[
							'name'=>'Penduduk Laki-Laki',
							'tag'=>'Jumlah_Laki_Laki_orang',
							'aggregate'=>'sum',
							'satuan'=>'Jiwa'
						],
						[
							'name'=>'Penduduk Perempuan',
							'tag'=>'Jumlah_Perempuan_orang',
							'aggregate'=>'sum',
							'satuan'=>'Jiwa'
						],

					    [
					        "name"=> "Total Penduduk ",
					        "tag"=> "Jumlah_Total_orang",
					        "aggregate"=> "sum",
					        "satuan"=> "Jiwa"
					    ],
					    [
					        "name"=> "Kepala Keluarga KK",
					        "tag"=> "Jumlah_Kepala_Keluarga_KK",
					        "aggregate"=> "sum",
					        "satuan"=> "Jiwa"
					    ],
					    // [
					    //     "name"=> "Kepadatan Penduduk Jiwa Km2",
					    //     "tag"=> "Kepadatan_Penduduk_Jiwa_Km2",
					    //     "aggregate"=> "sum",
					    //     "satuan"=> "km2"
					    // ],
					]
				];
				# code...
				break;

			case 'dash_potensi_iklim_tanah_erosi':
				return [

					'table'=>$table,
					'entity'=>[
						[
						        "name"=> "Curah Hujan",
						        "tag"=> "Curah_Hujan_mm",
						        "aggregate"=> "sum",
						        "satuan"=> "mm"
						    ],
						    [
						        "name"=> "Bulan Hujan",
						        "tag"=> "Jumlah_Bulan_Hujan_bulan",
						        "aggregate"=> "max",
						        "satuan"=> "bulan"
						    ],
						    [
						        "name"=> "Kelembapan Udara",
						        "tag"=> "Kelembapan_Udara_persen",
						        "aggregate"=> "average",
						        "satuan"=> "%"
						    ],
						    [
						        "name"=> "Suhu Rata Rata Harian",
						        "tag"=> "Suhu_Rata_Rata_Harian_oC",
						        "aggregate"=> "average",
						        "satuan"=> "oC"
						    ],
						    [
						        "name"=> "Tinggi Diatas Permukaan Laut",
						        "tag"=> "Tinggi_Diatas_Permukaan_Laut_M",
						        "aggregate"=> "average",
						        "satuan"=> "m"
						    ],
						    [
						        "name"=> "Warna Tanah kuning",
						        "tag"=> "Warna_Tanah_kuning",
						        "aggregate"=> "average",
						        "satuan"=> "-"
						    ],
						    [
						        "name"=> "Warna Tanah hitam",
						        "tag"=> "Warna_Tanah_hitam",
						        "aggregate"=> "average",
						        "satuan"=> "-"
						    ],
						    [
						        "name"=> "Warna Tanah abu abu",
						        "tag"=> "Warna_Tanah_abu_abu",
						        "aggregate"=> "average",
						        "satuan"=> "-"
						    ],
						    [
						        "name"=> "Warna Tanah merah",
						        "tag"=> "Warna_Tanah_merah",
						        "aggregate"=> "average",
						        "satuan"=> "-"
						    ],
						    [
						        "name"=> "Tekstur Tanah pasiran",
						        "tag"=> "Tekstur_Tanah_pasiran",
						        "aggregate"=> "average",
						        "satuan"=> "-"
						    ],
						    [
						        "name"=> "Tekstur Tanah debuan",
						        "tag"=> "Tekstur_Tanah_debuan",
						        "aggregate"=> "average",
						        "satuan"=> "-"
						    ],
						    [
						        "name"=> "Tekstur Tanah lempungan",
						        "tag"=> "Tekstur_Tanah_lempungan",
						        "aggregate"=> "average",
						        "satuan"=> "Jiwa"
						    ],
						    [
						        "name"=> "Kemiringan Tanah derajat",
						        "tag"=> "Kemiringan_Tanah_derajat",
						        "aggregate"=> "average",
						        "satuan"=> "-"
						    ],
						    [
						        "name"=> "Lahan Kritis",
						        "tag"=> "Lahan_Kritis_Ha",
						        "aggregate"=> "sum",
						        "satuan"=> "Ha"
						    ],
						    [
						        "name"=> "Lahan Terlantar",
						        "tag"=> "Lahan_Terlantar_Ha",
						        "aggregate"=> "sum",
						        "satuan"=> "Ha"
						    ],
						    [
						        "name"=> "Luas Tanah Erosi Ringan",
						        "tag"=> "Luas_Tanah_Erosi_Ringan_Ha",
						        "aggregate"=> "sum",
						        "satuan"=> "Ha"
						    ],
						    [
						        "name"=> "Luas Tanah Erosi Sedang",
						        "tag"=> "Luas_Tanah_Erosi_Sedang_Ha",
						        "aggregate"=> "sum",
						        "satuan"=> "Ha"
						    ],
						    [
						        "name"=> "Luas Tanah Erosi Berat",
						        "tag"=> "Luas_Tanah_Erosi_Berat_Ha",
						        "aggregate"=> "sum",
						        "satuan"=> "Ha"
						    ],
						    [
						        "name"=> "Luas Tanah yang Tidak Ada Erosi",
						        "tag"=> "Luas_Tanah_yang_Tidak_Ada_Erosi_Ha",
						        "aggregate"=> "sum",
						        "satuan"=> "Ha"
						    ]
					]
				];
				# code...
				break;

				case 'dash_ddk_pendidikan':
				return [

					'table'=>$table,
					'entity'=>[
						[
					        "name"=> "Tidak Menempuh Pendidikan",
					        "tag"=> "tidak_sekolah",
					        "aggregate"=> "sum",
					        "satuan"=> "Jiwa"
					    ],
					    [
					        "name"=> "Lulusan SD",
					        "tag"=> "sd",
					        "aggregate"=> "sum",
					        "satuan"=> "Jiwa"
					    ],
					    [
					        "name"=> "Lulusan SMP",
					        "tag"=> "smp",
					        "aggregate"=> "sum",
					        "satuan"=> "Jiwa"
					    ],
					    [
					        "name"=> "Lulusan SMP",
					        "tag"=> "sma",
					        "aggregate"=> "sum",
					        "satuan"=> "Jiwa"
					    ],
					    [
					        "name"=> "Lulusan Perguruan Tinggi",
					        "tag"=> "pt",
					        "aggregate"=> "sum",
					        "satuan"=> "Jiwa"
					    ],
					]
				];
				# code...
				break;

			
			default:
				# code...
				break;
		}
	}

	static function translate_operator($op){
		switch (strtoupper($op)) {
			case 'SUM':
				return ['Jumlah','sum(',')'];
				# code...
				break;
			case 'AVERAGE':
				return ['Rata Rata','avg(',')'];
				break;

			case 'MIN':
				return ['Nilai Tertendah','min(',')'];
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
				return ['',''];

				break;
		}
	} 


}