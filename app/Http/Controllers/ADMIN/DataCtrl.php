<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Alert;
use Validator;
use Auth;
use Storage;
use Carbon\Carbon;
class DataCtrl extends Controller
{
    //

    public function update_visual($tahun,$id,Request $request){

    $valid=Validator::make($request->all(),[
        'name'=>'string|required',
        'auth'=>'boolean|nullable',
        'description'=>'nullable|string',
        'keywords'=>'array|nullable',
        'publish_date'=>'date|required',
        'id_instansi'=>'numeric|required',
    ]);

    if($valid->fails()){
        Alert::error('',$valid->errors()->first());
        return back();
    }

      $Defwhere=[
            "dt.tahun=".$tahun,
            'dt.id='.$id,
            "dt.type in ('VISUALISASI')"
        ];
        $pilih_kategori='';

        $where=[];
        $U=Auth::User();


        if($U->can('is_daerah')){
             $Defwhere[]="dt.kode_daerah =".Auth::User()->kode_daerah;
        }


       
        $data=DB::table('tb_data as dt')
        ->leftJoin('tb_data_detail_visualisasi as vis','vis.id_data','=','dt.id')
        ->whereRaw(implode(' and ', $Defwhere))->first();

        if($data){

            $data_up=[
                'id_user_update'=>$U->id,
                'updated_at'=>Carbon::now(),
                'publish_date'=>$request->publish_date,
                'deskripsi'=>$request->description,
                'title'=>$request->name,
                'tahun'=>$tahun,
                'keywords'=>json_encode($request->keywords),
            ];

            if($U->can('is_daerah')){
                $data_up['status']=0;
            }


            DB::table('tb_data')->where('id',$id)
            ->update($data_up);

            if($request->file){


            
               
                $path_file=$request->file;
                $MAP_DATA=DataViewCtrl::buildJson($path_file,$request);
                $path=Storage::put('public/publication/DATASET/'.$tahun,$request->file);
                $path=Storage::url($path);
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $size=filesize($request->file)??0;
                $size=$size / 1048576;
                $data=null;

                DB::table('tb_data_detail_visualisasi')
                ->updateOrInsert(
                [
                    'id_data'=>$id
                ],[
                    'id_data'=>$id,
                    'path_file'=>$path,
                    'extension'=>$ext,
                    'size'=>$size,
                ]);


            }else{
                $path_file=public_path($data->path_file);
                $MAP_DATA=DataViewCtrl::buildJson($path_file,$request);

            }

                $MAP_DATA['meta_table']['id']=$data->id;


                $JSON=Storage::put('public/publication/DATASET_VISUAL_JSON/'.$tahun.'/'.$id.'.json',json_encode($MAP_DATA));


        }

        return back();
    }


