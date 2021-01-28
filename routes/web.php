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
	Route::get('/ketagori/form/create','ADMIN\KategoriCtrl@create')->name('admin.kategori.create');
	Route::post('/ketagori/form/create','ADMIN\KategoriCtrl@store')->name('admin.kategori.store');



});

Route::prefix('v')->group(function(){
	Route::get('/', 'HomeCtrl@index')->name('index');
	Route::get('/category/{id}/{slug?}', 'KategoriCtrl@index')->name('kategori.index');

	Route::get('/pendidikan', 'DASH\PendidikanCtrl@index')->name('d.pendidikan');
	Route::get('/pendidikan/penduduk/p', 'DASH\PendidikanCtrl@get_pp_provinsi')->name('d.pendidikan.data');
	Route::get('/pendidikan/penduduk/k/{kodepemda}', 'DASH\PendidikanCtrl@get_pp_kota')->name('d.pendidikan.chart.k');
	Route::get('/pendidikan/penduduk/kc/{kodepemda}', 'DASH\PendidikanCtrl@get_pp_kecamatan')->name('d.pendidikan.chart.kc');

	Route::get('/pendidikan/penduduk/d/{kodepemda}', 'DASH\PendidikanCtrl@get_pp_desa')->name('d.pendidikan.chart.d');



	Route::get('/luas-desa', 'DASH\LuasDesaCtrl@index')->name('d.luas_desa');
	Route::get('/luas-desa/kewilayahan/p', 'DASH\LuasDesaCtrl@get_provinsi')->name('d.luas_desa.data');
	Route::get('/luas-desa/kewilayahan/k/{kodepemda}', 'DASH\LuasDesaCtrl@get_kota')->name('d.luas_desa.chart.k');
	Route::get('/luas-desa/kewilayahan/kc/{kodepemda}', 'DASH\LuasDesaCtrl@get_kecamatan')->name('d.luas_desa.chart.kc');

	Route::get('/luas-desa/kewilayahan/d/{kodepemda}', 'DASH\LuasDesaCtrl@get_desa')->name('d.luas_desa.chart.d');



	Route::get('/peta-batas', 'DASH\PenetapanBatasCtrl@index')->name('d.peta_batas');
	Route::get('/peta-batas/kewilayahan/p', 'DASH\PenetapanBatasCtrl@get_provinsi')->name('d.peta_batas.data');
	Route::get('/peta-batas/kewilayahan/k/{kodepemda}', 'DASH\PenetapanBatasCtrl@get_kota')->name('d.peta_batas.chart.k');
	Route::get('/peta-batas/kewilayahan/kc/{kodepemda}', 'DASH\PenetapanBatasCtrl@get_kecamatan')->name('d.peta_batas.chart.kc');

	Route::get('/peta-batas/kewilayahan/d/{kodepemda}', 'DASH\PenetapanBatasCtrl@get_desa')->name('d.peta_batas.chart.d');





	Route::get('/pekerjaan', 'DASH\PekerjaanCtrl@index')->name('d.pekerjaan');
	Route::get('/pekerjaan/penduduk/p', 'DASH\PekerjaanCtrl@get_pp_provinsi')->name('d.pekerjaan.data');
	Route::get('/pekerjaan/penduduk/k/{kodepemda}', 'DASH\PekerjaanCtrl@get_pp_kota')->name('d.pekerjaan.chart.k');
	Route::get('/pekerjaan/penduduk/kc/{kodepemda}', 'DASH\PekerjaanCtrl@get_pp_kecamatan')->name('d.pekerjaan.chart.kc');

	Route::get('/pekerjaan/penduduk/d/{kodepemda}', 'DASH\PekerjaanCtrl@get_pp_desa')->name('d.pekerjaan.chart.d');

	Route::get('/kewilayahan', 'DASH\KewilayahanCtrl@index')->name('d.kewilayahan');


	Route::get('/kependudukan', 'DASH\KependudukanCtrl@index')->name('d.kependudukan');
	Route::get('/kependudukan/penduduk/p', 'DASH\KependudukanCtrl@get_jp_provinsi')->name('d.kependudukan.chart.p');
	Route::get('/kependudukan/penduduk/k/{kodepemda}', 'DASH\KependudukanCtrl@get_jp_kota')->name('d.kependudukan.chart.k');
	Route::get('/kependudukan/penduduk/d/{kodepemda}', 'DASH\KependudukanCtrl@get_jp_desa')->name('d.kependudukan.chart.d');
	Route::get('/kependudukan/penduduk/kc/{kodepemda}', 'DASH\KependudukanCtrl@get_jp_kecamatan')->name('d.kependudukan.chart.kc');



	Route::get('/query-data', 'DataCtrl@index')->name('query.data');
	Route::get('/query-data-category/{id_category}/{slug}', 'DataCtrl@categorical')->name('query.data.categorycal');

	Route::get('/data/{id}/{slug}', 'DataCtrl@detail')->name('query.data.detail');


});
