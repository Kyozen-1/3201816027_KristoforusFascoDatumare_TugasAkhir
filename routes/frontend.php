<?php

Route::get('/', 'HomePontianakController@index')->name('home');
Route::get('/home-peta-utama', 'HomePontianakController@peta_utama')->name('peta_utama');
Route::get('/home-data-ptk', 'HomePontianakController@data_ptk')->name('home.data_ptk');

Route::get('/table-data-covid-19', 'TableDataCovid19Controller@index')->name('table_data.index');

Route::get('/table-data-pontura', 'TableDataCovid19Controller@table_data_pontura')->name('table_data.pontura');
Route::get('/table-data-pontur', 'TableDataCovid19Controller@table_data_pontur')->name('table_data.pontur');
Route::get('/table-data-ponteng', 'TableDataCovid19Controller@table_data_ponteng')->name('table_data.ponteng');
Route::get('/table-data-ponko', 'TableDataCovid19Controller@table_data_ponko')->name('table_data.ponko');
Route::get('/table-data-ponsel', 'TableDataCovid19Controller@table_data_ponsel')->name('table_data.ponsel');
Route::get('/table-data-ponbar', 'TableDataCovid19Controller@table_data_ponbar')->name('table_data.ponbar');
Route::get('/table-data-tgl1', 'TableDataCovid19Controller@table_data_tgl1')->name('table_data.tgl1');
Route::get('/table-data-tgl2', 'TableDataCovid19Controller@table_data_tgl2')->name('table_data.tgl2');
Route::get('/table-data-tgl3', 'TableDataCovid19Controller@table_data_tgl3')->name('table_data.tgl3');
Route::get('/table-data-tgl4', 'TableDataCovid19Controller@table_data_tgl4')->name('table_data.tgl4');
Route::get('/table-data-tgl5', 'TableDataCovid19Controller@table_data_tgl5')->name('table_data.tgl5');
Route::get('/table-data-tgl6', 'TableDataCovid19Controller@table_data_tgl6')->name('table_data.tgl6');
Route::get('/table-data-peta-kecamatan', 'TableDataCovid19Controller@peta_kecamatan')->name('peta_kecamatan');


Route::get('/statistik', 'StatistikController@index')->name('statistik');
Route::get('/statistik-peta-kecamatan', 'StatistikController@peta_kecamatan')->name('statistik_peta_kecamatan');
Route::get('/statistik/filter/{filter}/{bln}', 'StatistikController@filter');


Route::get('/rumah-sakit-rujukan', 'RumahSakitRujukanController@index')->name('rumah_sakit');
Route::get('/rumah-sakit-rujukan/data_covid', 'RumahSakitRujukanController@data_covid')->name('rumah_sakit.data_covid');
Route::get('/rumah-sakit-rujukan/tgl', 'RumahSakitRujukanController@tanggal')->name('rumah_sakit.tgl');