    public function edit_visual($tahun,$id){
        $Defwhere=[
            "dt.tahun=".$tahun,
            'dt.id='.$id,
            "dt.type in ('VISUALISASI')"
        ];
        $pilih_kategori='';

        $where=[];

        if(Auth::User()->role>2){
             $Defwhere[]="dt.kode_daerah =".Auth::User()->kode_daerah;
        }

        $U=Auth::User();

       
        $data=DB::table('tb_data as dt')
        ->leftJoin('tb_data_detail_visualisasi as vis','vis.id_data','=','dt.id')
        ->leftJoin('tb_data_group as dg','dg.id_data','=','dt.id')
        ->leftJoin('master_provinsi as pro','pro.kdprovinsi','=','dt.kode_daerah')
        ->leftJoin('master_kabkota as kab','kab.kdkabkota','=','dt.kode_daerah')
        ->leftJoin('master_kecamatan as kc','kc.kdkecamatan','=','dt.kode_daerah')
        ->leftJoin('master_desa as ds','ds.kddesa','=','dt.kode_daerah')
        ->leftJoin('master_category as c','c.id','=','dg.id_category')
        ->leftJoin('tb_data_instansi as di','di.id_data','=','dt.id')
        ->leftjoin('master_instansi as i','i.id','=','di.id_instansi')
        ->leftjoin('users as usc','usc.id','=','dt.id_user')
        ->leftjoin('users as usu','usu.id','=','dt.id_user_update')
        ->groupBy('dt.id')
        ->orderBy('dt.updated_at')
        ->selectRaw("dt.*,  
                vis.path_file,
                vis.path_file,

                usc.name as nama_user_created,
                usc.jabatan as jabatan_user_created,
                i.name as nama_instansi,
                (case when (i.type) then i.type else 'DAERAH' end) as jenis_instansi,
                group_concat(c.type SEPARATOR ',') as tema,
                group_concat(concat(c.id,'|||',c.type,'|||',c.name) SEPARATOR '------') as category,
                case when (ds.kddesa is not null) then ds.nmdesa when (kc.nmkecamatan is not  null)  then kc.nmkecamatan when  (kab.nmkabkota is not null)  then kab.nmkabkota when (pro.nmprovinsi is not null)  then pro.nmprovinsi else '' end as nama_daerah")

        ->whereRaw(implode(' and ', $Defwhere))->first();

        $u=Auth::User();
        $view=[];

        $file=file_get_contents(storage_path('app/public/publication/DATASET_VISUAL_JSON/'.$tahun.'/'.$data->id.'.json'));
        if($file){
            $file=json_decode($file,true);
            $map_view=$file['meta_table']['view_'];
        }else{
            $map_view=null;
        }



         foreach([2=>'PROVINSI',4=>'KOTA/KAB',6=>'KECEMATAN',10=>"DESA/KELURAHAN"] as $kl=>$l){
                $view[$kl]=[
                    'head'=>$l,
                    'map'=>isset($map_view[$kl])?$map_view[$kl]:[]
                ];

                foreach([0,1,2,3] as $r){
                    $dr=[];
                    if($dr){
                        $view[$kl]['map'][$r]=$dr;
                    }

                }                
          }

          if($u->role!=1){
            $instansi=DB::table('master_instansi as c')
            ->where(
                'type','REGIONAL'
            )->selectRaw('c.id, c.name as text')->get();
          }else{
            $instansi=DB::table('master_instansi as c')->selectRaw('c.id, c.name as text')->get();
          }


        if($data){
            return view('admin.data.handle.edit_data_set')->with([
                'jenis'=>$data->type,
                'data'=>$data,
                'view'=>$view,
                'instansi'=>$instansi,
                'category'=>[]
            ]);
        }

    }

	static function store_infografis($tahun,Request $request){
		$path=Storage::put('public/publication/DATASET/'.$tahun,$request->file);
		$path=Storage::url($path);
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$size=filesize($request->file)??0;
		$size=$size / 1048576;


		$data=DB::table('tb_data')
		->insertGetId([
			'name'=>$request->name,
			'type'=>'INFOGRAFIS',
			'publish_date'=>$request->publish_date,
			'extension'=>$ext,
			'description'=>$request->description,
			'organization_id'=>$request->id_instansi??15,
			'year'=>$tahun,
			'size'=>$size,
			'dashboard'=>(boolean)(($request->dashboard)),
			'auth'=>(boolean)(($request->dashboard)?$request->auth:0),
			'keywords'=>($request->keywords)?json_encode($request->keywords,true):'[]',
			'document_path'=>$path,
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now(),
			'publish_date'=>Carbon::now(),
			'id_user'=>Auth::User()->id

		]);

		if($data){
			Alert::success('Berhasil','Data Berhasil Ditambahkan');
			foreach ($request->category as $key => $k) {
    				# code...
    				DB::table('data_group')->insertOrIgnore([
    					'id_data'=>$data,
    					'id_category'=>$k
    				]);

    			}
			return back();
		}


	}


	static function build_map($head){

	}


	static public function store($tahun,Request $request){


        $valid=Validator::make($request->all(),[
            'name'=>'string|required',
            'auth'=>'boolean|nullable',
            'description'=>'nullable|string',
            'keywords'=>'array|nullable',
            'publish_date'=>'date|required',
            'id_instansi'=>'numeric|required',
        ]);

        if($valid->fails()){
            Alert::error('',$valid->errors()->first());
            return back()->withInputs();
        }


		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
        $sheet=$spreadsheet->setActiveSheetIndex(0);
        $maping=[];
        $head=[];

    

		$MAP_DATA=DataViewCtrl::buildJson($request->file,$request);

		$path=Storage::put('public/publication/DATASET/'.$tahun,$request->file);
		$path=Storage::url($path);
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$size=filesize($request->file)??0;
		$size=$size / 1048576;
		$data=null;

		if($MAP_DATA){

			$data=DB::table('tb_data')->insertGetId([
    		    'title'=>$request->name,
                'auth'=>$request->auth,
    			'deskripsi'=>$request->description,
    			'type'=>'VISUALISASI',
				'publish_date'=>$request->publish_date,
                'status'=>0,
                'tahun'=>$tahun,
                'kode_daerah'=>Auth::User()->can('is_only_daerah')?Auth::User()->kode_daerah:null,
                'id_user'=>Auth::User()->id,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
    			'keywords'=>json_encode($request->keywords),

    		]);

		if($data){
				DB::table('tb_data_detail_visualisasi')
				->insert([
					'id_data'=>$data,
					'path_file'=>$path,
					'extension'=>$ext,
					'size'=>$size,
				]);
			}
		}

		if($data){
			Alert::success('Berhasil','Data Berhasil Ditambahkan');

			$JSON=Storage::put('public/publication/DATASET_VISUAL_JSON/'.$tahun.'/'.$data.'.json',json_encode($MAP_DATA));

			foreach ($request->category as $key => $k) {
    				# code...
    				DB::table('tb_data_group')->insertOrIgnore([
    					'id_data'=>$data,
    					'id_category'=>$k
    				]);



    		}

    		if(!Auth::User()->can('is_only_daerah')){
    			DB::table('tb_data_instansi')->insertOrIgnore([
                	'id_data'=>$data,
                	'id_instansi'=>$request->id_instansi
           		 ]);
    		}

    		 
			return back();
		}else{
			return abort(500);
		}
	}



    public function create($tahun,$jenis,Request $request){

    	$u=Auth::User();
		$view=[];
		 foreach([2=>'PROVINSI',4=>'KOTA/KAB',6=>'KECEMATAN',10=>"DESA/KELURAHAN"] as $kl=>$l){
                $view[$kl]=[
                    'head'=>$l,
                    'map'=>[]
                ];

                foreach([0,1,2,3] as $r){
                    $dr=[];
                    if($dr){
                        $view[$kl]['map'][$r]=$dr;
                    }

                }                
          }

          if($u->role!=1){
          	$instansi=DB::table('master_instansi as c')
          	->where(
          		'type','REGIONAL'
          	)->selectRaw('c.id, c.name as text')->get();
          }else{
          	$instansi=DB::table('master_instansi as c')->selectRaw('c.id, c.name as text')->get();
          }

		return view('admin.data.handle.create_data_set')->with(['instansi'=>$instansi,'jenis'=>$jenis,'view'=>$view]);
    }

    public function index($tahun,Request $request){
    	$Defwhere=[
    		"dt.tahun=".$tahun,
    		"dt.type in ('DATATABLE','VISUALISASI')"
    	];
    	$pilih_kategori='';

    	$where=[];

    	if($request->q){
            $where[]="dt.deskripsi like '%".$request->q."%' ";
            $where[]="dt.keywords like '%".$request->q."%' ";
            $where[]="dt.title like '%".$request->q."%' ";
            $where[]="dt.deskripsi_min like '%".$request->q."%' ";
        }

        if($request->tema){
            $where[]="c.type like '".$request->tema."%' ";

        }

        if($request->kategori){
            $where[]="c.id = ".$request->kategori;
            $pilih_kategori=DB::table('master_category')
            ->where('id',$request->kategori)->pluck('name')
            ->first();
        }

        if(Auth::User()->role>2){
        	 $Defwhere[]="dt.kode_daerah =".Auth::User()->kode_daerah;
        }

        if($request->jenis){
            $where[]="dt.type = ".$request->jenis;

        }

         if($request->status){
            $where[]="dt.status = ".$request->status;

        }

        if($request->instansi){
            $where[]="i.name like '".$request->instansi."' ";
        }

        $whereRaw=[];

        if(count($where)){
            foreach ($where as $key => $w) {
                $q=[];
                $q[]=$w;
                foreach ($Defwhere as $d => $y) {
                     $q[]=$y;
                }

                if(count($q)){
                    $whereRaw[$key]='('.implode(' and ',$q).')';
                }


            }
        }else{

           if(count($Defwhere)){
                $whereRaw[]='('.implode(' and ', $Defwhere).')';
           }
        }


    	$data=DB::table('tb_data as dt')
        ->leftJoin('tb_data_group as dg','dg.id_data','=','dt.id')
        ->leftJoin('master_provinsi as pro','pro.kdprovinsi','=','dt.kode_daerah')
        ->leftJoin('master_kabkota as kab','kab.kdkabkota','=','dt.kode_daerah')
        ->leftJoin('master_kecamatan as kc','kc.kdkecamatan','=','dt.kode_daerah')
        ->leftJoin('master_desa as ds','ds.kddesa','=','dt.kode_daerah')
        ->leftJoin('master_category as c','c.id','=','dg.id_category')
        ->leftJoin('tb_data_instansi as di','di.id_data','=','dt.id')
        ->leftjoin('master_instansi as i','i.id','=','di.id_instansi')
        ->leftjoin('users as usc','usc.id','=','dt.id_user')
        ->leftjoin('users as usu','usu.id','=','dt.id_user_update')
        ->whereRaw(implode(' OR ',$whereRaw))
        ->groupBy('dt.id')
        ->orderBy('dt.updated_at')
        ->selectRaw("dt.*,	
        		usc.name as nama_user_created,
        		usc.jabatan as jabatan_user_created,
        		i.name as nama_instansi,
        		(case when (i.type) then i.type else 'DAERAH' end) as jenis_instansi,
        		group_concat(c.type SEPARATOR ',') as tema,
        		group_concat(c.name SEPARATOR ',') as nama_category,
                case when (ds.kddesa is not null) then ds.nmdesa when (kc.nmkecamatan is not  null)  then kc.nmkecamatan when  (kab.nmkabkota is not null)  then kab.nmkabkota when (pro.nmprovinsi is not null)  then pro.nmprovinsi else '' end as nama_daerah")
        ->paginate(15);

    	return view('admin.data.index')
    	->with(
    		[
    		'data'=>$data,
    		'request'=>$request,
    		'pilih_kategori'=>$pilih_kategori
    	]);


    }

   
}
