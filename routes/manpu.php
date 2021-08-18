<?php

Route::group(['middleware' => ['role:superadmin']], function(){
    Route::get('/admin/manajemen_pengguna','ManajemenPenggunaController@index')->name('manpu.index');
    Route::get('/admin/manajemen_pengguna/create','ManajemenPenggunaController@create')->name('manpu.create');
    Route::post('/admin/manajemen_pengguna','ManajemenPenggunaController@store')->name('manpu.store');
    Route::get('/admin/manajemen_pengguna/{id}/detail', 'ManajemenPenggunaController@show');
    Route::post('/session/create','ManajemenPenggunaController@sesi')->name('manpu.sesi');
    Route::get('/admin/manajemen_pengguna/{id}/edit','ManajemenPenggunaController@edit');
    Route::post('/admin/manajemen_pengguna/update','ManajemenPenggunaController@update')->name('manpu.update');
    Route::get('/admin/manajemen_pengguna/{id}', 'ManajemenPenggunaController@destroy');
});