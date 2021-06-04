<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class CloneDataCtrl extends Controller
{
    //

    protected $connection;

    function __contruct($connection){
    	if($connection){
    		$this->connection=$connection;
    	}else{
    		$connection=env('DB_DATABASE_STAGING');
    	}
    } 

    public function clone($name_table){
    	$data=[
    		"name"=>"",
    		"data"=>[]
    	];

    	$production_con=env('DB_DATABASE');
    	
    	$chek_exits=DB::


    }
}
