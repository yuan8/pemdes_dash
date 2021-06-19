<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use HP;
use HPV;
use Auth;
use Carbon\Carbon;
use Dompdf\Dompdf;
use PDF;
use Storage;
use Alert;


// instantiate and use the dompdf class

class BeritaAcaraCtrl extends Controller
{

    public function pengesahan($tahun,$kode_daerah,$kode_data){
        $kode_daerah=substr($kode_daerah,0,4);
        $data=DB::table('tb_berita_acara')->where([
            ['id_ms_table','=',$kode_data],
            ['tahun','=',$tahun],
            ['kode_daerah','=',$kode_daerah],
        ])->first();


    }


    public function buat_doc_pengsahan($tahun,$kode_daerah,$kode_data){
        $kode_daerah=substr($kode_daerah,0,4);
        $head=null;
            
        if(file_exists(public_path('storage/berita-acara/'.$kode_daerah.'/'.$tahun.'/data-'.static::kode_data($kode_daerah,$kode_data).'-rekap.json'))){
            $head=json_decode(file_get_contents(public_path('storage/berita-acara/'.$kode_daerah.'/'.$tahun.'/data-'.static::kode_data($kode_daerah,$kode_data).'-rekap.json')),true);
        }

        $data=DB::table('tb_berita_acara')->where([
            ['id_ms_table','=',$kode_data],
            ['tahun','=',$tahun],
            ['kode_daerah','=',$kode_daerah],
        ])->first();


        $ttd=[
            'path_berita_acara'=>null,
            'path_ttd'=>null
        ];

        if($data){
            $ttd['path_berita_acara']=$data->path_berita_acara?url($data->path_berita_acara??'').'?v='.date('y-m-d-h-i'):null;
            $ttd['path_ttd']=$data->path_ttd?url($data->path_ttd??''):null;
            $ttd['penanda_tangan']=$data->penanda_tangan?json_decode($data->penanda_tangan):[];

            if($data->path_berita_acara){
                if(!file_exists(public_path($data->path_berita_acara))){
                     DB::table('tb_berita_acara')->where('id',$data->id)->update([
                        'path_berita_acara'=>null
                    ]);
                     $ttd['path_berita_acara']=null;
                }
            }

            if($data->path_ttd ){
                if(!file_exists(public_path($data->path_ttd))){
                    DB::table('tb_berita_acara')->where('id',$data->id)->update([
                        'path_ttd'=>null
                    ]);
                     $ttd['path_ttd']=null;

                }
            }

        }

        if($ttd['path_berita_acara'] and (!$ttd['path_ttd'])){
            $ttd['path_ttd']=route('a.b.r.berkas.appv',[
                'tahun'=>$tahun,
                'kode_daerah'=>$kode_daerah,'kode_data'=>$kode_data]);
        }


        $table=HP::level_build((Object)['id_map'=>$kode_data],$kode_daerah,1,1);


        return view('admin.beritaacara.penandatanganan.edit')->with([
            'data'=>$ttd,
            'table'=>$table,
            'head'=>$head,
            'id_data'=>$kode_data,
            'kode_daerah'=>$kode_daerah
        ]);

    
    }

    public function save_doc_pengsahan($tahun,$kode_daerah,$id_data,Request $request){
            $data=DB::table('tb_berita_acara')->where([
                ['kode_daerah','=',$kode_daerah],
                ['tahun','=',$tahun],
                ['id_ms_table','=',$id_data],

            ])->first();

            if($data){
                 $data=DB::table('tb_berita_acara')
                 ->where('id',$data->id)
                 ->update(
                    ['penanda_tangan'=>json_encode($request->peserta)]
                 );
            }

            return back();  
    }


