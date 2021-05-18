<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use HP;
use Carbon\Carbon;
use Alert;
use App\User;
use Notification;
use App\Notifications\UpdateData;

class ValidasiCtrl extends Controller
{
    //


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


    public function index($tahun){
    	$table=DB::table('master_table_map')->where('edit_daerah',true)->get();

    	$get_list=static::check_access();

    	if($get_list){
    		if($get_list['list']){
	    		if(Auth::User()->can('is_only_regional')){
	    			$provinsi=DB::table('users_group as g')
                        ->join('master_regional as r','r.id','=','g.id_regional')
                        ->join('master_regional_detail as gdt','gdt.id_regional','=','r.id')
	    				->join('master_provinsi as p','p.kdprovinsi','=','gdt.kode_daerah')
                        ->selectRaw('p.*,r.name as name_region')
	    				->where('g.id_user',Auth::user()->id)->get();

                       $get_list['nama_daerah']=implode(',', $provinsi->pluck('name_region')->toArray());
	    		}else{
                    $provinsi=DB::table('master_provinsi')->get();
                    $get_list['nama_daerah']='';
                }

                return view('admin.validasi.index')->with([
                    'table'=>$table,
                    'provinsi'=>$provinsi,
                    'nama_daerah'=>$get_list['nama_daerah']
                ]);

	    	}else{
	    		return view('admin.validasi.index_daerah')->with(['kodedaerah'=>$get_list['kode_daerah'],'nama_daerah'=>$get_list['nama_daerah'],'table'=>$table]);
	    	}

    	}
    	
    }


