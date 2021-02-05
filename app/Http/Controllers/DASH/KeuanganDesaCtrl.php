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

        	return array(
        		'title'=>$sheet->getCell('A1')->getCalculatedValue(),
        		'header'=>$sheet->toArray()[1]??'REKAP KEUANGAN',
        		'data'=>$data

        	);

      

	}


	public function index(){
		$title=static::getTitle();
		return view('dash.keuangan_desa.index')->with('title',$title);
	}


	public function show($index){
		$data=static::getData($index);
		return view('dash.keuangan_desa.data',['data'=>$data]);
	}



}