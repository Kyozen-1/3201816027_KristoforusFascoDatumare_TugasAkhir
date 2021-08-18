<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
//Frontend

@include('frontend.php');

//Dashboard
@include('dashboard.php');

//Profile
@include('profile.php');

//Change Password
@include('change_password.php');

//Kecamatan
@include('kecamatan.php');

//Kelurahan
@include('Kelurahan.php');

//Covid-19 Kelurahan
@include('c19_klh.php');

//Covid-19 Pontianak
@include('c19_ptk.php');

//Covid-19 Kecamatan
@include('c19_kct.php');

//Rumah Sakit
@include('rs.php');

//Data Rumah Sakit
@include('rs_data.php');

//Mini Test
@include('mini_test.php');

//Manajemen Pengguna
@include('manpu.php');

//Color
@include('color.php');
// Route::get('/home', 'HomeController@index')->name('home');