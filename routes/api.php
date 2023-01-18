<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth:api'], function(){
  Route::post('details', 'AuthController@details'); 
  Route::get('home', 'Api\ServiceController@index'); // semua histori orderan
  Route::post('add', 'Api\ServiceController@addOrderan');
  Route::get('history/today', 'Api\ServiceController@todayHistory'); // semua histori orderan hari ini
  Route::get('history/customer', 'Api\ServiceController@customerHistory'); // semua histori orderan berdasarkan pelanggan
  Route::post('find', 'Api\ServiceController@findingCustomer');


  Route::get('v2/history/today', 'Api\ServiceController@v2TodayHistory'); // semua histori orderan hari ini
  Route::post('ubahStatus/{id}', 'Api\ServiceController@UbahStatus');


  // upload foto
  Route::post('images', 'Api\ServiceController@uploadImage2');
  Route::delete('images', 'Api\ServiceController@deleteImage');
  Route::post('images_contoh', 'Api\ServiceController@uploadImage1');

// Hanya untuk tes
  Route::post('tes', 'TestController@todayHistory');
});
