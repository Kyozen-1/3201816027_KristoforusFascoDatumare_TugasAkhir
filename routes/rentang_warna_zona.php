<?php

Route::get('/admin/rentang-warna-zona', 'RentangWarnaZonaController@index')->name('rentang-warna-zona.index');
Route::get('/admin/rentang-warna-zona/{id}/detail', 'RentangWarnaZonaController@show');
Route::post('/admin/rentang-warna-zona','RentangWarnaZonaController@store')->name('rentang-warna-zona.store');
Route::get('/admin/rentang-warna-zona/{id}/edit','RentangWarnaZonaController@edit');
Route::post('/admin/rentang-warna-zona/update','RentangWarnaZonaController@update')->name('rentang-warna-zona.update');
Route::get('/admin/rentang-warna-zona/destroy/{id}','RentangWarnaZonaController@destroy');