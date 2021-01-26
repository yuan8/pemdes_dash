<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
class KategoriCtrl extends Controller
{
    //

    public function index(Request $request){

    	$jenis='PRIMER_';
    	if($request->jenis){
    		$jenis=$request->jenis;
    	}
    	$data=DB::table('category')->where('type','like',(''.$jenis.'%'))->get();
    	return view('admin.kategori.index')->with(['data'=>$data,'req'=>$request]);
    }

    public function create(){
    	return view('admin.kategori.create');

    }

    public function store(Request $request){

    	$image_path=null;

    	if($request->image_path){
    		$image_path=Storage::put('/public/c/image',$request->image_path);
    		if($image_path){
    			$image_path=Storage::url($image_path);
    		}
    	}
    	DB::table('category')->insert([
    		'name'=>$request->name,
    		'description'=>$request->description,
    		'type'=>$request->jenis,
    		'route'=>$request->route,
    		'image_path'=>$image_path
    	]);

    	return redirect()->route('admin.kategori.index');
    }
}
