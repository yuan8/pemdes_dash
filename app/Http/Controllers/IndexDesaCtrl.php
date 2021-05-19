<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class IndexDesaCtrl extends Controller
{
    //

    public function index($tahun,Request $request){
    	$provinsi=DB::table('master_provinsi')->get();
    	return view('show_data.index_desa')->with(['provinsi'=>$provinsi,'request'=>$request,'title'=>'index Desa']);


    }


    public function data_index_desa($tahun,Request $request){

    	$scope=[

    	];
    	$data=DB::table('master_desa as ds')
    	->leftJoin('dash_klasifikasi_prodeskel as b',[
    		['b.kode_desa','=','ds.kddesa'],
    		['b.status_validasi','=',DB::raw(5)],
    		['b.tahun','=',DB::raw($tahun)]]
    	)->leftJoin('dash_klasifikasi_epdeskel as a',[
    		['b.kode_desa','=','ds.kddesa'],
    		['b.status_validasi','=',DB::raw(5)],
    		['b.tahun','=',DB::raw($tahun)]]
    	)->selectRaw("
    	ds.stapem,
    	ds.nmdesa,
    	ds.nmkecamatan,
    	ds.nmkabkota,
    	ds.nmprovinsi,
    	ds.kddesa,
    	a.klasifikasi as klasifikasi_epdeskel,
    	b.klasifikasi as klasifikasi_prodeskel")
    	->whereRaw("
    		((a.tahun=".$tahun." and a.klasifikasi is not null) or (a.tahun=".$tahun." and b.klasifikasi is not null))  and (ds.kddesa like '".$request->kodedaerah."%')
    	")->get();


    	return $data;


    }
}
