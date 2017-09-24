<?php

Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('login.admin');
Route::post('login', 'Admin\Auth\LoginController@login')->name('login.admin.post');

Route::middleware('auth:admin')->group(function() {
    Route::get('/', function () {
        return view('admin.home');
    })->name('admin.dashboard');

    Route::prefix('users')->group(function () {
        Route::get('/', 'Admin\UserController@index')->name('users.index');
        Route::get('/search', 'Admin\UserController@search')->name('users.search');
        Route::get('/edit/{userId}', 'Admin\UserController@edit')->name('user.edit');
        Route::post('/edit/{userId}', 'Admin\UserController@update');
        Route::get('download', 'Admin\UserController@download')->name('users.download');
    });
});
