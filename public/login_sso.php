<?php

 $lib_en=[
        'A'=>'F|U|X',
        'G'=>'|Xu|H',
        'b'=>'78**II:',
        'C'=>'|OL*P',
        'd'=>'O|P*L',
        'E'=>'encriptZoo',
        '1'=>'****',
        '0'=>'234^444',
        'f'=>'^^LLL^^',
        '9'=>'ClS&555',
 ];



function translate($data){
	$base=$text;
        foreach($lib_en as $key=>$e){
            $base=str_replace($e, $key,$base);
        }
    $base=base64_decode($base);
    $base=base64_decode($base);

    return $base;
}



$data=isset($_REQUEST['_sso_access'])?$_REQUEST['_sso_access']:null;
if($data){

$data=explode('//',$data);

foreach($data as $key=>$d){
	$data[$key]=translate($data[$key]);
}

// [user,token_sso,time]
// time =Asia/Jakarta

$range=10;
// minutes | real  = ($range*2) 

$start=time()-(60*$range);
$end=time()+(60*$range);
$time=strtotime($data[2]);

if(($start<=$time) and ($end>$time)){
	// query 
		// jika user bernar dan token bernar
		$query=true;
		if($query){
			// attemp session user disini

			$res=[
				'status'=>200,
				'status_text'=>'success',
				'message'=>'Berhasil login'
			];
		}else{
			$res=[
				'status'=>500,
				'status_text'=>'gagal',
				'message'=>'User tidak ditemukan'
			];
		}

		return json_encode($res);




	}else{
		$res=[
			'status'=>500,
			'status_text'=>'gagal',
			'message'=>'User tidak ditemukan'
		];

		return json_encode($res);
	}

}
	return json_encode($res);






