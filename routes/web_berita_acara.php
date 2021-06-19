<?php
Route::prefix('admin/{tahun?}')->middleware(['auth:web','bindTahun','can:is_active'])->group(function(){

	Route::prefix('/penjadwalan')->middleware('can:is_daerah_kabkota')->group(function(){
		Route::get('/','ADMIN\PenjadwalanCtrl@index')->name('a.p.index');
		Route::put('/update','ADMIN\PenjadwalanCtrl@update')->name('a.p.update');

	});

	Route::prefix('/berita-acara')->middleware('can:is_daerah_kabkota')->group(function(){
		Route::get('/file','ADMIN\BeritaAcaraCtrl@rekap')->name('a.b.b.index');

	});

	Route::prefix('/berita-acara')->middleware('can:is_only_daerah')->group(function(){
		Route::get('/status','ADMIN\BeritaAcaraCtrl@penandatanganan')->name('a.b.ttd');
		Route::get('/edit/{kode_daerah}/{id_data}','ADMIN\BeritaAcaraCtrl@buat_doc_pengsahan')->name('a.b.r.edit');
		Route::post('/update/{kode_daerah}/{id_data}','ADMIN\BeritaAcaraCtrl@save_doc_pengsahan')->name('a.b.r.save');
		Route::get('/berkas-pengesahan/{kode_daerah}/{id_data}','ADMIN\BeritaAcaraCtrl@berkas_pengesahan')->name('a.b.r.berkas.appv');
		
	});

	Route::prefix('/berita-acara-verifikasi')->middleware('can:is_daerah')->group(function(){
		Route::get('/rekap','ADMIN\ValidasiCtrl@rekap_verifikasi')->name('a.b.r.v.index');

	});

});