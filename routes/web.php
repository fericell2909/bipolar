<?php

//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
});

Route::get('account-management', 'Auth\LoginController@showLoginForm')->name('login-with-register');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::post('register', 'Auth\RegisterController@register')->name('register.post');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
