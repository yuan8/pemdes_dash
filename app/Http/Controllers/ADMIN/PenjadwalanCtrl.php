<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Carbon\Carbon;
use Alert;
class PenjadwalanCtrl extends Controller
{
    //

    public function index($tahun,Request $request){
    	$U=Auth::User();
    	$def=[
    		"j.tahun =".$tahun,
    		"j.kode_daerah =".($U->kode_daerah??0)
    	];

    	$where=[];

    	$whereRaw=[];

    	if($where){

    	}else{
    		$whereRaw[]=implode(' and ', $def);
    	}

    	$data_level=[
    		'10'=>[
    			'level_name'=>'VERIFIKASI DESA',
    			'level'=>10,
    			'mulai'=>null,
    			'selesai'=>null,

    		],
    		'6'=>[
    			'level_name'=>'VERIFIKASI KECAMATAN',
    			'level'=>6,
    			'mulai'=>null,
    			'selesai'=>null,

    		],
    		'4'=>[
    			'level_name'=>'VALIDASI KOTA/KAB',
    			'level'=>4,
    			'mulai'=>null,
    			'selesai'=>null,

    		]
    	];




    	$data=DB::table("tb_jadwal_pengisian as j")
    	->whereRaw(implode(' or ', $whereRaw))->get();

    	foreach ($data as $key => $v) {
    		if(isset($data_level[$v->level])){
    			$data_level[$v->level]['mulai']=Carbon::parse($v->mulai);
    			$data_level[$v->level]['selesai']=Carbon::parse($v->selesai);
    		}
    	}


    	return view('admin.penjadwalan.index')->with(['data'=>$data_level,'request'=>$request]);
    }


    public function update($tahun,Request $request){
    	$U=Auth::User();

    	$data_level=[
    		'10'=>[
    			'level_name'=>'VERIFIKASI DESA',
    			'level'=>10,
    			'mulai'=>null,
    			'selesai'=>null,

    		],
    		'6'=>[
    			'level_name'=>'VERIFIKASI KECAMATAN',
    			'level'=>6,
    			'mulai'=>null,
    			'selesai'=>null,

    		],
    		'4'=>[
    			'level_name'=>'VALIDASI KOTA/KAB',
    			'level'=>4,
    			'mulai'=>null,
    			'selesai'=>null,

    		]
    	];

    	foreach ($request->penjadwalan??[] as $key => $v) {

    		if((!empty($v['selesai'])) and (!empty($v['mulai']))){
    			$m=Carbon::parse($v['mulai'])->startOfDay();
    			$s=Carbon::parse($v['selesai'])->endOfDay();

    			if($m->lt($s)){

	    			DB::table('tb_jadwal_pengisian')->updateOrInsert([
	    				'kode_daerah'=>$U->kode_daerah??0,
	    				'level'=>$key,
	    				'tahun'=>$tahun,
	    			],[
	    				'level'=>$key,
	    				'kode_daerah'=>$U->kode_daerah??0,
	    				'mulai'=>$m,
	    				'selesai'=>$s,
	    				'id_user'=>$U->id,
	    				'tahun'=>$tahun,
	    				'updated_at'=>Carbon::now()

	    			]);
	    			
	    		}else{
    				Alert::warning('','Penjadwalan '.$data_level[$key]['level_name'].' Salah');

    			return back();

	    		}
    		}
    		# code...
    	}

    	Alert::success('Berhasil','Berhasil Update Data Penjadwalan');
    	return back();
    }
}
