<?php

use Illuminate\Http\Request;
use Modules\Order\Http\Controllers\OrderController;

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

Route::get('admin/order/getall', 'Modules\Order\Http\Controllers\OrderController@getAllOrders');
Route::get('admin/order/getdata/{order_id}', 'Modules\Order\Http\Controllers\OrderController@getOrder');
Route::post('admin/order/create', 'Modules\Order\Http\Controllers\OrderController@create');
Route::post('admin/order/safedelete/{order_id}', 'Modules\Order\Http\Controllers\OrderController@safeDelete');
Route::post('admin/order/update/{order_id}', 'Modules\Order\Http\Controllers\OrderController@update');