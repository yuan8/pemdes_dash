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


Route::get('/',function(){
	return redirect()->route('index',['tahun'=>env('TAHUN')]);
})->name('home');

Route::get('/home',function(){
	return redirect()->route('index');
})->name('home.index');





Route::middleware('guest:web')->get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::middleware('guest:web')->post('/login','Auth\LoginController@login');
Route::middleware('auth:web')->post('/logout','Auth\LoginController@logout')->name('logout');


	
Route::prefix('admin/{tahun?}')->middleware(['auth:web','bindTahun'])->group(function(){
	Route::get('/','ADMIN\AdminCtrl@index')->name('admin.index');
	Route::get('/ketagori','ADMIN\KategoriCtrl@index')->name('admin.kategori.index');
	Route::get('/ketagori/form/create','ADMIN\KategoriCtrl@create')->name('admin.kategori.create');

	Route::get('/ketagori/form/edit/{id}','ADMIN\KategoriCtrl@edit')->name('admin.kategori.edit');


	Route::post('/ketagori/form/edit/{id}','ADMIN\KategoriCtrl@update')->name('admin.kategori.update');
	
	Route::post('/ketagori/form/create','ADMIN\KategoriCtrl@store')->name('admin.kategori.store');

	Route::prefix('validasi')->group(function(){
		Route::get('/','ADMIN\ValidasiCtrl@index')->name('admin.validasi.index');
		Route::get('/data','ADMIN\ValidasiCtrl@data')->name('admin.validasi.data');
		Route::post('/validated/{table}/{id}','ADMIN\ValidasiCtrl@validated')->name('admin.validasi.try');
		Route::put('/validated/{table}/{id}','ADMIN\ValidasiCtrl@update')->name('admin.validasi.update');



	});

	Route::prefix('data')->group(function(){
		Route::get('/','ADMIN\DataCtrl@index')->name('admin.data.index');
		Route::get('/data','ADMIN\DataCtrl@data')->name('admin.data.detail');
		Route::get('/data/create/{jenis}','ADMIN\DataCtrl@create')->name('admin.data.create');
		Route::post('/data/create/{jenis}','ADMIN\DataCtrl@store')->name('admin.data.store');

		Route::get('/data/update/{id}','ADMIN\DataCtrl@edit')->name('admin.data.edit');
		Route::put('/data/update/{id}','ADMIN\DataCtrl@update')->name('admin.data.update');


	});

});



Route::prefix('v/{tahun?}/')->middleware(['bindTahun'])->group(function(){
	Route::get('/', 'HomeCtrl@index')->name('index');
	Route::get('/tb/{h}', 'ADMIN\ValidasiCtrl@number_to_alphabet')->name('tb');


	Route::get('/visulisasi-p-table/{table}','TestCtrl@index')->name('visual.data.table');
	Route::get('/get-data-v-table/{id}/{slug?}','TestCtrl@view')->name('get.data.table');


	Route::get('/category/{id}/{slug?}', 'KategoriCtrl@index')->name('kategori.index');

	Route::get('/category-data/{id}/{slug?}', 'KategoriCtrl@data')->name('kategori.data');

	Route::get('/construction', 'DASH\KONST@index')->name('d.konst');


	
	Route::get('/query-data', 'DataCtrl@index')->name('query.data');
	Route::get('/instansi', 'DataCtrl@instansi')->name('organisasi');
	Route::get('/tema', 'DataCtrl@tema')->name('tema');

	Route::get('/query-data-type/{type}', 'DataCtrl@delivery_type')->name('query.data.delivery');

	Route::get('/query-data-category/{id_category}/{slug}', 'DataCtrl@categorical')->name('query.data.categorycal');

	Route::get('/data-detail/{id}/{slug?}', 'DataCtrl@detail')->name('query.data.detail');


});
