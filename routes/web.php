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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
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

// admin
Route::group(['prefix' => 'admin', 'middleware' => 'CheckAdminLogin'], function () {
	// transaction
	Route::delete('/transaction/{id}', [TransactionController::class, 'destroy']);

	// report chart
	Route::get('/chart', [AdminController::class, 'index']);
	Route::get('/report_product', function () {
		return view('admin.report_product');
	});
	Route::get('/report_transaction', function () {
		return view('admin.report_transaction');
	});
	Route::post('/report_product/{id}', [ProductController::class, 'reportProduct']);
	Route::get('/report_product/{id}', [ProductController::class, 'reportProduct']);
	Route::post('/report_transaction/from_date={from_date}&to_date={to_date}&status={status}', [TransactionController::class, 'reportTransaction']);
	Route::get('/report_transaction/from_date={from_date}&to_date={to_date}&status={status}', [TransactionController::class, 'reportTransaction']);
	
});

// admin-collaborator
Route::group(['prefix' => 'admin', 'middleware' => 'CheckAdmin'], function () {

	// get home page admin 
	Route::get('/', [AdminController::class, 'homePage']);
	Route::get('/home', [AdminController::class, 'homePage']);

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

	// transactions
	Route::get('/transaction', [TransactionController::class, 'index']);
	Route::get('/transaction_pending', [TransactionController::class, 'pending']);
	Route::get('/transaction_shipped', [TransactionController::class, 'shipped']);
	Route::get('/transaction_delivered', [TransactionController::class, 'delivered']);
	Route::get('/transaction_cancel', [TransactionController::class, 'cancel']);
	Route::get('/transaction/{order_id}', [TransactionController::class, 'show']);
	Route::get('/transaction_note/{id}', [TransactionController::class, 'note']);
	Route::put('/transaction/{id}', [TransactionController::class, 'update']);
	Route::put('/transaction/cancel/{id}', [TransactionController::class, 'cancelTransaction']);
	Route::delete('/transaction/{id}', [TransactionController::class, 'destroy']);

});

// admin
Route::group(['prefix' => 'admin'], function () {
	Route::get('/login', [LoginController::class, 'showLoginForm']);
	Route::post('/login', [LoginController::class, 'postLoginAdmin']);
	Route::get('/logout', [LoginController::class, 'logoutAdmin']);
});