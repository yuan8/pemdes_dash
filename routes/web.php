<?php


Route::get('/',function(){
	return redirect()->route('index',['tahun'=>env('TAHUN')]);
})->name('home');
Route::get('/home',function(){
	return redirect()->route('index');
})->name('home.index');

Route::get('init','InitCtrl@init');
Route::get('check',function(){
	dd(DB::table('master_desa')->count());
});


Route::get('route', function()
{
    header('Content-Type: application/excel');
    header('Content-Disposition: attachment; filename="routes.csv"');

    $routes = Route::getRoutes();
    $fp = fopen('php://output', 'w');
    fputcsv($fp, ['METHOD', 'URI', 'NAME', 'ACTION'],';');
    foreach ($routes as $route) {
        fputcsv($fp, [head($route->methods()) , $route->uri(), $route->getName(), $route->getActionName()],';');
    }
    fclose($fp);
});


Route::middleware(['guest:web'])->get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::middleware('guest:web')->post('/login','Auth\LoginController@login');
Route::middleware('auth:web')->post('/logout','Auth\LoginController@logout')->name('logout');

Route::prefix('admin/{tahun?}')->middleware(['auth:web','bindTahun','can:is_active'])->group(function(){
	Route::get('/','ADMIN\AdminCtrl@index')->name('admin.index');

	Route::get('/ketagori','ADMIN\KategoriCtrl@index')->name('admin.kategori.index');

	Route::get('/ketagori/form/create','ADMIN\KategoriCtrl@create')->name('admin.kategori.create');

	Route::get('/ketagori/form/edit/{id}','ADMIN\KategoriCtrl@edit')->name('admin.kategori.edit');


	Route::post('/ketagori/form/edit/{id}','ADMIN\KategoriCtrl@update')->name('admin.kategori.update');
	
	Route::post('/ketagori/form/create','ADMIN\KategoriCtrl@store')->name('admin.kategori.store');

	Route::prefix('/regional')->middleware('can:is_super')->group(function(){
		Route::get('/','ADMIN\RegionalCtrl@index')->name('admin.region.index');
		Route::get('/show/{id}','ADMIN\RegionalCtrl@show')->name('admin.region.show');
		Route::get('/add/','ADMIN\RegionalCtrl@add')->name('admin.region.add');
		Route::post('/store/','ADMIN\RegionalCtrl@store')->name('admin.region.store');
		Route::post('/update/{id}','ADMIN\RegionalCtrl@update')->name('admin.region.update');
		Route::post('/delete/{id}','ADMIN\RegionalCtrl@delete')->name('admin.region.delete');
	});

	Route::prefix('/setting')->middleware('can:is_super')->group(function(){
		Route::get('/tentang-kami','ADMIN\SettingCtrl@index')->name('admin.set.index');
		Route::post('/tentang-kami','ADMIN\SettingCtrl@update')->name('admin.set.update');
	});


	Route::prefix('/instansi')->middleware('can:is_super')->group(function(){
		Route::get('/','ADMIN\InstansiCtrl@index')->name('admin.instansi.index');
		Route::get('/add','ADMIN\InstansiCtrl@add')->name('admin.instansi.add');

		Route::get('/show/{id}/{slug}','ADMIN\InstansiCtrl@show')->name('admin.instansi.show');
		Route::post('/update/{id}','ADMIN\InstansiCtrl@update')->name('admin.instansi.update');
		Route::post('/store/','ADMIN\InstansiCtrl@store')->name('admin.instansi.store');
		Route::post('/delete/{id}','ADMIN\InstansiCtrl@delete')->name('admin.instansi.delete');
	});

	Route::prefix('/session')->middleware('can:is_super')->group(function(){
		Route::get('/','ADMIN\SessionCtrl@index')->name('admin.session.index');
		Route::post('/kill/{id}','ADMIN\SessionCtrl@kill')->name('admin.session.kill');

	});

	Route::prefix('validasi')->group(function(){
		Route::get('/','ADMIN\ValidasiCtrl@index')->name('admin.validasi.index');
		Route::get('/data/build-berita-acara','ADMIN\BeritaAcaraCtrl@build')->name('admin.validasi.berita_acara.build');

		Route::get('/data','ADMIN\ValidasiCtrl@data')->name('admin.validasi.data');
		Route::get('/data/upload','ADMIN\ValidasiCtrl@form_upload')->name('admin.validasi.upload');
		Route::post('/data/upload/{id}','ADMIN\ValidasiCtrl@upload_data')->name('admin.validasi.update.bulk');
		Route::post('/validated/{table}/{id}','ADMIN\ValidasiCtrl@validated')->name('admin.validasi.try');
		Route::put('/validated/{table}/{id}','ADMIN\ValidasiCtrl@update')->name('admin.validasi.update');
	});

	Route::prefix('users')->group(function(){
		Route::get('/','ADMIN\UserCtrl@index')->name('admin.users.index')->middleware(['can:is_super']);
		Route::get('/detail/{id}','ADMIN\UserCtrl@show')->name('admin.users.detail');
		Route::get('/add/','ADMIN\UserCtrl@add')->name('admin.users.add')->middleware(['can:is_super']);
		Route::post('/store/','ADMIN\UserCtrl@store')->name('admin.users.store')->middleware(['can:is_super']);
		Route::post('/update/password/{id}','ADMIN\UserCtrl@up_pass')->name('admin.users.up_pass');
		Route::post('/update/profile/{id}','ADMIN\UserCtrl@up_profile')->name('admin.users.up_profile');
		Route::post('/update/access/{id}','ADMIN\UserCtrl@up_access')->name('admin.users.up_access')->middleware(['can:is_super']);
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
		Route::get('/data-set/edit/{id}','ADMIN\DataCtrl@edit')->name('admin.dataset.edit');
		Route::put('/data-set/update/{id}','ADMIN\DataCtrl@update')->name('admin.dataset.update');
		Route::get('/data/update/{id}','ADMIN\DataCtrl@edit')->name('admin.data.edit');
		Route::put('/data/update/{id}','ADMIN\DataCtrl@update')->name('admin.data.update');
	});

});

Route::prefix('v/{tahun?}/')->middleware(['bindTahun'])->group(function(){
	Route::get('/', 'HomeCtrl@index')->name('index');

	Route::get('/tentang-kami', 'ADMIN\SettingCtrl@public_tentang')->name('public_tentang');


	Route::get('/query-data', 'DataCtrl@index')->name('query.data');

	Route::get('/data-integrasi/{id}/{slug}', 'DataCtrl@detail')->name('data.int.detail');

	Route::get('/instansi', 'DataCtrl@instansi')->name('organisasi');
	Route::get('/tema', 'DataCtrl@tema')->name('tema');
	Route::get('/query-data-type/{type}', 'DataCtrl@delivery_type')->name('query.data.delivery');



	Route::prefix('api-dokumentasi')->middleware(['auth:web'])->group(function(){
		Route::get('/','API\APIDATACtrl@index')->name('doc.api');
	});

	Route::get('/pindah-tahun', 'HomeCtrl@pindahTahun')->name('p.tahun');
	Route::post('/pindah-tahun', 'HomeCtrl@pindahkanTahun')->name('p.tahun.change');

	Route::get('/query-data-category/{id_category}/{slug}', 'DataCtrl@categorical')->name('query.data.categorycal');
});

include __DIR__ .'/test.php';
