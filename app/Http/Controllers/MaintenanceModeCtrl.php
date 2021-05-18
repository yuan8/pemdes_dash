<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceModeCtrl extends Controller
{
    //

    public function index(){
    	return view('down.maintenance');
    }

    public function code(){
    	dd(
    		config('proepdeskel.maintenance.prefix'),
    		route('index')
    	);
    }
}
