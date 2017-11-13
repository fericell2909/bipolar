<?php
// Prefix: ajax-admin, Middleware auth:admin
Route::delete('sizes/{sizeId}', 'Admin\SettingsController@deleteSize');
Route::delete('colors/{colorId}', 'Admin\ColorController@delete');
Route::delete('types/{sizeId}', 'Admin\TypesController@delete');
Route::delete('photo/{photoId}', 'Admin\ProductController@deletePhoto');
Route::delete('products/{productId}', 'Admin\ProductController@delete');
Route::get('products/search', 'Admin\Ajax\ProductController@search');
Route::get('products/{productHashId}/recommendeds', 'Admin\Ajax\ProductController@recommendeds');
Route::post('products/{productHashId}/recommendeds/{recommendedHashId}', 'Admin\Ajax\ProductController@recommend');
Route::delete('products/{productHashId}/recommendeds/{recommendedHashId}', 'Admin\Ajax\ProductController@removeRecommend');