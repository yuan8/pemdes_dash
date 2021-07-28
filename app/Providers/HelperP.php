<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Str;
use DB;
use Auth;
use Carbon\Carbon;
class HelperP extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public static function abl_aksi_front($TAG='NONE'){
        $U=Auth::User();
        // $abl=[99=>'UPDATE'];
        
        if($TAG=='ALL'){
            $abl[2]='Verifikasi Desa/Kel';
               $abl[3]='Verifikasi Kecamatan';
               $abl[5]='Validasi Kota/Kab';
               $abl[1]='Hold Data';
               $abl[0]='Data Integrasi';

        }


        if($U->can('is_admin')){
           $abl[2]='Verifikasi Desa/Kel';
           $abl[3]='Verifikasi Kecamatan';
           $abl[5]='Validasi Kota/Kab';
           $abl[1]='Hold Data';
        }else if($U->can('is_regional')){
            $abl=[];

        }
        else if($U->can('is_daerah')){
            switch (strlen($U->kode_daerah)) {
                case 10:
                    $abl[2]='Verifikasi Desa/Kel'; 
                    $abl[1]='Hold Data';   
                        
                    break;
                case 6:
                    $abl[3]='Verifikasi Kecamatan';  
                     $abl[2]='Verifikasi Desa/Kel';  
                    $abl[1]='Hold Data';   
                    break;
                case 4:
                    $abl[5]='Validasi Kota/Kab'; 
                    $abl[3]='Verifikasi Kecamatan';  
                    $abl[2]='Verifikasi Desa/Kel';  
                    $abl[1]='Hold Data';

                    break;
                default:
                    # code...
                    break;
            }
        }

