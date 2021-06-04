<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataManualCtrl extends Controller
{
    
    public function store($tahun,Request $request){

    	dd($request->all());

    }
}
