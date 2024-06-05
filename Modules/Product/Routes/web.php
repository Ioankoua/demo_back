<?php

use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\CategoryController;

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

Route::get('admin/product/getall', 'Modules\Product\Http\Controllers\ProductController@getAllProducts');
Route::get('admin/product/deleted', 'Modules\Product\Http\Controllers\ProductController@getDeletedProducts');
Route::post('admin/product/create', 'Modules\Product\Http\Controllers\ProductController@create');
Route::get('admin/product/getdata/{product_id}', 'Modules\Product\Http\Controllers\ProductController@getProduct');
Route::post('admin/product/update/{product_id}', 'Modules\Product\Http\Controllers\ProductController@update');
Route::post('admin/product/safedelete/{product_id}', 'Modules\Product\Http\Controllers\ProductController@softDelete');
Route::post('admin/product/delete/{product_id}', 'Modules\Product\Http\Controllers\ProductController@delete');
Route::post('admin/product/activate/{product_id}', 'Modules\Product\Http\Controllers\ProductController@activate');

Route::post('admin/product/category/create', 'Modules\Product\Http\Controllers\CategoryController@create');
Route::get('admin/product/category/getall', 'Modules\Product\Http\Controllers\CategoryController@getAllCategories');
Route::get('admin/product/category/getdata/{category_id}', 'Modules\Product\Http\Controllers\CategoryController@getCategory');
Route::post('admin/product/category/update/{category_id}', 'Modules\Product\Http\Controllers\CategoryController@update');
Route::post('admin/product/category/delete/{category_id}', 'Modules\Product\Http\Controllers\CategoryController@delete');

