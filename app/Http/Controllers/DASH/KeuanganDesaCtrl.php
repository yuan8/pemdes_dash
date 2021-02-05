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

	static function getData($i){
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


	public function index(){
		$title=static::getTitle();
		return view('dash.keuangan_desa.index')->with('title',$title);
	}


	public function show($index){

		$knop=['URAIAN','TAHUN'];
		$data=static::getData($index);

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

					if(in_array($data['header'][$keyd],['%','PERSEN'])){
						$DP['yAxis']=2;
					}

					else{
						$DP['yAxis']=1;
					}

						$series[$keyd]['data'][]=$DP;
					}

					
				}
			}

		}


		return view('dash.keuangan_desa.data',[
			'satuan'=>[
				[
            		'satuan'=>'-',
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