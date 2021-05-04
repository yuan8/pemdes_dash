<?php

namespace App\Http\Controllers\Notif;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Notifications\UpdateData;
use App\User;

use Notification;

class FireBaseCtrl extends Controller
{
    //

    public function sendTest(Request $request){
    	$User=User::find(2);
        Notification::route('App.User.2','broadcast' )
        ->notify(new UpdateData($request));
    	// $daa=$User->notify(new UpdateData($request));
// 
    	// dd($User,$daa);
    }

    public function auth(Request $request){
    	dd($request->all());
    }


    public function receiver(){
    	return view('testing.index');

    }
}
