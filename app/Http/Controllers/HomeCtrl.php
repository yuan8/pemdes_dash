<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeCtrl extends Controller
{
    //

    public function index(){
    	$tema=DB::table('category')->where('type','TEMA')->get();
    	return view('index')->with('tema',$tema);

    }
}