    public function berkas_pengesahan($tahun,$kode_daerah,$kode_data){
         $data=DB::table('tb_berita_acara')->where([
                ['kode_daerah','=',$kode_daerah],
                ['tahun','=',$tahun],
                ['id_ms_table','=',$kode_data],

        ])->first();
         $peserta=[];
         $now=Carbon::now();
         $table=HP::level_build((Object)['id_map'=>$kode_data],$kode_daerah,1,1);
         if(file_exists(public_path('storage/berita-acara/'.$kode_daerah.'/'.$tahun.'/data-'.static::kode_data($kode_daerah,$kode_data).'-rekap.json'))){
                  $rekap=json_decode(file_get_contents(public_path('storage/berita-acara/'.$kode_daerah.'/'.$tahun.'/data-'.static::kode_data($kode_daerah,$kode_data).'-rekap.json')),true);
         }else{
            $rekap=[];
         }
       
         if($data){

            $peserta=json_decode($data->penanda_tangan??'[]');
            
         }
         // $view=view()
         //        ->with(['peserta'=>$peserta,
         //            'tahun'=>$tahun,
         //            'now'=>$now,
         //            'rekap'=>$rekap,
         //            'table_map'=>$table
         //        ])->render();

                // return $view;
             
         $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('admin.beritaacara.penandatanganan.buat',[
        'peserta'=>$peserta,
         'tahun'=>$tahun,
        'now'=>$now,
        'rekap'=>$rekap,
        'table_map'=>$table
        ])
        ->setPaper('A4', 'landscape');
                
        // $pdf = PDF::setOptions(["isPhpEnabled"=> true])
        //         ->loadView('admin.beritaacara.penandatanganan.buat',[
        //         'peserta'=>$peserta,
        //          'tahun'=>$tahun,
        //         'now'=>$now,
        //         'rekap'=>$rekap,
        //         'table_map'=>$table
        //         ])
        //         ->setPaper('A4', 'landscape');
                // ->output();
                // $pdf=$pdf->getDomPDF();
         return $pdf->stream('pengesahan-berita-acara-'.$kode_daerah.'-'.$tahun.'/data-'.$kode_data.'.pdf',array('Attachment'=>false))  ;


    }

    static function kode_data($kode_daerah,$kode_data){
        return md5($kode_daerah.'-'.$kode_data);
    }

    public function rekap($tahun){
        $kode_daerah=substr(Auth::User()->kode_daerah, 0,4);
        $data=DB::table('master_table_map')->where('edit_daerah',true)->get();
        $rekap=[];
        foreach ($data as $key => $m) {
            if(file_exists(storage_path('app/public/berita-acara/'.$kode_daerah.'/'.$tahun.'/data-'.$m->id.'-full.pdf'))){
                $rekap[]=[
                    'name'=>$m->name,
                    'file_source'=>url('storage/berita-acara/'.$kode_daerah.'/'.$tahun.'/data-'.$m->id.'-full.pdf'),
                    'file_signature'=>null
                ];
            }
           


        }

        dd($data);
        return view('admin.beritaacara.rekap.index')->with(['rekap'=>$rekap,'count'=>count($data)]);

    }

