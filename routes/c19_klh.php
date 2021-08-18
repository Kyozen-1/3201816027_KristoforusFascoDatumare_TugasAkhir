<?php

Route::get('/admin/kelurahan/covid19', 'C19KelurahanController@index')->name('c19_klh.index');
Route::post('/admin/kelurahan/covid19/import', 'C19KelurahanController@import')->name('c19_klh.import');
Route::get('/admin/kelurahan/covid19/export', 'C19KelurahanController@export')->name('c19_klh.export');
Route::get('/admin/kelurahan/covid19/create','C19KelurahanController@create')->name('c19_klh.create');
Route::get('/admin/kelurahan/covid19/sps','C19KelurahanController@sps')->name('c19_klh.sps');
Route::get('/admin/kelurahan/covid19/{id}/detail', 'C19KelurahanController@show');
Route::post('/admin/kelurahan/covid19','C19KelurahanController@store')->name('c19_klh.store');
Route::post('/admin/kelurahan/covid19/coba', 'C19KelurahanController@coba_insert')->name('covid19-dynamic-field.insert');
Route::get('/admin/kelurahan/covid19/{id}/edit','C19KelurahanController@edit');
Route::post('/admin/kelurahan/covid19/update','C19KelurahanController@update')->name('c19_klh.update');
Route::get('/admin/kelurahan/covid19/destroy/tgl/{id}', 'C19KelurahanController@tgl');
Route::get('/admin/kelurahan/covid19/destroy/{id}','C19KelurahanController@destroy');