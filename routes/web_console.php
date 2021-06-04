<?php


Route::prefix('init')->group(function(){
	Route::get('create-file','InitDataCtrl@createFile');
	Route::get('copy','InitDataCtrl@server_');
	Route::get('copy-view','InitDataCtrl@copy_view');



	Route::get('data-table','InitDataCtrl@index');
});