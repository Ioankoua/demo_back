<?php

use Illuminate\Http\Request;

use Modules\CustomerTracker\Http\Controllers\CustomerTracker;

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

Route::post('admin/tracker/save', 'Modules\CustomerTracker\Http\Controllers\CustomerTrackerController@tracked');
Route::post('admin/tracker/uniquevisitor', 'Modules\CustomerTracker\Http\Controllers\CustomerTrackerController@UniqueVisitors');