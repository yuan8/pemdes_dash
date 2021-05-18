<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class HomeCtrl extends Controller
{
    //


    public function index($tahun=null){
    	$timeS=Carbon::now()->startOfDay();
    	$timeYS=Carbon::parse($tahun.'-01-01')->startOfDay();
    	$timeYE=Carbon::parse($tahun.'-12-01')->endofMonth();

    	$timeBS=Carbon::now()->startOfMonth();
    	$timeBE=Carbon::now()->endofMonth();


    	$timeE=Carbon::now()->endofDay();

    	$tema=DB::table('master_category as c')->where('type','TEMA_DATA_UTAMA')->get();
    	$tema2=DB::table('master_category as c')->where('type','TEMA_DATA_PENDUKUNG')->get();
    	$kunjungan=[
    		'total'=>DB::table('tb_visitor')->count(),
    		'hari_ini'=>DB::table('tb_visitor')
    		->where('updated_at','<=',$timeE)
    		->where('updated_at','>=',$timeS)
    		->count(),
    		'tahun_ini'=>DB::table('tb_visitor')
    		->where('updated_at','<=',$timeYE)
    		->where('updated_at','>=',$timeYS)
    		->count(),
    		'bulan_ini'=>DB::table('tb_visitor')
    		->where('updated_at','<=',$timeBE)
    		->where('updated_at','>=',$timeBS)
    		->count(),
	];

	$statistik_data=[

		'data_utama'=>DB::table('tb_data as d')
		->join('tb_data_group as g','g.id_data','=','d.id')
		->join('master_category as c','c.id','=','g.id_category')
		->where([
			['d.status','=',1],
			['d.type','=','INTEGRASI'],
			['c.type','=','TEMA_DATA_UTAMA'],
			
		])->orwhere([
			['d.status','=',1],
			['d.type','=','VISUALISASI'],
			['c.type','=','TEMA_DATA_UTAMA'],
			['d.tahun','=',$tahun],
		])->orwhere([
			['d.status','=',1],
			['d.type','=','TABLE'],
			['c.type','=','TEMA_DATA_UTAMA'],
			['d.tahun','=',$tahun],

		])->orwhere([
		['d.status','=',1],
			['d.type','=','INFOGRAFIS'],
			['c.type','=','TEMA_DATA_UTAMA'],
			['d.tahun','=',$tahun],
		])
		->groupBy('d.id')->count(),
		'data_pendukung'=>DB::table('tb_data as d')
		->join('tb_data_group as g','g.id_data','=','d.id')
		->join('master_category as c','c.id','=','g.id_category')
		->where([
			['d.status','=',1],
			['d.type','=','INTEGRASI'],
			['c.type','=','TEMA_DATA_PENDUKUNG'],
			
		])->orwhere([
			['d.status','=',1],
			['d.type','=','VISUALISASI'],
			['c.type','=','TEMA_DATA_PENDUKUNG'],
			['d.tahun','=',$tahun],
		])->orwhere([
			['d.status','=',1],
			['d.type','=','TABLE'],
			['c.type','=','TEMA_DATA_PENDUKUNG'],
			['d.tahun','=',$tahun],

		])->orwhere([
		['d.status','=',1],
			['d.type','=','INFOGRAFIS'],
			['c.type','=','TEMA_DATA_PENDUKUNG'],
			['d.tahun','=',$tahun],
		])
		->groupBy('d.id')->count(),
		'visualisasi'=>DB::table('tb_data as d')
			->where([
				['d.status','=',1],
				['d.type','=','VISUALISASI'],
				['d.tahun','=',$tahun],
			])
			->groupBy('d.id')->count(),
		'table'=>DB::table('tb_data as d')
			->where([
				['d.status','=',1],
				['d.type','=','TABLE'],
				['d.tahun','=',$tahun],
			])
			->groupBy('d.id')->count(),
		'infografis'=>DB::table('tb_data as d')
			->where([
				['d.status','=',1],
				['d.type','=','INFOGRAFIS'],
				['d.tahun','=',$tahun],
			])
			->groupBy('d.id')->count(),
		'publikasi'=>DB::table('tb_data as d')
			->where([
				['d.status','=',1],
				['d.type','=','INFOGRAFIS'],
				['d.tahun','=',$tahun],
			])
			->groupBy('d.id')->count(),

	];


    	return view('index')->with(['tema'=>$tema,'tema2'=>$tema2,'videos'=>[],'kunjungan'=>$kunjungan,'statistik_data'=>$statistik_data]);
    }
}
