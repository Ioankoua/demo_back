<?php

use Modules\CustomerTracker\Http\Controllers\CustomerTracker;

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

Route::post('admin/tracker/save', 'Modules\CustomerTracker\Http\Controllers\CustomerTrackerController@tracked');
Route::post('admin/tracker/uniquevisitor', 'Modules\CustomerTracker\Http\Controllers\CustomerTrackerController@UniqueVisitors');