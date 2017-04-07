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


Route::get('/domain', ['uses' =>'ApiController@update_ip']);
Route::get('/domain/{name}/{token}', ['uses' =>'ApiController@update_ip_url']);
