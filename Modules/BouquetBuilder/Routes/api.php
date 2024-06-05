<?php

use Illuminate\Http\Request;

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

Route::get('admin/bouquetbuilder/getall', 'Modules\BouquetBuilder\Http\Controllers\BouquetBuilderController@getAllBouquetBuilder');
Route::get('admin/bouquetbuilder/getdata/{bouquet_id}', 'Modules\BouquetBuilder\Http\Controllers\BouquetBuilderController@getBouquet');
Route::post('admin/bouquetbuilder/create', 'Modules\BouquetBuilder\Http\Controllers\BouquetBuilderController@create');
Route::post('admin/bouquetbuilder/safedelete/{bouquet_id}', 'Modules\BouquetBuilder\Http\Controllers\BouquetBuilderController@safeDelete');