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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/{tahun?}/chart-offline-d','TestCtrl@offline_donwload')->name('chart.offline');

Route::prefix('/meta')->group(function () {
    Route::get('kota/{provinsi?}','API\KodeDaerahCtrl@kota')->name('api.meta.kota');
    Route::get('kecamatan/{kota?}','API\KodeDaerahCtrl@kecamatan')->name('api.meta.kecamatan');
    Route::get('desa/{kecamatan?}','API\KodeDaerahCtrl@desa')->name('api.meta.desa');

    Route::middleware('auth:api')->group(function(){
    	Route::get('kategori','API\KetegoriCtrl@get')->name('api.meta.kategori');
    	Route::get('instansi','API\KetegoriCtrl@instansi')->name('api.meta.instansi');

    });


});

Route::prefix('data/admin/{tahun}')->middleware(['auth:api','bindTahun'])->group(function(){
	Route::get('validation-form/{table}/{id}','API\ValidateCtrl@form')->name('api.data.validate.form');
});

Route::prefix('d/{tahun}')->middleware(['bindTahun'])->group(function(){

	Route::get('/visulisasi-p-table/{id}/{table}','TestCtrl@index')->name('visual.data.table');
    Route::get('/visulisasi-d-dataset/{id}','DataVisualCtrl@index')->name('visual.dataset');

});

