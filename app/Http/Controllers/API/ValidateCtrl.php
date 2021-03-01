<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ValidateCtrl extends Controller
{

	public function form($tahun,$table,$id){
		$data=DB::table('master_desa as d')
		->join($table.' as data',[
			['data.kode_desa','=','d.kode_bps'],
			['data.tahun','=',DB::RAW($tahun)],
		])
		->leftJoin('validasi_confirm as cfm',[
			['cfm.kode_desa','=','data.kode_desa'],
			['cfm.tahun','=',DB::RAW($tahun)],
			['cfm.table','=',DB::RAW("'".$table."'")]

		])
		->selectRAW("data.tahun as tahun, data.kode_desa as kode_desa_data ,d.desa as name,cfm.*")
		->where('data.tahun',$tahun)
		->where('data.kode_desa',$id)
		->first();

		if($data){
			if($data->id){
				return view('admin.validasi.api.form.edit')->with(['data'=>$data,'table'=>$table]);
			}else{
				return view('admin.validasi.api.form.create')->with(['data'=>$data,'table'=>$table]);

			}
		}
	}


}