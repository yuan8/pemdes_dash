<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;


class FaqCtrl extends Controller
{
    //

	public function get_question($tahun,Request $request){
		
    	$data=DB::table('faq_question as quest')
	    	->join('faq_category as cat','cat.id','=','quest.id_category')
	    	->groupBy('quest.id');
	    	if($request->q){
	    		$data=$data->where('quest.question','like','%'.$request->q.'%');
	    	}
	    	if($request->category){
	    		$data=$data->where('cat.id','=',$request->category);
	    	}

	    	$data=$data->selectRaw("quest.*,cat.id as id_cat,cat.nama as cat_nama,cat.deskripsi as cat_deskripsi,concat(cat.id,'|',cat.nama) pluck_con ")
	    	->get();

	    $category=[];
    	$cat=array_unique($data->pluck('pluck_con')->toArray());
    	foreach ($cat as $key => $c) {
    		$d=explode('|', $c);
    		$category[$d[0]]=[
    			'id'=>$d[0],
    			'nama'=>$d[1],
    			'questions'=>[]

    		];
    		# code...
    	}

    	$category_list=DB::table('faq_category')->get();

    	foreach ($data as $key => $d) {
    		$category[$d->id_cat]['questions'][]=$d;
    		$category[$d->id_cat]['deskripsi']=$d->cat_deskripsi;
    	}

    	

    	
    	return	[
    			'category'=>array_values($category),
    			'req'=>$request->all(),
    			'cat_list'=>$category_list
    		];
    	


	}


    public function index_dash($tahun,Request $request){
    	$category=DB::table('faq_category')->get();

    	return view('faq.index')->with(
    		[
    			'req'=>$request->all(),
    			'category'=>$category
    		]);
    }

    public function index($tahun,Request $request){
    	$data=DB::table('faq_question as quest')
    	->join('faq_category as cat','cat.id','=','quest.id_category')
    	->groupBy('quest.id');
    	if($request->q){
    		$data=$data->where('quest.question','like','%'.$request->q.'%');
    	}
    	if($request->category){
    		$data=$data->where('cat.id','=',$request->category);
    	}

    	$data=$data->selectRaw("quest.*,cat.nama as cat_nama,cat.deskripsi as cat_deskripsi")
    	->paginate(10);

    	$data->appends($request->all());
    	$category=DB::table('faq_category')->get();

    	return view('admin.faq.index')->with(
    		['data'=>$data,'req'=>$request->all(),'category'=>$category]);
    }
}
