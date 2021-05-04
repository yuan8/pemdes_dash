<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class KodeDaerahCtrl extends Controller
{


	public static function kota($provinsi=''){
		return ['result'=>DB::table('master_kabkota')->where(DB::raw("left(kdkabkota,2)"),'like',$provinsi.'%')->selectRaw("kdkabkota as id,nmkabkota as text")->get()];
	}

	public static function kecamatan($kota=''){
		return ['result'=>DB::table('master_kecamatan')->where(DB::raw("left(kdkecamatan,4)"),'=',$kota)->selectRaw("kdkecamatan as id,nmkecamatan as text")->get()];
	}

	public static function desa($kecamatan=''){
		return ['result'=>DB::table('master_desa')->where(DB::raw("left(kddesa,6)"),'=',$kecamatan)->selectRaw("kddesa as id,nmdesa as text")->get()];
	}

}