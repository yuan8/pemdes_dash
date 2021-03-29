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
				DB::table('category')
				->selectRaw("concat(replace(type,'_',' '),' - ',name) as text,id ")
				->where([
					['name','like','%'.$request->q.'%'],
					['type','like',($tema??'TEMA_%')]
				])
				->Orwhere([
					['type','like','%'.$request->q.'%'],
					['type','like',($tema??'TEMA_%')]])
				->get()->toArray()
		];
	}

	public function instansi(Request $request){
		return [
			'results'=>
				DB::table('category')
				->selectRaw("concat(replace(type,'_',' - '),' ',name) as text,id ")
				->where([
					['name','like','%'.$request->q.'%'],
					['type','=',('INSTANSI')]
				])
				->Orwhere([
					['type','like','%'.$request->q.'%'],
					['type','=',('INSTANSI')]

				]
				)
				->get()->toArray()
		];
	}

}