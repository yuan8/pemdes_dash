<?php

namespace App\Http\Controllers\DASH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class PotensiCtrl extends Controller
{


	public function iklim(Request $request){

		if($request->id){
			$data=DB::table('data')->where('id',$request->id)->first();
		return view('dash.potensi.iklim')->with('category',$data);

		}
	}

	public function iklim_p(){
		$data=DB::table('provinsi as p')
        ->leftJoin('dash_potensi_iklim_tanah_erosi as jp',DB::raw("left(jp.kode_desa,2)"),'=','p.kdprovinsi')
        ->selectRaw("p.kdprovinsi as id,
        	(select count(distinct(d.kode_bps)) from master_desa as d where left(d.kode_bps,2)=p.kdprovinsi) as jumlah_desa,
        	count(distinct(jp.kode_desa)) as jumlah_desa_mengisi,
        	p.nmprovinsi as name,avg(jp.Curah_Hujan_mm) as Curah_Hujan_mm,avg(jp.Jumlah_Bulan_Hujan_bulan) as Jumlah_Bulan_Hujan_bulan,avg(jp.Kelembapan_Udara_persen) as Kelembapan_Udara_persen,avg(jp.Suhu_Rata_Rata_Harian_oC) as Suhu_Rata_Rata_Harian_oC")
        ->groupBy('p.kdprovinsi')
        ->where('p.kdprovinsi','<>',0)
        ->get();

        $data=json_decode(json_encode($data),true);
        $series=[
          [
            'name'=>'CURAH HUJAN',
            'key_v'=>'Curah_Hujan_mm',
            'data'=>[],
            'yAxis'=>0,

          ],
          [
            'name'=>'JUMLAH BULAN HUJAN',
            'data'=>[],
            'key_v'=>'Jumlah_Bulan_Hujan_bulan',        
            'yAxis'=>0,


          ],
          [
            'name'=>'KELEMBABAN UDARA',
            'data'=>[],
            'key_v'=>'Kelembapan_Udara_persen',        
            'yAxis'=>1,


          ],
           [
            'name'=>'SUHU RATA RATA HARIAN',
            'data'=>[],
            'key_v'=>'Suhu_Rata_Rata_Harian_oC',        
            
            'yAxis'=>1,


          ],
         

        ];

        $series_map=[];


        foreach ($data as $key => $value) {
            $series[0]['data'][]=[
              'name'=>$value['name'],
              'y'=>(float)$value[$series[0]['key_v']],
              'satuan'=>'mm',
              'id'=>$value['id'],
              'route'=>route('d.luas_desa.chart.k',['kodepemda'=>$value['id']])


            ];

            

            $series[1]['data'][]=[
              'name'=>$value['name'],
              'y'=>(float)$value[$series[1]['key_v']],
              'satuan'=>'Desa',
              'id'=>$value['id'],

              'route'=>route('d.luas_desa.chart.k',['kodepemda'=>$value['id']])


            ];

             $series[2]['data'][]=[
              'name'=>$value['name'],
              'y'=>(float)$value[$series[2]['key_v']],
              'satuan'=>'Ha',
              'id'=>$value['id'],
              'route'=>route('d.luas_desa.chart.k',['kodepemda'=>$value['id']])


            ];

             $series[3]['data'][]=[
              'name'=>$value['name'],
              'y'=>(float)$value[$series[3]['key_v']],
              'satuan'=>'C',
              'id'=>$value['id'],
              'route'=>route('d.luas_desa.chart.k',['kodepemda'=>$value['id']])


            ];
            

            $series_map[]=[];
        }


          return view('chart.compone_chart_2')->with(
        	[ 'series'=>$series,
            	'series_map'=>$series_map,
           
            'chart'=>[
              'chart.bar','chart.map'
            ],

          'title'=>'KONDISI IKLIM TANAH EROSI RATA RATA',
          'subtitle'=>'',
          'child_f_prefix'=>"get_point_2(",
        'child_f_surfix'=>")",
        'scope_map'=>'idn',
        ])->render().view('chart.table')->with(['series'=>$series,'child_f_prefix'=>"get_point_2(",
        'child_f_surfix'=>")"])->render();


      
	}

}