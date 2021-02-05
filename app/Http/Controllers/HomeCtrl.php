<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeCtrl extends Controller
{
    //

    public function index(){

    


    	$tema=DB::table('category')->whereIn('type',['TEMA_PRIMER'])->where('id_parent','=',null)->get();

    	
    	$tema2=DB::table('category')->whereIn('type',['TEMA_SEKUNDER'])->where('id_parent','=',null)->get();
    	// $tema=[];
    	// $tema2=[];
    	return view('index')->with(['tema'=>$tema,'tema2'=>$tema2]);

    }
}
