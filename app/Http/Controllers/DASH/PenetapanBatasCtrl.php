<?php

namespace App\Http\Controllers\DASH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class PenetapanBatasCtrl extends Controller
{
    //

    public function index(Request $request){
    	$category=DB::table('category')->where('id',$request->id)->first();
    	return view('dash.kewilayahan.peta_batas.index')->with(['category'=>$category]);
    }

    public function get_provinsi(){
      $data=DB::table('provinsi as p')
      ->leftJoin('dash_potensi_luas_wilayah as jp',DB::raw("left(jp.kode_desa,2)"),'=','p.kdprovinsi')
      ->selectRaw("p.kdprovinsi as id,
      	(select count(distinct(d.kode_bps)) from master_desa as d where left(d.kode_bps,2)=p.kdprovinsi) as jumlah_desa,
      	count(distinct(jp.kode_desa)) as jumlah_desa_mengisi,
      	p.nmprovinsi as name,sum(jp.luas_wilayah) as luas_wilayah,sum(jp.penetapan_batas) as penetapan_batas,sum(jp.peta_batas) as peta_batas")
      ->groupBy('p.kdprovinsi')
      ->where('p.kdprovinsi','<>',0)
      ->get();


      $series=[
        [
          'name'=>'JUMLAH DESA',
          'data'=>[],
          'yAxis'=>0,

        ],
        [
          'name'=>'JUMLAH DESA MENGISI',
          'data'=>[],
          'yAxis'=>0,


        ],
        [
          'name'=>'PENETAPAN BATAS',
          'data'=>[],
          'yAxis'=>0,


        ],
        [
          'name'=>'	MEMILIKI PETA BATAS',
          'data'=>[],
          'yAxis'=>0,


        ],
       

      ];

      $series_map=[];


      foreach ($data as $key => $value) {
          $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_desa,
            'satuan'=>'Desa',
            'id'=>$value->id,
            'route'=>route('d.peta_batas.chart.k',['kodepemda'=>$value->id])


          ];

          

          $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_desa_mengisi,
            'satuan'=>'Desa',
            'id'=>$value->id,
            'route'=>route('d.peta_batas.chart.k',['kodepemda'=>$value->id])


          ];

           $series[2]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->penetapan_batas,
            'satuan'=>'Desa',
            'id'=>$value->id,

            'route'=>route('d.peta_batas.chart.k',['kodepemda'=>$value->id])


          ];
          $series[3]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->peta_batas,
            'satuan'=>'Desa',
            'id'=>$value->id,

