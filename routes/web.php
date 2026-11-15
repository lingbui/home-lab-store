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
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\UnitController;

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

	// manufacturers 
	Route::get('/manufacturer', [ManufactureController::class, 'index']);
	Route::get('/manufacturer/{id}', [ManufactureController::class, 'show']);
	Route::put('/manufacturer/{id}', [ManufactureController::class, 'update']);
	Route::post('/manufacturer', [ManufactureController::class, 'store']);
	Route::get('/new/manufacturer', function () {
		return view('manufacturer.new_manufacturer');
	});
	Route::delete('/manufacturer/{id}', [ManufactureController::class, 'destroy']);

	// units 
	Route::get('/unit', [UnitController::class, 'index']);
	Route::get('/unit/{id}', [UnitController::class, 'show']);
	Route::put('/unit/{id}', [UnitController::class, 'update']);
	Route::post('/unit', [UnitController::class, 'store']);
	Route::get('/new/unit', function () {
		return view('unit.new_unit');
	});
	Route::delete('/unit/{id}', [UnitController::class, 'destroy']);

	// products 
	Route::get('/product', [ProductController::class, 'index']);
	Route::get('/product/detail/{id}', [ProductController::class, 'show']);
	Route::post('/product/update', [ProductController::class, 'update']);
	Route::post('/product', [ProductController::class, 'store']);
	Route::get('/new/product', function () {
		return view('product.new_product');
	});
	Route::delete('/product/{id}', [ProductController::class, 'destroy']);
	Route::put('/update-status-product/{id}', [ProductController::class, 'updateStatus']);

});

// admin
Route::group(['prefix' => 'admin'], function () {
	Route::get('/login', [LoginController::class, 'showLoginForm']);
	Route::post('/login', [LoginController::class, 'postLoginAdmin']);
	Route::get('/logout', [LoginController::class, 'logoutAdmin']);
});