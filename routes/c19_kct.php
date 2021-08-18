<?php

Route::get('/admin/kecamatan/covid19', 'C19KecamatanController@index')->name('c19_kct.index');
Route::get('/admin/kecamatan/covid19/pontianak-utara', 'C19KecamatanController@pontura')->name('c19_kct.pontura');
Route::get('/admin/kecamatan/covid19/pontianak-timur', 'C19KecamatanController@pontur')->name('c19_kct.pontur');
Route::get('/admin/kecamatan/covid19/pontianak-tenggara', 'C19KecamatanController@ponteng')->name('c19_kct.ponteng');
Route::get('/admin/kecamatan/covid19/pontianak-kota', 'C19KecamatanController@ponko')->name('c19_kct.ponko');
Route::get('/admin/kecamatan/covid19/pontianak-selatan', 'C19KecamatanController@ponsel')->name('c19_kct.ponsel');
Route::get('/admin/kecamatan/covid19/pontianak-barat', 'C19KecamatanController@ponbar')->name('c19_kct.ponbar');

Route::get('/admin/kecamatan/covid19/pontianak-utara/tgl', 'C19KecamatanController@ponturaTgl')->name('pontura_tgl');
Route::get('/admin/kecamatan/covid19/pontianak-timur/tgl', 'C19KecamatanController@ponturTgl')->name('pontur_tgl');
Route::get('/admin/kecamatan/covid19/pontianak-tenggara/tgl', 'C19KecamatanController@pontengTgl')->name('ponteng_tgl');
Route::get('/admin/kecamatan/covid19/pontianak-kota/tgl', 'C19KecamatanController@ponkoTgl')->name('ponko_tgl');
Route::get('/admin/kecamatan/covid19/pontianak-selatan/tgl', 'C19KecamatanController@ponselTgl')->name('ponsel_tgl');
Route::get('/admin/kecamatan/covid19/pontianak-barat/tgl', 'C19KecamatanController@ponbarTgl')->name('ponbar_tgl');
