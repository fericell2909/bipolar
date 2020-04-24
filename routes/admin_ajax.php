<?php
// Prefix: ajax-admin, Middleware auth:admin
Route::delete('sizes/{sizeId}', 'Admin\SettingsController@deleteSize');
Route::delete('colors/{colorId}', 'Admin\ColorController@delete');
Route::delete('types/{typeId}', 'Admin\TypesController@delete');
Route::delete('photo/{photoId}', 'Admin\ProductController@deletePhoto');
Route::delete('subtypes/{subtypeId}', 'Admin\TypesController@subtype_delete');
Route::get('colors', 'Admin\Ajax\ColorController@index');
Route::get('sizes', 'Admin\Ajax\SizeController@index');
Route::get('types', 'Admin\Ajax\TypeController@index');
Route::get('subtypes', 'Admin\Ajax\TypeController@subtypes');
Route::get('states', 'Admin\Ajax\StateController@index');
Route::get('search/products', 'Admin\Ajax\ProductController@search');

Route::prefix('bsale')->group(function () {
    Route::get('products', 'Admin\BsaleController@products');
});

Route::prefix('products')->group(function () {
    Route::get('/', 'Admin\Ajax\ProductController@get');
    Route::post('/', 'Admin\Ajax\ProductController@store');
    Route::get('{productHashId}', 'Admin\Ajax\ProductController@show');
    Route::put('{productHashId}', 'Admin\Ajax\ProductController@update');
    Route::get('{productHashId}/recommendeds', 'Admin\Ajax\ProductController@recommendeds');
    Route::post('{productHashId}/recommendeds/{recommendedHashId}', 'Admin\Ajax\ProductController@recommend');
    Route::delete('{productHashId}/recommendeds/{recommendedHashId}', 'Admin\Ajax\ProductController@removeRecommend');
    Route::post('{productHashId}/discount', 'Admin\Ajax\ProductController@updateDiscount');
    Route::post('order', 'Admin\Ajax\ProductController@orderProductsAndSave');
    Route::post('{productHashId}/photo/upload', 'Admin\Ajax\PhotoController@productUpload')->name('products.photo.upload');
    Route::post('photos/order', 'Admin\Ajax\PhotoController@orderPhotos');
    Route::delete('remove/{productId}', 'Admin\Ajax\ProductController@deletesoft');
    Route::get('{productHashId}/stocks', 'Admin\Ajax\ProductController@stocks');
    Route::post('publishdate', 'Admin\Ajax\ProductController@publishUpdate');
});

Route::post('stocks/{stockId}', 'Admin\Ajax\ProductController@updateStock');

Route::prefix('home-posts')->group(function () {
    Route::post('order', 'Admin\Ajax\HomePostController@order');
    Route::post('{hashId}/photos', 'Admin\Ajax\PhotoController@homePostUpload')->name('homepost.photo.upload');
    Route::post('photos/order', 'Admin\Ajax\PhotoController@orderPhotos');
    Route::delete('{homePostId}', 'Admin\Ajax\HomePostController@destroy');
});

Route::prefix('post')->group(function () {
    Route::post('new', 'Admin\Ajax\PostController@store');
    Route::post('{postId}/photos', 'Admin\Ajax\PhotoController@postUpload')->name('post.photo.upload');
    Route::get('{postId}/show', 'Admin\Ajax\PostController@show');
    Route::put('{postId}/update', 'Admin\Ajax\PostController@update');
    Route::post('photos/order', 'Admin\Ajax\PostController@order');
    Route::delete('{postId}/delete', 'Admin\Ajax\PostController@remove');
});

Route::get('categories', 'Admin\Ajax\CategoryController@index');
Route::post('categories', 'Admin\Ajax\CategoryController@store');

Route::post('historics/order', 'Admin\Ajax\HistoricsController@order');

Route::post('banners/order', 'Admin\Ajax\BannersController@order');
Route::delete('banners/{banner}', 'Admin\Ajax\BannersController@destroy');

Route::post('buys/{buyId}/sent', 'Admin\Ajax\BuysController@sent');

Route::get('coupons/{coupon}', 'Admin\Ajax\CouponsController@show');
Route::post('coupons/{coupon}/types-subtypes', 'Admin\Ajax\CouponsController@saveTypesAndSubtypes');
Route::delete('coupons/{coupon}', 'Admin\Ajax\CouponsController@destroy');

Route::get('labels', 'Admin\Ajax\LabelController@index');

Route::get('tags', 'Admin\Ajax\TagsController@index');
Route::post('tags', 'Admin\Ajax\TagsController@store');

Route::post('pages', 'Admin\Ajax\PageController@store');
Route::get('pages/{pageId}', 'Admin\Ajax\PageController@show');
Route::put('pages/{pageId}', 'Admin\Ajax\PageController@update');

Route::delete('image/{imageId}', 'Admin\ImagesController@delete');

Route::prefix('discount-tasks')->group(function () {
    Route::get('/{hashId}/edit', 'Admin\Ajax\DiscountController@edit');
    Route::post('/{hashId}/execute', 'Admin\Ajax\DiscountController@execute');
    Route::post('/{hashId}/revert', 'Admin\Ajax\DiscountController@revert');
    Route::put('/{hashId}', 'Admin\Ajax\DiscountController@update');
    Route::delete('/{hashId}', 'Admin\Ajax\DiscountController@destroy');
});
