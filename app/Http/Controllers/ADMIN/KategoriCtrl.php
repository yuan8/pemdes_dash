<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class KategoriCtrl extends Controller
{
    //

    public function index(){
    	$data=DB::table('category')->get();
    	return view('admin.kategori')->with(['data'=>$data]);
    }
}
