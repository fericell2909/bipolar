<?php
// Prefix: ajax-admin, Middleware auth:admin
Route::delete('sizes/{sizeId}', 'Admin\SettingsController@deleteSize');
Route::delete('colors/{colorId}', 'Admin\ColorController@delete');
Route::delete('types/{sizeId}', 'Admin\TypesController@delete');
Route::delete('photo/{photoId}', 'Admin\ProductController@deletePhoto');
Route::get('colors', 'Admin\Ajax\ColorController@index');
Route::get('sizes', 'Admin\Ajax\SizeController@index');
Route::get('types', 'Admin\Ajax\TypeController@index');
Route::get('states', 'Admin\Ajax\StateController@index');
Route::get('search/products', 'Admin\Ajax\ProductController@search');

Route::prefix('products')->group(function () {
    Route::get('/', 'Admin\Ajax\ProductController@get');
    Route::post('/', 'Admin\Ajax\ProductController@store');
    Route::get('{productHashId}', 'Admin\Ajax\ProductController@show');
    Route::put('{productHashId}', 'Admin\Ajax\ProductController@update');
    Route::get('{productHashId}/recommendeds', 'Admin\Ajax\ProductController@recommendeds');
    Route::post('{productHashId}/recommendeds/{recommendedHashId}', 'Admin\Ajax\ProductController@recommend');
    Route::delete('{productHashId}/recommendeds/{recommendedHashId}', 'Admin\Ajax\ProductController@removeRecommend');
    Route::post('state/{action}', 'Admin\Ajax\ProductController@stateToggle');
    Route::post('freeshipping/{activate}', 'Admin\Ajax\ProductController@freeShippingToggle');
    Route::post('salient/{activate}', 'Admin\Ajax\ProductController@salientToggle');
    Route::post('dolar-price', 'Admin\Ajax\ProductController@changeDolarPrice');
    Route::post('order', 'Admin\Ajax\ProductController@orderProductsAndSave');
    Route::post('{productHashId}/photo/upload', 'Admin\Ajax\PhotoController@productUpload')->name('products.photo.upload');
    Route::post('photos/order', 'Admin\Ajax\PhotoController@orderPhotos');
    Route::delete('products/{productId}', 'Admin\Ajax\ProductController@deletesoft');
});

Route::prefix('home-posts')->group(function () {
    Route::post('order', 'Admin\Ajax\HomePostController@order');
    Route::post('{hashId}/photos', 'Admin\Ajax\PhotoController@homePostUpload')->name('homepost.photo.upload');
    Route::post('photos/order', 'Admin\Ajax\PhotoController@orderPhotos');
});
