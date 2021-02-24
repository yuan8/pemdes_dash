<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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

		];

		
	}

}