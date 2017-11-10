<?php
// Prefix: ajax-admin
Route::get('products/search', 'Admin\Ajax\ProductController@search');
Route::get('products/{productHashId}/recommendeds', 'Admin\Ajax\ProductController@recommendeds');
Route::post('products/{productHashId}/recommendeds/{recommendedHashId}', 'Admin\Ajax\ProductController@recommend');
Route::delete('products/{productHashId}/recommendeds/{recommendedHashId}', 'Admin\Ajax\ProductController@removeRecommend');