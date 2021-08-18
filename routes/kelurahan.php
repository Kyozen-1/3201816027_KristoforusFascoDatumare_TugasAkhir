<?php

Route::group(['middleware' => ['role:superadmin']], function(){
    Route::get('/admin/kelurahan', 'KelurahanController@index')->name('kelurahan.index');
    Route::get('/admin/kelurahan/{id}/detail', 'KelurahanController@show');
    Route::post('/admin/kelurahan','KelurahanController@store')->name('kelurahan.store');
    Route::get('/admin/kelurahan/{id}/edit','KelurahanController@edit');
    Route::post('/admin/kelurahan/update','KelurahanController@update')->name('kelurahan.update');
    Route::get('/admin/kelurahan/destroy/{id}','KelurahanController@destroy');
});