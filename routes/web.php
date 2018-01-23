<?php

Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localize'])
    ->group(function () {
        Route::get('/', 'Web\LandingsController@home')->name('home');
        Route::get('account-management/{loginRegister?}', 'Web\Auth\LoginController@showLoginForm')->name('login-with-register');
        Route::get('/change-currency', 'Web\LandingsController@changeCurrency')->name('change-currency');

        Route::post('login', 'Web\Auth\LoginController@login')->name('login.post');
        Route::post('register', 'Web\Auth\RegisterController@register')->name('register.post');
        Route::post('logout', 'Web\Auth\LoginController@logout')->name('logout');
        Route::post('register/newsletter', 'Web\NewsletterController@register')->name('register.newsletter');

        Route::get('shop', 'Web\ShopController@shop')->name('shop');
        Route::post('shop', 'Web\ShopController@shop')->name('shop.post');
        Route::get('shop/{productSlug}', 'Web\ShopController@product')->name('shop.product');

        Route::get('wishlist/add/{productSlug}', 'Web\WishlistController@add')->name('wishlist.add');
        Route::get('wishlist/remove/{productSlug}', 'Web\WishlistController@remove')->name('wishlist.remove');
        Route::get('wishlist', 'Web\WishlistController@view')->name('wishlist');

        Route::get('bipolar', 'Web\LandingsController@bipolar')->name('landings.bipolar');
        Route::get('shipping', 'Web\LandingsController@shipping')->name('landings.shipping');
        Route::get('showroom', 'Web\LandingsController@showroom')->name('landings.showroom');

        Route::get('cart', 'Web\CartController@cart')->name('cart');
        Route::get('cart/remove/{productSlug}', 'Web\CartController@remove')->name('cart.remove');
        Route::post('cart', 'Web\CartController@update')->name('cart.update');

        Route::middleware('auth:web')->group(function () {
            Route::get('my-account', 'Web\UserController@profile')->name('profile');
            Route::post('my-account', 'Web\UserController@updateProfile')->name('profile.update');
            Route::get('checkout', 'Web\CheckoutController@checkout')->name('checkout');
            Route::post('address/{addressType}/register', 'Web\AddressesController@add')->name('address.add');
            Route::get('ajax/country/{countryId}/country-states', 'Web\Ajax\CountryStatesController@get');
        });
    });

Route::post('ajax/oauth/facebook', 'Web\Auth\LoginController@facebookAuth');
Route::post('ajax/cart/product', 'Web\Ajax\CartController@add');
