<?php

namespace App\Http\Controllers\DASH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class PendidikanCtrl extends Controller
{
    //
     public function index(){

      // 

      return view('dash.kependudukan.pendidikan');

    }

    public function get_pp_provinsi(){
    	$title='TINGKAT PENDIDIKAN PENDUDUK PERPROVINSI';

    	$data=DB::table('provinsi as p')
      ->leftJoin('dash_ddk_pendidikan as jp',DB::raw("left(jp.kode_desa,2)"),'=','p.kdprovinsi')
      ->selectRaw("p.kdprovinsi as id,p.nmprovinsi as name,sum(jp.tidak_sekolah) as tidak_sekolah,sum(jp.sd) as sd,sum(jp.smp) as smp,sum(jp.sma) as sma,sum(jp.pt) as pt")
      ->groupBy('p.kdprovinsi')
      ->where('p.kdprovinsi','<>',0)
      ->get();


      $series=[
        [
          'name'=>'JUMLAH PENDUDUK TIDAK SEKOLAH',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SD',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SMP',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SMA',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT PERGURUAN TINGGI',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ]

      ];

       foreach ($data as $key => $value) {
          $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->tidak_sekolah,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.k',['kodepemda'=>$value->id])

          ];

         
          $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->sd,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.k',['kodepemda'=>$value->id])

          ];
          $series[2]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->smp,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.k',['kodepemda'=>$value->id])

          ];
           $series[3]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->sma,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.k',['kodepemda'=>$value->id])

          ];
           $series[4]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->pt,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.k',['kodepemda'=>$value->id])

          ];

         
      }

      return view('chart.table')->with(['series'=>$series,'child_f_prefix'=>"get_point_2(",
          'child_f_surfix'=>")",'title'=>$title])->render();


    }

    public function get_pp_kota($kodepemda){
    	$pemda=DB::table('provinsi')->where('kdprovinsi','=',$kodepemda)->first();
    	$title='TINGKAT PENDIDIKAN PENDUDUK PER KOTA/KAB PROVINSI '.$pemda->nmprovinsi;

      $data=DB::table('kabkota as p')
      ->leftJoin('dash_ddk_pendidikan as jp',DB::raw("left(jp.kode_desa,4)"),'=','p.kdkabkota')
      ->selectRaw("p.kdkabkota as id,p.nmkabkota as name,sum(jp.tidak_sekolah) as tidak_sekolah,sum(jp.sd) as sd,sum(jp.smp) as smp,sum(jp.sma) as sma,sum(jp.pt) as pt")
      ->groupBy('p.kdkabkota')
      ->where(DB::raw("left(p.kdkabkota,2)"),'=',$kodepemda)
      ->get();


      $series=[
        [
          'name'=>'JUMLAH PENDUDUK TIDAK SEKOLAH',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SD',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SMP',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SMA',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT PERGURUAN TINGGI',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ]

      ];

       foreach ($data as $key => $value) {
          $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->tidak_sekolah,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.kc',['kodepemda'=>$value->id])

          ];

         
          $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->sd,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.kc',['kodepemda'=>$value->id])

          ];
          $series[2]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->smp,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.kc',['kodepemda'=>$value->id])

          ];
           $series[3]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->sma,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.kc',['kodepemda'=>$value->id])

          ];
           $series[4]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->pt,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.kc',['kodepemda'=>$value->id])

          ];

         
      }

      return view('chart.table')->with(['series'=>$series,'child_f_prefix'=>"get_point_3(",
          'child_f_surfix'=>")",'title'=>$title])->render();


    }

    public function get_pp_kecamatan($kodepemda){
    	$pemda=DB::table('kabkota')->where('kdkabkota','=',$kodepemda)->first();
    	$title='TINGKAT PENDIDIKAN PENDUDUK PER KECAMATAN '.$pemda->nmkabkota;

      $data=DB::table('kecamatan as p')
      ->leftJoin('dash_ddk_pendidikan as jp',DB::raw("left(jp.kode_desa,7)"),'=','p.kdkecamatan')
      ->selectRaw("p.kdkecamatan as id,p.nmkecamatan as name,sum(jp.tidak_sekolah) as tidak_sekolah,sum(jp.sd) as sd,sum(jp.smp) as smp,sum(jp.sma) as sma,sum(jp.pt) as pt")
      ->groupBy('p.kdkecamatan')
      ->where(DB::raw("left(p.kdkecamatan,4)"),'=',$kodepemda)

      ->get();


      $series=[
        [
          'name'=>'JUMLAH PENDUDUK TIDAK SEKOLAH',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SD',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SMP',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SMA',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT PERGURUAN TINGGI',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ]

      ];

       foreach ($data as $key => $value) {
          $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->tidak_sekolah,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.d',['kodepemda'=>$value->id])

          ];

         
          $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->sd,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.d',['kodepemda'=>$value->id])

          ];
          $series[2]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->smp,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.d',['kodepemda'=>$value->id])

          ];
           $series[3]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->sma,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.d',['kodepemda'=>$value->id])

          ];
           $series[4]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->pt,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.d',['kodepemda'=>$value->id])

          ];

         
      }

      return view('chart.table')->with(['series'=>$series,'child_f_prefix'=>"get_point_4(",
          'child_f_surfix'=>")",'title'=>$title])->render();


    }

    public function get_pp_desa($kodepemda){
    	$pemda=DB::table('kecamatan')->where('kdkecamatan','=',$kodepemda)->first();
    	$title='TINGKAT PENDIDIKAN PENDUDUK PER KECAMATAN '.$pemda->nmkecamatan;

      $data=DB::table('master_desa as p')
      ->leftJoin('dash_ddk_pendidikan as jp',DB::raw("(jp.kode_desa)"),'=','p.kode_dagri')
      ->selectRaw("p.kode_dagri as id,p.desa as name,sum(jp.tidak_sekolah) as tidak_sekolah,sum(jp.sd) as sd,sum(jp.smp) as smp,sum(jp.sma) as sma,sum(jp.pt) as pt")
      ->groupBy('p.kode_dagri')
      ->where(DB::raw("left(p.kode_dagri,7)"),'=',$kodepemda)

      ->get();


      $series=[
        [
          'name'=>'JUMLAH PENDUDUK TIDAK SEKOLAH',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SD',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SMP',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT SMA',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ],
        [
          'name'=>'JUMLAH PENDUDUK TAMAT PERGURUAN TINGGI',
          'data'=>[],
          // 'point_step'=>max($data->pluck('jumlah_l')->toArray())

        ]

      ];

       foreach ($data as $key => $value) {
          $series[0]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->tidak_sekolah,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.kc',['kodepemda'=>$value->id])

          ];

         
          $series[1]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->sd,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.kc',['kodepemda'=>$value->id])

          ];
          $series[2]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->smp,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.kc',['kodepemda'=>$value->id])

          ];
           $series[3]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->sma,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.kc',['kodepemda'=>$value->id])

          ];
           $series[4]['data'][]=[
            'name'=>$value->name,
            'y'=>(float)$value->pt,
            'satuan'=>'Jiwa','id'=>$value->id,
            'route'=>route('d.pendidikan.chart.kc',['kodepemda'=>$value->id])

          ];

         
      }

      return view('chart.table')->with(['series'=>$series,'title'=>$title])->render();


    }
}
