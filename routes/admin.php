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

    Route::prefix('products')->group(function () {
        Route::get('/', 'Admin\ProductController@index')->name('products.index');
        Route::get('new', 'Admin\ProductController@create')->name('products.create');
        Route::get('{productId}/edit', 'Admin\ProductController@edit')->name('products.edit');
        Route::get('{slug}/photos', 'Admin\ProductController@photos')->name('products.photos');
        Route::post('{productHashId}/photo/upload', 'Admin\ProductController@uploadPhoto')->name('products.photo.upload');
        Route::get('photos/{slug}/order', 'Admin\ProductController@seePhotos')->name('products.photos.order');
        Route::post('photos/order', 'Admin\ProductController@orderAndSavePosition');
        Route::get('{slug}/recommended', 'Admin\ProductController@recommended')->name('products.recommended');
        Route::get('trashed', 'Admin\ProductController@trashed')->name('products.trashed');
        Route::post('{productHashId}/hard-delete', 'Admin\ProductController@deletehard')->name('products.harddelete');
    });

    Route::prefix('settings')->group(function () {
        Route::get('general', 'Admin\SettingsController@general')->name('settings.general');
        Route::post('general', 'Admin\SettingsController@saveGeneral');
        // Sizes
        Route::get('sizes', 'Admin\SettingsController@seeSizes')->name('settings.sizes');
        Route::post('sizes', 'Admin\SettingsController@saveSize')->name('settings.sizes.save');
        Route::get('sizes/{sizeHashId}', 'Admin\SettingsController@showSize')->name('settings.sizes.show');
        Route::post('sizes/{sizeHashId}', 'Admin\SettingsController@updateSize')->name('settings.sizes.update');
        // Colors
        Route::get('colors', 'Admin\ColorController@index')->name('settings.colors');
        Route::post('colors', 'Admin\ColorController@create')->name('settings.colors.save');
        Route::get('colors/{colorHashid}', 'Admin\ColorController@show')->name('settings.colors.show');
        Route::post('colors/{colorHashid}', 'Admin\ColorController@update');
        // Types
        Route::get('types', 'Admin\TypesController@index')->name('settings.types');
        Route::post('types', 'Admin\TypesController@store');
        Route::get('types/{typeHashId}', 'Admin\TypesController@edit')->name('settings.types.edit');
        Route::post('types/{typeHashId}', 'Admin\TypesController@update');
        Route::get('types/{typeHashId}/subtypes', 'Admin\TypesController@subtypes')->name('settings.types.subtypes');
        // Subtypes
        Route::get('subtypes/{subtypeHashId}', 'Admin\SubtypeController@edit')->name('settings.subtypes.edit');
        Route::post('subtypes/{subtypeHashId}', 'Admin\SubtypeController@update');
    });
});
