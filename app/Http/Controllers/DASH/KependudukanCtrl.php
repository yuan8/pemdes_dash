<?php

namespace App\Http\Controllers\DASH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class KependudukanCtrl extends Controller
{
    //

    public function index(){

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
      }

      return view('chart.column')->with(
        ['series'=>$series,'title'=>'DATA PENDUDUK PER PROVINSI','subtitle'=>'',
        'child_f_prefix'=>"get_point_2(",
        'child_f_surfix'=>")"
      ])->render().view('chart.table')->with(['series'=>$series])->render();
    }

    public function get_jp_kota($kodepemda){
      $data=DB::table('master_daerah as p')
      ->leftJoin('jumlah_penduduk_dan_kk as jp',DB::raw("left(jp.kode_desa,4)"),'=','p.id')
      ->where('p.kode_daerah_parent',$kodepemda)
      ->selectRaw("p.id,p.nama_pemda as name,sum(jp.penduduk_pria) as jumlah_l,sum(jp.penduduk_wanita) as jumlah_p,sum(jp.kepala_keluarga) as jumlah_kk")
      ->groupBy('p.id')
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

      return view('chart.column')->with(
        ['series'=>$series,'title'=>'DATA PENDUDUK PER KOTA/KAB '.DB::table('master_daerah')->find($kodepemda)->nama_pemda,'subtitle'=>'',
        'child_f_prefix'=>"get_point_3(",
        'child_f_surfix'=>")"
      ])->render().view('chart.table')->with(['series'=>$series])->render();
    }

    public function get_jp_desa($kodepemda){
      $data=DB::table('master_desa as p')
      ->leftJoin('jumlah_penduduk_dan_kk as jp',DB::raw("jp.kode_desa"),'=','p.kode_dagri')
      ->where(DB::raw("left(p.kode_dagri,4)"),'like',DB::raw("'".$kodepemda."'"))
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

      return view('chart.column')->with(
        ['series'=>$series,'title'=>'DATA PENDUDUK PER DESA  '.DB::table('master_daerah')->find($kodepemda)->nama_pemda,'subtitle'=>'',

      ])->render().view('chart.table')->with(['series'=>$series])->render();
    }
}
