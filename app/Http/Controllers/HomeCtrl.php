<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeCtrl extends Controller
{
    //


    public function index($tahun=null){

    	$tema=DB::table('master_category as c')->where('type','TEMA_DATA_UTAMA')->get();
    	$tema2=DB::table('master_category as c')->where('type','TEMA_DATA_PENDUKUNG')->get();


    	return view('index')->with(['tema'=>$tema,'tema2'=>$tema2,'videos'=>[]]);
    }
}
