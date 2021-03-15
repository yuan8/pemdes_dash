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

Route::get('/y','TestCtrl@tt');


Route::get('/home',function(){
	return redirect()->route('index');
})->name('home.index');

Route::prefix('test')->group(function(){
	Route::get('cron','CronJob@handle');

	Route::get('request','TestCtrl@req');

});



Route::middleware(['guest:web'])->get('/login','Auth\LoginController@showLoginForm')->name('login');
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
		Route::get('/data/upload','ADMIN\ValidasiCtrl@form_upload')->name('admin.validasi.upload');
		Route::post('/data/upload/{id}','ADMIN\ValidasiCtrl@validate_bulk')->name('admin.validasi.update.bulk');

		Route::post('/validated/{table}/{id}','ADMIN\ValidasiCtrl@validated')->name('admin.validasi.try');
		Route::put('/validated/{table}/{id}','ADMIN\ValidasiCtrl@update')->name('admin.validasi.update');



	});

	Route::prefix('data-view')->group(function(){
		Route::get('/','ADMIN\DataViewCtrl@index')->name('admin.dataview.index');
		Route::get('form-edit/{id}','ADMIN\DataViewCtrl@edit')->name('admin.dataview.edit');
		Route::get('form-delete/{id}','ADMIN\DataViewCtrl@form_delete')->name('admin.dataview.form_delete');
		Route::delete('form-delete/{id}','ADMIN\DataViewCtrl@delete')->name('admin.dataview.delete');
		Route::get('form-new/','ADMIN\DataViewCtrl@create')->name('admin.dataview.create');
		Route::post('form-new/','ADMIN\DataViewCtrl@store')->name('admin.dataview.store');
		Route::put('form-edit/{id}','ADMIN\DataViewCtrl@update')->name('admin.dataview.update');

	});

	Route::prefix('table-map')->group(function(){
		Route::get('/','ADMIN\TableMapCtrl@index')->name('admin.tablemap.index');
		Route::get('form-edit/{id}','ADMIN\TableMapCtrl@edit')->name('admin.tablemap.edit');
		Route::put('form-edit/{id}','ADMIN\TableMapCtrl@update')->name('admin.tablemap.update');
		Route::get('form-add/','ADMIN\TableMapCtrl@create')->name('admin.tablemap.create');
		Route::post('form-add/','ADMIN\TableMapCtrl@store')->name('admin.tablemap.store');

		Route::get('form-edit-view/{id}','ADMIN\TableMapCtrl@editView')->name('admin.tablemap.edit.view');
		Route::get('form-edit-columns/{id}','ADMIN\TableMapCtrl@editColumns')->name('admin.tablemap.edit.columns');

		Route::put('form-edit-columns/{id}','ADMIN\TableMapCtrl@updateColumn')->name('admin.tablemap.update.columns');


		Route::put('form-edit-view/{id}','ADMIN\TableMapCtrl@updateView')->name('admin.tablemap.update.view');

		Route::get('form-delete/{id}','ADMIN\TableMapCtrl@form_delete')->name('admin.tablemap.form_delete');
		Route::delete('form-delete/{id}','ADMIN\TableMapCtrl@delete')->name('admin.tablemap.delete');
		Route::get('form-new/','ADMIN\TableMapCtrl@create')->name('admin.tablemap.create');
		Route::post('form-new/','ADMIN\TableMapCtrl@store')->name('admin.tablemap.store');
		Route::put('form-edit/{id}','ADMIN\TableMapCtrl@update')->name('admin.tablemap.update');

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

Route::prefix('sso')->group(function(){
	Route::post('sso-try-attemp','SSOCtrl@attemp')->name('sso.attemp');
	Route::get('sso-login/{id}','SSOCtrl@login')->name('sso.login');


});


	Route::get('/pindah-tahun', 'HomeCtrl@pindahTahun')->name('p.tahun');
	Route::post('/pindah-tahun', 'HomeCtrl@pindahkanTahun')->name('p.tahun.change');


	Route::get('/tb/{h}', 'ADMIN\ValidasiCtrl@number_to_alphabet')->name('tb');


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
