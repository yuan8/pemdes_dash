<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Alert;
use Carbon\Carbon;
use Storage;
use HPV;
use HP;
use Auth;
use Nahid\JsonQ\Jsonq;

use App\Http\Controllers\DataIntegrasiCtrl as MAP;

use App\Http\Controllers\Controller\ADMIN\DataViewCtrl;
use WEBSET;
class DataCtrl extends Controller
{

    public function data_type($tahun,$type,Request $request){
        $type=strtoupper($type);
        if(!in_array($type,['INFOGRAFIS','TABLE','VISUALISASI'])){
            return abort(404);
        }

        $instansi=null;
        if($type){

        $now=Carbon::now();
        $Defwhere=[
            "dt.status=1",
            "dt.type='".$type."'",
            "dt.tahun=".$tahun,
            "dt.publish_date <= '".$now."'"
        ];

        $where=[];

        if($request->q){
            $where[]="dt.deskripsi like '%".$request->q."%' ";
            $where[]="dt.keywords like '%".$request->q."%' ";
            $where[]="dt.title like '%".$request->q."%' ";
            $where[]="dt.deskripsi_min like '%".$request->q."%' ";
            $where[]="i.name like '%".$request->q."%' ";
            $where[]="pro.nmprovinsi like '%".$request->q."%' ";
            $where[]="kab.nmkabkota like '%".$request->q."%' ";
            $where[]="kc.nmkecamatan like '%".$request->q."%' ";
            $where[]="ds.nmdesa like '%".$request->q."%' ";
            $where[]="replace(replace(c.type,'TEMA_',''),'_',' ') like '%".$request->q."%' ";

        }

        $whereRaw=[];
        $whereSql='';

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
        ->whereRaw(implode(' OR ',$whereRaw))
        ->groupBy('dt.id')
        ->orderBy('dt.updated_at')
        ->selectRaw("dt.*,
                (
                    (CASE WHEN(dt.type <> 'INTEGRASI') THEN (dt.tahun=".$tahun.") else dt.tahun<=".$tahun." end) 
                ) as nn,
                case when (ds.kddesa is not null) then ds.nmdesa when (kc.nmkecamatan is not  null)  then kc.nmkecamatan when  (kab.nmkabkota is not null)  then kab.nmkabkota when (pro.nmprovinsi is not null)  then pro.nmprovinsi else '' end as nama_daerah")
        ->paginate(15);

        $data->appends([
            'q'=>$request->q
            ]
        );
        return view('show_data.dataset.tema')->with(['data'=>$data,'instansi'=>$instansi,'title'=>$type]);
        }




    }

     public function data_tema($tahun,$id,Request $request){


        $instansi=DB::table('master_category')
            ->where('id',$id)
            ->selectRaw('*,description as deskripsi')
            ->first();
        if($instansi){

        config([
            'proepdeskel.meta.title'=>$instansi->name,
            'proepdeskel.meta.description'=>$instansi->deskripsi,
            'proepdeskel.meta.keywords'=>implode(',',[$instansi->name]),
            'proepdeskel.meta.category'=>$instansi->name,
        ]);

        $now=Carbon::now();
        $Defwhere=[
            "dt.status=1",
            "c.id=".$id,
            "dt.publish_date <= '".$now."'"
        ];

        $where=[];

        if($request->q){
            $where[]="dt.deskripsi like '%".$request->q."%' ";
            $where[]="dt.keywords like '%".$request->q."%' ";
            $where[]="dt.title like '%".$request->q."%' ";
            $where[]="dt.deskripsi_min like '%".$request->q."%' ";
            $where[]="i.name like '%".$request->q."%' ";
            $where[]="pro.nmprovinsi like '%".$request->q."%' ";
            $where[]="kab.nmkabkota like '%".$request->q."%' ";
            $where[]="kc.nmkecamatan like '%".$request->q."%' ";
            $where[]="ds.nmdesa like '%".$request->q."%' ";
            $where[]="replace(replace(c.type,'TEMA_',''),'_',' ') like '%".$request->q."%' ";

        }

        $whereRaw=[];
        $whereSql='';

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
        ->whereRaw(implode(' OR ',$whereRaw))
        ->groupBy('dt.id')
        ->orderBy('dt.updated_at')
        ->selectRaw("dt.*,
                (
                    (CASE WHEN(dt.type <> 'INTEGRASI') THEN (dt.tahun=".$tahun.") else dt.tahun<=".$tahun." end) 
                ) as nn,
                case when (ds.kddesa is not null) then ds.nmdesa when (kc.nmkecamatan is not  null)  then kc.nmkecamatan when  (kab.nmkabkota is not null)  then kab.nmkabkota when (pro.nmprovinsi is not null)  then pro.nmprovinsi else '' end as nama_daerah")
        ->paginate(15);

        $data->appends([
            'q'=>$request->q
            ]
        );
        return view('show_data.dataset.tema')->with(['data'=>$data,'instansi'=>$instansi,'title'=>$instansi->name]);
        }

     }

    public function data_instansi($tahun,$id,Request $request){


        $instansi=DB::table('master_instansi')
            ->where('id',$id)
            ->first();
        if($instansi){

        $now=Carbon::now();
        $Defwhere=[
            "dt.status=1",
            "di.id=".$id,
            "dt.publish_date <= '".$now."'"
        ];

        $where=[];

        if($request->q){
            $where[]="dt.deskripsi like '%".$request->q."%' ";
            $where[]="dt.keywords like '%".$request->q."%' ";
            $where[]="dt.title like '%".$request->q."%' ";
            $where[]="dt.deskripsi_min like '%".$request->q."%' ";
            $where[]="i.name like '%".$request->q."%' ";
            $where[]="pro.nmprovinsi like '%".$request->q."%' ";
            $where[]="kab.nmkabkota like '%".$request->q."%' ";
            $where[]="kc.nmkecamatan like '%".$request->q."%' ";
            $where[]="ds.nmdesa like '%".$request->q."%' ";
            $where[]="replace(replace(c.type,'TEMA_',''),'_',' ') like '%".$request->q."%' ";

        }

        $whereRaw=[];
        $whereSql='';

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
        ->whereRaw(implode(' OR ',$whereRaw))
        ->groupBy('dt.id')
        ->orderBy('dt.updated_at')
        ->selectRaw("dt.*,
                (
                    (CASE WHEN(dt.type <> 'INTEGRASI') THEN (dt.tahun=".$tahun.") else dt.tahun<=".$tahun." end) 
                ) as nn,
                case when (ds.kddesa is not null) then ds.nmdesa when (kc.nmkecamatan is not  null)  then kc.nmkecamatan when  (kab.nmkabkota is not null)  then kab.nmkabkota when (pro.nmprovinsi is not null)  then pro.nmprovinsi else '' end as nama_daerah")
        ->paginate(15);

        $data->appends([
            'q'=>$request->q
            ]
        );
        return view('show_data.dataset.instansi')->with(['data'=>$data,'instansi'=>$instansi,'title'=>$instansi->name]);
        }

     }



     public function data_instansi_pemda($tahun,$kode_daerah,Request $request){
        $level=HP::table_level($kode_daerah);

        if($level){

        $instansi=DB::table($level['table'].' as d')
                ->selectRaw("'' as deskripsi, ".$level['column_id'].' as id, '.$level['column_name']." as name, null as image_path,'PEMDA' as type ,'".$level['level']."' as jenis")->where($level['column_id'],'=',$kode_daerah)
                ->first();

       
        $now=Carbon::now();
        $Defwhere=[
            "dt.tahun=".$tahun,
            "dt.status=1",
            "dt.kode_daerah=".$kode_daerah,
            "dt.publish_date <= '".$now."'"
        ];

        $where=[];

        if($request->q){
            $where[]="dt.deskripsi like '%".$request->q."%' ";
            $where[]="dt.keywords like '%".$request->q."%' ";
            $where[]="dt.title like '%".$request->q."%' ";
            $where[]="dt.deskripsi_min like '%".$request->q."%' ";
            $where[]="i.name like '%".$request->q."%' ";
            $where[]="pro.nmprovinsi like '%".$request->q."%' ";
            $where[]="kab.nmkabkota like '%".$request->q."%' ";
            $where[]="kc.nmkecamatan like '%".$request->q."%' ";
            $where[]="ds.nmdesa like '%".$request->q."%' ";
            $where[]="replace(replace(c.type,'TEMA_',''),'_',' ') like '%".$request->q."%' ";

        }

        $whereRaw=[];
        $whereSql='';

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
        ->whereRaw(implode(' OR ',$whereRaw))
        ->groupBy('dt.id')
        ->orderBy('dt.updated_at')
        ->selectRaw("dt.*,
                (
                    (CASE WHEN(dt.type <> 'INTEGRASI') THEN (dt.tahun=".$tahun.") else dt.tahun<=".$tahun." end) 
                ) as nn,
                case when (ds.kddesa is not null) then ds.nmdesa when (kc.nmkecamatan is not  null)  then kc.nmkecamatan when  (kab.nmkabkota is not null)  then kab.nmkabkota when (pro.nmprovinsi is not null)  then pro.nmprovinsi else '' end as nama_daerah")
        ->paginate(15);

        $data->appends([
            'q'=>$request->q
            ]
        );
        return view('show_data.dataset.instansi_pemda')->with(['data'=>$data,'instansi'=>$instansi,'title'=>$instansi->name]);
        }

     }


    public function tema($tahun,Request $request){

       
        $data=[];
        $data=[
            'data_utama'=>DB::table('master_category')->where('type','TEMA_DATA_UTAMA')->get(),
            'data_pendukung'=>DB::table('master_category')->where('type','TEMA_DATA_PENDUKUNG')->get()
        ];
        return view('show_data.tema')->with(['data'=>$data,'request'=>$request]);
    }


    public function instansi($tahun,Request $request){

        $type='PUSAT';
        $provinsi=[];
        if($request->jenis){
            $type=$request->jenis;

        }

        if($type=='PUSAT'){
            $data=DB::table('master_instansi')
            ->selectRaw("id,name,image_path")
            ->get();
            return view('show_data.instansi')->with(
            [
                    'data'=>$data,
                    'title'=>'instansi',
                    'request'=>$request

            ]);

        }else if($type=='PEMDA'){
            return view('show_data.instansi')->with(
                [
                        'title'=>'instansi',
                        'request'=>$request,
                        'provinsi'=>DB::table('master_provinsi')->get()

                ]);
               
        }   



    }


    public function query($tahun,Request $request){

        $now=Carbon::now();
        $Defwhere=[
            "(
                (CASE WHEN(dt.type <> 'INTEGRASI') THEN (dt.tahun=".$tahun.") else dt.tahun<=".$tahun." end) 
            )",
            "dt.status=1",
            "dt.publish_date <= '".$now."'"
        ];

        $where=[];

        if($request->q){
            $where[]="dt.deskripsi like '%".$request->q."%' ";
            $where[]="dt.keywords like '%".$request->q."%' ";
            $where[]="dt.title like '%".$request->q."%' ";
            $where[]="dt.deskripsi_min like '%".$request->q."%' ";
            $where[]="i.name like '%".$request->q."%' ";
            $where[]="pro.nmprovinsi like '%".$request->q."%' ";
            $where[]="kab.nmkabkota like '%".$request->q."%' ";
            $where[]="kc.nmkecamatan like '%".$request->q."%' ";
            $where[]="ds.nmdesa like '%".$request->q."%' ";
            $where[]="replace(replace(c.type,'TEMA_',''),'_',' ') like '%".$request->q."%' ";

        }

        $whereRaw=[];
        $whereSql='';

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
        ->whereRaw(implode(' OR ',$whereRaw))
        ->groupBy('dt.id')
        ->orderBy('dt.updated_at')
        ->selectRaw("dt.*,
                (
                    (CASE WHEN(dt.type <> 'INTEGRASI') THEN (dt.tahun=".$tahun.") else dt.tahun<=".$tahun." end) 
                ) as nn,
                case when (ds.kddesa is not null) then ds.nmdesa when (kc.nmkecamatan is not  null)  then kc.nmkecamatan when  (kab.nmkabkota is not null)  then kab.nmkabkota when (pro.nmprovinsi is not null)  then pro.nmprovinsi else '' end as nama_daerah")
        ->paginate(15);

        $data->appends([
            'q'=>$request->q
            ]
        );




        return view('data.index')->with(['data'=>$data]);
        

    }


    public function index($tahun,Request $request){
    	$data=DB::table('tb_data as dt')
    	->whereRaw(
    		"(
    			(CASE WHEN(dt.type <> 'INTEGRASI') THEN (dt.tahun=".$tahun." and dt.status=1 ) else dt.tahun<=".$tahun." end) 
    		) AND (
    		dt.deskripsi like '%".$request->q."%' OR dt.title like '%".$request->q."%' OR dt.deskripsi_min like '%".$request->q."%' OR dt.keywords like '%".$request->q."%'

    		)  "
    	)
    	->leftJoin('tb_data_instansi as di','di.id_data','=','dt.id')
    	->leftJoin('master_instansi as in','in.id','=','di.id_instansi')
    	->selectRaw("dt.*,in.id as i_id,in.name as i_nama")

    	->paginate(10);


    	return view('data.index')->with(['data'=>$data]);

    }


    public function detail($tahun,$d,$slug){
        $data=DB::table('tb_data as dt')->where('dt.id',$d)
        ->leftJoin('tb_data_detail_map as dtm','dtm.id_data','=','dt.id')
        ->leftJoin('master_table_map as map','map.id','=','dtm.id_map')
        ->selectRaw("dt.*,dtm.id_map,map.inheritance,map.start_level,map.stop_level")
        ->where('type','INTEGRASI')->first();
        if($data){
            return view('show_data.integrasi')->with('data',$data);
        }
    }


    static function aggre($kode_daerah,$key,$agrre,$data){
        if($data){
        switch ($agrre) {
            case 'SUM':
            
                return $data->sum($key);
                break;
            case 'MIN':
                # code...
                return $data->min($key);

                break;
            case 'MAX':
                return $data->max($key);


                # code...
                break;
            case 'COUNT':
                return $data->max($key);

                # code...
                break;
            
            default:
                # code...
                break;
            }
        }
        return 0;

        
    }

     public function visualisasi_index($tahun,$id,$slug,Request $request){
        $whereRaw=[
            "type = 'VISUALISASI'"
        ];

        if($request->preview){
            if(Auth::User()->can('is_admin') ){

            }else{
              $whereRaw[]='kode_daerah='.Auth::User()->kode_daerah;
            }
        }else{
              $whereRaw[]='status=1';
              $whereRaw[]="publish_date <= '".Carbon::now()."'";  
        }

         $data=DB::table('tb_data as d')
        ->where('tahun',($tahun))
        ->whereRaw(implode(" and ", $whereRaw))
        ->where('id',$id)->first();

        config([
            'proepdeskel.meta.title'=>$data->title,
            'proepdeskel.meta.description'=>$data->deskripsi,
            'proepdeskel.meta.keywords'=>implode(',',json_decode($data->keywords??[])),
        ]);

        if($data){

            return view('show_data.dataset_visual')->with('data',$data);
        }else{
            return abort(404);
        }

     }


     public function visualisasi_data($tahun,$id,Request $request){
        if($request->kdparent){
            $request->kode_daerah=$request->kdparent;
        }
      $file_exist=file_exists(storage_path('/app/public/publication/DATASET_VISUAL_JSON/'.$tahun.'/'.$id.'.json'));
        if($file_exist){
            $file_json=file_get_contents(storage_path('/app/public/publication/DATASET_VISUAL_JSON/'.$tahun.'/'.$id.'.json'));
            $meta_table=json_decode($file_json,true)['meta_table'];
            $meta_table['key_view']='f';
        }

         $data=DB::table('tb_data as d')
        ->where('tahun',($tahun))
        ->where('type','VISUALISASI')
        ->where('id',$id)->first();

        $level=HP::table_level($request->kode_daerah)['child'];
        $level['count']=$level['count']>0?$level['count']:2;

        $DATA=[];

        if($data){
            if(!isset($meta_table)){
                $MAP_DATA=DataViewCtrl::buildJson(public_path($data->document_path));
                $JSON=Storage::put('public/publication/DATASET_VISUAL_JSON/'.$tahun.'/'.$id.'.json',json_encode($MAP_DATA));

                return static::index($tahun,$id,$request)['child'];
            }
            


           

            $data_list = new Jsonq($file_json);
            $data_list=$data_list->from('tb_data')->get()->pluck('kode_desa')->toArray();

            foreach ($data_list as $key => $value) {
                $data_list[$key]=substr($value, 0,$level['count']);
            }



            $daerah=DB::table($level['table'].' as da')
             ->whereIn($level['column_id'],$data_list)
            ->where($level['column_id'],'like',$request->kode_daerah.'%')
            ->selectRaw($level['column_id'].' as id,'.$level['column_name'].' as name')->get();




            foreach ($daerah->toArray() as $keyd => $d) {
                $d=(array)$d;
                $d['jumlah_desa']=0;

                foreach ($meta_table['columns'] as $key => $col) {

                    $jsonq = new Jsonq($file_json);
                  
                    $obj=$jsonq->from('tb_data');


                    $d['id_cmf']=count($obj->where('kode_desa','startswith',$d['id'])->get());
                    $d['id_data']=$d['id'];
                    $d['jumlah_data_desa']=$d['id_cmf'];

                    if($d['id_cmf']){
                        $d['data_'.$key]=static::aggre($d['id'],'data_'.$key,$col['aggregate_type'],$obj);


                    }else{
                        $d['data_'.$key]=0;
                    }


                    $d['data_'.$key.'_satuan']=$col['satuan'];

                }

                $DATA[]=$d;
            }



        }




        $data_type=[
                'data'=>$DATA
        ];

        $data_type['series']=MAP::data_series('xx',$DATA,$meta_table,$level,$id,'DATASET');
        $data_type['series_map']=MAP::data_map('xx',$DATA,$meta_table,$level,$id,'DATASET');
        $data_type['data_sort']=MAP::rekap_data($DATA,$meta_table,4);


        $vie=$meta_table['view_'];
        foreach ([2,4,6,10] as $key => $value) {
            $meta_entity[$value]=(isset($vie[$value]))?$vie[$value]:[];
        }

            $l='';

        if($request->kode_daerah){
            $nama_pemda=HP::daerah_level($request->kode_daerah);
            // $l=$level['parent']['level'];
        }
        else{
            $nama_pemda='PROVINSI';
            $l='';
        }




        $meta_entity=$meta_entity[$level['count']?$level['count']:2];
        $meta_entity[]=[['type'=>'table']];
        $datenow=Carbon::now()->format('d F Y');
        
            $id_c='chart_id_'.rand(0,100).'_'.date('Ymdhi');
            $return='<div class="row " id="'.$id_c.'">';
            if(count($meta_entity)==0){
                $return.='<div class="col-md-12"><h4 class="text-center">DATA TIDAK TERSEDIA</h4></div>';
            }
            $return.='<div class="col-md-12 text-center"><h4><b>'.strtoupper($data->title.' '.$l.' '.$nama_pemda).'</b></h4></div>';

            foreach ($meta_entity as $key => $value) {
                foreach($value as $v){
                    $return.='<div class="table-responsive ch col-md-'.(12/count($value)).' col-lg-'.(12/count($value)).'">'.view('view_data.'.$v['type'])->with([
                        'data_type'=>$data_type,
                        'title'=>strtoupper($data->title),
                        'subtitle'=>'Capaian Tahun '.($tahun).' - '.$datenow,
                        'level'=>$level['count'],
                        'level_meta'=>$level,
                        'kdparent'=>$request->kode_daerah,
                        'pemda'=>$nama_pemda,
                        'table_meta'=>$meta_table,
                        'tahun_capaian'=>$tahun,
                        'dataset'=>true,
                        'id_dataset'=>$id
                    ])->render().'</div>';
                    
                }
            }
            $return.='</div>
            ';

    return $return;
       




       // dd($json_content,$json_data_path);



        

    }



    
}
