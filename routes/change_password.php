<?php

Route::get('/admin/change-password', 'ChangePasswordController@index');
Route::post('/admin/change-password', 'ChangePasswordController@store')->name('change-password');