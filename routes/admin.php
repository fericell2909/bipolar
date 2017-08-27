<?php

Route::get('/', function () {
    return view('admin.home');
});
Route::get('/login', function () {
    return view('admin.login');
});

Route::prefix('users')->group(function () {
    Route::get('/', 'UserController@index')->name('users.index');
    Route::get('/search', 'UserController@search')->name('users.search');
});