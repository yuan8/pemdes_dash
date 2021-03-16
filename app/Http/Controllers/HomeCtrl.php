<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Alert;
class HomeCtrl extends Controller
{
    //

    public function get_data_description($tahun,$id){

        $description='-';
        $data=DB::table('data')->where([
            'id'=>$id
        ])->first();
        if($data){
            $description=$data->description;
            return view('api.data.description')->with('data'=>$description);

        }else{
            '';
        }

    }

    public function cat_desa($tahun){
        $data=[
            [
                'name'=>'Prodeskel',
                'link'=>'http://prodeskel.binapemdes.kemendagri.go.id',
                'data'=>(array)DB::connection('mysql')->table('dash_klasifikasi as d')
                        ->selectRaw("(select count(distinct(dd.kode_bps)) from master_desa as dd ) as jumlah_desa,count(distinct(d.kode_desa)) as count,d.klasifikasi")
                        ->groupBy('d.klasifikasi')
                        ->where('d.tahun',$tahun)
                        
                        ->get()->toArray()
                        ,'rekap'=>[]

            ],
             [
                'name'=>'Epdeskel',
                'link'=>'http://epdeskel.binapemdes.kemendagri.go.id',
                'data'=>DB::connection('mysql')->table('status_deskel as d')
                        ->selectRaw("(select count(distinct(dd.kode_bps)) from master_desa as dd ) as jumlah_desa,count(distinct(d.kode_desa)) as count,d.klasifikasi")
                        ->groupBy('d.klasifikasi')
                        ->where('d.tahun',$tahun)
                        ->get()->toArray(),
                        'rekap'=>[]

            ],

        ];
        foreach ($data as $key => $value) {
            foreach ($value['data'] as $i => $c){

                $data[$key]['data'][$i]=(array)$c;
                $value['data'][$i]=(array)$c;

            }

            if(!isset($data[$key]['rekap']['jumlah_desa'])){
                $data[$key]['rekap']=[
                    'jumlah_desa'=>(int)isset($value['data'][0]['jumlah_desa'])?$value['data'][0]['jumlah_desa']:0,
                    'count'=>isset($value['data'][0]['count'])?(int)$value['data'][0]['count']:0
                ];
            }else{
                foreach ($value['data'] as $i => $c) {
                    # code...
                    if($key>0){
                     $data[$key]['rekap']['count']+=(int)$c['count'];

                    }
                }
            }

        }


        return [
            'status'=>200,
            'data'=>view('glob.klasifikasi')->with('data',$data)->render()
        ];
    }

    public function index($tahun=null){


    	$tema=DB::table('category')->whereIn('type',['TEMA_DATA_UTAMA'])->where('id_parent','=',null)->get();
    	
    	$tema2=DB::table('category')->whereIn('type',['TEMA_DATA_PENDUKUNG'])->where('id_parent','=',null)->get();
    	
    	return view('index')->with(['tema'=>$tema,'tema2'=>$tema2]);

    }

    public function pindahTahun($tahun){
    	$tahuns=DB::table('tahun_access')->get();
    	return view('pindah_tahun')->with(['tahuns'=>$tahuns]);
    }

    public function pindahkanTahun($tahun,Request $request){
        $r=url('/v/'.$request->tahun_new);
        $url=$request->url();
        $url_main=str_replace('/','\/',url(''));
        $mm=('/'.$url_main.'\/(admin|v)\/[2-9][0-9][0-9][0-9]/');
        preg_match($mm, $request->url(), $output_array);

        $skop='v';

        if(isset($output_array[1])){
            $skop=$output_array[1];
            $s=$skop.'/'.$request->tahun_new;
            $url_new=preg_replace('/(admin|v)\/[2-9][0-9][0-9][0-9]/', $s, $request->url());

            session(['change_tahun',$request->tahun_new]);
            Alert::success('Berhasil', 'Tahun Berhasil Dipindahkan');

            return redirect($url_new);
        }

        return back();



       
    }
}
