<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeCtrl extends Controller
{
    //

    public function index(){
    	$tema=DB::table('category')->whereIn('type',['PRIMER_'])->get();
    	$tema2=DB::table('category')->whereIn('type',['SEKUNDER_'])->get();
    	// $tema=[];
    	// $tema2=[];
    	return view('index')->with(['tema'=>$tema,'tema2'=>$tema2]);

    }
}
