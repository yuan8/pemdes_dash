<?php
Route::prefix('provider-messager')->group(function(){

	Route::post('inbound',function(){
		return [
			'testing'=>ok
		];
	});

	Route::post('status',function(){
		return [
			'testing_status'=>ok
		];
	});

	Route::get('test','NotifChangeDataCtrl@testing');
	Route::get('test-blash','NotifChangeDataCtrl@notifWa');

});