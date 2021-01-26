<?php

namespace App\Http\Controllers\DASH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class KependudukanCtrl extends Controller
{
    //

    public function index(){
      $bind_side_left=null;

      // 

      return view('dash.kependudukan.penduduk');

    }


    static function step_legend($max,$cill,$value){

    }


    public function get_jp_provinsi(){
      $data=DB::table('provinsi as p')
      ->leftJoin('jumlah_penduduk_dan_kk as jp',DB::raw("left(jp.kode_desa,2)"),'=','p.kdprovinsi')
      ->selectRaw("p.kdprovinsi as id,p.nmprovinsi as name,sum(jp.penduduk_pria) as jumlah_l,sum(jp.penduduk_wanita) as jumlah_p,sum(jp.kepala_keluarga) as jumlah_kk")
      ->groupBy('p.kdprovinsi')
      ->where('p.kdprovinsi','<>',0)
      ->get();


      $series=[
        [
          'name'=>'JUMLAH PENDUDUK PRIA',
          'data'=>[],
          'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK PEREMPUAN',
          'data'=>[],
          'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH KEPALA KELUARGA',
          'data'=>[],
          'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ]

      ];

      $series_map=[];


      foreach ($data as $key => $value) {
          $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_l,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.kependudukan.chart.k',['kodepemda'=>$value->id])

          ];

          

          $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_p,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.kependudukan.chart.k',['kodepemda'=>$value->id])

          ];
          $series[2]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_kk,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.kependudukan.chart.k',['kodepemda'=>$value->id])



          ];

