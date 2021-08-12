<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Validator;
use App\User;
use Alert;
use MyHash;
use Hash;
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
        
        $U=Auth::User();
        if($U->can('ac_super')){
        $data=User::where('id','!=',Auth::User()->id);

        }
        else if($U->can('ac_daerah') && Auth::User()->main_daerah){
            $data=User::where('kode_daerah','like',Auth::User()->kode_daerah.'%');
        }else if($U->can('ac_admin')){
            return abort(404);
        }

        

        if($request->q){
            $data=$data->where('name','like','%'.$request->q.'%');
        }

        $data=$data->where('id','!=',Auth::User()->id)->orderBy('kode_daerah','asc')->paginate(10);

        return view('admin.users.index')->with(['data'=>$data]);


    }

    public function up_profile($tahun,$id,Request $request){
        $u=Auth::User();
        $x=false;

        $ue=DB::table('users')->where('id',$id)->first();
        if(!$ue){
            return redirect()->route('admin.users.index',['tahun'=>$tahun]);
        }

        if($request->kode_daerah){
             $x=strpos((string)$request->kode_daerah??'x', (string)(!empty($u->kode_daerah)?$u->kode_daerah:$request->kode_daerah))!==false;
        }

        if(($u->role<=2) OR ($id==$u->id) OR $x ){

            $data=[
                'name'=>$request->name,
                'username'=>str_replace(' ', '_', trim(($request->username))),
                'email'=>$request->email,
                'nomer_telpon'=>$request->nomer_telpon,
                'wa_number'=>$request->wa_number=='on'?true:false,
                'wa_notif'=>$request->wa_notif=='on'?true:false,
                'nik'=>$request->nik?str_replace('-', '', trim($request->nik)):null,
                'nip'=>$request->nip?trim($request->nip):null,
                'api_access'=>$request->api_access?(true):false,

            ];

            if($u->can('ac_super')){
                    $data['role']=$request->role;
            }else if($ue->role){
                    $data['role']=$ue->role;
            }


            $data['kode_daerah']=($data['role']==4)?($request->kode_daerah??null):null;
            $data['main_daerah']=($data['role']==4)?true:false;


            // dd($data,$request->all());
            // if($id!=$u->id){

            //     $data['walidata']=($data['role']==4)?($request->walidata=='on'?true:false):false;
            //     if((string)$u->kode_daerah!=(string)$data['kode_daerah']){
                   
            //     }

            // }else{

            // }






            $valid=Validator::make($data,[
                'name'=>'required|string|min:3',
                'email'=>'required|email',
                'username'=>'required|string',
                'nomer_telpon'=>'required|string|min:11',
                'wa_notif'=>'nullable|boolean',
                'wa_number'=>'nullable|boolean',
                'kode_daerah'=>'nullable|numeric',

            ]);



            if($valid->fails()){
                Alert::error('Gagal',$valid->errors()->first());
                return back();
            }

           
            $check=DB::table('users')->whereRaw(
                "
                (id != ".$id.") and (username ='".$data['username']."') OR 
                (id != ".$id.") and (email ='".$data['email']."') OR
                (id != ".$id.") and (nik ='".$data['nik']."') OR
                (id != ".$id.") and (nip ='".$data['nip']."') 
                "
            )->first();

            if($check){
                 Alert::error('Gagal','username / email / NIK / NIP telah digunakan sebelumya');
                 return back();
            }

            if($u->can('is_super')){
                $data['is_active']=($request->is_active)?true:false;
                $data['role']=$request->role;
            }

            DB::table('users')->where('id',$id)->update($data);

            Alert::success('Berhasil','Update Profil User');

          

            if($u->can('is_super') ){
                if($request->id_instansi){
                    DB::table('tb_user_instansi')->updateOrInsert(
                        ['id_user'=>

                        $id]
                        ,[
                        'id_user'=>$id,
                        'id_instansi'=>$request->id_instansi
                    ]);
                }


                // foreach ($request->instansi??[] as $key => $value) {
                //      DB::table('user_instansi')->insertOrIgnore([
                //         'user_id'=>$id,
                //         'instansi_id'=>$value,

                //      ]);
                // }

                // if($request->instansi){
                //      DB::table('user_instansi')
                //       ->where('user_id',$id)
                //       ->whereNotIn('instansi_id',$request->instansi??[])->delete();
                // }
                
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
        $data=DB::table('users as u')
        ->leftJoin('tb_user_instansi as ui','ui.id_user','=','u.id')
        ->selectRaw('u.*,ui.id_instansi as id_instansi')->where('u.id',$id)->first();

        $daerah_access=null;
        if($data){
            $data_regional=[];
            $data->daerah_selected=null;
            $data->daerah_selected_regional=null;
            if($data->role>3){
                $level_kode=strlen(trim($data->kode_daerah));
                switch ($level_kode) {
                    case 2:
                        
                        $data->level_daerah='provinsi';
                        $data->daerah_selected=DB::table('master_provinsi')->selectraw("kdprovinsi as id,nmprovinsi as text")
                        ->where('kdprovinsi',$data->kode_daerah)
                        ->first();


                        break;
                    case 4:
                        
                        $data->level_daerah='kab_kota';
                         $data->daerah_selected=DB::table('master_kabkota')->selectraw("kdkabkota as id,concat(nmkabkota,' - ',nmprovinsi) as text")
                        ->where('kdkabkota',$data->kode_daerah)
                        ->first();

                        # code...
                        break;
                    case 6:
                       
                        $data->level_daerah='kecamatan';
                         $data->daerah_selected=DB::table('master_kecamatan')->selectraw("kdkecamatan as id,concat(nmkecamatan,' - ',nmkabkota,' - ',nmprovinsi) as text")
                        ->where('kdkecamatan',$data->kode_daerah)
                        ->first();

                        break;
                    case 10:
                       
                        $data->level_daerah='desa';
                        $data->daerah_selected=DB::table('master_desa')->selectraw("kddesa as id,concat(nmdesa,' - ',nmkecamatan,' - ',nmkabkota,' - ',nmprovinsi) as text")
                        ->where('kddesa',$data->kode_daerah)
                        ->first();

                        break;
                    
                    default:
                        # code...
                        break;
                }

               



            }else if($data->role==3){
                $data_regional=DB::table('users_group as ug')
                ->where('ug.id_user',$data->id)
                ->join('master_regional as r','r.id','=','ug.id_regional')
                ->selectraw('ug.id_regional')
                ->get()
                ->pluck('id_regional');
                $data->level_daerah='regional';
                $data->kode_daerah=null;

                $data->daerah_selected_regional=$data_regional;

            }


            $instansi=DB::table('master_instansi as c')
            ->get();

             

            $daerah=DB::table('master_kabkota as k')->join(
                'master_provinsi as p','p.kdprovinsi','=',DB::raw("LEFT(k.kdkabkota,2)")
            )->selectraw("k.kdkabkota as id,CONCAT(p.nmprovinsi,' - ',k.nmkabkota) as text")
            ->get();

            // ,'record_instansi'=>$instansi_user
            $regional_list=DB::table('master_regional')->get();
            return view('admin.users.detail')->with([
                'data'=>$data,
                'regional_list_acc'=>$data_regional,
                'regional_list'=>$regional_list,
                'daerah_ac'=>$daerah_access,
                'instansi'=>$instansi,
                'list_daerah_access'=>static::access_daerah($tahun)]);
        }

    }



    public function access_daerah_admin($tahun,Request $request){
        $scope=$request->scope??0;
        $data=[];
        switch ($scope) {
            case 2:
                $data=DB::table('master_provinsi')->selectraw('kdprovinsi as id,nmprovinsi as text')
                ->where(DB::raw("nmprovinsi"),'like','%'.$request->q.'%')
                ->limit(20)
                ->get()->toArray();
                # code...
                break;
             case 4:
                $data=DB::table('master_kabkota')->selectraw("kdkabkota as id,concat(nmkabkota,' - ',nmprovinsi) as text")
                ->where(DB::raw("concat(nmkabkota,' - ',nmprovinsi)"),'like','%'.$request->q.'%')->limit(20)->get()->toArray();
                # code...
                break;
            case 6:
                $data=DB::table('master_kecamatan')->selectraw("kdkecamatan as id,concat(nmkecamatan,' - ',nmkabkota,' - ',nmprovinsi) as text")
                ->where(DB::raw("concat(nmkecamatan,' - ',nmkabkota,' - ',nmprovinsi)"),'like','%'.$request->q.'%')->limit(20)
                ->get()->toArray();
                break;
            case 10:
                $data=DB::table('master_desa')->selectraw("kddesa as id,concat(nmdesa,' - ',nmkecamatan,' - ',nmkabkota,' - ',nmprovinsi) as text")
                ->where(DB::raw("concat(nmdesa,' - ',nmkecamatan,' - ',nmkabkota,' - ',nmprovinsi)"),'like','%'.$request->q.'%')->limit(20)
                ->get()->toArray();
            break;
            
            default:
                # code...
                break;
        }

        return array('items'=>$data);
    }

    public static function access_daerah($tahun){
        $data=Auth::User();
        $daerah_access_inher=[];
        if($data){
            if($data->role==4){
                 switch (strlen($data->kode_daerah)) {
                    case 2:
                        $provinsi=DB::table('master_provinsi')->selectraw('kdprovinsi as id,nmprovinsi as text')->where('kdprovinsi','like',$data->kode_daerah.'%')->get()->toArray();

                         $kota=DB::table('master_kabkota')->selectraw('kdkabkota as id,nmkabkota as text')->where('kdkabkota','like',$data->kode_daerah.'%')->get()->toArray();

                        $kecamatan=DB::table('master_kecamatan')->selectraw("kdkecamatan as id,concat(nmkecamatan,' - ',nmkabkota) as text")->where('kdkecamatan','like',$data->kode_daerah.'%')->get()->toArray();

                         $desa=DB::table('master_desa')->selectraw("kddesa as id,concat('DESA ',nmdesa,' - ',nmkecamatan) as text")->where('kddesa','like',$data->kode_daerah.'%')->get()->toArray();

                         $daerah_access_inher=array_merge($provinsi,$kota,$kecamatan,$desa);

                        # code...
                        break;
                    case 4:
                     $kota=DB::table('master_kabkota')->selectraw('kdkabkota as id,nmkabkota as text')->where('kdkabkota','like',$data->kode_daerah.'%')->get()->toArray();
                        $kecamatan=DB::table('master_kecamatan')->selectraw("kdkecamatan as id,concat(nmkecamatan,' - ',nmkabkota) as text")->where('kdkecamatan','like',$data->kode_daerah.'%')->get()->toArray();
                        $desa=DB::table('master_desa')->selectraw("kddesa as id,concat('DESA ',nmdesa,' - ',nmkecamatan) as text")->where('kddesa','like',$data->kode_daerah.'%')->get()->toArray();
                        $daerah_access_inher=array_merge($kota,$kecamatan,$desa);


                    break;

                      case 6:
                     
                        $kecamatan=DB::table('master_kecamatan')->selectraw("kdkecamatan as id,concat(nmkecamatan,' - ',nmkabkota) as text")->where('kdkecamatan','like',$data->kode_daerah.'%')->get()->toArray();

                        $desa=DB::table('master_desa')->selectraw("kddesa as id,concat('DESA ',nmdesa,' - ',nmkecamatan) as text")->where('kddesa','like',$data->kode_daerah.'%')->get()->toArray();

                        $daerah_access_inher=array_merge($kecamatan,$desa);


                    break;

                        case 10:
                     
                        $kecamatan=DB::table('master_kecamatan')->selectraw("kdkecamatan as id,concat(nmkecamatan,' - ',nmkabkota) as text")->where('kdkecamatan','like',$data->kode_daerah.'%')->get()->toArray();

                        $desa=DB::table('master_desa')->selectraw("kddesa as id,concat('DESA ',nmdesa,' - ',nmkecamatan) as text")->where('kddesa','like',$data->kode_daerah.'%')->get()->toArray();

                        $daerah_access_inher=array_merge($kecamatan,$desa);


                    break;
                    
                    default:
                        # code...
                        break;
                }
            }else{
                
            }
        }

        return $daerah_access_inher;
    }



    public function add($tahun){

            return view('admin.users.add')->with([
                'list_daerah_access'=>static::access_daerah($tahun),
                'regional_list_acc'=>DB::table('master_regional')->get()->pluck('id'),
                'regional_list'=>DB::table('master_regional')->get(),
                'instansi'=>DB::table('master_instansi')->get()

            ]);
    }

     public function store($tahun,Request $request){
        $v=[
            'username'=>'required|string|unique:users,username|min:3',
            'email'=>'required|email|unique:users,email',
            'nik'=>'required|string|unique:users,nik|min:11',
            'nip'=>'required|string|unique:users,nip|min:10',
            'jabatan'=>'required|string|min:1',
            'nomer_telpon'=>'required|string|min:11|unique:users,nomer_telpon',
            'password'=>'required|confirmed|min:8',

        ];
        $u_daerah=Auth::User()->role==4;


        if($u_daerah){
            $v['kode_daerah']='required|min:2';
        }

        $valid=Validator::make($request->all(),$v);


        if($valid->fails()){
            Alert::error('Gagal',$valid->errors()->first());
            return back()->withInput();
        }
        $u=Auth::User();


        $data_insert=[
            'name'=>$request->name,
            'email'=>$request->email,
            'username'=>$request->username,
            'nip'=>$request->nip,
            'nik'=>$request->nik,
            'jabatan'=>$request->jabatan,
            'nomer_telpon'=>$request->nomer_telpon,
            'wa_number'=>$request->wa_number=='on',
            'wa_notif'=>($request->wa_notif=='on'),
            'main_daerah'=>($request->main_daerah=='on')?true:false,
            'walidata'=>($request->walidata=='on')?true:false,
            'kode_daerah'=>$u_daerah?$request->kode_daerah:null,
            'password'=>MyHash::pass_encode($request->password),
            'role'=>$u_daerah?4:(in_array($request->role, [1,2,3,4])?$request->role:2),
            'api_token'=>Hash::make($request->email),
            'is_active'=>((boolean)$request->is_active)==true?true:false
        ];
         $data=DB::table('users')->insertOrIgnore($data_insert);
         $data=DB::table('users')->where('username',$request->username)->first();

        if($data){

            if($u->can('is_super') ){
                if($request->id_instansi){
                    DB::table('tb_user_instansi')->updateOrInsert(
                        ['id_user'=>

                        $data->id]
                        ,[
                        'id_user'=>$data->id,
                        'id_instansi'=>$request->id_instansi
                    ]);
                }

            }


            Alert::success('Berhasil','User Berhasil Ditambahkan');
            return redirect()->route('admin.users.index',['tahun'=>$GLOBALS['tahun_access']]);
        }else{
            Alert::error('Gagal','');
            return back()->withInput();
        }


            
    }
}
