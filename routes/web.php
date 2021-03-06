<?php

Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localize', 'location.detect'])
    ->group(function () {
        Route::get('/', 'Web\LandingsController@home')->name('home');
        Route::get('account-management/{loginRegister?}', 'Web\Auth\LoginController@showLoginForm')->name('login-with-register');
        Route::get('/change-currency', 'Web\LandingsController@changeCurrency')->name('change-currency');

        Route::post('login', 'Web\Auth\LoginController@login')->name('login.post');
        Route::post('register', 'Web\Auth\RegisterController@register')->name('register.post');
        Route::post('logout', 'Web\Auth\LoginController@logout')->name('logout');
        Route::post('register/newsletter', 'Web\NewsletterController@register')->name('register.newsletter');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');

        Route::get('shop', 'Web\ShopController@shop')->name('shop');
        Route::post('shop', 'Web\ShopController@shop')->name('shop.post');
        Route::get('shop/{productSlug}', 'Web\ShopController@product')->name('shop.product');

        Route::get('wishlist/remove/{productSlug}', 'Web\WishlistController@remove')->name('wishlist.remove');
        Route::get('wishlist', 'Web\WishlistController@view')->name('wishlist');

        // Keep this routes as references at least 1 year. Implemented Jan 1, 2019
        Route::permanentRedirect('bipolar', 'info/bipolar');
        Route::permanentRedirect('shipping', 'info/shipping');
        Route::permanentRedirect('exchange-and-returns', 'info/exchange-and-return');
        Route::permanentRedirect('care-tips', 'info/care_tips');
        Route::permanentRedirect('showroom', 'info/showroom');
        Route::get('historico', 'Web\LandingsController@historico')->name('landings.historico');
        Route::get('newsletter', 'Web\LandingsController@newsletter')->name('landings.newsletter');
        Route::get('blog', 'Web\LandingsController@blog')->name('landings.blog');
        Route::get('blog/{postSlug}', 'Web\LandingsController@seeBlogPost')->name('landings.blog.post');
        Route::get('contacto', 'Web\LandingsController@contact')->name('landings.contacto');
        Route::post('contacto', 'Web\LandingsController@contactProcess');

        Route::get('cart', 'Web\CartController@cart')->name('cart');
        Route::get('cart/remove/{detailHashId}', 'Web\CartController@remove')->name('cart.remove');
        Route::post('cart', 'Web\CartController@update')->name('cart.update');

        Route::middleware('auth:web')->group(function () {
            Route::middleware('checkStockAvailability')->group(function () {
                Route::get('checkout', 'Web\CheckoutController@checkout')->name('checkout');
                Route::post('checkout', 'Web\CheckoutController@buy');
            });
            Route::get('my-account/buys', 'Web\UserController@myaccount')->name('myaccount');
            Route::get('my-account/edit-account', 'Web\UserController@profile')->name('profile');
            Route::post('my-account/edit-account', 'Web\UserController@updateProfile')->name('profile.update');
            Route::post('address/{addressType}/register', 'Web\AddressesController@add')->name('address.add');
            Route::get('confirmation/{buyId}', 'Web\PaymeController@pagoPayme')->name('confirmation');
            Route::post('confirmation-payment', 'Web\PaymeController@reconfirmationPost')->name('confirmation.successful');
            Route::get('confirmation-payment/{buyId?}', 'Web\PaymeController@confirmation')->name('reconfirmation');
            Route::get('ajax/country/{countryId}/country-states', 'Web\Ajax\CountryStatesController@get');
            Route::post('ajax/address/{addressId}/main', 'Web\Ajax\AddressesController@setMain');
            Route::delete('ajax/address/{addressId}', 'Web\Ajax\AddressesController@remove');
        });

        Route::get('info/{page}', 'HomeController@page')->name('page');

        Route::get('shop/pl/{uuid}', 'Web\ShopController@shop_premium_link')->name('shop.premium-links');

    });

Route::post('bsale/sync', 'Web\BsaleController@sync');
Route::post('ajax/oauth/facebook', 'Web\Auth\LoginController@facebookAuth');
Route::post('ajax/cart/product', 'Web\Ajax\CartController@add');
Route::post('ajax/wishlist/add/{productHashId}', 'Web\Ajax\WishlistController@add');
Route::post('ajax/coupon', 'Web\Ajax\CouponController@add');
Route::post('ajax/coupon-remove', 'Web\Ajax\CouponController@remove');
Route::post('ajax/buy/{buyHashId}/delete', 'Web\Ajax\CartController@destroy_buy');
Route::post('ajax/calculate-size', 'Web\Ajax\SizeController@calculate');
