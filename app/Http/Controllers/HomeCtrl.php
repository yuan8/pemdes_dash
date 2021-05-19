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

     public function cat_desa($tahun){
        $data=[
            [
                'name'=>'Prodeskel',
                'link'=>'http://prodeskel.binapemdes.kemendagri.go.id',
                'data'=>(array)DB::table('dash_klasifikasi_prodeskel as d')
                        ->selectRaw("(select count(distinct(dd.kddesa)) from master_desa as dd ) as jumlah_desa,count(distinct(d.kode_desa)) as count,d.klasifikasi")
                        ->groupBy('d.klasifikasi')
                        ->where([
                        	['d.tahun','=',$tahun],
                        	['d.status_validasi','=',5]

                        ])
                        ->get()->toArray()
                        ,'rekap'=>[]

            ],
             [
                'name'=>'Epdeskel',
                'link'=>'http://epdeskel.binapemdes.kemendagri.go.id',
                'data'=>DB::table('dash_klasifikasi_epdeskel as d')
                        ->selectRaw("(select count(distinct(dd.kddesa)) from master_desa as dd ) as jumlah_desa,count(distinct(d.kode_desa)) as count,d.klasifikasi")
                        ->groupBy('d.klasifikasi')
                        ->where([
                        	['d.tahun','=',$tahun],
                        	['d.status_validasi','=',5]

                        ])
                        ->get()->toArray(),
                        'rekap'=>[]

            ],

        ];
        foreach ($data as $key => $value) {
            foreach ($value['data'] as $i => $c){
                $data[$key]['data'][$i]=(array)$c;
                $value['data'][$i]=(array)$c;
                if(!isset($data[$key]['rekap']['jumlah_desa'])){
                    $data[$key]['rekap']=[
                        'jumlah_desa'=>(int)isset($value['data'][0]['jumlah_desa'])?$value['data'][0]['jumlah_desa']:0,
                        'count'=>isset($value['data'][0]['count'])?(int)$value['data'][0]['count']:0
                    ];


                }else{

                    $c=(array)$c;
                    if($i>0){
                        $data[$key]['rekap']['count']+=(int)$c['count'];
                    }
                }
            }

            if(count($value['data'])==0){
        		$data[$key]['rekap']=[
                        'count'=>isset($value['data'][0]['count'])?(int)$value['data'][0]['count']:0
                    ];
        	}



        }




        return [
            'status'=>200,
            'data'=>view('glob.klasifikasi')->with('data',$data)->render()
        ];
    }

}
