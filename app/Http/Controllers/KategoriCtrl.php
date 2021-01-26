<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class KategoriCtrl extends Controller
{
    //

    public function index($id){
    	$data=DB::table('category')->where('id',$id)->first();
    	foreach (DB::table('category')->where('id_parent',$id)->get() as $key => $c) {
    		$data->sub[]=$c;
    	}

    	return view('dash.kategori.index')->with(['data'=>$data]);
    }
}