    public function data($tahun,Request $request){
       

    	$access_data_daerah=$request->kddesa??$request->kdkecamatan??$request->kdkabkota??$request->kdprovinsi;
    	$check_access=static::check_access($access_data_daerah);


    	$mapTb=DB::table('master_table_map as m')
    	->join('master_column_map as c',[['m.id','=','c.id_ms_table'],['c.validate','=',DB::raw(true)]])
    	->selectRaw('m.*,m.id as id_map')->where('m.id',$request->data)
    	->first();

        $jadwal_status=HP::check_jadwal_pengisian($access_data_daerah,$tahun);
        $expt_jadwal=[
            'status_jadwal'=>isset($jadwal_status['status_jadwal'])?$jadwal_status['status_jadwal']:false,
            'jadwal'=>$jadwal_status,
            'nama_data'=>$mapTb->name
        ];

        if($request->export_format=='FORM' and $expt_jadwal['status_jadwal']!=1){
                return view('admin.validasi.jadwal_excpt')->with($expt_jadwal);
        }else if($expt_jadwal['status_jadwal']>1 OR $expt_jadwal['status_jadwal']<1 ){
                return view('admin.validasi.jadwal_excpt')->with($expt_jadwal);
        }






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

    		$defwhere=[
    			['da.kddesa','like',DB::raw("'".$maping['level_data']['kode_daerah'].'%'."'")]
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

    		$rekap=
		        DB::table($maping['level_data']['child']['table'].' as da')
				->leftJoin($maping['data_table'],$defJoin)
				->selectRaw("
					count(distinct(da.kddesa)) as total,
					count(distinct(case when dt.status_validasi=5 then da.kddesa else null end) ) as jumlah_desa_valid,
					count(distinct(case when dt.status_validasi=2 then da.kddesa else null end) ) as jumlah_desa_ver_10,
					count(distinct(case when dt.status_validasi=3 then da.kddesa else null end) ) as jumlah_desa_ver_6,
					count(distinct(case when dt.status_validasi=4 then da.kddesa else null end) ) as jumlah_desa_ver_4,
					count(distinct(case when dt.status_validasi=5 then da.kddesa else null end) ) as jumlah_desa_ver_2,
					count(distinct(case when dt.kode_desa then dt.kode_desa else null end) ) as jumlah_data

					");




    		 $data_query=
		        DB::table($maping['level_data']['child']['table'].' as da')
				->leftJoin($maping['data_table'],$defJoin)
				->selectRaw(implode(',',$maping['column']))
				->groupBy($maping['level_data']['child']['column_id'])
				->orderBy($maping['level_data']['child']['column_id'],'asc');

			if($OrWhere){
				foreach ($OrWhere as $key => $value) {
					if($key==0){
						$data_query=$data_query->where($value);
						$rekap=$rekap->where($value);

					}
						$data_query=$data_query->orWhere($value);
						$rekap=$rekap->orWhere($value);


				}
			}else{
				$data_query=$data_query->where($defwhere);
				$rekap=$rekap->where($defwhere);

			}
			

			$data_query=$data_query->get();

           

			if($request->export_format){
                
                switch ($request->export_format) {
                    case 'FORM':
                        # code...
                    return static::build_excel('FORM',$data_query,$maping,$check_access,static::check_form_abl(),$tahun);

                        break;
                    case 'HASIL':
                    return static::build_excel('HASIL',$data_query,$maping,$check_access,static::check_form_abl(),$tahun);
                        # code...
                        break;
                    
                    default:
                        # code...
                        break;
                }

                return abort('404');
				
			}

			$rekap=(array)$rekap->first();



			$req=$check_access['kode_daerah'];
			$req['data']=$request->data;
			$req['status_daerah']=$request->status_daerah;
			$req['verifikasi_status']=$request->verifikasi_status;
			$req['q']=$request->q;

			// $rekap=DB::TABLE

			$verifikasi=[
				'total'=>$rekap['total'],
				'sudah'=>$rekap['jumlah_desa_valid'],
				'belum'=>((int)$rekap['total'] - (int)$rekap['jumlah_desa_valid']),
				'verifikasi'=>$rekap['jumlah_desa_ver_'.strlen($access_data_daerah)]
			];

			return view('admin.validasi.data')
		->with(
				[
					'daerah'=>$check_access['nama_daerah'],
					'table_map'=>$maping,
					'data'=>$data_query,
					'req'=>$req,
					'data_index'=>$request->data,
					'table'=>$table,
					'rekap'=>$verifikasi,
					'nama_data'=>$maping['data_name'],
					'kode_daerah'=>$access_data_daerah
				]);




    	}





    }


    static function check_form_abl(){

    	if(Auth::User()->can('is_super')){
    		return [
    			'valid'=>true,
    			'list'=>['VALIDASI','VERIFIKASI','UPDATE','NONE'],
                'abl_status'=>5
    		];
    	}

    	if(Auth::User()->can('is_admin')){
    		return [
    			'valid'=>true,
    			'list'=>['VALIDASI','UPDATE','NONE'],
                'abl_status'=>5

    		];
    	}

    	if(Auth::User()->can('is_daerah')){
    		if(strlen(Auth::User()->kode_daerah)==4){
    			return [
    				'valid'=>true,
    				'list'=>['VALIDASI','UPDATE','NONE'],
                    'abl_status'=>4

    			];
    		}else{
                $abl_status=1;
                switch (strlen(Auth::User()->kode_daerah)) {
                    case 10:
                    $abl_status=2;

                        # code...
                        break;
                    case 6:
                    $abl_status=3;

                        # code...
                        break;
                    
                    default:
                        # code...
                        break;
                }
    			return [
    				'valid'=>false,
    				'list'=>['VERIFIKASI','UPDATE','NONE'],
                    'abl_status'=>$abl_status
    			];
    		}
    	}

    	return [
    				'valid'=>false,
    				'list'=>[]
    	];
    }


    public function build_excel($ext,$data,$maping,$access,$abl_aksi,$tahun){
    	$rows=HP::maping_row($data,$maping);
    	$HEADSTYLE=[
			'font' => [
        		'bold' => true,
        		'color'=>[
        			'argb'=>'FFFFFFFF'
        		]
    		],
    		'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		        ],
		    ],
		    'fill' => [
		        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
		        'startColor' => [
		            'argb' => 'FF327da8',
		        ],
		        'endColor' => [
		            'argb' => 'FFFFFFFF',
		        ],
		    ],
		];

		
		$HEADNUMBERSTYLE=[
			'font' => [
        		'bold' => true,
        		'color'=>[
        			'argb'=>'FFFFFFFF'
        		]
    		],
    		'alignment'=>[
    			'wrapText'=>true,
    			'horizontal'=>'center'
    		],
    		'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		        ],
		    ],
		    'fill' => [
		        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
		        'startColor' => [
		            'argb' => 'FF000000',
		        ],
		        'endColor' => [
		            'argb' => 'FFFFFFFF',
		        ],
		    ],
		];

