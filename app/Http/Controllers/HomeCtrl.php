<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeCtrl extends Controller
{
    //

    public function index($tahun=null){


    	$tema=DB::table('category')->whereIn('type',['TEMA_DATA_UTAMA'])->where('id_parent','=',null)->get();
    	
    	$tema2=DB::table('category')->whereIn('type',['TEMA_DATA_PENDUKUNG'])->where('id_parent','=',null)->get();
    	
    	return view('index')->with(['tema'=>$tema,'tema2'=>$tema2]);

    }

    public function pindahTahun($tahun){
    	$tahuns=DB::table('tahun_access')->get();
    	return view('pindah_tahun')->with(['tahuns'=>$tahuns]);
    }
}
