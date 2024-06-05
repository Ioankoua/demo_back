<?php

use Modules\Order\Http\Controllers\OrderController;

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

Route::get('admin/order/getall', 'Modules\Order\Http\Controllers\OrderController@getAllOrders');
Route::get('admin/order/getdata/{order_id}', 'Modules\Order\Http\Controllers\OrderController@getOrder');
Route::post('admin/order/create', 'Modules\Order\Http\Controllers\OrderController@create');
Route::post('admin/order/safedelete/{order_id}', 'Modules\Order\Http\Controllers\OrderController@safeDelete');
Route::post('admin/order/update/{order_id}', 'Modules\Order\Http\Controllers\OrderController@update');
