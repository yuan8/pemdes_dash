<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
class KetegoriCtrl extends Controller
{

	public function get_pendukung(Request $request)
	{
		// code...
	}


	public function get(Request $request){
		$tema=null;
		$where=[['name','like','%'.$request->q.'%']];

		if($request->tema){
			$tema=$request->tema;
			if(Auth::User()->role<=2){

			}else{
				$where=[['type','like',$tema],['name','like','%'.$request->q.'%']];
			}
		}
		return [
			'results'=>
				DB::table('master_category')
				->selectRaw("concat(replace(replace(type,'_',' '),'TEMA DATA ',''),' - ',name) as text,id ")
				->where(
					$where	
				)
				
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