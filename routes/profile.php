<?php
Route::get('/admin/profile/{id}', 'ProfileController@edit')->name('profile');
Route::put('/admin/profile/{id}', 'ProfileController@update');