<?php


Route::get('test-echo','Notif\FireBaseCtrl@receiver');

Route::get('test-echo-send', 'Notif\FireBaseCtrl@sendTest');


use Illuminate\Support\Facades\Broadcast;

Route::get('test',function(){

	dd(Broadcast::routes());
});
