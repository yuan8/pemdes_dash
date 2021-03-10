<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use HPV;
use Carbon\Carbon;
use Auth;
class ValidasiCtrl extends Controller
{	

	public function validated($tahun,$table,$id,Request $request){
		$data=DB::table('validasi_confirm as cfm')->where(
			[
				['tahun','=',$tahun],
				['table','=',$table],
				['kode_desa','=',$id]
			]
		)->first();

		if(!$data){
			$data=DB::table('validasi_confirm')->insert([
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
		$data_index=0;
		if($request->data){
			$data_index=$request->data;
		}

		$provinsi=DB::table('provinsi')->where('kdprovinsi','!=','0')->where('kdprovinsi','!=','00')->get();

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
			$daerah=DB::table('master_desa')->where('kode_bps',$kodedaerah['kddesa'])->fisrt();


		}

		if($request->kddesa){
			$kodedaerah['kddesa']=$request->kddesa;
			$daerah=DB::table('master_desa')->where('kode_bps',$kodedaerah['kddesa'])->fisrt();
		}




		return view('admin.validasi.index')->with([
			'provinsi'=>$provinsi,'kodedaerah'=>$kodedaerah,'data_index'=>$data_index,'table'=>$table]);
	}

	public function data($tahun,Request $request){
		$table=DB::table('master_table_map')->where('edit_daerah',true)->get();

		$data_index=0;
		$daerah=NULL;
		if($request->data){
			$data_index=$request->data;
		}
		$table_map=(array)DB::table('master_table_map as tmap')->where('id',$data_index)->first();


		$raw=[
		];

		if(!$table_map){
			$GLOBALS['ab_message']=['title'=>''];

			return abort(404);
		}else{
			$table_map=HPV::gen_map($table_map['key_view'],0);
			foreach ($table_map['columns'] as $key => $value) {
				$raw[]='d.'.$value['name_column'];
			}
		}



		$where=[];
		if($request->kdprovinsi){
			$kddd=$request->kdprovinsi;

			$where[]=[DB::raw("left(md.kode_bps,2)"),'=',$request->kdprovinsi];
			$daerah=DB::table('provinsi')

			->where('kdprovinsi',$request->kdprovinsi)
			->selectRaw("
				'' as parent,
				kdprovinsi as id,'PROVINSI' as jenis,nmprovinsi as name")
			->first();
		}


		if($request->kdkota){
			$kddd=$request->kdkota;

			$where[]=[DB::raw("left(md.kode_bps,4)"),'=',$request->kdkota];
			$daerah=DB::table('kabkota')
			->where('kdkabkota',$request->kdkota)
			->selectRaw("'".$daerah->jenis.' '.$daerah->name." -> ' as parent,kdkabkota as id,'KAB/KOTA' as jenis,nmkabkota as name")
			->first();
		}



		if($request->kdkecamatan){
			$kddd=$request->kdkecamatan;

			$where[]=[DB::raw("left(md.kode_bps,7)"),'=',$request->kdkecamatan];
			$daerah=DB::table('kecamatan')
			->where('kdkecamatan',$request->kdkecamatan)->selectRaw("'".$daerah->parent." ".$daerah->name." -> ' as parent,
				kdkecamatan as id,'KECAMATAN' as jenis,nmkecamatan as name")
			->first();
		}


		if($request->kddesa){
			$kddd=$request->kddesa;
			$where[]=[DB::raw("(md.kode_bps)"),'=',$request->kddesa];
			$daerah=DB::table('master_desa')
			->where('kode_bps',$request->kddesa)->selectRaw("'".$daerah->parent." ".$daerah->jenis." ".$daerah->name." -> ' as parent,
				kode_bps as id, 'DESA' as jenis,desa as name")
			->first();

		}


		$data=DB::table('master_desa as md')
		->leftjoin($table_map['table'].' as d',[['md.kode_bps','=','d.kode_desa'],['d.tahun','=',DB::Raw($tahun)]])
		->leftJoin('kecamatan as mkc',DB::raw("left(md.kode_bps,7)"),DB::raw('='),DB::raw('mkc.kdkecamatan'))
		->leftJoin('validasi_confirm as cfm',[
			[DB::raw("(d.kode_desa)"),'=',DB::raw('cfm.kode_desa')],
			['cfm.table','=',DB::RAW("'".$table_map['table']."'") ],
			['cfm.tahun','=',DB::RAW($tahun)]
		])
		->selectRaw("md.kode_bps as id_desa,(case when (cfm.id) then 'VALID' else 'BELUM' end)  as status_validasi,cfm.tanggal_validasi as valid_date , md.desa as name, mkc.nmkecamatan as name_kecamatan".(count($raw)?','.implode(',', $raw):'' ));

		if(count($where)>0){
			$data=$data->where($where);
		}


		if($request->export_format){

			$data=$data->orderBy('md.kode_bps','asc')->get();
			return static::export_format($tahun,$data,$table_map['name'].' '.$daerah->parent.' '.$daerah->name,$table_map,$kddd);
		}else{

			$data=$data->orderBy('md.kode_bps','asc')->paginate(10);

		}	



		$verifikasi=[
			'sudah'=>(int)DB::table($table_map['table'].' as d')
			->join('master_desa as md','md.kode_bps','=','d.kode_desa')
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
			$where[]=[DB::raw("left(md.kode_bps,2)"),'=',$request->kdprovinsi];
			$daerah=DB::table('provinsi')

			->where('kdprovinsi',$request->kdprovinsi)
			->selectRaw("
				'' as parent,
				kdprovinsi as id,'PROVINSI' as jenis,nmprovinsi as name")
			->first();
		}


		if($request->kdkota){
			$kdd=$request->kdkota;

			$where[]=[DB::raw("left(md.kode_bps,4)"),'=',$request->kdkota];
			$daerah=DB::table('kabkota')
			->where('kdkabkota',$request->kdkota)
			->selectRaw("'".$daerah->jenis.' '.$daerah->name." -> ' as parent,kdkabkota as id,'KAB/KOTA' as jenis,nmkabkota as name")
			->first();
		}



		if($request->kdkecamatan){
			$kdd=$request->kdkecamatan;

			$where[]=[DB::raw("left(md.kode_bps,7)"),'=',$request->kdkecamatan];
			$daerah=DB::table('kecamatan')
			->where('kdkecamatan',$request->kdkecamatan)->selectRaw("'".$daerah->parent." ".$daerah->name." -> ' as parent,
				kdkecamatan as id,'KECAMATAN' as jenis,nmkecamatan as name")
			->first();
		}


		if($request->kddesa){
			$kdd=$request->kddesa;
			$where[]=[DB::raw("(md.kode_bps)"),'=',$request->kddesa];
			$daerah=DB::table('master_desa')
			->where('kode_bps',$request->kddesa)->selectRaw("'".$daerah->parent." ".$daerah->jenis." ".$daerah->name." -> ' as parent,
				kode_bps as id, 'DESA' as jenis,desa as name")
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
    	$index_data=9;

    	$data_change=[];
    	$data_head=[

    	];


		if($app and $table){
			
			foreach ($sheet->toArray() as $key => $d) {
				if($key==4){
					for($index=7;$index<count($d);$index+=2){
						$data_head[$index]=$d[$index];
					}
				}
				if($key>=8){

					if($d[1]=='VALID'){
						$dddd=[
							'tahun'=>$tahun,
							'kode_desa'=>$d[0]
						];
						foreach ($d as $keyr => $x) {
							
							for($index=7;$index<count($d);$index+=2){
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
			$f=DB::table('validasi_confirm')->where([
				'table'=>$d['table'],
				'tahun'=>$d['tahun'],
				'kode_desa'=>$d['kode_desa']
			])->first();

			if(!$f){
				$va=DB::table('validasi_confirm')->insert([
					'table'=>$d['table'],
					'tahun'=>$d['tahun'],
					'kode_desa'=>$d['kode_desa'],
					'tanggal_validasi'=>$d['tanggal_validasi'],
					'id_user'=>Auth::User()->id
				]);

			}

			if($va){
				$data_update+=1;
				
				DB::table($d['table'])->where([

					['kode_desa','=',$d['kode_desa']],
					['tahun','=',$d['tahun']]
				])->updateOrInsert($d['data_xx']);

			}


		}

		return back();

		// return 'data validasi '.$data_update.' Data';









	}


	public function getData($tahun,$table,$kodedesa){
		$data=DB::table($table[0]['table'])->get();

	}


	public function export_format($tahun,$data,$title,$map=[],$kddd){
		$data=(HPV::maping_row($data,$map));
		$spreadsheet=\PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('dist-web/format-validasi3.xlsx'));
		$sheet=$spreadsheet->setActiveSheetIndex(0);
		$pointer_head=8;
		$sheet=$spreadsheet->getActiveSheet();
		$index_head=8;
		$max_column=2;

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
			    		$sheet->mergeCells((static::nta($h['pointer_c']).''.$h['pointer_r']).':'.(static::nta($h['pointer_c']+1).''.$h['pointer_r']));
			    	}
			    	


					if($krow==0){
						if($h['type']=='DATA'){

							 $sheet->getCell(static::nta($h['pointer_c']).'7')
			    					->setValue(strtoupper($h['name']));
			    			$sheet->mergeCells((static::nta($h['pointer_c']).'7').":".(static::nta($h['pointer_c']+1).'7'));
			    			$sheet->getCell(static::nta($h['pointer_c']).'5')
			    					->setValue($h['name_column']);
			    			$sheet->mergeCells((static::nta($h['pointer_c']).'5').":".(static::nta($h['pointer_c']+1).'5'));
			    			$sheet->getCell(static::nta($h['pointer_c']).'6')
			    					->setValue($h['aggregate_type']);
			    			$sheet->getCell(static::nta($h['pointer_c']+1).'6')
			    					->setValue($h['satuan']);

			    			$sheet->getCell(static::nta($h['pointer_c']).'8')
			    					->setValue($index_head);
			    			$sheet->mergeCells((static::nta($h['pointer_c']).'8').":".(static::nta($h['pointer_c']+1).'8'));

			    			if($max_column<$h['pointer_c']){
			    				$max_column=$h['pointer_c']+1;
			    			}

			    			$index_head+=1;
						}

					}

				}
					
			}
			$sheet->getStyle(static::nta(8).'6:'.static::nta($max_column).'7')->applyFromArray($HEADSTYLE);
			$sheet->getStyle(static::nta(8).'8:'.static::nta($max_column).'8')->applyFromArray($HEADNUMBERSTYLE);

			$sheet->getStyle(static::nta(1).'9:'.static::nta($max_column).((count($data)-1)+9) )->applyFromArray($DATASTYLE);
			$sheet->setAutoFilter(static::nta(1).'8:'.static::nta($max_column).((count($data)-1)+9));

			$sheet->getStyle((static::nta(3).'9:'.static::nta(3).((count($data)-1)+9)))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);

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