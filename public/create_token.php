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

$data=isset($_REQUEST['_token_access'])?$_REQUEST['_token_access']:null;
die($data);
if($data){
    $data=translate($data);
$data=explode('//',$data);
// $data=[email,password,time]

// query
$query=true;
if($query){
    // $query create or ignore token enc terserah penting unique
    // nama column sso_token 

    $token_enc='axjskjsydhejhseycshcjshiceyech';
    $token=true;
    if($token){

        $res=[
            'status'=>200,
            'status_text'=>'success',
            'message'=>'Success',

            'data'=>[
                'token'=>$token_enc
            ]
        ];

    }else{
         $res=[
            'status'=>500,
            'status_text'=>'error',
            'message'=>'Error'
            
        ];
    }

}else{
     $res=[
            'status'=>500,
            'status_text'=>'error',
            'message'=>'Error'
            
        ];

}




}

echo json_encode($res);

