<?php
Route::group(['middleware' => ['role:superadmin']], function(){
    Route::get('/admin/kecamatan', 'KecamatanController@index')->name('kecamatan.index');
    Route::get('/admin/kecamatan/{id}/detail', 'KecamatanController@show');
    Route::post('/admin/kecamatan','KecamatanController@store')->name('kecamatan.store');
    Route::get('/admin/kecamatan/{id}/edit','KecamatanController@edit');
    Route::post('/admin/kecamatan/update','KecamatanController@update')->name('kecamatan.update');
    Route::get('/admin/kecamatan/destroy/{id}','KecamatanController@destroy');
});