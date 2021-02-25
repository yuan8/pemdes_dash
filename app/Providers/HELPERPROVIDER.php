<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Storage;

class HELPERPROVIDER extends ServiceProvider
{

	static function route_data($data){

		switch ($data->delivery_type) {
			case 'VISUALISASI':
				return route($data->route??'index',['id'=>$data->id,'slug'=>static::slugify($data->name)]);
				# code...
				break;
			case 'DATASET':
				return route($data->route??'index',['id'=>$data->id,'slug'=>static::slugify($data->name)]);
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


	static function table_data(){
		return [
			[
				'name'=>'Data Potensi Iklim Tanah Erosi',
				'table'=>'dash_potensi_iklim_tanah_erosi'
			],
			[
				'table'=>'dash_potensi_jenis_lahan',
				'name'=>'Data Potensi Jenis Lahan'
			],
			[
				'table'=>'dash_potensi_jumlah_penduduk',
				'name'=>'Data Potensi Jumlah Penduduk'
			],
			[
				'table'=>'dash_potensi_kepemilikan_lahan_pertanian',
				'name'=>'Data Potensi Kepemilikan Tanah Pertanian'
			],
			[
				'table'=>'dash_potensi_lembaga_kemasyarakatan',
				'name'=>'Data Potensi Lembaga Kemasyarakatan'
			],
			[
				'table'=>'dash_potensi_lembaga_pemerintahan',
				'name'=>'Data Potensi Lembaga Pemerintah'
			],
			[
				'table'=>'dash_potensi_luas_wilayah',
				'name'=>'Data Potensi Luas Wilayah'
			],
			[
				'table'=>'dash_potensi_umur_penduduk',
				'name'=>'Data Potensi Umur Penduduk'
			],
			[
				'table'=>'jumlah_penduduk_dan_kk',
				'name'=>'Data Jumlah Penduduk dan kk'
			],[
				'table'=>'nama_kades_prodes',
				'name'=>'Data Nama Kepala Desa'
			]


		];

		
	}

	static function vdata($key){
		if(in_array($key, ['desa','kabkota','provinsi','kecamatan','kode_dagri'])){
			return 0;
		}else{
			return 1;
		}
	}

	static function nformat($val,$key=null){
		if(in_array($key, ['kode_desa'])){
			return $val;

		}else{

			if(is_numeric($val)){
				$after_dot=explode('.',(string)$val);
				$d=isset($after_dot[1])?(int)$after_dot[1]:0;

				if($d>=0){
					return number_format($val,0,',','.');

				}else{
					return number_format($val,2,',','.');

				}

		}else{
			return $val;
			}
		}
		
	}

	static function data_set(Array $data){
		$dataArray=[];
		if(file_exists(public_path($data['document_path']))){
			if(file_exists(public_path('/storage/publication/DATASET_JSON/'.$data['id'].'.json'))){
				$D=file_get_contents(public_path('/storage/publication/DATASET_JSON/'.$data['id'].'.json'));
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

}