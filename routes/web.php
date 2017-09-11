<?php

//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
});

Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::post('register', 'Auth\RegisterController@register')->name('register.post');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('account-management', 'Auth\LoginController@showLoginForm')->name('login-with-register');
Route::middleware('auth')->group(function () {
    Route::get('my-account', 'UserController@profile')->name('profile');
    Route::post('my-account', 'UserController@updateProfile')->name('profile.update');
});
