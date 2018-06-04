<?php

Route::get('/preview-mail', function () {
    $buy = \App\Models\Buy::find(40);

    return new \App\Mail\BuyConfirmation($buy);
});
Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localize', 'removeEmptyCarts'])
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

        Route::get('bipolar', 'Web\LandingsController@bipolar')->name('landings.bipolar');
        Route::get('shipping', 'Web\LandingsController@shipping')->name('landings.shipping');
        Route::view('exchange-and-returns', 'web.landings.exchange_returns')->name('landings.exchange');
        Route::get('showroom', 'Web\LandingsController@showroom')->name('landings.showroom');
        Route::get('historico', 'Web\LandingsController@historico')->name('landings.historico');
        Route::view('newsletter', 'web.landings.newsletter_landing')->name('landings.newsletter');
        Route::get('contacto', 'Web\LandingsController@contact')->name('landings.contacto');
        Route::post('contacto', 'Web\LandingsController@contactProcess');

        Route::get('cart', 'Web\CartController@cart')->name('cart');
        Route::get('cart/remove/{productSlug}', 'Web\CartController@remove')->name('cart.remove');
        Route::post('cart', 'Web\CartController@update')->name('cart.update');

        Route::middleware('auth:web')->group(function () {
            Route::get('my-account/buys', 'Web\UserController@myaccount')->name('myaccount');
            Route::get('my-account/edit-account', 'Web\UserController@profile')->name('profile');
            Route::post('my-account/edit-account', 'Web\UserController@updateProfile')->name('profile.update');
            Route::get('checkout', 'Web\CheckoutController@checkout')->name('checkout');
            Route::post('checkout', 'Web\CheckoutController@buy');
            Route::post('address/{addressType}/register', 'Web\AddressesController@add')->name('address.add');
            Route::get('confirmation/{buyId}', 'Web\PaymeController@pagoPayme')->name('confirmation');
            Route::post('confirmation-payment', 'Web\PaymeController@reconfirmationPost')->name('confirmation.successful');
            Route::get('confirmation-payment/{buyId?}', 'Web\PaymeController@confirmation')->name('reconfirmation');
            Route::get('ajax/country/{countryId}/country-states', 'Web\Ajax\CountryStatesController@get');
            Route::post('ajax/address/{addressId}/main', 'Web\Ajax\AddressesController@setMain');
            Route::delete('ajax/address/{addressId}', 'Web\Ajax\AddressesController@remove');
        });
    });

Route::post('ajax/oauth/facebook', 'Web\Auth\LoginController@facebookAuth');
Route::post('ajax/cart/product', 'Web\Ajax\CartController@add');
Route::post('ajax/wishlist/add/{productHashId}', 'Web\Ajax\WishlistController@add');
Route::post('ajax/coupon', 'Web\Ajax\CouponController@add');
Route::post('ajax/coupon-remove', 'Web\Ajax\CouponController@remove');
