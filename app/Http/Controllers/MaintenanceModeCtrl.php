<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceModeCtrl extends Controller
{
    //

    public function index(){

    }

    public function code(){
    	dd(
    		config('proepdeskel.maintenance.prefix'),
    		route('index')
    	);
    }
}
