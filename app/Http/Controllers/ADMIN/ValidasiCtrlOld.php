<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use HPV;
use Carbon\Carbon;
use Auth;
use Alert;
use Notification;
use App\Notifications\UpdateData;

class ValidasiCtrlOld extends Controller
{	

	public function validated($tahun,$table,$id,Request $request){
		$data=DB::connection('mysql')->table('validasi_confirm as cfm')->where(
			[
				['tahun','=',$tahun],
				['table','=',$table],
				['kode_desa','=',$id]
			]
		)->first();

		if(!$data){
			$data=DB::connection('mysql')->table('validasi_confirm')->insertOrIgnore([
				'tahun'=>$tahun,
				'table'=>$table,
				'kode_desa'=>$id,
				'tanggal_validasi'=>Carbon::parse($request->updated_at),
				'keterangan'=>$request->keterangan,
				'id_user'=>Auth::User()->id
			]);

			$data=DB::table('validasi_confirm')->insertOrIgnore([
				'tahun'=>$tahun,
				'table'=>$table,
				'kode_desa'=>$id,
				'tanggal_validasi'=>Carbon::parse($request->updated_at),
				'keterangan'=>$request->keterangan,
				'id_user'=>Auth::User()->id
			]);

			return back();
		}

		return back();

	}

	public function index($tahun,Request $request){
		$table=DB::table('master_table_map')->where('edit_daerah',true)->get();
		$U=Auth::User();
		$data_index=0;
		if($request->data){
			$data_index=$request->data;
		}


		if(Auth::User()->role==4){
			  $kota=DB::table('kabkota as k')->join(
                'provinsi as p','p.kdprovinsi','=',DB::raw("LEFT(k.kdkabkota,2)")
            )->selectraw("LEFT(k.kdkabkota,2) as id_provinsi,k.kdkabkota as id,CONCAT(p.nmprovinsi,' - ',k.nmkabkota) as text")
			 ->where('k.kdkabkota','=',$U->kode_daerah)
            ->first();

			if($kota){
				
				$kodedaerah=[
					'kdprovinsi'=>$kota->id_provinsi,
					'kdkota'=>$kota->id,
					'kdkecamatan'=>null,
					'kddesa'=>null,
				];
				return view('admin.validasi.index_daerah')->with([
					'provinsi'=>$kodedaerah['kdprovinsi'],
					'kodedaerah'=>$kodedaerah['kdkota'],'data_index'=>$data_index,'table'=>$table,'nama_daerah'=>$kota->text]);

			}else{

				return abort('404');

			}
		}
		
		if(Auth::User()->role==3){
			$provinsi=DB::table('provinsi')
			->whereIn('kdprovinsi',session('_regional_access')->toArray())
			->where('kdprovinsi','!=','0')->where('kdprovinsi','!=','00')->get();
		}else{
			$provinsi=DB::table('provinsi')
			->where('kdprovinsi','!=','0')->where('kdprovinsi','!=','00')->get();
		}


		$kodedaerah=[
			'kdprovinsi'=>null,
			'kdkota'=>null,
			'kdkecamatan'=>null,
			'kddesa'=>null,
		];


		if($request->kdprovinsi){
			$kodedaerah['kdprovinsi']=$request->kdprovinsi;
		}

		if($request->kdkota){
			$kodedaerah['kdkota']=$request->kdkota;

		}

		if($request->kdkecamatan){
			$kodedaerah['kdkecamatan']=$request->kdkecamatan;
			$daerah=DB::table('master_desa')->where('kode_dagri',$kodedaerah['kddesa'])->fisrt();


		}

		if($request->kddesa){
			$kodedaerah['kddesa']=$request->kddesa;
			$daerah=DB::table('master_desa')->where('kode_dagri',$kodedaerah['kddesa'])->fisrt();
		}




		return view('admin.validasi.index')->with([
			'provinsi'=>$provinsi,'kodedaerah'=>$kodedaerah,'data_index'=>$data_index,'table'=>$table]);
	}

