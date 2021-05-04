<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Alert;
use Validator;
use Storage;
use Carbon\Carbon;
class InstansiCtrl extends Controller
{
    //
      public function index(Request $request){
    	$data=DB::table('master_instansi as r');

    	if($request->q){
    		$data=$data->where([
                ['r.name','like','%'.$request->q.'%'],
                ]
            );
            
           

    	}
        
    	$data=$data->leftJoin('tb_data_instansi as d','r.id','=','d.id_instansi')
    	->groupBy('r.id')
    	->selectRaw("r.*,count(distinct(d.id)) as count")
    	->paginate(15);
        $data->appends(['q'=>$request->q]);

    	return view('admin.instansi.index')->with(['data'=>$data]);
    }

    public function show($tahun,$id,$slug,Request $request){
        $data=DB::table('master_category')
        ->where('type','INSTANSI')->where('id',$id)->first();

        if($data){
            return view('admin.instansi.detail')->with(['data'=>$data]);

        }else{
            return abort(404);
        }
    }

    public function add(){
        return view('admin.instansi.tambah');
    }


    public function store($tahun,Request $request){
         $dataup=[
                'name'=>$request->name,
                'type'=>$request->sub_type,
                'kode_daerah'=>($request->sub_type=='PEMDA KOTA/KAB'?$request->kode_daerah:null),
                'deskripsi'=>$request->deskripsi,
                'id_user'=>Auth::User()->id,
                'id_user_update'=>Auth::User()->id,
                'updated_at'=>Carbon::now(),
                'created_at'=>Carbon::now()
            ];


            if($request->image_path){
                $path=Storage::put('public/c/image',$request->image_path);
                $path=Storage::url($path);
                $dataup['image_path']=$path;
            }else{
                $dataup['image_path']='/logo.png';
            }

             $data=DB::table('master_instansi')->insert($dataup);
             if($data){
                Alert::success('Berhasil');
                return redirect()->route('admin.instansi.index',['tahun'=>$GLOBALS['tahun_access']]);
             }else{
                Alert::success('Gagal');
                return back()->withInput();
             }
    }

    public function update($tahun,$id,Request $request){
         $data=DB::table('master_category')
        ->where('type','INSTANSI')->where('id',$id)->first();

        if($data){

            $dataup=[
                'name'=>$request->name,
                'sub_type'=>$request->sub_type,
                'description'=>$request->description,
                'updated_at'=>Carbon::now()
            ];

            if($request->image_path){
                $path=Storage::put('public/c/image',$request->image_path);
                $path=Storage::url($path);
                $dataup['image_path']=$path;
            }
            $data=DB::table('master_category')->where('id',$id)->update($dataup);
            Alert::success('Berhasil','Data telah diupdate');
            return back();

        }else{
            Alert::error('Gagal','data tidak tersedia');
            return redirect()->route('admin.instansi.index',['tahun'=>$GLOBALS['tahun_access']]);
        }

    }

    public function delete($tahun,$id){
        $data=DB::table('master_category')
        ->where('type','INSTANSI')->where('id',$id)->delete();

        if($data){
            Alert::success('Berhasil','Data telah dihapus');

        }else{
            Alert::error('Gagal','data tidak tersedia');

        }
        return back();
    }
}
