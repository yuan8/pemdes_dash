<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCtrl extends Controller
{
    //

    public function index($tahun){
    	return view('admin.index');
    }
}