	public function data($tahun,Request $request){
		$table=DB::table('master_table_map')->where('edit_daerah',true)->get();

		$tbmap=DB::table('master_table_map as mp')->where('id',$request->data)
		->selectRaw("mp.*,mp.id as id_map")->where('map.edit_daerah',true)->first();

		if($tbmap){
		}

			dd($tbmap);


		$verifikasi=[
			'sudah'=>(int)DB::connection('mysql')->table($table_map['table'].' as d')
			->join('master_desa as md','md.kode_dagri','=','d.kode_desa')
			->join('validasi_confirm as cfm',[[DB::raw("(d.kode_desa)"),'=',DB::raw('cfm.kode_desa')],['cfm.table','=',DB::RAW("'".$table_map['table']."'")],['cfm.tahun','=',DB::raw($tahun)]])
			->count(),
		];


		$verifikasi['belum']=$data->total()-$verifikasi['sudah'];

		$data=$data->appends([
			'kddesa'=>$request->kddesa,
			'kdprovinsi'=>$request->kdprovinsi,
			'kdkota'=>$request->kdkota,
			'kdkecamatan'=>$request->kdkecamatan,
			'data'=>$request->data,
		]);

		$req=[
			'kddesa'=>$request->kddesa,
			'kdprovinsi'=>$request->kdprovinsi,
			'kdkota'=>$request->kdkota,
			'kdkecamatan'=>$request->kdkecamatan,
			'data'=>$request->data
		];


		return view('admin.validasi.data')
		->with(['daerah'=>$daerah,'table_map'=>$table_map,'data'=>$data,'req'=>$req,'data_index'=>$data_index,'table'=>$table,'rekap'=>$verifikasi]);
	}

