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

    	$jenis='TEMA_PRIMER';
    	if($request->jenis){
    		$jenis=$request->jenis;
    	}
        
    	$data=DB::table('category')->where('type','like',(''.$jenis.'%'))->get();
    	return view('admin.kategori.index')->with(['data'=>$data,'req'=>$request]);
    }



    public function create(){
    	return view('admin.kategori.create');

    }

    public function edit($id){
        $data=DB::table('category')->where('id',$id)->first();
        if($data){
            return view('admin.kategori.edit')->with(['data'=>$data]);

        }


    }

    public function update($id,Request $request){
        $image_path=null;
        $data=[];
        if($request->image_path){
            $image_path=Storage::put('/public/c/image',$request->image_path);
            if($image_path){
                $image_path=Storage::url($image_path);
            }
            $data['image_path']=$image_path;
        }
            $data['name']=$request->name;
            $data['type']=$request->jenis;
            $data['route']=$request->route??'query.data.categorycal';

            $data['description']=$request->description;

         DB::table('category')->where('id',$id)->update($data);

        return back();

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
    		'route'=>$request->route??'query.data.categorycal',
    		'image_path'=>$image_path
    	]);

    	return redirect()->route('admin.kategori.index');
    }
}