            'route'=>route('d.peta_batas.chart.k',['kodepemda'=>$value->id])


          ];
          

          $series_map[]=[
            'id'=>$value->id,
            'name'=>$value->name,
            'value'=>(float)$value->luas_wilayah,
            'y'=>(float)$value->luas_wilayah,
            'route'=>route('d.peta_batas.chart.k',['kodepemda'=>$value->id]),

            'data_map'=>[
              [
                
                  'name'=>'JUMLAH DESA',
                  'y'=>(float)$value->jumlah_desa,
                  'satuan'=>'Desa'
                
              ],
              [
                
                  'name'=>'JUMLAH DESA MENGISI',
                  'y'=>(float)$value->jumlah_desa_mengisi,
                  'satuan'=>'Desa'
                
              ],
               [
                
                  'name'=>'PENETAPAN BATAS',
                  'y'=>(float)$value->peta_batas,
                  'satuan'=>'Desa'
                
              ],
              [
                
                  'name'=>'MEMILIKI PETA DESA',
                  'y'=>(float)$value->peta_batas,
                  'satuan'=>'Desa'
                
              ],
              
            ]
          ];
      }
        return view('chart.compone_chart_2')->with(
      	[ 'series'=>$series,
          'series_map'=>$series_map,
          'satuan'=>[
          	[
          		'satuan'=>'Desa',
          		'title'=>'Jumlah Desa'
          	],
          	[
          		'satuan'=>'Ha',
          		'title'=>'Luas Desa'
          	]
          ],
          'chart'=>[
            'chart.bar','chart.map'
          ],

        'title'=>'DATA PENETAPAN BATAS DESA PER PROVINSI',
        'subtitle'=>'',
        'child_f_prefix'=>"get_point_2(",
      'child_f_surfix'=>")",
      'scope_map'=>'idn',
      ])->render().view('chart.table')->with(['series'=>$series,'child_f_prefix'=>"get_point_2(",
      'child_f_surfix'=>")"])->render();


    }

    
    public function get_kota($kodepemda){
      $pemda=DB::table('provinsi')->where('kdprovinsi','=',$kodepemda)->first();

      $data=DB::table('kabkota as p')
      ->leftJoin('dash_potensi_luas_wilayah as jp',DB::raw("left(jp.kode_desa,4)"),'=','p.kdkabkota')
      ->selectRaw("p.kdkabkota as id,
        (select count(distinct(d.kode_bps)) from master_desa as d where left(d.kode_bps,4)=p.kdkabkota) as jumlah_desa,
        count(distinct(jp.kode_desa)) as jumlah_desa_mengisi,
        p.nmkabkota as name,sum(jp.luas_wilayah) as luas_wilayah,sum(jp.penetapan_batas) as penetapan_batas,sum(jp.peta_batas) as peta_batas")
      ->groupBy('p.kdkabkota')
      ->where(DB::RAW("LEFT(p.kdkabkota,2)"),'=',$kodepemda)
      ->get();


      $series=[
        [
          'name'=>'JUMLAH DESA',
          'data'=>[],
          'yAxis'=>0,

        ],
        [
          'name'=>'JUMLAH DESA MENGISI',
          'data'=>[],
          'yAxis'=>0,


        ],
        [
          'name'=>'PENETAPAN BATAS',
          'data'=>[],
          'yAxis'=>0,


        ],
         [
          'name'=>'MEMILIKI PETA BATAS',
          'data'=>[],
          'yAxis'=>0,


        ],
       

      ];

      $series_map=[];


      foreach ($data as $key => $value) {
          $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_desa,
            'satuan'=>'Desa',
            'id'=>$value->id,
            'route'=>route('d.peta_batas.chart.kc',['kodepemda'=>$value->id])


          ];

          

          $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_desa_mengisi,
            'satuan'=>'Desa',
            'id'=>$value->id,

            'route'=>route('d.peta_batas.chart.kc',['kodepemda'=>$value->id])


          ];

           $series[2]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->penetapan_batas,
            'satuan'=>'Desa',
            'id'=>$value->id,

            'route'=>route('d.peta_batas.chart.kc',['kodepemda'=>$value->id])


          ];

          $series[3]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->peta_batas,
            'satuan'=>'Desa',
            'id'=>$value->id,

            'route'=>route('d.peta_batas.chart.kc',['kodepemda'=>$value->id])


          ];
          

          $series_map[]=[
            'id'=>$value->id,
            'name'=>$value->name,
            'value'=>(float)$value->luas_wilayah,
            'y'=>(float)$value->luas_wilayah,
            'route'=>route('d.peta_batas.chart.kc',['kodepemda'=>$value->id]),

            'data_map'=>[
              [
                
                  'name'=>'JUMLAH DESA',
                  'y'=>(float)$value->jumlah_desa,
                  'satuan'=>'Desa'
                
              ],
              [
                
                  'name'=>'JUMLAH DESA MENGISI',
                  'y'=>(float)$value->jumlah_desa_mengisi,
                  'satuan'=>'Desa'
                
              ],
               [
                
                  'name'=>'PENETAPAN BATAS',
                  'y'=>(float)$value->penetapan_batas,
                  'satuan'=>'Desa'
                
              ],
              [
                
                  'name'=>'MEMILIKI PETA BATAS',
                  'y'=>(float)$value->peta_batas,
                  'satuan'=>'Desa'
                
              ],
              
            ]
          ];
      }
        return view('chart.compone_chart_2')->with(
        [ 'series'=>$series,
          'series_map'=>$series_map,
          'satuan'=>[
            [
              'satuan'=>'Desa',
              'title'=>'Jumlah Desa'
            ],
            [
              'satuan'=>'Ha',
              'title'=>'Luas Desa'
            ]
          ],
          'chart'=>[
            'chart.bar','chart.map'
          ],

        'title'=>'DATA PENETAPAN BATAS DESA PER KAB/KOTA PROVINSI '.$pemda->nmprovinsi,
        'subtitle'=>'',
        'legend_map'=>'JUMLAH LUAS DESA',
        'child_f_prefix'=>"get_point_3(",
      'child_f_surfix'=>")",
      'scope_map'=>'idn_'.$pemda->kdprovinsi,
      ])->render().view('chart.table')->with(['series'=>$series,'child_f_prefix'=>"get_point_3(",
      'child_f_surfix'=>")"])->render();


    }

     public function get_kecamatan($kodepemda){
      $pemda=DB::table('kabkota')->where('kdkabkota','=',$kodepemda)->first();
       $data=DB::table('kecamatan as p')
      ->leftJoin('dash_potensi_luas_wilayah as jp',DB::raw("left(jp.kode_desa,7)"),'=','p.kdkecamatan')
      ->selectRaw("p.kdkecamatan as id,
        (select count(distinct(d.kode_bps)) from master_desa as d where left(d.kode_bps,7)=p.kdkecamatan) as jumlah_desa,
        count(distinct(jp.kode_desa)) as jumlah_desa_mengisi,
        p.nmkecamatan as name,sum(jp.luas_wilayah) as luas_wilayah,sum(jp.penetapan_batas) as penetapan_batas,sum(jp.peta_batas) as peta_batas")
      ->groupBy('p.kdkecamatan')
      ->where(DB::RAW("LEFT(p.kdkecamatan,4)"),'=',$kodepemda)
      ->get();


      $series=[
        [
          'name'=>'JUMLAH DESA',
          'data'=>[],
          'yAxis'=>0,

        ],
        [
          'name'=>'JUMLAH DESA MENGISI',
          'data'=>[],
          'yAxis'=>0,


        ],
         [
          'name'=>'PENETAPAN BATAS',
          'data'=>[],
          'yAxis'=>0,


        ],
         [
          'name'=>'MEMILIKI PETA BATAS',
          'data'=>[],
          'yAxis'=>0,


        ],
       
       

      ];

      $series_map=[];


      foreach ($data as $key => $value) {
          $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_desa,
            'satuan'=>'Desa',
            'id'=>$value->id,
            'route'=>route('d.peta_batas.chart.d',['kodepemda'=>$value->id])


          ];

          

          $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_desa_mengisi,
            'satuan'=>'Desa',
            'id'=>$value->id,

            'route'=>route('d.peta_batas.chart.d',['kodepemda'=>$value->id])


          ];

         
           $series[2]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->penetapan_batas,
            'satuan'=>'Desa',
            'id'=>$value->id,

            'route'=>route('d.peta_batas.chart.d',['kodepemda'=>$value->id])


          ];

          $series[3]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->peta_batas,
            'satuan'=>'Desa',
            'id'=>$value->id,

            'route'=>route('d.peta_batas.chart.d',['kodepemda'=>$value->id])


          ];
          

          $series_map[]=[
            'id'=>$value->id,
            'name'=>$value->name,
            'value'=>(float)$value->luas_wilayah,
            'y'=>(float)$value->luas_wilayah,
            'route'=>route('d.peta_batas.chart.d',['kodepemda'=>$value->id]),

            'data_map'=>[
              [
                
                  'name'=>'JUMLAH DESA',
                  'y'=>(float)$value->jumlah_desa,
                  'satuan'=>'Desa'
                
              ],
              [
                
                  'name'=>'JUMLAH DESA MENGISI',
                  'y'=>(float)$value->jumlah_desa_mengisi,
                  'satuan'=>'Desa'
                
              ],
              [
                
                  'name'=>'PENETAPAN BATAS',
                  'y'=>(float)$value->penetapan_batas,
                  'satuan'=>'Desa'
                
              ],
              [
                
                  'name'=>'MEMILIKI PETA BATAS',
                  'y'=>(float)$value->peta_batas,
                  'satuan'=>'Desa'
                
              ],
              
              
            ]
          ];
      }
        return view('chart.bar')->with(
        [ 'series'=>$series,
          'series_map'=>$series_map,
          'satuan'=>[
            [
              'satuan'=>'Desa',
              'title'=>'Jumlah Desa'
            ],
            [
              'satuan'=>'Ha',
              'title'=>'Luas Desa'
            ]
          ],
          'chart'=>[
            'chart.bar','chart.map'
          ],
            'child_f_prefix'=>"get_point_4(",
        'child_f_surfix'=>")",

        'title'=>'DATA PENETAPAN BATAS DESA PER KECAMATAN '.$pemda->nmkabkota,
        'subtitle'=>'',
        'legend_map'=>'JUMLAH LUAS DESA',
      
      ])->render().view('chart.table')->with(['series'=>$series,'child_f_prefix'=>"get_point_4(",
      'child_f_surfix'=>")"])->render();


    
	}


     public function get_desa($kodepemda){
      $pemda=DB::table('kecamatan')->where('kdkecamatan','=',$kodepemda)->first();
       $data=DB::table('master_desa as p')
      ->leftJoin('dash_potensi_luas_wilayah as jp',DB::raw("(jp.kode_desa)"),'=','p.kode_bps')
      ->selectRaw("p.kode_bps as id,
        (select count(distinct(d.kode_bps)) from master_desa as d where (d.kode_bps)=p.kode_bps) as jumlah_desa,
        count(distinct(jp.kode_desa)) as jumlah_desa_mengisi,
        p.kode_bps as name,sum(jp.luas_wilayah) as luas_wilayah,sum(jp.penetapan_batas) as penetapan_batas,sum(jp.peta_batas) as peta_batas")
      ->groupBy('p.kode_bps')
      ->where(DB::RAW("LEFT(p.kode_bps,7)"),'=',$kodepemda)
      ->get();


      $series=[
        
       
         [
          'name'=>'PENETAPAN BATAS',
          'data'=>[],
          'yAxis'=>0,


        ],
         [
          'name'=>'MEMILIKI PETA BATAS',
          'data'=>[],
          'yAxis'=>0,


        ],
       
       

      ];

      $series_map=[];


      foreach ($data as $key => $value) {
        

          

       

           $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->penetapan_batas,
            'satuan'=>'Desa',
            'id'=>$value->id,


          ];
           $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->peta_batas,
            'satuan'=>'Desa',
            'id'=>$value->id,


          ];
          

          $series_map[]=[
            'id'=>$value->id,
            'name'=>$value->name,
            'value'=>(float)$value->luas_wilayah,
            'y'=>(float)$value->luas_wilayah,

            'data_map'=>[
             
               [
                
                  'name'=>'PENETAPAN BATAS',
                  'y'=>(float)$value->luas_wilayah,
                  'satuan'=>'Ha'
                
              ],
              
            ]
          ];
      }
        return view('chart.bar')->with(
        [ 'series'=>$series,
          'series_map'=>$series_map,
          'satuan'=>[
            [
              'satuan'=>'Desa',
              'title'=>'Jumlah Desa'
            ],
            [
              'satuan'=>'Ha',
              'title'=>'Luas Desa'
            ]
          ],
          'chart'=>[
            'chart.bar','chart.map'
          ],
          

        'title'=>'DATA PENETAPAN BATAS DESA KECAMATAN '.$pemda->nmkecamatan,
        'subtitle'=>'',
      
      ])->render().view('chart.table')->with(['series'=>$series])->render();


    
  }



}
