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

// Auth::routes();
Route::get('error',function() {
    return view('error');
});
Route::group(['middleware'=>'cPanel'],function() {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    // Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    // Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('/settings', 'UserController@ShowSettingsForm')->name('settings');
    Route::post('/settings', 'UserController@SubmitSettingsForm')->name('settings.submit');
    Route::post('/settings/theme', 'UserController@SubmitSettingsTheme')->name('settings.theme');
    Route::get('/new',['uses'=> 'WebController@index'])->middleware('auth');
    Route::post('/new',['uses'=> 'WebController@new'])->middleware('auth');
    Route::get('/', 'WebController@domains')->middleware('auth');
    Route::get('/home', 'WebController@domains')->middleware('auth');
    // Route::get('/domains', 'WebController@domains')->middleware('auth');
    Route::get('/delete/{id}', 'WebController@delete')->middleware('auth');
    Route::get('/toggle/{id}', 'WebController@toggle')->middleware('auth');
    Route::get('/edit/{id}', 'WebController@load_edit')->middleware('auth');
    Route::post('/edit/{id}', 'WebController@manual_update')->middleware('auth');
});
