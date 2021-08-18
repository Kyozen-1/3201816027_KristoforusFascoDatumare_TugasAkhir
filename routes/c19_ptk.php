<?php
Route::get('/admin/pontianak/covid19', 'C19_PtkController@index')->name('c19_ptk.index');
Route::post('/admin/pontianak/covid19/import', 'C19_PtkController@import')->name('c19_ptk.import');
Route::get('/admin/pontianak/covid19/export', 'C19_PtkController@export')->name('c19_ptk.export');
Route::get('/admin/pontianak/covid19/{id}/detail', 'C19_PtkController@show');
Route::post('/admin/pontianak/covid19','C19_PtkController@store')->name('c19_ptk.store');
Route::get('/admin/pontianak/covid19/{id}/edit','C19_PtkController@edit');
Route::post('/admin/pontianak/covid19/update','C19_PtkController@update')->name('c19_ptk.update');
Route::get('/admin/pontianak/covid19/destroy/{id}','C19_PtkController@destroy');