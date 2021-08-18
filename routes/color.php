<?php

Route::get('/admin/color', 'ColorController@index')->name('color.index');
Route::get('/admin/color/{id}/detail', 'ColorController@show');
Route::post('/admin/color','ColorController@store')->name('color.store');
Route::get('/admin/color/{id}/edit','ColorController@edit');
Route::post('/admin/color/update','ColorController@update')->name('color.update');
Route::get('/admin/color/destroy/{id}','ColorController@destroy');