<?php

Route::get('/admin/zona', 'ZonaController@index')->name('zona.index');
Route::get('/admin/zona/{id}/detail', 'ZonaController@show');
Route::post('/admin/zona','ZonaController@store')->name('zona.store');
Route::get('/admin/zona/{id}/edit','ZonaController@edit');
Route::post('/admin/zona/update','ZonaController@update')->name('zona.update');
Route::get('/admin/zona/destroy/{id}','ZonaController@destroy');