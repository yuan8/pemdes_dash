<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use HPV;
class ValidasiCtrl extends Controller
{

	public function index(Request $request){
		$table=HPV::table_data();
		$data_index=0;
		if($request->data){
			$data_index=$request->data;
		}

		$provinsi=DB::table('provinsi')->where('kdprovinsi','!=','0')->where('kdprovinsi','!=','00')->get();

		$kodedaerah=[
			'kdprovinsi'=>null,
			'kdkota'=>null,
			'kdkecamatan'=>null,
			'kddesa'=>null,
		];


		if($request->kdprovinsi){
			$kodedaerah['kdprovinsi']=$request->kdprovinsi;
		}

		if($request->kdkota){
			$kodedaerah['kdkota']=$request->kdkota;

		}

		if($request->kdkecamatan){
			$kodedaerah['kdkecamatan']=$request->kdkecamatan;
			$daerah=DB::table('master_desa')->where('kode_bps',$kodedaerah['kddesa'])->fisrt();


		}

		if($request->kddesa){
			$kodedaerah['kddesa']=$request->kddesa;
			$daerah=DB::table('master_desa')->where('kode_bps',$kodedaerah['kddesa'])->fisrt();
		}




		return view('admin.validasi.index')->with([
			'provinsi'=>$provinsi,'kodedaerah'=>$kodedaerah,'data_index'=>$data_index,'table'=>$table]);
	}

	public function data(Request $request){
		$table=HPV::table_data();
		$data_index=0;
		if($request->data){
			$data_index=$request->data;
		}
		$where=[];
		if($request->kdprovinsi){
			$where[]=[DB::raw("left(d.kode_desa,2)"),'=',$request->kdprovinsi];
		}

		if($request->kdkota){
			$where[]=[DB::raw("left(d.kode_desa,4)"),'=',$request->kdkota];
		}

		if($request->kdkecamatan){
			$where[]=[DB::raw("left(d.kode_desa,7)"),'=',$request->kdkecamatan];
		}

		if($request->kddesa){
			$where[]=[DB::raw("(d.kode_desa"),'=',$request->kddesa];
		}

		


		$data=DB::table($table[$data_index]['table'].' as d')
		->join('master_desa as md','md.kode_bps','=','d.kode_desa')
		->leftJoin('kecamatan as mkc','mkc.kdkecamatan','=',DB::raw("left('d.kode_desa',7)"))

		->selectRaw('md.desa as Nama_Desa, mkc.nmkecamatan as Nama_Kecamatan,d.*');
		if(count($where)>0){
			$data=$data->where($where);
		}

		$data=$data->get();

		return view('admin.validasi.data')->with(['data'=>$data,'data_index'=>$data_index,'table'=>$table]);
	}


	public function getData($table,$kodedesa){
		$data=DB::table($table[0]['table'])->get();

	}


}