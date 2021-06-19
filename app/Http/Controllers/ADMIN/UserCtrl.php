<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Validator;
use Alert;
class UserCtrl extends Controller
{
    //

    public function list_user_daerah($tahun,$kodedaerah,Request $request){
    	$daerah=$request['amp;daerah'];
    	$nama_data=$request['data'];
    	$data=DB::table('users')->where('kode_daerah',$kodedaerah)->where('role',4)->get();
    	return view('admin.users.list_daerah_user')->with(['nama_data'=>$nama_data,'data'=>$data,'daerah'=>$daerah]);
    }


    public function index($tahun,Request $request){
        $data=DB::table('users');

        if($request->q){
            $data=$data->where('name','like','%'.$request->q.'%');
        }

        $data=$data->paginate(10);

        return view('admin.users.index')->with(['data'=>$data]);


    }

    public function up_profile($tahun,$id,Request $request){
        $u=Auth::User();
        if(($u->role==1)OR ($id==$u->id)){

            $data=[
                'name'=>$request->name,
                'username'=>str_replace(' ', '_', trim(($request->username))),
                'email'=>$request->email,
            ];

            $valid=Validator::make($data,[
                'name'=>'required|string|min:3',
                'email'=>'required|email',
                'username'=>'required|string',


            ]);

            if($valid->fails()){
                Alert::error('Gagal',$valid->errors()->first());
                return back()->withError();
            }

            $check=DB::table('users')->whereRaw(
                "
                (id != ".$id.") and (username ='".$data['username']."') OR 
                (id != ".$id.") and (email ='".$data['email']."')
                "
            )->first();
            if($check){
                 Alert::error('Gagal','username atau email telah digunakan sebelumya');
                 return back();
            }

            if($u->can('is_super')){
                $data['is_active']=($request->is_active)?true:false;
                $data['role']=$request->role;
            }

            DB::table('users')->where('id',$id)->update($data);

            Alert::success('Berhasil','Update Profil User');

          

            if($u->can('is_super') ){

                 foreach ($request->instansi??[] as $key => $value) {
                     DB::table('user_instansi')->insertOrIgnore([
                        'user_id'=>$id,
                        'instansi_id'=>$value,

                     ]);
                }

                if($request->instansi){
                     DB::table('user_instansi')
                      ->where('user_id',$id)
                      ->whereNotIn('instansi_id',$request->instansi??[])->delete();
                }
                
                foreach ($request->role_group??[] as $key => $value) {
                    DB::table('users_group')->insertOrIgnore([
                        'id_user'=>$id,
                        'id_regional'=>$value
                    ]);

                }

                if($request->role_group){
                     DB::table('users_group')
                      ->where('id_user',$id)
                      ->whereNotIn('id_regional',$request->role_group??[])->delete();
                }

                 

                Alert::success('Berhasil','Update Akses Berhasil');
               

            }else{
            }



            if($request->action_to=='UPDATE_AND_BACKTOFORM'){
                return back();
            }else{
                return redirect()->route('admin.users.index',['tahun'=>$tahun]);
            }
        }
    }

    public function up_access($tahun,$id,Request $request){
        $u=Auth::User();

        if($u->can('is_super')){
            foreach ($request->role_group??[] as $key => $value) {
                DB::table('users_group')->insertOrIgnore([
                    'id_user'=>$id,
                    'id_regional'=>$value
                ]);

            }

              DB::table('users_group')
              ->where('id_user',$id)
              ->whereNotIn('id_regional',$request->role_group??[])->delete();

            Alert::success('Berhasil','Update Akses Berhasil');
            if($request->action_to=='UPDATE_AND_BACKTOFORM'){
                return back();
            }else{
                return redirect()->route('admin.users.index',['tahun'=>$tahun]);
            }



        }else{
            Alert::error('Access Denied','');
            return back();
        }

    }

     public function up_pass($tahun,$id,Request $request){
        $u=Auth::User();
        if(($u->can('is_super'))OR ($id=$u->id)){
            $data=[
                'password'=>MyHash::pass_encode($request->password),
            ];

                $valid=Validator::make($request->all(),[
                    'password'=>'required|min:8'
                ]);

                if($valid->fails()){                    
                    Alert::error('Error',$valid->errors()->first());
                    return back();
                }

            if(!$u->can('is_super')){
                $valid=Validator::make($request->all(),[
                    'password'=>'required|min:8|confirmed'
                ]);

                if($valid->fails()){                    
                    Alert::error('Error',$valid->errors()->first());
                    return back();

                    
                }
            }

             DB::table('users')->where('id',$id)->update($data);
            Alert::success('Berhasil','Update Password Berhasil');
            if($request->action_to=='UPDATE_AND_BACKTOFORM'){
                return back();
            }else{
                return redirect()->route('admin.users.index',['tahun'=>$tahun]);
            }
        }
    }

