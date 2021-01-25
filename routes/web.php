<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/',function(){
	
	return redirect()->route('index');

})->name('home');

	
Route::prefix('admin')->middleware('auth:web')->group(function(){
	Route::get('/','ADMIN\AdminCtrl@index')->name('admin.index');
	Route::get('/ketagori','ADMIN\KategoriCtrl@index')->name('admin.kategori.index');

});

Route::prefix('v')->group(function(){
	Route::get('/', 'HomeCtrl@index')->name('index');

	Route::get('/kependudukan', 'DASH\KependudukanCtrl@index')->name('d.kependudukan');
	Route::get('/kependudukan/penduduk/p', 'DASH\KependudukanCtrl@get_jp_provinsi')->name('d.kependudukan.chart.p');
	Route::get('/kependudukan/penduduk/k/{kodepemda}', 'DASH\KependudukanCtrl@get_jp_kota')->name('d.kependudukan.chart.k');
	Route::get('/kependudukan/penduduk/d/{kodepemda}', 'DASH\KependudukanCtrl@get_jp_desa')->name('d.kependudukan.chart.d');



	Route::get('/query-data', 'DataCtrl@index')->name('query.data');
	Route::get('/query-data-category/{id_category}/{slug}', 'DataCtrl@categorical')->name('query.data.categorycal');

	Route::get('/data/{id}/{slug}', 'DataCtrl@detail')->name('query.data.detail');


});
