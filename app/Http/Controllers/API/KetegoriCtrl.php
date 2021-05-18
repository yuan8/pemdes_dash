<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class KetegoriCtrl extends Controller
{


	public function get(Request $request){
		$tema=null;
		if($request->tema){
			$tema=$request->tema;
		}
		return [
			'results'=>
				DB::table('master_category')
				->selectRaw("concat(replace(type,'_',' '),' - ',name) as text,id ")
				->where([
					['name','like','%'.$request->q.'%'],
				])
				->Orwhere([
					['type','like','%'.$request->q.'%']
				])
				->get()->toArray()
		];
	}

	public function instansi(Request $request){
		return [
			'results'=>
				DB::table('master_instansi')
				->selectRaw("concat(replace(type,'_',' - '),' ',name) as text,id ")
				->where([
					['name','like','%'.$request->q.'%']
				])
				->Orwhere([
					['type','like','%'.$request->q.'%']

					]
				)
				->get()->toArray()
		];
	}

}