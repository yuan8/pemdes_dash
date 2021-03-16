<?php
namespace App\Http\Controllers\DASH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class KeuanganDesaCtrl extends Controller
{


	static public function getTitle(){
		$title=[];
		$spreadsheet=\PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('OKOK.xlsx'));
    	for($i=0;$i<$spreadsheet->getSheetCount();$i++ ) {
    		$title[]=[
    			'id'=>$i,
    			'title'=>$spreadsheet->setActiveSheetIndex($i)->getCell('A1')->getCalculatedValue()
    		];
    	}

    	return $title;

	}

	static public function getData($tahun,$i){
			$spreadsheet=\PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('OKOK.xlsx'));
        	$sheet= $spreadsheet->setActiveSheetIndex($i);
        	$data=[];
        	foreach ($sheet->toArray() as $key => $d) {
    			if($key>=2){
    				$data[]=$d;
    			}
        	}

        	

        	$return= array(
        		'title'=>$sheet->getCell('A1')->getCalculatedValue(),
        		'header'=>$sheet->toArray()[1]??'REKAP KEUANGAN',
        		'data'=>$data

        	);

        	foreach ($return['data'] as $key => $d) {
        		$dx=[];
        		foreach($d as $keyd=>$dt){
        			if($keyd>0){
        				$dx[$keyd]=(float)str_replace(',', '', $dt);
        			}else{
        				$dx[$keyd]=$dt;
        			}
        		}
        		$return['data'][$key]=$dx;
        	}

        	return $return;

      

	}


	public function index($tahun){
		$title=static::getTitle();
		return view('dash.keuangan_desa.index')->with('title',$title);
	}


	public function show($tahun,$index=0){

		$knop=['URAIAN','TAHUN','WILAYAH PEMERINTAHAN'];
		$data=static::getData($tahun,$index);

		$series=[];
		foreach($data['header'] as $ked=>$h){
		if(!in_array($h,$knop)){
			$series[$ked]=[
				'name'=>$h,
				'data'=>[]
			];

			if(in_array($data['header'][$ked],['%','PERSEN'])){
				$series[$ked]['yAxis']=1;
			}

			else{
				$series[$ked]['yAxis']=0;
			}
		}
	}
		

		foreach ($data['data'] as $key => $d) {
			# code...

			foreach ($d as $keyd => $dt) {
				if($keyd>0){

					if(!in_array($data['header'][$keyd],$knop)){
						$DP=[
						'name'=>$d[0],
						'y'=>(float)$dt,
						'satuan'=>in_array($data['header'][$keyd], ['%','PERSEN'])?'%':''
						];

						

						$series[$keyd]['data'][]=$DP;
					}

					
				}
			}

		}

		$series=(array_values($series));


		return view('dash.keuangan_desa.data',[
			'satuan'=>[
				[
            		'satuan'=>'',
            		'title'=>'-'
            	],
            	[
            		'satuan'=>'%',
            		'title'=>'%'
            	]

            ],
			'data'=>$data,'series'=>array_values($series)]);
	}



}