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

Route::get('/', 'Auth\LoginController@index')->name('login');
Route::post('/', 'Auth\LoginController@check')->name('login.check');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/bypass', 'AuthController@bypass')->name('bypass');

Route::group(['middleware' => 'auth', 'prefix' => 'finance'], function () {
	Route::get('/home', 'UserController@index');
	Route::get('/cari', 'Finance\ServiceController@index');
	Route::get('/orderan', 'Finance\ServiceController@orderan')->name('orderan');
	Route::post('/pelanggan/cari', 'Finance\ServiceController@cari');	
	Route::get('/pelanggan/histori/{id}', 'Finance\ServiceController@ownHistory');
	Route::get('/updateStatus', 'Finance\ServiceController@updateStatus');
	Route::get('/Hidrolik/{id}', 'Finance\ServiceController@pilihHidrolik')->name('pilih.hidrolik');
	Route::post('/hidrolikUpdate/{id}', 'Finance\ServiceController@hidrolikUpdate')->name('update.hidrolik');
	Route::get('/pendapatan', 'Finance\ServiceController@byReport');
	Route::post('/pendapatan/filter', 'Finance\ServiceController@byReportFilter');
	Route::get('/print/{id?}', 'Finance\ServiceController@print');
	Route::get('/print/{id?}', 'Finance\ServiceController@print');	

	Route::get('/laporan', 'Finance\LaporanController@index')->name('laporan');
	Route::get('/laporanBulanan', 'Finance\LaporanController@bulanan')->name('lap.bul');

	Route::get('viewProses1', 'Finance\ViewProsesController@index');
	Route::get('viewProses2', 'Finance\ViewProsesController@viewProses2');
	Route::get('viewProses3', 'Finance\ViewProsesController@viewProses3');
	Route::get('viewProses4', 'Finance\ViewProsesController@viewProses4');
	
});

// struk dan kwitansi
Route::get('send/struk/{id}', 'Finance\ServiceController@genStrukOrder');
// Route::get('send/kwitansi/{id}', 'Finance\ServiceController@genKwitansi');
Route::get('send/kwitansi/{id}', 'Finance\ServiceController@genKwitansi2');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
	Route::get('/home', 'Admin\DashboardController@index');
	Route::get('/payment', 'Admin\ServiceController@byPayment'); // Menampilkan data berdasarkan metode pembayaran
	Route::get('/orderan', 'Admin\ServiceController@index');
	Route::post('/orderan/filter', 'Admin\ServiceController@orderanFilter');
	Route::get('/pendapatan', 'Admin\ServiceController@byReport');
	Route::post('/pendapatan/filter', 'Admin\ServiceController@byReportFilter');
	Route::post('/payment/filter', 'Admin\ServiceController@byPaymentFilter');
	Route::get('/updateStatus', 'Admin\ServiceController@updateStatus');
});
