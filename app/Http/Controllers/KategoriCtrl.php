<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
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
    		  dd(Auth::check());
            if(Auth::check()){
                if($request->q){
                $where=" AND (name like '%".$request->q."%' OR tags like '%".$request->q."%' OR keywords like '%".$request->q."%')";
                }
            }else{
                dd('c');
                 if($request->q){
                $where=" AND (name like '%".$request->q."%' OR tags like '%".$request->q."%' OR keywords like '%".$request->q."%') AND auth is false";
                }
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
