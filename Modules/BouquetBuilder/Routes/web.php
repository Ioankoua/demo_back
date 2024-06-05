<?php

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

Route::get('admin/bouquetbuilder/getall', 'Modules\BouquetBuilder\Http\Controllers\BouquetBuilderController@getAllBouquetBuilder');
Route::get('admin/bouquetbuilder/getdata/{bouquet_id}', 'Modules\BouquetBuilder\Http\Controllers\BouquetBuilderController@getBouquet');
Route::post('admin/bouquetbuilder/create', 'Modules\BouquetBuilder\Http\Controllers\BouquetBuilderController@create');
Route::post('admin/bouquetbuilder/safedelete/{bouquet_id}', 'Modules\BouquetBuilder\Http\Controllers\BouquetBuilderController@safeDelete');