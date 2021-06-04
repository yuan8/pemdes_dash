<?php


Route::prefix('init')->group(function(){
	Route::get('create-file','InitDataCtrl@createFile');
	Route::get('copy','InitDataCtrl@server_');


	Route::get('data-table','InitDataCtrl@index');
});