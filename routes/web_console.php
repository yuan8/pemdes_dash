<?php


Route::prefix('init')->group(function(){
	Route::get('create-file','InitDataCtrl@createFile');
	Route::get('copy','InitDataCtrl@server_');
	Route::get('copy-view','InitDataCtrl@copy_view');


	Route::get('build-db','InitCtrl@init');

	Route::get('data-table','InitDataCtrl@index');
	Route::get('data-table-drop','InitDataCtrl@drop');

});