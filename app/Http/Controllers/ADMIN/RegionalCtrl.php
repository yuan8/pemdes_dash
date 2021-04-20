<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Alert;
class RegionalCtrl extends Controller
{
    //

    public function add($tahun){

        $daerah=DB::table('provinsi')->selectRaw("kdprovinsi as id,nmprovinsi as text ")->get();
                   
        return view('admin.regional.tambah')->with(['daerah'=>$daerah]);

    }

    public function index(Request $request){
    	$data=DB::table('master_regional as r');
    	if($request->q){

    		$data=$data->where('name','like','%'.$request->q.'%');

    	}
    	$data=$data->leftJoin('master_regional_detail as d','r.id','=','d.id_regional')
    	->groupBy('r.id')
    	->selectRaw("r.*,count(distinct(d.kode_daerah)) as count")
    	->paginate(15);

        $data->appends(['q'=>$request->q]);

    	return view('admin.regional.index')->with(['data'=>$data]);
    }

    public function store($tahun,Request $request){
        $data=DB::table('master_regional')->insertGetId([
            'name'=>$request->name
        ]);

        if($data){
             foreach($request->anggota??[] as $d){
                DB::table('master_regional_detail')->insertOrignore([
                    'id_regional'=>$data,
                    'kode_daerah'=>$d
                ]);
            }

        }
            Alert::success('Berhasil');


        return redirect()->route('admin.region.index',['tahun'=>$GLOBALS['tahun_access']]);
    }


    public function show($tahun,$id){
                $data=DB::table('master_regional as r')->where('id',$id)->first();

                if($data){
                     $daerah=DB::table('provinsi')->selectRaw("kdprovinsi as id,nmprovinsi as text ")->get();
                     $data_req=DB::table('master_regional_detail')->where('id_regional',$id)->get()->pluck('kode_daerah')->toArray();
                    return view('admin.regional.detail')->with(['data'=>$data,'daerah'=>$daerah,'data_req'=>$data_req]);
                }else{
                    return abort(404);
                }
    }

    public function update($tahun,$id,Request $request){
        $data=DB::table('master_regional as r')->where('id',$id)->first();
        if($data){

            DB::table('master_regional as r')->where('id',$id)->update([
                'name'=>$request->name
            ]);

            foreach($request->anggota??[] as $d){
                DB::table('master_regional_detail')->insertOrignore([
                    'id_regional'=>$id,
                    'kode_daerah'=>$d
                ]);
            }

            if($request->anggota){
                  DB::table('master_regional_detail')
                  ->where('id_regional',$id)
                  ->whereNotIn('kode_daerah',$request->anggota)->delete();
            }
            Alert::success('Berhasil');

            return back();



        }else{
            return abort(404);

        }
    }

   public function delete($tahun,$id){
     $data=DB::table('master_regional')->where('id',$id)->delete();
        if($data){
            Alert::success('Berhasil');

        }else{
            Alert::error('Gagal');

        }

        return back();

    }
}
