<?php

Route::get('/admin/mini-test', 'AdminMiniTestController@index')->name('mini_test.index');
Route::get('/admin/mini-test/{id}/detail', 'AdminMiniTestController@show');
Route::post('/admin/mini-test','AdminMiniTestController@store')->name('mini_test.store');
Route::get('/admin/mini-test/{id}/edit','AdminMiniTestController@edit');
Route::post('/admin/mini-test/update','AdminMiniTestController@update')->name('mini_test.update');
Route::get('/admin/mini-test/destroy/{id}','AdminMiniTestController@destroy');