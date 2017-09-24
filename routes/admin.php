<?php

Route::get('/', function () {
    return view('admin.home');
});
Route::get('/login', function () {
    return view('admin.login');
});

Route::prefix('users')->group(function () {
    Route::get('/', 'Admin\UserController@index')->name('users.index');
    Route::get('/search', 'Admin\UserController@search')->name('users.search');
    Route::get('/edit/{userId}', 'Admin\UserController@edit')->name('user.edit');
    Route::post('/edit/{userId}', 'Admin\UserController@update');
    Route::get('download', 'Admin\UserController@download')->name('users.download');
});