    public function show($tahun,$id){
        $data=DB::table('users')->find($id);
        $daerah_access=null;
        if($data){
            $data_regional=[];
            $data->daerah_selected=null;
            if($data->role>3){
                $level_kode=strlen(trim($data->kode_daerah));
                switch ($level_kode) {
                    case 2:
                        $daerah_access=DB::table('master_provinsi as pro')->where('kdprovinsi',$data->kode_daerah)
                        ->selectraw('kdprovinsi as id,nmprovinsi as text')->first();

                            $data->level_daerah='provinsi';
                       
                        break;
                    case 4:
                        $daerah_access=DB::table('master_kabkota as kab')->where('kdkabkota',$data->kode_daerah)
                        ->selectraw("kdkabkota as id,concat(nmkabkota,' - ',(select nmprovinsi from master_provinsi where left(kdkabkota,2)=kdprovinsi limit 1))  as text")->first();
                        $data->level_daerah='kab_kota';

                        # code...
                        break;
                    case 6:
                         $daerah_access=DB::table('master_kecamatan as kec')->where('kdkecamatan',$data->kode_daerah)
                        ->selectraw("kdkecamatan as id,concat(nmkecamatan,' - ',(select nmkabkota from kabkota where kdkabkota = left(kdkecamatan,4) limit 1),' - ',(select nmprovinsi from provinsi where left(kdkecamatan,2)=kdprovinsi limit 1))  as text")->first();
                        $data->level_daerah='kecamatan';

                        break;
                    case 10:
                        $daerah_access=DB::table('master_desa as des')->where('kode_dagri',$data->kode_daerah)
                        ->selectraw("kdkecamatan as id,concat(nmkecamatan,' - ',(select nmkabkota from kabkota where kdkabkota = left(kode_dagri,4) limit 1),' - ',(select nmprovinsi from provinsi where left(kode_dagri,2)=kdprovinsi limit 1))  as text")->first();
                        $data->level_daerah='desa';

                        break;
                    
                    default:
                        # code...
                        break;
                }

                $data->daerah_selected=$daerah_access;

            }else if($data->role==3){
                $data_regional=DB::table('users_group as ug')
                ->where('ug.id_user',$data->id)
                ->join('master_regional as r','r.id','=','ug.id_regional')
                ->selectraw('ug.id_regional')
                ->get()
                ->pluck('id_regional');
                $data->level_daerah='regional';
                $data->kode_daerah=null;

                $data->daerah_selected=$data_regional;

            }



            
            $instansi=DB::table('master_instansi as c')
            ->get();

            // dd($instansi);
             // $instansi_user=DB::table('user_instansi')
             // ->where('user_id',$id)->select('instansi_id')->get()->pluck('instansi_id')->toArray();

            $daerah=DB::table('master_kabkota as k')->join(
                'master_provinsi as p','p.kdprovinsi','=',DB::raw("LEFT(k.kdkabkota,2)")
            )->selectraw("k.kdkabkota as id,CONCAT(p.nmprovinsi,' - ',k.nmkabkota) as text")
            ->get();

            // ,'record_instansi'=>$instansi_user
            $regional_list=DB::table('master_regional')->get();
            return view('admin.users.detail')->with(['data'=>$data,'regional_list_acc'=>$data_regional,'regional_list'=>$regional_list,'daerah_ac'=>$daerah_access,'instansi'=>$instansi]);
        }

    }

    public function add($tahun){
            return view('admin.users.add');
    }

     public function store($tahun,Request $request){

        $data=DB::table('users')->insertOrIgnore([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>MyHash::pass_encode($request->password),
            'role'=>in_array($request->role, [1,2,3,4])?$request->role:2,
            'api_token'=>Hash::make($request->email),
            'is_active'=>((boolean)$request->is_active)==true?true:false
        ]);

        if($data){
            return redirect()->route('admin.users.index',['tahun'=>$GLOBALS['tahun_access']]);
        }


            
    }
}