          $series_map[]=[
            'id'=>$value->id,
            'name'=>$value->name,
            'value'=>(float)$value->jumlah_l+(float)$value->jumlah_p,
            'y'=>(float)$value->jumlah_l+(float)$value->jumlah_p,
            'data_map'=>[
              [
                
                  'name'=>'JUMLAH PENDUDUK PRIA',
                  'y'=>(float)$value->jumlah_l,
                  'satuan'=>'Jiwa'
                
              ],
              [
                
                  'name'=>'JUMLAH PENDUDUK PEREMPUAN',
                  'y'=>(float)$value->jumlah_p,
                  'satuan'=>'Jiwa'
                
              ],
              [
                
                  'name'=>'JUMLAH KEPALA KELUARGA',
                  'y'=>(float)$value->jumlah_kk,
                  'satuan'=>'Jiwa'
                
              ]
            ]
          ];
      }

      return view('chart.compone_chart_2')->with(
        [ 'series'=>$series,
          'series_map'=>$series_map,
          'chart'=>[
            'chart.bar','chart.map'
          ],
          'title'=>'DATA PENDUDUK PER PROVINSI','subtitle'=>'',
          'child_f_prefix'=>"get_point_2(",
          'child_f_surfix'=>")",
          'scope_map'=>'idn',

        ])->render().view('chart.table')->with(['series'=>$series])->render();

    }

    public function get_jp_kota($kodepemda){
      $pemda=DB::table('provinsi')->where('kdprovinsi','=',$kodepemda)->first();
      $data=DB::table('kabkota as p')
      ->leftJoin('jumlah_penduduk_dan_kk as jp',DB::raw("left(jp.kode_desa,4)"),'=','p.kdkabkota')
      ->where(DB::raw("left(p.kdkabkota,2)"),$kodepemda)
      ->selectRaw("p.kdkabkota as id,p.nmkabkota as name,sum(jp.penduduk_pria) as jumlah_l,sum(jp.penduduk_wanita) as jumlah_p,sum(jp.kepala_keluarga) as jumlah_kk")
      ->groupBy('p.kdkabkota')
      ->get();
      $series=[
        [
          'name'=>'JUMLAH PENDUDUK PRIA',
          'data'=>[]

        ],
        [
          'name'=>'JUMLAH PENDUDUK PEREMPUAN',
          'data'=>[]

        ],
        [
          'name'=>'JUMLAH KEPALA KELUARGA',
          'data'=>[]

        ]

      ];
      $series_map=[];
      foreach ($data as $key => $value) {
          $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_l,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.kependudukan.chart.kc',['kodepemda'=>$value->id])

          ];
          $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_p,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.kependudukan.chart.kc',['kodepemda'=>$value->id])



          ];
          $series[2]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_kk,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.kependudukan.chart.kc',['kodepemda'=>$value->id])



          ];

          $series_map[]=[
            'id'=>$value->id,
            'name'=>$value->name,

            'data_map'=>[
              [
                
                  'name'=>'JUMLAH PENDUDUK PRIA',
                  'y'=>(float)$value->jumlah_l,
                  'satuan'=>'Jiwa',
                
              ],
              [
                
                  'name'=>'JUMLAH PENDUDUK PEREMPUAN',
                  'y'=>(float)$value->jumlah_p,
                  'satuan'=>'Jiwa'
                
              ],
              [
                
                  'name'=>'JUMLAH KEPALA KELUARGA',
                  'y'=>(float)$value->jumlah_kk,
                  'satuan'=>'Jiwa'
                
              ]
            ]
          ];
      }

     return view('chart.compone_chart_2')->with(
      [ 'series'=>$series,
          'series_map'=>$series_map,
          'chart'=>[
            'chart.bar','chart.map'
          ],
        'title'=>'DATA PENDUDUK PER KOTA/KAB  PROVINSI '.$pemda->nmprovinsi,
        'subtitle'=>'',
        'child_f_prefix'=>"get_point_3(",
          'child_f_surfix'=>")",
          'scope_map'=>'idn_'.$kodepemda,

        ])->render().view('chart.table')->with(['series'=>$series])->render();
    }

     public function get_jp_kecamatan($kodepemda){
      $pemda=DB::table('kabkota')->where('kdkabkota','=',$kodepemda)->first();
      $data=DB::table('kecamatan as p')
      ->leftJoin('jumlah_penduduk_dan_kk as jp',DB::raw("left(jp.kode_desa,7)"),'=','p.kdkecamatan')
      ->where(DB::raw("left(p.kdkecamatan,4)"),'like',$kodepemda)
      ->selectRaw("p.kdkecamatan as id,p.nmkecamatan as name,sum(jp.penduduk_pria) as jumlah_l,sum(jp.penduduk_wanita) as jumlah_p,sum(jp.kepala_keluarga) as jumlah_kk")
      ->groupBy('p.kdkecamatan')
      ->get();
      $series=[
        [
          'name'=>'JUMLAH PENDUDUK PRIA',
          'data'=>[]

        ],
        [
          'name'=>'JUMLAH PENDUDUK PEREMPUAN',
          'data'=>[]

        ],
        [
          'name'=>'JUMLAH KEPALA KELUARGA',
          'data'=>[]

        ]

      ];
      $series_map=[];
      foreach ($data as $key => $value) {
          $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_l,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.kependudukan.chart.d',['kodepemda'=>$value->id])

          ];
          $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_p,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.kependudukan.chart.d',['kodepemda'=>$value->id])



          ];
          $series[2]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_kk,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.kependudukan.chart.d',['kodepemda'=>$value->id])



          ];

         
      }

     return view('chart.bar')->with(
      [ 'series'=>$series,
        
        'title'=>'DATA PENDUDUK PER-KECAMATAN '.$pemda->nmkabkota,
        'subtitle'=>'',
        'child_f_prefix'=>"get_point_4(",
        'child_f_surfix'=>")",

        ])->render().view('chart.table')->with(['series'=>$series])->render();
    }


    public function get_jp_desa($kodepemda){
      $pemda=DB::table('kecamatan')->where('kdkecamatan','=',$kodepemda)->first();
      $data=DB::table('master_desa as p')
      ->leftJoin('jumlah_penduduk_dan_kk as jp',DB::raw("jp.kode_desa"),'=','p.kode_dagri')
      ->where(DB::raw("left(p.kode_dagri,7)"),'like',DB::raw("'".$kodepemda."'"))
      ->selectRaw("p.kode_dagri AS id,p.desa as name,sum(jp.penduduk_pria) as jumlah_l,sum(jp.penduduk_wanita) as jumlah_p,sum(jp.kepala_keluarga) as jumlah_kk")
      ->groupBy('p.kode_dagri')
      ->get();
      $series=[
        [
          'name'=>'JUMLAH PENDUDUK PRIA',
          'data'=>[]

        ],
        [
          'name'=>'JUMLAH PENDUDUK PEREMPUAN',
          'data'=>[]

        ],
        [
          'name'=>'JUMLAH KEPALA KELUARGA',
          'data'=>[]

        ]

      ];
      foreach ($data as $key => $value) {
          $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_l,
            'satuan'=>'Jiwa','id'=>$value->id,


          ];
          $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_p,
          'id'=>$value->id,



          ];
          $series[2]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->jumlah_kk,
            'satuan'=>'Jiwa','id'=>$value->id,



          ];
      }

      return view('chart.bar')->with(
        ['series'=>$series,
        'title'=>'DATA PENDUDUK PER-DESA  KECAMATAN '.$pemda->nmkecamatan,
        'subtitle'=>'',

      ])->render().view('chart.table')->with(['series'=>$series])->render();
    }
}
