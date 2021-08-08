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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('product', 'ProductController');

Route::resource('prepaid-balance', 'BalanceController');

Route::post('/payment-store', 'PaymentController@store')->name('payment.store');
Route::get('/success', 'PaymentController@successView')->name('success.view');
Route::post('/payment', 'PaymentController@order')->name('payment.order');
Route::get('/order', 'PaymentController@indexOrder')->name('order-history');
