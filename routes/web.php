<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\Auth_Admin\LoginController;

use App\Http\Controllers\Customer\LoginController as CustomerLoginController;
use App\Http\Controllers\Customer\LogoutController as CustomerLogoutController;
use App\Http\Controllers\Customer\RegisterController as CustomerRegisterController;


// login 
Route::get('/login', function () {
	return view('login');
});

// dang nhap 
Route::post('/login', [CustomerLoginController::class, 'postLogin']);

// dang xuat 
Route::get('/logout', [CustomerLogoutController::class, 'logout']);

// dang ky
Route::get('/register', function () {
	return view('register');
});
Route::post('/register', [CustomerRegisterController::class, 'register']);
// cap nhat thong tin
Route::get('/fulfill/information', [CustomerRegisterController::class, 'fulfill']);
// tao tai khoan
Route::post('/create/account', [CustomerRegisterController::class, 'createAccount']);

// admin-collaborator
Route::group(['prefix' => 'admin', 'middleware' => 'CheckAdmin'], function () {


	// get change pass 
	Route::get('/change/password', [LoginController::class, 'getChangePassword']);
	Route::post('/change/password', [LoginController::class, 'changePassword']);

});

// admin
Route::group(['prefix' => 'admin'], function () {
	Route::get('/login', [LoginController::class, 'showLoginForm']);
	Route::post('/login', [LoginController::class, 'postLoginAdmin']);
	Route::get('/logout', [LoginController::class, 'logoutAdmin']);
});