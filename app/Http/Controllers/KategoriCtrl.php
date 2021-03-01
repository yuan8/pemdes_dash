<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class KategoriCtrl extends Controller
{
    //

    public function index($tahun,$id){
    	$data=DB::table('category')->where('id',$id)->first();
    	foreach (DB::table('category')->where('id_parent',$id)->get() as $key => $c) {
    		$data->sub[]=$c;
    	}

    	return view('dash.kategori.index')->with(['data'=>$data]);
    }


    public function data($tahun,$id,$slug,Request $request){
    	$cat=DB::table('category')->where('id',$id)->first();

    	if($cat){
    		$where="dg.id_category =".$id;
    		if($request->q){
    		$where=" AND (name like '%".$request->q."%' OR tags like '%".$request->q."%' OR keywords like '%".$request->q."%')";
	    	}
	    	$data=DB::table('data as d')
	    	->join('data_group as dg','dg.id_data','=','d.id')
	    	->where('dg.id_category',$id)
	    	->whereRaw($where)
	    	->selectRaw("d.*,dg.id_category as id_category")
	    	->paginate(10);


	    	

    	}

    	


    }
}
