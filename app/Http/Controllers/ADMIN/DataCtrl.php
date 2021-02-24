<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
class DataCtrl extends Controller
{

	public function index(Request $request){
		$where=[];
		$Orwhere=[];
		if($request->jenis){
			$where[]=['d.delivery_type','=',$request->jenis];
			$Orwhere[]=['d.delivery_type','=',$request->jenis];

		}

		if($request->q){
			$where[]=['d.name','ilike','%'.$request->q.'%'];
			$Orwhere[]=['d.description','ilike','%'.$request->q.'%'];
		}

		if($request->kategori){
			$where[]=['gc.id_category','=',$request->kategori];
			$Orwhere[]=['gc.id_category','=',$request->kategori];

		}

		$data=DB::table('data as d')
		->leftJoin('data_group as gc','gc.id_data','=','d.id')
		->leftJoin('category as c','c.id','=','gc.id_category')
		->selectRaw('c.name as nama_category,c.type as tema ,d.*');

		if(count($where)){
			$data=$data->where($where);
		}

		if(count($Orwhere)){
			$data=$data->orWhere($Orwhere);
		}

		$data=$data->paginate(10);

		return view('admin.data.index')->with(['data'=>$data,'request'=>$request]);

	}

}