<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Str;
use Alert;
class ForumCtrl extends Controller
{
    //

    public function index($tahun,Request $request){

    	$data=DB::table('chatter_categories');
    	if($request->q){
    		$data->where('name','like','%'.$request->q.'%')
    		->orwhere('deskripsi','like','%'.$request->q.'%');

    	}
    	$data=$data->get();

    	return view('admin.forum.index')->with(['data'=>$data,'req'=>$request]);
    }

    public function store($tahun,Request $request){
    	$data=DB::table('chatter_categories')->insertOrIgnore([
    		'parent_id'=>$request->parent_id,
    		'name'=>$request->nama,
    		'color'=>$request->color_code,
    		'slug'=>Str::slug($request->nama)
    	]);

    	if($data){
    		Alert::success('Berahsil');

    		return back();
    	}
    }

    public function edit($tahun,$id,Request $request){

    	$data=DB::table('chatter_categories')->where('id',$id)->first();
    	if($data){
    		$cabang=DB::table('chatter_categories')->where('id','!=',$id)->get();
    	return view('admin.forum.edit')->with(['data'=>$data,'cabang'=>$cabang]);

    	}

    }


    public function delete($tahun,$id,Request $request){

    	$data=DB::table('chatter_categories')->where('id',$id)->delete();
    	if($data){
    		Alert::success('Berhasil');

    	}
    		return back();


    }
    public function update($tahun,$id,Request $request){

    	$data=DB::table('chatter_categories')->where('id',$id)->first();
    	if($data){
    		$data_update=[
    			'parent_id'=>$request->parent_id,
	    		'name'=>$request->nama,
	    		'color'=>$request->color_code,
	    		'slug'=>Str::slug($request->nama)
    		];

    		DB::table('chatter_categories')->where('id',$id)->update($data_update);
    		Alert::success('Berhasil');
    	}

    	return back();

    }

      public function tambah(Request $request){
    	$cabang=DB::table('chatter_categories')->get();
    	return view('admin.forum.add')->with(['cabang'=>$cabang]);
    }
}
