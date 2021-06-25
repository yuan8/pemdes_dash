<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/{tahun?}/chart-offline-d','TestCtrl@offline_donwload')->name('chart.offline');


Route::prefix((config('proepdeskel.maintenance.status')?config('proepdeskel.maintenance.prefix').'/':'').'/meta')->group(function () {
    Route::get('kota/{provinsi?}','API\KodeDaerahCtrl@kota')->name('api.meta.kota');

    Route::get('kecamatan/{kota?}','API\KodeDaerahCtrl@kecamatan')->name('api.meta.kecamatan');
    Route::get('desa/{kecamatan?}','API\KodeDaerahCtrl@desa')->name('api.meta.desa');

    Route::middleware('auth:api')->group(function(){
    	Route::get('kategori','API\KetegoriCtrl@get')->name('api.meta.kategori');
    	Route::get('instansi','API\KetegoriCtrl@instansi')->name('api.meta.instansi');

    });


});

Route::prefix((config('proepdeskel.maintenance.status')?config('proepdeskel.maintenance.prefix').'/':'').'data/admin/{tahun}')->middleware(['auth:api','bindTahun'])->group(function(){
    
    Route::get('list-daerah','Admin\UserCtrl@access_daerah_admin')->name('api.list_access_daerah');

	Route::get('validation-form/{table}/{id}','API\ValidateCtrl@form')->name('api.data.validate.form');
    Route::post('show-my-list-sso-access','SSOCtrl@List')->name('api.sso.list');
    // Route::post('add-my-list-sso-access','SSOCtrl@add')->name('api.sso.add');


});

Route::prefix((config('proepdeskel.maintenance.status')?config('proepdeskel.maintenance.prefix').'/':'').'d/{tahun}')->middleware(['bindTahun'])->group(function(){
    Route::get('/index-desa-data', 'IndexDesaCtrl@data_index_desa')->name('index.desa.data');
    
	// Route::get('/visulisasi-p-table/{id}/{table}','TestCtrl@index')->name('visual.data.table');
    Route::get('/visulisasi-d-dataset/{id}','DataCtrl@visualisasi_data')->name('vs.data.visual');
    Route::get('/get-category-desa/','HomeCtrl@cat_desa')->name('re.cat.cat_desa');

    Route::get('data-integrasi-level/{id}/','DataIntegrasiCtrl@get_data')->name('vs.data.integrasi');

    Route::get('data-integrasi/{id}/','DataIntegrasiCtrl@get_data_desa')->name('vs.data.integrasi.desa');

    Route::get('instansi','API\InstansiCtrl@getInstansi')->name('api.get.instansi');

    

});



Route::prefix((config('proepdeskel.maintenance.status')?config('proepdeskel.maintenance.prefix').'/':'').'v/{tahun}')->middleware(['bindTahun','auth:api'])->group(function(){
    Route::post('get-data/{id}/{kodedaerah}','API\APIDATACtrl@getData')->name('api.public.getdata');
    Route::post('get-data-list-user-daerah/{kodedaerah}','ADMIN\UserCtrl@list_user_daerah')->name('api.list.user.daerah');




});