    public function delete($tahun,Request $request){
        $access_data_daerah=$request->kddesa??$request->kdkecamatan??$request->kdkabkota??$request->kdprovinsi;
        $file=file_exists(storage_path('app/public/berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.static::kode_data($access_data_daerah,$request->data).'-full.pdf'));
      
        if($file){
            Alert::success('Berhasil');
            Storage::delete(('/public/berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.static::kode_data($access_data_daerah,$request->data).'-full.pdf'));
        }

        return back();
    }

    public function buat_index($tahun,Request $request){
        $jenis_data=DB::table('master_table_map')->where([
            ['edit_daerah','=',true],

        ])->get();
        $kecamatan=[];
        return view('admin.beritaacara.buat.index')->with(['jenis_data'=>$jenis_data,'kecamatan'=>$kecamatan]);
    }

    public function build_daerah($tahun,Request $request){
        set_time_limit(-1);
        $kdkecamatan=substr($request->kode_daerah,0,6);
        $access_data_daerah=substr($request->kode_daerah,0,4);
        $mapTb=DB::table('master_table_map as m')
        ->join('master_column_map as c',[['m.id','=','c.id_ms_table'],['c.validate','=',DB::raw(true)]])
        ->selectRaw('m.*,m.id as id_map')->where('m.id',$request->data)
        ->first();
        $now=Carbon::now();

        $check_access=HP::check_access($access_data_daerah);


        if($check_access and $mapTb){

            $table=DB::table('master_table_map')->where('edit_daerah',true)->get();

            $maping=HP::level_build($mapTb,$access_data_daerah,1,1);
        

            $maping['column'][]="da.kddesa as id";
            $maping['column'][]="da.nmdesa as name";

            $maping['column'][]="da.stapem as status_desa";
            $maping['column'][]="da.nmkabkota as nama_kota";
            $maping['column'][]="da.nmkecamatan as nama_kecamatan";
            $maping['column'][]="da.nmprovinsi as nama_provinsi";
            $maping['column'][]="dt.status_validasi as status_data";
            $maping['column'][]="dt.validasi_date as valid_date";
            $maping['column'][]="dt.updated_at as updated_at";

            $kecamatans=DB::table('master_kecamatan as kc')

            ->selectRaw("kc.*,(select count(da.kddesa) from master_desa as da where da.kddesa like concat(kc.kdkecamatan,'%')) as jumlah_desa")

            ->where('kdkecamatan','like',$kdkecamatan.'%')
            ->limit(1)->get();
            $data_q=[];
            $total=[
                        'jumlah_desa'=>0,
                        'jumlah_desa_melapor'=>0
                    ];
           

            foreach ($kecamatans as $kc) {
                    $data_q[$kc->kdkecamatan]=[
                        'nama'=>$kc->nmkecamatan,
                        'nmkota'=>$kc->nmkabkota,
                        'nmprovinsi'=>$kc->nmprovinsi,
                        'id'=>$kc->kdkecamatan,
                        'jumlah_desa'=>$kc->jumlah_desa,
                        'data'=>[],
                        'walidata'=>DB::table('users')->where([
                            ['role','=',4],
                            ['walidata','=',true],
                            ['kode_daerah','=',$kc->kdkecamatan],
                            ['is_active','=',true]
                        ])->selectRaw('name,nik,jabatan')->get()->toArray(),
                    ];



                    $defwhere=[
                        ['da.kddesa','like',$kc->kdkecamatan.'%'],
                        ['dt.status_validasi','=',5]
                        
                    ];
                    

                    $defJoin=[
                        [
                            DB::raw("left(dt.kode_desa,".($maping['level_data']['child']['count']==0?2:$maping['level_data']['child']['count']).")"),
                            '=',
                            $maping['level_data']['child']['column_id']
                        ],
                        ['dt.tahun','=',DB::raw($tahun)]
                    ];

                    $OrWhere=[];

                


                     $data_query=
                        DB::table($maping['level_data']['child']['table'].' as da')
                        ->join($maping['data_table'],$defJoin)
                        ->selectRaw(implode(',',$maping['column']))
                        ->groupBy($maping['level_data']['child']['column_id'])
                        ->orderBy($maping['level_data']['child']['column_id'],'asc');

                    if($OrWhere){
                        foreach ($OrWhere as $key => $value) {
                            if($key==0){
                                $data_query=$data_query->where($value);

                            }
                                $data_query=$data_query->orWhere($value);


                        }
                    }else{
                        $data_query=$data_query->where($defwhere);

                    }
                    
                    $data_query=$data_query->get()->toArray();
                    
                    if(count($data_query)){
                    $data_q[$kc->kdkecamatan]['data']=$data_query;
                    $data_q[$kc->kdkecamatan]['jumlah_data']=count($data_query);
                    $data_q[$kc->kdkecamatan]['persentase_pelaporan']=HPV::nformat((count($data_query)/$data_q[$kc->kdkecamatan]['jumlah_desa']) *100);
                   

                     $kecamatan_series[]=[
                        'name'=>$kc->nmkecamatan,
                        'data'=>[
                            [
                                'name'=>'Jumlah Total Desa',
                                'y'=>((int)$data_q[$kc->kdkecamatan]['jumlah_desa']),
                                'value'=>((int)$data_q[$kc->kdkecamatan]['jumlah_desa'])
                            ],
                            [
                                'name'=>'Jumlah Desa Melapor',
                                'y'=>(int)count($data_query),
                                'value'=>(int)count($data_query)
                            ],
                            [
                                'name'=>'Jumlah Desa Tidak Melapor',
                                'y'=>((int)$data_q[$kc->kdkecamatan]['jumlah_desa'])-(int)count($data_query),
                                'value'=>((int)$data_q[$kc->kdkecamatan]['jumlah_desa']) - count($data_query)
                            ]

                        ]



                    ];

                    }else{
                        unset($data_q[$kc->kdkecamatan]);
                    }
                # code...
            }
            $data=[
                'table_map'=>$maping,
                'data'=>$data_q
            ];


            
            if($maping){
                if(count($maping['columns'])>10){

                    $maping['split_col']=array_chunk($maping['columns'],10);
                    // dd($maping['split_col']);

                }else{
                    $maping['split_col']=array_chunk($maping['columns'],10);

                }
            }


            if(isset($data_q[$kdkecamatan])){
                 $pdf = PDF::loadHtml(view('admin.beritaacara.buat.per_kc')
                ->with(['kecamatan'=>$data_q[$kdkecamatan],'tahun'=>$tahun,'now'=>$now,'table_map'=>$maping])->render())
                ->setPaper('A4', 'landscape');
                return $pdf->stream('berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.$request->data.'/'.$data_q[$kdkecamatan]['id'].'.pdf',array('Attachment'=>false))  ;

            }

          
        }



    }

    public function penandatanganan($tahun){
        $kode_daerah=substr(Auth::User()->kode_daerah,0,4);
        $data=DB::table('master_table_map as m')
        ->leftJoin('tb_berita_acara as ba',[
            ['ba.id_ms_table','=','m.id'],
            ['ba.tahun','=',DB::raw($tahun)],
            ['ba.kode_daerah','=',DB::raw($kode_daerah)]
            ]
        )->where('m.edit_daerah',true)
        ->select('m.id as id_data','m.table','m.name as nama_data','ba.*')
        ->get();

        foreach ($data as $key => $value) {

            if($value->path_berita_acara){
                if(!file_exists(public_path($value->path_berita_acara))){
                     DB::table('tb_berita_acara')->updateOrInsert(
                        [
                            'kode_daerah'=>$kode_daerah,
                            'tahun'=>$tahun,
                            'id_ms_table'=>$value->id_data
                        ],
                        [
                            'path_berita_acara'=>null,
                            'path_ttd'=>null,
                        ]
                    );
                    Storage::delete(public_path(str_replace('-full.pdf', '-rekap.json', $value->path_berita_acara)));
                }
                // lancar

            }else if(file_exists(public_path('storage/berita-acara/'.$kode_daerah.'/'.$tahun.'/data-'.static::kode_data($kode_daerah,$value->id_data).'-full.pdf'))){
                DB::table('tb_berita_acara')->updateOrInsert(
                    [
                        'kode_daerah'=>$kode_daerah,
                        'tahun'=>$tahun,
                        'id_ms_table'=>$value->id_data
                    ],
                    [
                        'path_berita_acara'=>'storage/berita-acara/'.$kode_daerah.'/'.$tahun.'/data-'.static::kode_data($kode_daerah,$value->id_data).'-full.pdf',
                        'id_user'=>Auth::User()->id,
                        'kode_daerah'=>$kode_daerah,
                        'tahun'=>$tahun,
                        'id_ms_table'=>$value->id_data
                    ]
                );

            }else{
                DB::table('tb_berita_acara')->updateOrInsert(
                    [
                        'kode_daerah'=>$kode_daerah,
                        'tahun'=>$tahun,
                        'id_ms_table'=>$value->id_data
                    ],
                    [
                        'path_berita_acara'=>null,
                        'path_ttd'=>null,
                    ]
                );

            }

            
        }


        $data=DB::table('master_table_map as m')
        ->leftJoin('tb_berita_acara as ba',[
            ['ba.id_ms_table','=','m.id'],
            ['ba.tahun','=',DB::raw($tahun)],
            ['ba.kode_daerah','=',DB::raw($kode_daerah)]
            ]
        )->where('edit_daerah',true)
        ->select('m.id as id_data','m.table','m.name as nama_data','ba.*')
        ->get();
        $jumlah_kecamatan=DB::table('master_kecamatan')->where('kdkecamatan','like',DB::raw("'".$kode_daerah."%'"))->count();
        $jumlah_desa=DB::table('master_desa')->where('kddesa','like',DB::raw("'".$kode_daerah."%'"))->count();

        foreach($data as $key=>$value){
            $data[$key]->total_kec=$jumlah_kecamatan;
            $data[$key]->total_des=$jumlah_desa;

             $data[$key]->rekap_real=(array)DB::table($value->table.' as dt')
                ->whereRaw("dt.tahun=".$tahun." 
                    and dt.kode_desa like '".$kode_daerah."%'")
                ->selectRaw(
                    implode(', ',["sum(case when status_validasi=2 then 1 else 0 end) as kat_2",
                    "sum(case when status_validasi=3 then 1 else 0 end) as kat_3",
                    "count(distinct(case when status_validasi>1 then left(dt.kode_desa,6) else null end)) as jum_kec_l",
                    "sum(case when status_validasi=5 then 1 else 0 end) as kat_5"])
                )->first();
        }



        return view('admin.beritaacara.penandatanganan.index')->with(['data'=>$data]);


    }

    public function build($tahun,Request $request){

        // return base64_encode(file_get_contents(public_path('dist-web/logo2.png')));
        set_time_limit(-1);
    	$access_data_daerah=$request->kddesa??$request->kdkecamatan??$request->kdkabkota??$request->kdprovinsi;
    	$check_access=HP::check_access($access_data_daerah);
        
    	$mapTb=DB::table('master_table_map as m')
    	->join('master_column_map as c',[['m.id','=','c.id_ms_table'],['c.validate','=',DB::raw(true)]])
    	->selectRaw('m.*,m.id as id_map')->where('m.id',$request->data)
    	->first();


    	$now=Carbon::now();
        $total=[
            'jumlah_desa'=>0,
            'jumlah_desa_melapor'=>0,
        ];

    	if($check_access and $mapTb){

    		$table=DB::table('master_table_map')->where('edit_daerah',true)->get();

    		$maping=HP::level_build($mapTb,$access_data_daerah,1,1);
        

    		$maping['column'][]="da.kddesa as id";
    		$maping['column'][]="da.nmdesa as name";

    		$maping['column'][]="da.stapem as status_desa";
    		$maping['column'][]="da.nmkabkota as nama_kota";
    		$maping['column'][]="da.nmkecamatan as nama_kecamatan";
    		$maping['column'][]="da.nmprovinsi as nama_provinsi";
    		$maping['column'][]="dt.status_validasi as status_data";
    		$maping['column'][]="dt.validasi_date as valid_date";
    		$maping['column'][]="dt.updated_at as updated_at";

    		$kecamatans=DB::table('master_kecamatan as kc')

    		->selectRaw("kc.*,(select count(da.kddesa) from master_desa as da where da.kddesa like concat(kc.kdkecamatan,'%')) as jumlah_desa")

    		->where('kdkecamatan','like',$access_data_daerah.'%')
    		->get();
    		$data_q=[];
            $kecamatan_series=[];

            $count_kecamatan=count($kecamatans);

    		foreach ($kecamatans as $kc) {
    				$data_q[$kc->kdkecamatan]=[
    					'nama'=>$kc->nmkecamatan,
                        'nmkota'=>$kc->nmkabkota,
                        'nmprovinsi'=>$kc->nmprovinsi,
    					'id'=>$kc->kdkecamatan,
    					'jumlah_desa'=>$kc->jumlah_desa,
    					'data'=>[],
    					'walidata'=>DB::table('users')->where([
    						['role','=',4],
    						['walidata','=',true],
    						['kode_daerah','=',$kc->kdkecamatan],
    						['is_active','=',true]
    					])->selectRaw('name,nik,jabatan')->get()->toArray(),
    				];



    			    $defwhere=[
		    			['da.kddesa','like',$kc->kdkecamatan.'%'],
		    			['dt.status_validasi','=',5]
		    			
		    		];
		    		

		    		$defJoin=[
		    			[
							DB::raw("left(dt.kode_desa,".($maping['level_data']['child']['count']==0?2:$maping['level_data']['child']['count']).")"),
							'=',
							$maping['level_data']['child']['column_id']
						],
						['dt.tahun','=',DB::raw($tahun)]
		    		];

		    		$OrWhere=[];

		    		

		    		if($request->verifikasi_status){
		    			$defwhere[]=['dt.status_validasi','=',$request->verifikasi_status];

		    		}
		    		if($request->status_daerah){
		    			$defwhere[]=['da.stapem','=',$request->status_daerah];
		    		}

		    		if($request->q){
		    			foreach (['nmdesa','nmkecamatan','nmprovinsi','nmkabkota'] as $key => $value) {
		    				$OrWhere[]=array_merge($defwhere,[['da.'.$value,'like','%'.$request->q.'%']]);
		    			}
		    		}

		    		 $data_query=
				        DB::table($maping['level_data']['child']['table'].' as da')
						->join($maping['data_table'],$defJoin)
						->selectRaw(implode(',',$maping['column']))
						->groupBy($maping['level_data']['child']['column_id'])
						->orderBy($maping['level_data']['child']['column_id'],'asc');

					if($OrWhere){
						foreach ($OrWhere as $key => $value) {
							if($key==0){
								$data_query=$data_query->where($value);

							}
								$data_query=$data_query->orWhere($value);


						}
					}else{
						$data_query=$data_query->where($defwhere);

					}
					
					$data_query=$data_query->get()->toArray();
					if(count($data_query)){
					$data_q[$kc->kdkecamatan]['data']=$data_query;
					$data_q[$kc->kdkecamatan]['jumlah_data']=count($data_query);
					$data_q[$kc->kdkecamatan]['persentase_pelaporan']=HPV::nformat((count($data_query)/$data_q[$kc->kdkecamatan]['jumlah_desa']) *100);

                    $total['jumlah_desa']+=$data_q[$kc->kdkecamatan]['jumlah_desa'];
                    $total['jumlah_desa_melapor']+=count($data_query);

                     $kecamatan_series[]=[
                        'name'=>$kc->nmkecamatan,
                        'data'=>[
                            [
                                'name'=>'Jumlah Total Desa',
                                'y'=>((int)$data_q[$kc->kdkecamatan]['jumlah_desa']),
                                'value'=>((int)$data_q[$kc->kdkecamatan]['jumlah_desa'])
                            ],
                            [
                                'name'=>'Jumlah Desa Melapor',
                                'y'=>(int)count($data_query),
                                'value'=>(int)count($data_query)
                            ],
                            [
                                'name'=>'Jumlah Desa Tidak Melapor',
                                'y'=>((int)$data_q[$kc->kdkecamatan]['jumlah_desa'])-(int)count($data_query),
                                'value'=>((int)$data_q[$kc->kdkecamatan]['jumlah_desa']) - count($data_query)
                            ]

                        ]



                    ];

					}else{
						unset($data_q[$kc->kdkecamatan]);
					}
    			# code...
    		}
    		$data=[
    			'table_map'=>$maping,
    			'data'=>$data_q
    		];

    		
            if($maping){
                if(count($maping['columns'])>10){

                    $maping['split_col']=array_chunk($maping['columns'],10);
                    // dd($maping['split_col']);

                }else{
                    $maping['split_col']=array_chunk($maping['columns'],10);

                }
            }


    	   $view= view('admin.export.berita_acara')
           ->with(
            [
                'daerah'=>$check_access,
                'data'=>$data,
                'table_map'=>$maping,
                'now'=>$now,
                'tahun'=>$tahun,
                'count_kecamatan'=>$count_kecamatan,
                'total'=>$total,
                'kecamatan_series'=>array_chunk($kecamatan_series, 2)
            ])->render();

           $view_rekap=view('admin.export.berita_acara')
           ->with(
            [
                'only_rekap'=>true,
                'daerah'=>$check_access,
                'data'=>$data,
                'table_map'=>$maping,
                'now'=>$now,
                'tahun'=>$tahun,
                'total'=>$total,
                'count_kecamatan'=>$count_kecamatan,
                'kecamatan_series'=>array_chunk($kecamatan_series, 2)
            ])->render();

           if($request->preview){
             return $view;
           }



           $json=[
            'id_data'=>$maping['id_map'],
            'table'=>trim(explode(' as ', $maping['data_table'])[0]),
            'nama_data'=>$maping['data_name'],
            'tahun'=>$tahun,
            'daerah'=>strtoupper($check_access['nama_daerah']),
            'rekap_desa'=>[
                'melapor'=>$total['jumlah_desa_melapor'],
                'total'=>$total['jumlah_desa'],

            ],
            'rekap_kecamatan'=>[
                'melapor'=>count($data['data']),
                'total'=>$count_kecamatan
            ]
           ];


           Storage::put('public/berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.static::kode_data($access_data_daerah,$request->data).'-rekap.json',json_encode($json,JSON_PRETTY_PRINT));

            // $pdf = PDF::loadHtml($view_rekap)
            // ->setPaper('A4', 'landscape');
            // $pdf->save(storage_path('app/public/berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.$request->data).'-rekap.pdf');

            // foreach ($data['data'] as $key => $kecamatan) {
            //     $pdf = PDF::loadHtml(view('admin.beritaacara.buat.per_kc')
            //     ->with(['kecamatan'=>$kecamatan,'tahun'=>$tahun,'now'=>$now,'table_map'=>$maping])->render())
            //     ->setPaper('A4', 'landscape');
            //     $pdf->save(storage_path('app/public/berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.$request->data).'/'.$kecamatan['id'].'.pdf');
            // }


           $pdf=PDF::loadHtml($view)
            ->setPaper('A4', 'landscape')->save(storage_path('app/public/berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.static::kode_data($access_data_daerah,$request->data)).'-full.pdf');

            DB::table('tb_berita_acara')->updateOrInsert([
                'kode_daerah'=>$access_data_daerah,
                'tahun'=>$tahun,
                'id_ms_table'=>$maping['id_map'],
                ],[

                'kode_daerah'=>$access_data_daerah,
                'tahun'=>$tahun,
                'id_ms_table'=>$maping['id_map'],
                'id_user'=>Auth::User()->id,
                'path_berita_acara'=>'storage/berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.static::kode_data($access_data_daerah,$request->data).'-full.pdf'
            ]);

           Alert::success('Berhasil','Berita Acara Berhasil Dibuat');
             if($request->redirect){
                session(['done_build'=>[

                   'text'=> strtoupper('Berita Acara '.$maping['data_name'].' Selesai'),
                   'redirect'=>$request->redirect
                ]
                ]);

                return redirect($request->redirect);

           }

            return $pdf->stream('berita-acara-'.$maping['data_name'].'-'.$tahun.'-'.$check_access['nama_daerah'].'.pdf',array("Attachment" => false));


            // $dompdf = new Dompdf();
            // $dompdf->set_base_path(public_path(''));

            // $dompdf->loadHtml($view);

            // // (Optional) Setup the paper size and orientation
            // $dompdf->setPaper('A4', 'landscape');
            // $dompdf->render();

            // // Output the generated PDF to Browser
            // $dompdf->stream('berita-acara-'.$maping['data_name'].'-'.$tahun.'-'.$check_access['nama_daerah'].'.pdf',array("Attachment" => false));

    	}
	}


}
