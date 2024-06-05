<?php

use Illuminate\Http\Request;

use Modules\AuthAdmin\Http\Controllers\AuthAdminController;

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

Route::post('admin/auth', 'Modules\AuthAdmin\Http\Controllers\AuthAdminController@AuthAdmin');