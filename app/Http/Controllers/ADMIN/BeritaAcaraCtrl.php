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

        return view('admin.beritaacara.rekap.index')->with(['rekap'=>$rekap,'count'=>count($data)]);

    }

    public function delete($tahun,Request $request){
        $access_data_daerah=$request->kddesa??$request->kdkecamatan??$request->kdkabkota??$request->kdprovinsi;
        $file=file_exists(storage_path('app/public/berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.$request->data.'-full.pdf'));
      
        if($file){
            Alert::success('Berhasil');
            Storage::delete(('/public/berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.$request->data.'-full.pdf'));
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

            DB::table('tb_berita_acara')->insertOrIgnore([
                'kode_daerah'=>$access_data_daerah,
                'tahun'=>$tahun,
                'id_table_map'=>$maping['id_map']
            ]);
            
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

    		DB::table('tb_berita_acara')->insertOrIgnore([
    			'kode_daerah'=>$access_data_daerah,
    			'tahun'=>$tahun,
    			'id_table_map'=>$maping['id_map']
    		]);
    		
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
                'count_kecamatan'=>$count_kecamatan,
                'kecamatan_series'=>array_chunk($kecamatan_series, 2)
            ])->render();

           if($request->preview){
             return $view;
           }

           Storage::put('public/berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.$request->data.'/init.index','');

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
            ->setPaper('A4', 'landscape')->save(storage_path('app/public/berita-acara/'.$access_data_daerah.'/'.$tahun.'/data-'.$request->data).'-full.pdf');

           Alert::success('Berhasil','Berita Acara Berhasil Dibuat');
             if($request->redirect){
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
