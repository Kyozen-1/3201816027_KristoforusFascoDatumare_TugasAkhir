<?php

Route::group(['middleware' => ['role:superadmin']], function(){
    Route::get('/admin/rumah-sakit', 'RumahSakitController@index')->name('rs.index');
    Route::get('/admin/rumah-sakit/{id}/detail', 'RumahSakitController@show');
    Route::post('/admin/rumah-sakit','RumahSakitController@store')->name('rs.store');
    Route::get('/admin/rumah-sakit/{id}/edit','RumahSakitController@edit');
    Route::post('/admin/rumah-sakit/update','RumahSakitController@update')->name('rs.update');
    Route::get('/admin/rumah-sakit/destroy/{id}','RumahSakitController@destroy');
});