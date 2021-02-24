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


Route::prefix('/meta')->group(function () {
    Route::get('kota/{provinsi?}','API\KodeDaerahCtrl@kota')->name('api.meta.kota');
    Route::get('kecamatan/{kota?}','API\KodeDaerahCtrl@kecamatan')->name('api.meta.kecamatan');
    Route::get('desa/{kecamatan?}','API\KodeDaerahCtrl@desa')->name('api.meta.desa');



});