		//META

    	
    	$spreadsheet=\PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('dist-web/format-validasi3.xlsx'));
		$sheet=$spreadsheet->setActiveSheetIndex(1);

		$DATASTYLE=[
			'font' => [
        		'bold' => true,

    		],
    		'alignment'=>[
    			'wrapText'=>true,
    		],
    		'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		        ],
		    ],
		    
		];

		$row_start=7;
		$them_interval=[];
		foreach (['NAMA DATA','SATUAN','DEFINISI','TIPE DATA','INTERVAL NILAI'] as $key => $value) {
			# code...
			$sheet->getCell(static::nta($key+2).($row_start-1))
    							->setValue($value);
		}

        $nomer=0;
        foreach ($maping['columns'] as $key => $c) {
            $nomer+=1;
            $sheet->getCell(static::nta(1).($row_start))
                                ->setValue($nomer);

            foreach(['name','satuan','definisi','tipe_data','interval_nilai'] as $col=>$v){

                if($v=='interval_nilai'){
                    if($c['interval_nilai']){
                        $interval=explode('|;|',$c['interval_nilai']);
                        if(count($interval)>0){
                            $them_interval[$key]=$spreadsheet->getActiveSheet()->getCell(static::nta($col+2).($row_start))
                             ->getDataValidation();
                            $them_interval[$key]->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
                            $them_interval[$key]->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
                            $them_interval[$key]->setAllowBlank(false);
                            $them_interval[$key]->setShowInputMessage(true);
                            $them_interval[$key]->setShowErrorMessage(true);
                            $them_interval[$key]->setShowDropDown(true);
                            $them_interval[$key]->setErrorTitle('Input error');
                            $them_interval[$key]->setError('Value is not in list.');
                            $them_interval[$key]->setPromptTitle('Pick from list');
                            $them_interval[$key]->setPrompt('Please pick a value from the drop-down list.');
                            $them_interval[$key]->setFormula1('"'.implode(',',$interval).'"');
                       
                            $sheet->getCell(static::nta($col+2).($row_start))
                                ->setValue($interval[0]);
                        }
                    }
                }else{

                     $sheet->getCell(static::nta($col+2).($row_start))
                                ->setValue($c[$v]);
                }
            }


            $row_start++;
        }

         $sheet->getStyle(static::nta(1).'7:'.static::nta($col+2).($row_start-1))->applyFromArray($DATASTYLE);


		

		// DATA
        // HEADER DATA
        $sheet=$spreadsheet->setActiveSheetIndex(0);

        $code_excel=($abl_aksi['valid']?'FORM-VALIDASI':'FORM-VERIFIKASI').'||'.$maping['level_data']['kode_daerah'].'||'.strlen($maping['level_data']['kode_daerah']);

        $sheet->getCell(static::nta(1).(1))
        ->setValue($code_excel);



        $start_col_head=10;
        $start_row_head=5;
        foreach ($maping['columns'] as $key => $row) {
            $sheet->getCell(static::nta($start_col_head).($start_row_head))
                                ->setValue($row['name_column']);
            $sheet->getCell(static::nta($start_col_head).($start_row_head+1))
                                ->setValue($row['tipe_data']);
            $sheet->getCell(static::nta($start_col_head).($start_row_head+2))
                                ->setValue($row['satuan']);
            $sheet->getCell(static::nta($start_col_head).($start_row_head+3))
                                ->setValue($row['name']);
            $sheet->getCell(static::nta($start_col_head).($start_row_head+4))
                                ->setValue($start_col_head);

            $start_col_head+=1;
        }

        $sheet->getStyle(static::nta(10).'5:'.static::nta($start_col_head-1).'8')->applyFromArray($HEADSTYLE);

        $sheet->getStyle(static::nta(10).'9:'.static::nta($start_col_head-1).'9')->applyFromArray($HEADNUMBERSTYLE);




		$index_data=10;
		$validation = $spreadsheet->getActiveSheet()->getCell('E'.$index_data)
   		 ->getDataValidation();
		$validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
		$validation->setAllowBlank(false);
		$validation->setShowInputMessage(true);
		$validation->setShowErrorMessage(true);
		$validation->setShowDropDown(true);
		$validation->setErrorTitle('Input error');
		$validation->setError('Value is not in list.');
		$validation->setPromptTitle('Pick from list');
		$validation->setPrompt('Please pick a value from the drop-down list.');
		$validation->setFormula1('"'.implode(',',$abl_aksi['list']).'"');

		foreach ($rows as $key => $row) {
            foreach ($row as $i=> $d) {
                $sheet->getCell(static::nta($d['col']).($d['row']))
                                ->setValue($d['val']);
                if($i==4){
                    $sheet->getCell('E'.$d['row'])->setDataValidation(clone $validation);
                }

                if($d['type']=='DATA'){
                    if(isset($d['use_theme_interval']) and $d['use_theme_interval']){
                     $sheet->getCell(static::nta($d['col']).$d['row'])->setDataValidation(clone $them_interval[$d['use_theme_interval']]);
                    }
                }

            }
            
        }

        $sheet->getStyle(static::nta(1).'10:'.static::nta($d['col']).($d['row']))->applyFromArray($DATASTYLE);
        $sheet->setAutoFilter(static::nta(1).'9:'.static::nta($d['col']).($d['row']));

        $sheet->getStyle(static::nta(3).'10:'.static::nta(4).($d['row']))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
         $sheet->getStyle(static::nta(4).'10:'.static::nta(4).($d['row']))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);


        $poin_daerah=$access['nama_daerah'];

         $sheet->getCell(static::nta(1).'2')
                                ->setValue(Carbon::now());
         $sheet->getCell(static::nta(1).'3')
                                ->setValue(($abl_aksi['valid']?'FORM VALIDASI ':'FORM VERIFIKASI').' '.$maping['data_name'].' TAHUN '.$tahun);
        $sheet->getCell(static::nta(1).'4')
                                ->setValue($poin_daerah);

    
        $title=($abl_aksi['valid']?'FORM VALIDASI ':'FORM VERIFIKASI').' '.$maping['data_name'].' TAHUN '.$tahun.' '.$poin_daerah;



		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$title.'.xlsx"');
        $writer->save("php://output");
        exit;


    }

    static  public function nta($number) {
    $number = intval($number);
    if ($number <= 0) {
        return '';
    }
    $alphabet = '';
    while($number != 0) {
        $p = ($number - 1) % 26;
        $number = intval(($number - $p) / 26);
        $alphabet = chr(65 + $p) . $alphabet;
    }
    return $alphabet;
	}

    public function form_upload($tahun,Request $request){
        $access_data_daerah=$request->kddesa??$request->kdkecamatan??$request->kdkabkota??$request->kdprovinsi;
        $check_access=static::check_access($access_data_daerah);

        if($check_access){
             $mapTb=DB::table('master_table_map as m')
            ->join('master_column_map as c',[['m.id','=','c.id_ms_table'],['c.validate','=',DB::raw(true)]])
            ->selectRaw('m.*,m.id as id_map')->where('m.id',$request->data)
            ->first();
             $maping=HP::level_build($mapTb,$access_data_daerah,1,1);



             if($mapTb and $maping){
                return view('admin.validasi.upload')->with(['table'=>$mapTb,'kd'=>$access_data_daerah,'level'=>$maping,'daerah'=>$check_access['nama_daerah']]);

            }


        }else{
            Alert::error('Error','Akses Daerah Tidak Tersedia');
            return back();
        }

        Alert::error('Error','Akses Daerah Tidak Tersedia');
        return back();
    }


    static function notifUpdate($kodedaerah,$data){
        $users=User::where([
            ['role','=',4],
            ['kode_daerah','like',substr($kodedaerah,0,2).'%']
        ])->selectRaw('users.*')
        ->join('sessions as se','se.user_id','=','users.id')
        ->get();

        foreach ($users as $key => $u) {
            $u->notify(new UpdateData($data));
        }
    }


    public function upload_data($tahun,$id_map,Request $request){

        $access_data_daerah=$request->kd;
        $check_access=static::check_access($access_data_daerah);

        $kode_daerah_parent_provinsi=substr($access_data_daerah,0,2);

        if($check_access){
            $mapTb=DB::table('master_table_map as m')
            ->join('master_column_map as c',[['m.id','=','c.id_ms_table'],['c.validate','=',DB::raw(true)]])
            ->selectRaw('m.*,m.id as id_map')->where('m.id',$id_map)
            ->first();
            $maping=HP::level_build($mapTb,$access_data_daerah,1,1);


          if($mapTb and $maping){

            $spreadsheet=\PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $spreadsheet->setActiveSheetIndexByName('DATA');
            $sheet=$spreadsheet->getActiveSheet();

            $kodeForm=$sheet->getCell(static::nta(1).'1')->getCalculatedValue();
            $kodeForm=explode('||', $kodeForm);
            $abl_check=static::check_form_abl();

            $abl=($abl_check['valid']?'FORM-VALIDASI':'FORM-VERIFIKASI');
            if(count($kodeForm)>1){
                if(($access_data_daerah==$kodeForm[1]) and ($abl==$kodeForm[0])){
                    $data_col_max=10;
                    $map_col_data=[];
                    do{
                        $col_table=$sheet->getCell(static::nta($data_col_max).'5')->getCalculatedValue();
                        if($col_table){
                            $map_col_data[]=$col_table;
                            $data_col_max+=1;
                        }
                    }while($col_table);


                    $data_col_max-=2;
                    $data_array=$sheet->toArray();
                    array_splice($data_array, 0, 9);

                    $data_update=[];
                    $data_verifikasi=[];
                    $data_validasi=[];
                    $now=Carbon::now();

                    foreach ($data_array as $key => $d) {
                        if(!in_array($d[4], $abl_check['list'])){
                            Alert::error('Error','AKSI LIST TIDAK SESUAI '.static::nta(4).($key+10).' ('.implode(',', $abl_check['list']).')');

                            return back();
                        }

                        if(!empty($d[4]) and ($d[4]!='NONE')){


                            $data_ch=[
                                'kode_desa'=>$d[0],
                                'tahun'=>$tahun,
                                'updated_at'=>$now
                            ];
                            $start_col=9;
                            foreach ($map_col_data as $i => $col) {
                                $data_ch[$col]=$d[$start_col+$i];
                            }

                            switch ($d[4]) {
                                case 'UPDATE':
                                    # code...
                                    $data_update[]=$data_ch;
                                    break;
                                case 'VERIFIKASI':
                                    # code...
                                    $data_verifikasi[]=$data_ch;
                                    break;
                                case 'VALIDASI':
                                    # code...
                                    $data_validasi[]=$data_ch;
                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }

                        }

                    }

                    // 

                    $upsuccess=static::update_data($data_update,$mapTb->table,$abl_check);
                    $versuccess=static::verifikasi_data($data_verifikasi,$mapTb->table,$abl_check);
                    $valsuccess=static::validasi_data($data_validasi,$mapTb->table,$abl_check);
                    
                    static::rekap($access_data_daerah,$maping);


                    $data_req=['tahun'=>$tahun,'data'=>$id_map];
                    foreach ($check_access['kode_daerah'] as $key => $value) {
                        if($key!='export_format'){
                            $data_req[$key]=$value;
                        }

                    }



                    $notif_message=[
                        'title'=>$maping['data_name'],
                        'options'=>[
                            'body'=>Auth::User()->name.' Melakukan Perubahan Data Di '.$check_access['nama_daerah'].'',
                            'icon'=>Auth::User()->profile_pic?asset(Auth::User()->profile_pic):asset('logo.png'),
                            'tag'=>'UPDATEDATAPROEPDESKEL',
                            'route'=>route('admin.validasi.data',$data_req),
                            'data'=>[
                                'user'=>[
                                    'id'=>Auth::User()->id,
                                    'name'=>Auth::User()->name,
                                    'role_name'=>HP::roleName(Auth::User()->role)
                                ],
                                'data_name'=>$maping['data_name'],
                                'body'=>'Melakukan Perubahan Data Di '.$check_access['nama_daerah'],
                                  'data'=>[
                                    'update'=>count($upsuccess),
                                    'verifikasi'=>count($versuccess),
                                    'valsuccess'=>count($valsuccess),
                                  ]
                              ]
                        ],
                        
                    ];

                    static::notifUpdate($access_data_daerah,$notif_message);


                    Alert::success('Berhasil','Jumlah Update : '.count($upsuccess).' , Jumlah Verifikasi : '.count($versuccess).' , Jumlah Validasi :'.count($valsuccess));


                    
                    $kdkd=[
                        'tahun'=>$tahun,
                        'id'=>$maping['id_map'],'data'=>$maping['id_map']];

                    foreach ($check_access['kode_daerah'] as $key => $value) {
                        $kdkd[$key]=$value;
                    }



                    return redirect()->route('admin.validasi.data',($kdkd));


                }
            }






          }


        }

        Alert::error('Error','Tidak Tersedia Akses / Form Salah');
        return back();


        

    }


    static function update_data($data,$table,$ac){
        $count_success=[];
        foreach ($data as $key => $d) {
            $dnew=$d;
            
            $check=DB::table($table)
            ->where([
                ['kode_desa','=',$d['kode_desa']],
                ['tahun','=',$d['tahun']],
            ])->first();

            if($check){
                if($check->status_validasi<=$ac['abl_status']){
                    $check_status=DB::table($table)
                      ->where([
                        ['kode_desa','=',$d['kode_desa']],
                        ['tahun','=',$d['tahun']],
                    ])
                    ->update($dnew);
                }

            }else{
                $dnew['status_validasi']=1;
                $check_status=DB::table($table)->insertOrIgnore($dnew);
            }

            if($check_status){
                $count_success[]=$d['kode_desa'];
            }
        }

        return $count_success;
    }

    static function verifikasi_data($data,$table,$ac){
        $count_success=[];
        static::update_data($data,$table,$ac);

        foreach ($data as $key => $d) {
            $dnew=$d;
            $dnew['status_validasi']=$ac['abl_status'];
            $check_status=DB::table($table)->where([
                ['kode_desa','=',$d['kode_desa']],
                ['status_validasi','<=',$ac['abl_status']],
                ['tahun','=',$d['tahun']],
            ])->update($dnew);

            if($check_status){
                $count_success[]=$d['kode_desa'];
            }
            # code...
        }

        return $count_success;

    }

    static function validasi_data($data,$table,$ac){
        $count_success=[];
        static::update_data($data,$table,$ac);
        $now=Carbon::now();

        foreach ($data as $key => $d) {
            $dnew=$d;
            $dnew['status_validasi']=5;
            $dnew['validasi_date']=$now;
            $check_status=DB::table($table)->where([
                ['kode_desa','=',$d['kode_desa']],
                ['status_validasi','<=',5],
                ['tahun','=',$d['tahun']],
            ])->update($dnew);

            if($check_status){
                $count_success[]=$d['kode_desa'];
            }
            # code...
        }
        

        return $count_success;

    }

    public static function rekap($kode_daerah,$table){
        $now=Carbon::now();
        $exist=(array) DB::table('master_desa as da')
        ->leftJoin($table['data_table'],'dt.kode_desa','=','da.kddesa')
        ->where('da.kddesa','like',$kode_daerah.'%')
        ->selectRaw(
            "
            count(distinct(da.kddesa)) as total,
            count(distinct(case when dt.status_validasi=5 then dt.kode_desa else null end) ) as valid,
            count(distinct(case when dt.status_validasi=2 then dt.kode_desa else null end) ) as ver_10,
            count(distinct(case when dt.status_validasi=3 then dt.kode_desa else null end) ) as ver_6,
            count(distinct(case when dt.status_validasi=4 then dt.kode_desa else null end) ) as ver_4,
            count(distinct(case when dt.status_validasi=5 then dt.kode_desa else null end) ) as ver_2,
            count(distinct(case when dt.kode_desa then dt.kode_desa else null end) ) as jumlah_data,
            count(distinct(case when dt.status_validasi>0 then dt.kode_desa else null end) ) as handle

            "
        )->first();


        $rekap=(array) DB::table('tb_notifikasi_wa')
        ->where('kode_daerah',$kode_daerah)
        ->first();

        if($exist){
            $exist['unhandle']=$exist['total']-$exist['handle'];
            $exist['desa_tidak_terdata']=$exist['total']-$exist['jumlah_data'];
            unset($exist['handle']);
            unset($exist['jumlah_data']);
            unset($exist['total']);
            $exist['id_user']=Auth::User()->id;
            $exist['id_table_map']=$table['id_map'];
            $exist['kode_daerah']=$kode_daerah;
             $exist['updated_at']=$now;

        }

        if($rekap){
            $is_new=false;
            foreach (['valid','ver_10','ver_6','ver_2','ver_4','unhandle','desa_tidak_terdata'] as  $key) {
                if($rekap[$key]!=$exist[$key]){
                    if(!$is_new){
                       $is_new =true;
                    }
                }

            }

            if($is_new){
                $exist['created_at']=$now;
            }

            DB::table('tb_notifikasi_wa')
            ->where('kode_daerah',$kode_daerah)
            ->update($exist);

        }else{
           
            $exist['created_at']=$now;

            DB::table('tb_notifikasi_wa')->insertOrIgnore($exist);


        }
    }

}
