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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'Auth\LoginController@index');
Route::post('/', 'Auth\LoginController@check')->name('login.check');
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['prefix' => 'finance', 'as', 'finance'], function () {
	Route::get('/home', 'UserController@index');
	Route::get('/cari', 'Finance\ServiceController@index');
	Route::get('/orderan', 'Finance\ServiceController@orderan');
	Route::post('/pelanggan/cari', 'Finance\ServiceController@cari');	
	Route::get('/pelanggan/histori/{id}', 'Finance\ServiceController@ownHistory');
	Route::get('/updateStatus', 'Finance\ServiceController@updateStatus');
	Route::get('/pendapatan', 'Finance\ServiceController@byReport');
	Route::post('/pendapatan/filter', 'Finance\ServiceController@byReportFilter');
	Route::get('/print/{id?}', 'Finance\ServiceController@print');
	Route::get('/print/{id?}', 'Finance\ServiceController@print');
});

Route::group(['prefix' => 'admin', 'as', 'admin'], function () {
	Route::get('/home', 'Admin\DashboardController@index');
	Route::get('/payment', 'Admin\ServiceController@byPayment'); // Menampilkan data berdasarkan metode pembayaran
	Route::get('/orderan', 'Admin\ServiceController@index');
	Route::post('/orderan/filter', 'Admin\ServiceController@orderanFilter');
	Route::get('/pendapatan', 'Admin\ServiceController@byReport');
	Route::post('/pendapatan/filter', 'Admin\ServiceController@byReportFilter');
	Route::post('/payment/filter', 'Admin\ServiceController@byPaymentFilter');
	Route::get('/updateStatus', 'Admin\ServiceController@updateStatus');
});