        return $abl;
    } 

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    static function color_status_data($status,$lock){
        $color='';
        if($status==0 OR $status==null){
            $color='bg-danger';
        }
        elseif($status==1){
            $color='bg-gray';
        }elseif($status==2){
            $color='bg-success';
        }elseif($status==3){
            if($lock){
                $color='bg-teal';
            }else{
                $color='bg-info';
            }
        }

        return $color;
    }


    static function roleName($role){
        switch ($role) {
            case 1:
                return 'Superadmin';
                # code...
                break;
             case 2:
                return 'Admin';
                # code...
                break;
            case 3:
                return 'User Regional';
                # code...
                break;

            case 4:
                return 'User Daerah';
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }

    static function maping_row($data,$map){
        $start_data_col=1;
        $data_return=[];
         $start_data_row=9;


        foreach ($data as $row => $d) {
            $d=(array)$d;
            $start_data_row+=1;
            $data_build=[
                [
                    'val'=>$d['id'],
                    'row'=>$start_data_row,
                    'col'=>$start_data_col,
                    'type'=>'META',

                ],
                 [
                    'val'=>static::verifikasi_status($d['status_data']),
                    'row'=>$start_data_row,
                    'col'=>$start_data_col+1,
                    'type'=>'META',

                ],
                [
                    'val'=>$d['updated_at']?Carbon::parse($d['updated_at'])->format('Y/m/d'):'',
                    'row'=>$start_data_row,
                    'col'=>$start_data_col+2,
                    'type'=>'META',

                ],
                [
                    'val'=>$d['valid_date']?Carbon::parse($d['valid_date'])->format('Y/m/d'):'',
                    'row'=>$start_data_row,
                    'col'=>$start_data_col+3,
                    'type'=>'META',

                ],
                [
                    'val'=>'NONE',
                    'row'=>$start_data_row,
                    'col'=>$start_data_col+4,
                    'type'=>'META',

                ],
                [
                    'val'=>$d['name'],
                    'row'=>$start_data_row,
                    'col'=>$start_data_col+5,
                    'type'=>'META',

                ],
                [
                    'val'=>$d['status_desa'],
                    'row'=>$start_data_row,
                    'col'=>$start_data_col+6,
                    'type'=>'META',

                ],
                [
                    'val'=>$d['nama_kecamatan'],
                    'row'=>$start_data_row,
                    'col'=>$start_data_col+7,
                    'type'=>'META',

                ],
                [
                    'val'=>$d['nama_kota'],
                    'row'=>$start_data_row,
                    'col'=>$start_data_col+8,
                    'type'=>'META',

                ],
              
               
               
                

            ];

            $col=$start_data_col+8;

            foreach ($map['columns'] as $key => $dx) {
                    $col+=1;
                    $use_interval=null;
                    if($dx['interval_nilai']){
                        $interval=explode('|;|', $dx['interval_nilai']);
                        if(count($interval)>0){
                            $use_interval=$key;
                        }
                    }

                    $data_build[]=
                     [
                        'val'=>$d[$key],
                        'row'=>$start_data_row,
                        'col'=>$col,
                        'type'=>'DATA',
                        'definisi'=>$dx['definisi'],
                        'satuan'=>$dx['satuan'],
                        'interval_nilai'=>$dx['interval_nilai'],
                        'tipe_data'=>$dx['tipe_data'],
                        'use_theme_interval'=>$use_interval
                     ];
            }

            $data_return[]=$data_build;
        }




        return $data_return;


    }

    static function translate_operator($op,$field){
        switch (strtoupper($op)) {
            case 'SUM':
                return ['Jumlah','sum('.$field.')'];
                # code...
                break;
            case 'COUNT_ADA':
                return ['Jumlah',"count(CASE WHEN 'ada'= ".$field.' then 1 else null end)'];
                # code...
                break;
            case 'COUNT_YA':
                return ['Jumlah',"count(CASE WHEN 'ya'= ".$field.' then 1 else null end)'];
                # code...
                break;
            case 'COUNT_TIDAK':
                return ['Jumlah',"count(CASE WHEN 'tidak'= ".$field.' then 1 else null) end'];
                # code...
                break;
            case 'AVERAGE':
                return ['Rata Rata','avg('.$field.')'];
                break;

            case 'MIN':
                return ['Nilai Tertrendah','min('.$field.')'];
                # code...
                break;
            case 'MAX':
                return ['Nilai Tertinggi','min('.$field.')'];
                # code...
                break;
            case 'COUNT':
                return ['Jumlah','count('.$field.')'];
                # code...
                break;
            case 'COUNT_DISTINCT':
                return ['Jumlah','count(distinct('.$field.'))'];
                # code...
                break;
            case 'COUNT_EXIST':
                return ['Jumlah','count(CASE WHEN ('.$field.'>0) THEN 1 ELSE NULL END)'];
                # code...
                break;
            case 'NONE':
                return ['','('.$field.')'];
                # code...
                break;
            
            default:
                # code...
                return ['','',''];

                break;
        }
    } 


    static function verifikasi_list(){
        $data=[
            ['id'=>0,'text'=>"Data Terintegrasi"],
            ['id'=>1,'text'=>'Data Tidak Terintegrasi'],
            ['id'=>2,'text'=>'Telah Diverifikasi Tingkat Desa'],
            ['id'=>3,'text'=>'Telah Diverifikasi Tingkat Kecamatan'],
            ['id'=>4,'text'=>'Telah Diverifikasi Tingkat Kabupaten/Kota'],
            ['id'=>5,'text'=>'Telah Divalidasi'],
        ];
        return $data;
    }

    static function verifikasi_status_level($kode_daerah){
        $count=strlen($kode_daerah);
        switch ($count) {
            case 2:
                return ['code'=>2,'level'=>'PROVINSI'];
            case 4:
                return ['code'=>4,'level'=>'KOTA/KABUPATEN'];
            case 6:
                return ['code'=>3,'level'=>'KECAMATAN'];
            case 10:
                return ['code'=>2,'level'=>'DESA/KELURAHAN'];
                # code...
                break;

            
            default:
                # code...
                break;
        }


        return ['code'=>100000,'level'=>'-'];

    }

    static function verifikasi_status($status){
        switch ($status) {
            case 0:
            return 'Data Terintegrasi';
                break;
            case 1:
            return 'Data Tidak Terintegrasi';
            break;
            case 2:
            return 'Telah Diverifikasi Tingkat Desa';
            break;
            case 3:
            return 'Telah Diverifikasi Tingkat Kecamatan';
            break;
            case 4:
            return 'Telah Diverifikasi Tingkat Kabupaten/Kota';
            break;
            case 5:
            return 'Telah Divalidasi';
            break;
            
            default:
                # code...
                break;
        }
    }

    static public function level_build($data,$kode_daerah,$bind_desa,$context=0){
        $count=strlen($kode_daerah);


        if($count==0){
            $count=$data->start_level;
            if($data->start_level==2){
                $count=0;
            }else if($data->start_level<4){
                $count=2;
            }
            else if($data->start_level<6){
                $count=4;
            }
            else if($data->start_level<10){
                $count=6;
            }
            else if($data->start_level==10){
                $count=10;
            }

        }

        
        if($context or $bind_desa){
            $count=10;
        }


        $column=[];
        $map_c=[];
        $column_map=DB::table('master_column_map as cm')
        ->where('cm.id_ms_table',$data->id_map);

        if($context){
            $column_map=$column_map->where('cm.validate',true);
        }else{
            $column_map=$column_map->where('cm.dashboard',true);

        }


        if(($count<10)){
            $column_map=$column_map->where('cm.aggregate_type','!=','NONE');
        }

        if(!Auth::guard('api')->user()){
            $column_map=$column_map->where('cm.auth',false);
        }

        $table_m=DB::table('master_table_map')
        ->select('*')->where('id',$data->id_map)
            ->first();


        $column_map=$column_map->get();

        foreach ($column_map as $key => $val) {
            $map_c['data_'.$key]=[
                'name'=>$val->name,
                'name_column'=>$val->name_column,
                'satuan'=>$val->satuan,
                'tipe_data'=>$val->tipe_data,
                'flag'=>'data_'.$key,
                'aggregate_type'=>$val->aggregate_type,
                'interval_nilai'=>$val->interval_nilai,
                'definisi'=>$val->definisi,
                'data'=>[]
            ];

            if($count<10){
                $column[]=static::translate_operator($val->aggregate_type,'dt.'.$val->name_column)[1].' as data_'.$key.'';

                $column[]="'".$val->satuan."'".' as data_'.$key.'_satuan';
                // $column[]="'".$val->interval_nilai."'".' as data_'.$key.'_interval_nilai';
                // $column[]="'".$val->tipe_data."'".' as data_'.$key.'_tipe_data';
            }else{
                $column[]=('dt.'.$val->name_column).' as data_'.$key.'';
                $column[]="'".$val->satuan."'".' as data_'.$key.'_satuan';
                // $column[]="'".$val->interval_nilai."'".' as data_'.$key.'_interval_nilai';
                // $column[]="'".$val->tipe_data."'".' as data_'.$key.'_tipe_data';

            }


        }

        $datam=static::table_level($kode_daerah,'all');

        $datam[$count]['select_data']=
            [
            'column'=>$column,
            'table_data'=>$table_m->table.' as dt',
            'map_column'=>$map_c
            ];

        $datam[$count]['columns']=$map_c;

       
        if($datam[$count]['daerah']==null){
            $daerah=(array)DB::table($datam[$count]['table'])->where($datam[$count]['column_id'],$kode_daerah)->first();
            $datam[$count]['daerah']=$daerah?'Di '.$daerah[$datam[$count]['column_name']]:'PER '.$datam[$count]['level'];

        }

        
        $return=[
            'level_data'=>$datam[$count],
            'columns'=>$map_c,
            'column'=>$column,
            'desk_table_map'=>isset($table_m->deskripsi)?$table_m->deskripsi:'',
            'id_map'=>$data->id_map,
            'data_table'=>$table_m->table.' as dt',
            'data_name'=>$table_m->name,
            'view_'=>[]
        ];


        foreach ([2,4,6,10] as $key => $l) {
                foreach ([0,1,2,3] as $d => $ro) {
                    $e=DB::table('master_view_method')
                    ->where('level',$l)
                    ->where('row',$ro)
                    ->where('id_ms_table',$data->id_map)->get()->pluck('type')->toArray();
                    if($e){
                    $return['view_'][$l][$ro]=$e;

                    }
                }       
                # code...
        }


        return $return;


    }


    static function table_level($kode_daerah,$ret='single'){
    $count=strlen($kode_daerah);

     $data_map=[];
        $datam=[];
        $datam[10]['level']='DESA';
        $datam[10]['count']=10;
        $datam[10]['kode_daerah']=$kode_daerah;
        $datam[10]['table']='master_desa';
        $datam[10]['column_id']='kddesa';
        $datam[10]['column_name']='nmdesa';
        $datam[10]['kode_daerah']=$kode_daerah;
        $datam[10]['daerah']=null;


        $datam[10]['child']=$datam[10];
        
        $datam[6]['level']='KECAMATAN';
        $datam[6]['count']=6;
        $datam[6]['table']='master_kecamatan';
        $datam[6]['column_id']='kdkecamatan';
        $datam[6]['kode_daerah']=$kode_daerah;
        $datam[6]['daerah']=null;


        $datam[6]['column_name']='nmkecamatan';
        $datam[6]['child']=$datam[10];

        $datam[4]['level']='KOTA/KAB';
        $datam[4]['count']=4;
        $datam[4]['table']='master_kabkota';
        $datam[4]['column_id']='kdkabkota';
        $datam[4]['kode_daerah']=$kode_daerah;
        $datam[4]['column_name']='nmkabkota';
        $datam[4]['child']=$datam[6];
        $datam[4]['daerah']=null;


        

        $datam[2]['level']='PROVINSI';
        $datam[2]['count']=2;
        $datam[2]['table']='master_provinsi';
        $datam[2]['column_id']='kdprovinsi';
        $datam[2]['column_name']='nmprovinsi';
        $datam[2]['kode_daerah']=$kode_daerah;
        $datam[2]['daerah']=null;


        $datam[2]['child']=$datam[4];
        $datam[0]['level']='NASIONAL';
        $datam[0]['count']=2;
        $datam[0]['table']='master_provinsi';
        $datam[0]['column_id']='kdprovinsi';
        $datam[0]['column_name']='nmprovinsi';
        $datam[0]['kode_daerah']=$kode_daerah;
        $datam[0]['daerah']='PER PROVINSI';
        $datam[0]['child']=$datam[2];
        
        if($ret=='all'){
            return $datam;
        }
        
        return $datam[$count];
    }


    public static function data_link($data){

        switch ($data->type) {
            case 'INTEGRASI':
            $q=['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>Str::slug($data->title)];
            if($data->from_instansi_daerah??null){
                $q['kdparent']=$data->from_instansi_daerah;
            }
            return route('data.int.detail',$q);
                # code...
                break;

             case 'VISUALISASI':
             return route('data.vis.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>Str::slug($data->title)]);
                # code...
                break;

            case 'TABLE':
             return route('data.table.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>Str::slug($data->title)]);
                # code...
                break;  
                          
            case 'INFOGRAFIS':
             return route('data.infograp.detail',['tahun'=>$GLOBALS['tahun_access'],'id'=>$data->id,'slug'=>Str::slug($data->title)]);
                # code...
                break;
            default:
                # code...
                break;
        }
    }

    static function array_split(Array $data,Int $part){
        $count=count($data);
        $group_count=round($count/$part) ;
        if($count>0){
           return array_chunk($data,$group_count);
        }else{
            $p=[];
            for ($i=0; $i <$part ; $i++) { 
                $p[]=[];
            }
            return $p;
        }

    }

    static function check_jadwal_pengisian($kode_daerah,$tahun){

        $kode_kota=substr($kode_daerah,0,4);
        $level=strlen($kode_daerah);

        $now=Carbon::now();
        if($level>2){
            $check=(array)DB::table('tb_jadwal_pengisian as j')
            ->selectRaw(
                "j.*, (case when ((mulai <= '".$now."') and (selesai >= '".$now."')) then 1 else (case when ((mulai > '".$now."')) then -1 else 2  end ) end) as status_jadwal"
            )->where([
                ['level','=',$level],
                ['kode_daerah','=',$kode_kota],
                ['tahun','=',$tahun]
            ])->first();
        }else{
            $check=[
                'mulai'=>Carbon::now(),
                'selesai'=>Carbon::now(),
                'status_jadwal'=>1
            ];
        }

        if($check){
            return $check;
        }else{
            return false;
        }

    }

     static function kode_data($kode_daerah,$kode_data){
        return md5($kode_daerah.'-'.$kode_data);
    }

    static function berita_acara($kode_daerah,$tahun,$id_table){
        $len=strlen($kode_daerah);
        $kode_kota=substr($kode_daerah,0,4);

        $berita=file_exists(storage_path('app/public/berita-acara/'.$kode_kota.'/'.$tahun.'/data-'.static::kode_data($kode_kota,$id_table).'-full.pdf'));
        
        $pengesahan=null;
        if($berita){
            $pengesahan=file_exists(storage_path('app/public/berita-acara/'.$kode_kota.'/'.$tahun.'/data-'.static::kode_data($kode_kota,$id_table).'-ttd.pdf'));
        }

        if($len==4){
             return [
                'access'=>true,
                'access_form'=>false,
                'access_berita_acara'=>Auth::User()->can('is_daerah_kabkota_n_admin'),
                'berita_acara'=>$berita?url('storage/berita-acara/'.$kode_kota.'/'.$tahun.'/data-'.static::kode_data($kode_kota,$id_table).'-full.pdf?v='.date('d-m-y-h:i')):null,
                'pengesahan'=>$pengesahan?url('storage/berita-acara/'.$kode_kota.'/'.$tahun.'/data-'.static::kode_data($kode_kota,$id_table).'-ttd.pdf?v='.date('d-m-y-h:i')):null


            ];
         }else if($len>4){
            return [
                'access'=>true,
                'access_form'=>false,
                'access_berita_acara'=>Auth::User()->can('is_daerah_kabkota_n_admin'),
                'berita_acara'=>$berita?route('admin.validasi.berita_acara.build_daerah',['tahun'=>$tahun,'data'=>$id_table,'kode_daerah'=>$kode_daerah]):null,
                'pengesahan'=>$pengesahan?url('storage/berita-acara/'.$kode_kota.'/'.$tahun.'/data-'.static::kode_data($kode_kota,$id_table).'-ttd.pdf?v='.date('d-m-y-h:i')):null
            ];
         }


         if(in_array(Auth::User()->role,[1,2,3])){
            return ['access'=>false,
                'access_form'=>false,
                'access_berita_acara'=>false,
                'berita_acara'=>null,
                'pengesahan'=>$pengesahan?url('storage/berita-acara/'.$kode_kota.'/'.$tahun.'/data-'.static::kode_data($kode_kota,$id_table).'-ttd.pdf?v='.date('d-m-y-h:i')):null
            ];
         }
       
            
    }


    static function status_verifikasi_dataset($kode){
        switch ($kode) {
            case 0:
            return 'BELUM DILAKUKAN PENILAIAN OLEH ADMIN';
                # code...
                break;
              case 1:
            return 'PUBLISH';
                # code...
                break;
             case 2:
            return 'KORDINASI ULANG';
                # code...
                break;
            default:
                # code...
                break;
        }

        return '';

    }

     static function status_kode_verifikasi_dataset(){
        return [
            0=>'BELUM DILAKUKAN PENILAIAN OLEH ADMIN',
            1=>'PUBLISH',
            2=>'KORDINASI ULANG',
        ];

    }
     static function daerah_level($kode_daerah){
        $count=strlen($kode_daerah);

        switch ($count) {
            case 2:
                return DB::table('master_provinsi')->selectRaw('nmprovinsi as name')->where('kdprovinsi',$kode_daerah)->pluck('name')->first();
                # code...
                break;
            case 4:
                return DB::table('master_kabkota')
                    ->selectRaw("concat(nmkabkota,' - ',nmprovinsi) as name")
                    ->where('kdkabkota',$kode_daerah)
                    ->pluck('name')->first();
                # code...
                break;
            case 6:
                return DB::table('master_kecamatan')
                    ->selectRaw("concat(nmkecamatan,' - ',nmkabkota,' - ',nmprovinsi) as name")
                    ->where('kdkecamatan',$kode_daerah)
                    ->pluck('name')->first();
                # code...
                break;

            case 10:
                return DB::table('master_desa')
                    ->selectRaw("concat(nmdesa,' - ',nmkecamatan,' - ',nmkabkota,' - ',nmprovinsi) as name")
                    ->where('kddesa',$kode_daerah)
                    ->pluck('name')->first();
                # code...
                break;
            
            default:
                # code...
                break;
        }

        return '';
    }

       static function check_access($kode_daerah=null){

        if(Auth::User()->can('is_regional')){
            $kode=isset($kode_daerah)?$kode_daerah:Auth::User()->kode_daerah;
            if($kode_daerah==null){
                return [
                    'list'=>true,
                    'kode_daerah'=>[]
                ];
            }
            if(Auth::User()->can('is_only_regional')){
                $provinsi=DB::table('users_group as g')
                ->join('master_regional as r','r.id','=','g.id_regional')
                ->join('master_regional_detail as gdt','gdt.id_regional','=','r.id')
                ->join('master_provinsi as p','p.kdprovinsi','=','gdt.kode_daerah')
                ->selectRaw('p.*,r.name as name_region')
                ->where('g.id_user',Auth::user()->id)->get()->pluck('kdprovinsi')->toArray();

                if(in_array(substr($kode_daerah,0,2),$provinsi)){
                    return ['list'=>true,
                        'kode_daerah'=>[
                            'kdprovinsi'=>strlen($kode)>=2?substr($kode,0,2):null,
                            'kdkabkota'=>strlen($kode)>=4?substr($kode,0,4):null,
                            'kdkecamatan'=>strlen($kode)>=6?substr($kode,0,6):null,
                            'kddesa'=>strlen($kode)>=10?substr($kode,0,10):null,
                            'kode'=>$kode

                        ],
                        'nama_daerah'=>static::daerah_level($kode)
                    ];

                }


            }else if(Auth::User()->can('is_admin')){
                return [
                'list'=>true,
                    'kode_daerah'=>[
                        'kdprovinsi'=>strlen($kode)>=2?substr($kode,0,2):null,
                        'kdkabkota'=>strlen($kode)>=4?substr($kode,0,4):null,
                        'kdkecamatan'=>strlen($kode)>=6?substr($kode,0,6):null,
                        'kddesa'=>strlen($kode)>=10?substr($kode,0,10):null,
                        'kode'=>$kode

                    ],
                    'nama_daerah'=>static::daerah_level($kode)
                ];
            }
        }else{
            $kode=isset($kode_daerah)?$kode_daerah:Auth::User()->kode_daerah;
            if($kode!=Auth::User()->kode_daerah){
                    if(strlen($kode)>strlen(Auth::User()->kode_daerah)){
                        if(substr($kode,0,strlen(Auth::User()->kode_daerah))==Auth::User()->kode_daerah){
                            return [
                                'list'=>false,
                                'kode_daerah'=>[
                                    'kdprovinsi'=>strlen($kode)>=2?substr($kode,0,2):null,
                                    'kdkabkota'=>strlen($kode)>=4?substr($kode,0,4):null,
                                    'kdkecamatan'=>strlen($kode)>=6?substr($kode,0,6):null,
                                    'kddesa'=>strlen($kode)>=10?substr($kode,0,10):null,
                                    'kode'=>$kode

                                ],
                                'nama_daerah'=>static::daerah_level($kode)

                                ];
                        }
                    }

                return false;
            }
            if($kode){
                return [
                    'list'=>false,
                    'kode_daerah'=>[
                        'kdprovinsi'=>strlen($kode)>=2?substr($kode,0,2):null,
                        'kdkabkota'=>strlen($kode)>=4?substr($kode,0,4):null,
                        'kdkecamatan'=>strlen($kode)>=6?substr($kode,0,6):null,
                        'kddesa'=>strlen($kode)>=10?substr($kode,0,10):null,
                        'kode'=>$kode

                    ],
                    'nama_daerah'=>static::daerah_level($kode)

                ];
            }else{
                return false;
            }
            return false;
        }
    }

}
