<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class AdminCtrl extends Controller
{
    //

    public function index(){
    	return view('admin.index');
    }
}
