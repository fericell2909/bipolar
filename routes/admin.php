<?php

Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('login.admin');
Route::post('login', 'Admin\Auth\LoginController@login')->name('login.admin.post');
Route::post('logout', 'Admin\Auth\LoginController@logout');

Route::middleware('auth:admin')->group(function () {
    Route::view('/graphql', 'admin.graphql');
    Route::get('/', 'Admin\DashboardController@dashboard')->name('admin.dashboard');
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.logs');
    Route::get('activity-logs', 'Admin\LogController@index')->name('admin.activity_log');

    Route::prefix('buys')->group(function () {
        Route::get('/', 'Admin\BuysController@index')->name('buys.index');
        Route::get('{buyId}/edit', 'Admin\BuysController@edit')->name('buys.edit');
        Route::post('{buyId}/edit', 'Admin\BuysController@update');
        Route::get("{buyId}/resend-email", 'Admin\BuysController@resendMail')->name('buys.resend-email');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', 'Admin\UserController@index')->name('users.index');
        Route::get('/search', 'Admin\UserController@search')->name('users.search');
        Route::get('/edit/{userId}', 'Admin\UserController@edit')->name('user.edit');
        Route::post('/edit/{userId}', 'Admin\UserController@update');
        Route::get('download', 'Admin\UserController@download')->name('users.download');
        Route::get('/with-carts', 'Admin\UserController@withCartFilled')->name('users.with-carts');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', 'Admin\ProductController@index')->name('products.index');
        Route::get('new', 'Admin\ProductController@create')->name('products.create');
        Route::get('order', 'Admin\ProductController@order')->name('products.order');
        Route::get('{productId}/edit', 'Admin\ProductController@edit')->name('products.edit');
        Route::get('{productSlug}/preview', 'Admin\ProductController@preview')->name('products.preview');
        Route::get('{slug}/photos', 'Admin\ProductController@photos')->name('products.photos');
        Route::get('photos/{slug}/order', 'Admin\ProductController@seePhotos')->name('products.photos.order');
        Route::get('{slug}/calculate-size', 'Admin\ProductController@sizeCalculation')->name('products.calculate');
        Route::post('{slug}/calculate-size', 'Admin\ProductController@sizeCalculationStore');
        Route::get('{slug}/recommended', 'Admin\ProductController@recommended')->name('products.recommended');
        Route::get('trashed', 'Admin\ProductController@trashed')->name('products.trashed');
        Route::post('{productHashId}/hard-delete', 'Admin\ProductController@deletehard')->name('products.harddelete');
        Route::get('{productHashId}/restore', 'Admin\ProductController@restore')->name('products.restore');
        Route::get('{product}/stocks', 'Admin\ProductController@stock')->name('products.stock');
        Route::post('stocks/{stock}/quantity', 'Admin\ProductController@stockSave')->name('products.stock.save');
        Route::get('{slug}/discount', 'Admin\ProductController@discount')->name('products.discount');
        Route::view('multiple-discounts', 'admin.products.multiple_discounts')->name('products.multiple-discounts');
        Route::get('multiple-discounts/edit/{hashId}', 'Admin\ProductController@multipleDiscountEdit')->name('products.multiple-discounts.edit');
        Route::get('massive', 'Admin\ProductController@massive')->name('products.massive-publication');
        Route::view('multiple-2x1', 'admin.products.multiple_2x1')->name('products.multiple-2x1');

        Route::view('text-conditions', 'admin.products.text_conditions')->name('products.text-conditions');

        Route::get('text-conditions/edit/{hashId}', 'Admin\ProductController@textConditiontEdit')->name ('products.text-conditions.edit');

        Route::view('premium-links', 'admin.products.premium_links')->name('products.premium-links');

        Route::get('premium-links/edit/{hashId}', 'Admin\ProductController@premiumLinkEdit')->name ('products.premium-links.edit');


    });

    Route::prefix('home-posts')->group(function () {
        Route::get('/', 'Admin\HomePostController@index')->name('homepost.index');
        Route::get('new', 'Admin\HomePostController@create')->name('homepost.create');
        Route::post('new', 'Admin\HomePostController@store');
        Route::get('order', 'Admin\HomePostController@order')->name('homepost.order');
        Route::get('{slug}/photos', 'Admin\HomePostController@photoUpload')->name('homepost.photos');
        Route::get('{slug}/photos/order', 'Admin\HomePostController@orderPhotos')->name('homepost.photos.order');
        Route::get('edit/{slug}', 'Admin\HomePostController@show')->name('homepost.edit');
        Route::post('edit/{slug}', 'Admin\HomePostController@update');
        Route::get('type/new', 'Admin\HomePostController@showTypes')->name('homepost.types');
        Route::post('type/new', 'Admin\HomePostController@storeType');
        Route::get('type/edit/{postType}', 'Admin\HomePostController@editType')->name('homepost.types.edit');
        Route::post('type/edit/{postType}', 'Admin\HomePostController@updateType');
    });

    Route::prefix('blog')->group(function () {
        Route::get('/', 'Admin\BlogController@index')->name('blog.index');
        Route::get('new', 'Admin\BlogController@create')->name('blog.create');
        Route::get('/edit/{postId}', 'Admin\BlogController@edit')->name('blog.edit');
        Route::get('/edit/{postId}/videos', 'Admin\BlogController@video')->name('blog.video');
        Route::post('/edit/{postId}/videos', 'Admin\BlogController@saveVideo');
        Route::get('/edit/{postId}/videos-remove', 'Admin\BlogController@removeVideo')->name('blog.video.remove');
        Route::get('edit/{postId}/photos', 'Admin\BlogController@photos')->name('blog.photos');
        Route::get('edit/{postId}/photos-order', 'Admin\BlogController@order')->name('blog.photos.order');
    });

    Route::prefix('banners')->group(function () {
        Route::get('/', 'Admin\BannersController@index')->name('banners.index');
        Route::get('new', 'Admin\BannersController@create')->name('banners.create');
        Route::post('new', 'Admin\BannersController@store');
        Route::get('/{banner}/edit', 'Admin\BannersController@edit')->name('banners.edit');
        Route::post('/{banner}/edit', 'Admin\BannersController@update');
        Route::get('order', 'Admin\BannersController@order')->name('banners.order');
        Route::get('/{banner}/preview', 'Admin\BannersController@preview')->name('banners.preview');
    });

    Route::prefix('banners-colors')->group(function () {
        Route::get('/', 'Admin\BannerColorController@index')->name('banners_colors.index');
        Route::get('new', 'Admin\BannerColorController@create')->name('banners_colors.create');
        Route::post('new', 'Admin\BannerColorController@store');
        Route::get('/{banner}/edit', 'Admin\BannerColorController@edit')->name('banners_colors.edit');
        Route::post('/{banner}/edit', 'Admin\BannerColorController@update');
        Route::get('/{banner}/text', 'Admin\BannerColorController@setText')->name('banners_colors.set_text');
        Route::get('order', 'Admin\BannerColorController@order')->name('banners_colors.order');
//        Route::get('/{banner}/preview', 'Admin\BannersController@preview')->name('banners.preview');
    });

    Route::prefix('pages')->group(function () {
        Route::get('/', 'Admin\PageController@index')->name('page_admin.index');
        Route::get('new', 'Admin\PageController@create')->name('page_admin.create');
        Route::get('{pageId}/image', 'Admin\PageController@image')->name('page_admin.image');
        Route::post('{pageId}/image', 'Admin\PageController@imageUpload');
        Route::get('{pageId}/edit', 'Admin\PageController@edit')->name('page_admin.edit');
    });

    Route::prefix('coupons')->group(function () {
        Route::get('/', 'Admin\CouponController@index')->name('coupons.index');
        Route::get('/new', 'Admin\CouponController@create')->name('coupons.create');
        Route::post('/new', 'Admin\CouponController@store');
        Route::get('/associate/{coupon}', 'Admin\CouponController@associate')->name('coupons.associate');
        Route::get('/edit/{coupon}', 'Admin\CouponController@edit')->name('coupon.edit');
        Route::post('/edit/{coupon}', 'Admin\CouponController@update');
    });

    Route::prefix('historics')->group(function () {
        Route::get('/', 'Admin\HistoricsController@index')->name('historics.index');
        Route::get('new', 'Admin\HistoricsController@create')->name('historics.create');
        Route::post('new', 'Admin\HistoricsController@store');
        Route::get('{historicId}/edit', 'Admin\HistoricsController@edit')->name('historics.edit');
        Route::post('{historicId}/edit', 'Admin\HistoricsController@update');
        Route::get('order', 'Admin\HistoricsController@order')->name('historics.order');
        Route::get('trashed', 'Admin\HistoricsController@trashed')->name('historics.trashed');
        Route::get('{historicId}/trash', 'Admin\HistoricsController@trash')->name('historics.trash');
        Route::get('{historicId}/restore', 'Admin\HistoricsController@restore')->name('historics.restore');
        Route::get('{historicId}/destroy', 'Admin\HistoricsController@destroy')->name('historics.destroy');
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
        // Labels
        Route::get('labels', 'Admin\LabelController@index')->name('settings.labels.index');
        Route::post('labels', 'Admin\LabelController@store');
        Route::get('labels/{labelId}', 'Admin\LabelController@edit')->name('settings.labels.edit');
        Route::post('labels/{labelId}', 'Admin\LabelController@update');
        // Types
        Route::get('types', 'Admin\TypesController@index')->name('settings.types');
        Route::post('types', 'Admin\TypesController@store');
        Route::get('types/{typeHashId}', 'Admin\TypesController@edit')->name('settings.types.edit');
        Route::post('types/{typeHashId}', 'Admin\TypesController@update');
        Route::get('types/{typeHashId}/subtypes', 'Admin\TypesController@subtypes')->name('settings.types.subtypes');
        Route::post('types/{typeHashId}/subtypes', 'Admin\SubtypeController@create');
        // Subtypes
        Route::get('subtypes/{subtypeHashId}', 'Admin\SubtypeController@edit')->name('settings.subtypes.edit');
        Route::post('subtypes/{subtypeHashId}', 'Admin\SubtypeController@update');
        // Shipping
        Route::get('shipping', 'Admin\ShippingController@index')->name('settings.shipping.index');
        Route::get('shipping/new', 'Admin\ShippingController@create')->name('settings.shipping.new');
        Route::post('shipping/new', 'Admin\ShippingController@store');
        Route::get('shipping/{shippingId}', 'Admin\ShippingController@edit')->name('settings.shipping.edit');
        Route::post('shipping/{shippingId}', 'Admin\ShippingController@update');
        Route::get('shipping/{shippingId}/prices', 'Admin\ShippingController@editPriceShipping')->name('settings.shipping.edit.price');
        Route::post('shipping/{shippingId}/prices', 'Admin\ShippingController@updatePriceShipping');
        Route::get('shipping/{shippingId}/activate/{indicator}', 'Admin\ShippingController@activate')->name('settings.shipping.activate');
        // Passwords
        Route::view('password', 'admin.settings.password')->name('settings.passwords');
        Route::post('password', 'Admin\SettingsController@changePassword');
        // 2x1
        Route::get('2x1/{value}', 'Admin\SettingsController@toggleDeals2x1')->name('settings.2x1');
    });

    Route::prefix('backgrounds')->name('backgrounds.')->group(function () {
        Route::get('/', 'Admin\ImagesController@index')->name('all');
        Route::view('create', 'admin.images.create')->name('create');
        Route::post('create', 'Admin\ImagesController@store');
        Route::get('edit/{imageId}', 'Admin\ImagesController@edit')->name('edit');
        Route::post('edit/{imageId}', 'Admin\ImagesController@update');
    });
});
