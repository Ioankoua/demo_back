<?php

use Modules\AuthAdmin\Http\Controllers\AuthAdminController;

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

Route::post('admin/auth', 'Modules\AuthAdmin\Http\Controllers\AuthAdminController@AuthAdmin');