	public function form_upload($tahun,Request $request){
		if($request->kdprovinsi){
			$kdd=$request->kdprovinsi;
			$where[]=[DB::raw("left(md.kode_dagri,2)"),'=',$request->kdprovinsi];
			$daerah=DB::table('provinsi')

			->where('kdprovinsi',$request->kdprovinsi)
			->selectRaw("
				'' as parent,
				kdprovinsi as id,'PROVINSI' as jenis,nmprovinsi as name")
			->first();
		}


		if($request->kdkota){
			$kdd=$request->kdkota;

			$where[]=[DB::raw("left(md.kode_dagri,4)"),'=',$request->kdkota];
			$daerah=DB::table('kabkota')
			->where('kdkabkota',$request->kdkota)
			->selectRaw("'".$daerah->jenis.' '.$daerah->name." -> ' as parent,kdkabkota as id,'KAB/KOTA' as jenis,nmkabkota as name")
			->first();
		}



		if($request->kdkecamatan){
			$kdd=$request->kdkecamatan;

			$where[]=[DB::raw("left(md.kode_dagri,7)"),'=',$request->kdkecamatan];
			$daerah=DB::table('kecamatan')
			->where('kdkecamatan',$request->kdkecamatan)->selectRaw("'".$daerah->parent." ".$daerah->name." -> ' as parent,
				kdkecamatan as id,'KECAMATAN' as jenis,nmkecamatan as name")
			->first();
		}


		if($request->kddesa){
			$kdd=$request->kddesa;
			$where[]=[DB::raw("(md.kode_dagri)"),'=',$request->kddesa];
			$daerah=DB::table('master_desa')
			->where('kode_dagri',$request->kddesa)->selectRaw("'".$daerah->parent." ".$daerah->jenis." ".$daerah->name." -> ' as parent,
				kode_dagri as id, 'DESA' as jenis,desa as name")
			->first();

		}

		$level=HPV::level($kdd);
		$table=DB::table('master_table_map')->where('id',$request->data)->first();

		if($table){
		return view('admin.validasi.upload')->with(['table'=>$table,'kd'=>$kdd,'level'=>$level,'daerah'=>$daerah]);

		}








	}


	public function validate_bulk($tahun,$idtable,Request $request){


		$kdd=$request->kd;
		$level=HPV::level($request->kd);
		$table=DB::table('master_table_map')->find($idtable);

		$spreadsheet=\PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('dist-web/format-validasi3.xlsx'));
		$sheet=$spreadsheet->setActiveSheetIndex(0);
		$pointer_head=8;
		$sheet=$spreadsheet->getActiveSheet();
		$index_head=8;
		$max_column=2;
		$spreadsheet=\PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
		$sheet=$spreadsheet->setActiveSheetIndex(0);
		$sheet=$spreadsheet->getActiveSheet();
		$date_def=$sheet->getCell(static::nta(1).'2')->getCalculatedValue();
		if($kdd==str_replace('VALIDATE-', '', $sheet->getCell(static::nta(1).'1')->getCalculatedValue())){
			$app=true;
		}else{
			$app=false;
			dd('DOKUMEN TIDAK SESUAI UNTUK VALIDASI DATA PADA DAERAH INI');
		}
    	$index_data=10;

    	$data_change=[];
    	$data_head=[

    	];


		if($app and $table){
			
			foreach ($sheet->toArray() as $key => $d) {
				if($key==4){
					for($index=7;$index<count($d);$index++){
						$data_head[$index]=$d[$index];
					}

				}
				if($key>=9){


					if($d[1]=='VALID'){
						$dddd=[
							'tahun'=>$tahun,
							'kode_desa'=>$d[0]
						];
						foreach ($d as $keyr => $x) {
							
							for($index=7;$index<count($d);$index++){
								$dddd[$data_head[$index]]=$d[$index];
							}
						}
						$data_change[]=[
							'kode_desa'=>$d[0],
							'tahun'=>$tahun,
							'table'=>$table->table,
							'tanggal_validasi'=>$d[2]?Carbon::parse($d[2]):$date_def,
							'data_xx'=>$dddd

						];
						
					}

				}
				# code...
			}


		}

		$data_update=0;

		foreach ($data_change as $key => $d) {
			$va=false;
			$f=DB::connection('mysql')->table('validasi_confirm')->where([
				'table'=>$d['table'],
				'tahun'=>$d['tahun'],
				'kode_desa'=>$d['kode_desa']
			])->first();

			if(!$f){
				$va=DB::connection('mysql')->table('validasi_confirm')->insert([
					'table'=>$d['table'],
					'tahun'=>$d['tahun'],
					'kode_desa'=>$d['kode_desa'],
					'tanggal_validasi'=>$d['tanggal_validasi'],
					'id_user'=>Auth::User()->id
				]);

			}

			if($va){
				$data_update+=1;
				
				DB::connection('mysql')->table($d['table'])->where([
					['kode_desa','=',$d['kode_desa']],
					['tahun','=',$d['tahun']]
				])->updateOrInsert(
					['kode_desa'=>$d['kode_desa'],'tahun'=>$d['tahun']],
					$d['data_xx']
				);
				
				DB::table($d['table'])->where([
					['kode_desa','=',$d['kode_desa']],
					['tahun','=',$d['tahun']]
				])->updateOrInsert(
					['kode_desa'=>$d['kode_desa'],'tahun'=>$d['tahun']],
					$d['data_xx']
				);
				

			}else{

				DB::connection('mysql')->table($d['table'])->where([
					['kode_desa','=',$d['kode_desa']],
					['tahun','=',$d['tahun']]
				])->updateOrInsert(
					['kode_desa'=>$d['kode_desa'],'tahun'=>$d['tahun']],
					$d['data_xx']
				);

			}


		}

         Alert::success('Berhasil', 'Data Berhasil Divalidasi '.HPV::nformat($data_update).' Data');

		return back();


	}


	public function getData($tahun,$table,$kodedesa){
		$data=DB::connection('mysql')->table($table[0]['table'])->get();

	}


	public function export_format($tahun,$data,$title,$map=[],$kddd){
		$data=(HPV::maping_row($data,$map));


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

		$no_meta=0;
		if(isset($data[0])){
			foreach ($data[0] as $key => $value) {
				if($value['type']=='DATA'){
					$no_meta+=1;
					$sheet->getCell(static::nta(1).$row_start)
    									->setValue($no_meta);
					foreach (['name','satuan','definisi','tipe_data','interval_nilai'] as $key_c => $col) {
							if($col=='interval_nilai'){
								$int=($value['interval_nilai'])?explode('|;|',$value['interval_nilai']):[];
								if($int){
									$sheet->getCell(static::nta($key_c+2).$row_start)
    									->setValue($int[0]);
									$them_interval[$key] =$spreadsheet->getActiveSheet()->getCell(static::nta($key_c+2).$row_start)
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
									$them_interval[$key]->setFormula1('"'.implode(',', $int).'"');
								}
							}else{
								$sheet->getCell(static::nta($key_c+2).$row_start)
    							->setValue($value[$col]);
							}

						# code...
					}
					$row_start+=1;


				}
				# code...
			
			}
		}

		$sheet->getStyle(static::nta(1).'7:'.static::nta(6).($no_meta+6))->applyFromArray($DATASTYLE);

		
		$sheet=$spreadsheet->setActiveSheetIndex(0);
		$pointer_head=8;
		$sheet=$spreadsheet->getActiveSheet();
		$index_head=8;
		$max_column=2;

		// dd($data);

		$sheet->getCell(static::nta(1).'1')
    					->setValue('VALIDATE-'.$kddd);

    	$sheet->getCell(static::nta(1).'2')
    					->setValue(Carbon::now());


		$sheet->getCell(static::nta(1).'3')
    					->setValue($title);
    	$sheet->getCell(static::nta(1).'4')
    					->setValue('Data Tahun '.$tahun);
    	$index_data=9;

    	$validation = $spreadsheet->getActiveSheet()->getCell('B'.$index_data)
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
		$validation->setFormula1('"VALID,BELUM"');

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


		if(count($data)>0){
			foreach ($data as $krow => $row) {
				foreach ($row as $kcol => $h) {
					$sheet->getCell(static::nta($h['pointer_c']).''.$h['pointer_r'])
			    	->setValue($h['value']);
			    	
			    	if($h['type']=='DATA'){
			    		if(isset($them_interval[$kcol])){
				    		$sheet->getCell(static::nta($h['pointer_c']).''.$h['pointer_r'])->setDataValidation(clone $them_interval[$kcol]);
				    	}
			    	}

			    	
			    	if($h['name_column']=='valid_date'){
			    		$sheet->getCell(static::nta($h['pointer_c']).''.$h['pointer_r'])
	    					->setValue($h['value']!=null?Carbon::parse($h['value'])->format('Y-m-d'):null);

			    	}
			    	else if($h['name_column']=='status_validasi'){

			    		$sheet->getCell(static::nta($h['pointer_c']).''.$h['pointer_r'])
	    					->setValue($h['value']??'BELUM');
	    				$sheet->getCell(static::nta($h['pointer_c']).''.$h['pointer_r'])->setDataValidation(clone $validation);

			    	}

			    	if($h['type']=='DATA'){
			    		// $sheet->mergeCells((static::nta($h['pointer_c']).''.$h['pointer_r']).':'.(static::nta($h['pointer_c']+1).''.$h['pointer_r']));
			    	}
			    	


					if($krow==0){
						if($h['type']=='DATA'){

							$sheet->getCell(static::nta($h['pointer_c']).'5')
			    					->setValue($h['name_column']);
			    			$sheet->getCell(static::nta($h['pointer_c']).'6')
			    					->setValue($h['tipe_data']);
							 $sheet->getCell(static::nta($h['pointer_c']).'7')
			    					->setValue(strtoupper($h['name']));
			    			// $sheet->mergeCells((static::nta($h['pointer_c']).'7').":".(static::nta($h['pointer_c']+1).'7'));
			    			
			    			// $sheet->mergeCells((static::nta($h['pointer_c']).'5').":".(static::nta($h['pointer_c']+1).'5'));
			    			
			    			$sheet->getCell(static::nta($h['pointer_c']).'8')
			    					->setValue($h['satuan']);

			    			$sheet->getCell(static::nta($h['pointer_c']).'9')
			    					->setValue($index_head);
			    			// $sheet->mergeCells((static::nta($h['pointer_c']).'8').":".(static::nta($h['pointer_c']+1).'8'));

			    			if($max_column<$h['pointer_c']){
			    				$max_column=$h['pointer_c'];
			    			}

			    			$index_head+=1;
						}

					}

				}
					
			}
			$sheet->getStyle(static::nta(8).'6:'.static::nta($max_column).'8')->applyFromArray($HEADSTYLE);
			$sheet->getStyle(static::nta(8).'9:'.static::nta($max_column).'9')->applyFromArray($HEADNUMBERSTYLE);

			$sheet->getStyle(static::nta(1).'10:'.static::nta($max_column).((count($data))+9) )->applyFromArray($DATASTYLE);

			$sheet->setAutoFilter(static::nta(1).'9:'.static::nta($max_column).((count($data))+9));

			$sheet->getStyle((static::nta(3).'10:'.static::nta(3).((count($data))+9)))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);

		}





	  	$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="export.xlsx"');
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


}