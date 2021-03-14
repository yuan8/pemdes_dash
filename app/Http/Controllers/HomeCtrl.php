<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Alert;
class HomeCtrl extends Controller
{
    //

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
