<?php

Route::get('/admin/rumah-sakit/data', 'RumahSakitDataController@index')->name('rs_data.index');
Route::get('/admin/rumah-sakit/data/create','RumahSakitDataController@create')->name('rs_data.create');
Route::get('/admin/rumah-sakit/data/sps','RumahSakitDataController@sps')->name('rs_data.sps');
Route::post('/admin/rumah-sakit/data/import', 'RumahSakitDataController@import')->name('rs_data.import');
Route::get('/admin/rumah-sakit/data/export', 'RumahSakitDataController@export')->name('rs_data.export');
Route::get('/admin/rumah-sakit/data/{id}/detail', 'RumahSakitDataController@show');
Route::post('/admin/rumah-sakit/data','RumahSakitDataController@store')->name('rs_data.store');
Route::post('/admin/rumah-sakit/data/coba', 'RumahSakitDataController@coba_insert')->name('rs-data-dynamic-field.insert');
Route::get('/admin/rumah-sakit/data/{id}/edit','RumahSakitDataController@edit');
Route::post('/admin/rumah-sakit/data/update','RumahSakitDataController@update')->name('rs_data.update');
Route::get('/admin/rumah-sakit/data/destroy/tgl/{id}', 'RumahSakitDataController@tgl');
Route::get('/admin/rumah-sakit/data/destroy/{id}','RumahSakitDataController@destroy');