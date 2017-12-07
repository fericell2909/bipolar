<?php
// Prefix: ajax-admin, Middleware auth:admin
Route::delete('sizes/{sizeId}', 'Admin\SettingsController@deleteSize');
Route::delete('colors/{colorId}', 'Admin\ColorController@delete');
Route::delete('types/{sizeId}', 'Admin\TypesController@delete');
Route::delete('photo/{photoId}', 'Admin\ProductController@deletePhoto');
Route::delete('products/{productId}', 'Admin\Ajax\ProductController@deletesoft');
Route::get('colors', 'Admin\Ajax\ColorController@index');
Route::get('sizes', 'Admin\Ajax\SizeController@index');
Route::get('types', 'Admin\Ajax\TypeController@index');
Route::get('states', 'Admin\Ajax\StateController@index');
Route::get('products', 'Admin\Ajax\ProductController@get');
Route::post('products', 'Admin\Ajax\ProductController@store');
Route::get('products/{productHashId}', 'Admin\Ajax\ProductController@show');
Route::put('products/{productHashId}', 'Admin\Ajax\ProductController@update');
Route::get('search/products', 'Admin\Ajax\ProductController@search');
Route::get('products/{productHashId}/recommendeds', 'Admin\Ajax\ProductController@recommendeds');
Route::post('products/{productHashId}/recommendeds/{recommendedHashId}', 'Admin\Ajax\ProductController@recommend');
Route::delete('products/{productHashId}/recommendeds/{recommendedHashId}', 'Admin\Ajax\ProductController@removeRecommend');
Route::post('products/state/{action}', 'Admin\Ajax\ProductController@stateToggle');
Route::post('products/freeshipping/{activate}', 'Admin\Ajax\ProductController@freeShippingToggle');
Route::post('products/salient/{activate}', 'Admin\Ajax\ProductController@salientToggle');
Route::post('products/dolar-price', 'Admin\Ajax\ProductController@changeDolarPrice');