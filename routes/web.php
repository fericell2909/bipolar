<?php

//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
});

Route::post('login', 'Web\Auth\LoginController@login')->name('login.post');
Route::post('register', 'Web\Auth\RegisterController@register')->name('register.post');
Route::post('logout', 'Web\Auth\LoginController@logout')->name('logout');
Route::get('account-management', 'Web\Auth\LoginController@showLoginForm')->name('login-with-register');
Route::middleware('auth')->group(function () {
    Route::get('my-account', 'Web\UserController@profile')->name('profile');
    Route::post('my-account', 'Web\UserController@updateProfile')->name('profile.update');
});
