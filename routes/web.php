<?php

//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix(LaravelLocalization::setLocale())->group(function () {
    Route::get('account-management/{loginRegister?}', 'Web\Auth\LoginController@showLoginForm')->name('login-with-register');
});

Route::post('login', 'Web\Auth\LoginController@login')->name('login.post');
Route::post('register', 'Web\Auth\RegisterController@register')->name('register.post');
Route::post('logout', 'Web\Auth\LoginController@logout')->name('logout');
Route::post('register/newsletter', 'Web\NewsletterController@register')->name('register.newsletter');

Route::middleware('auth:web')->group(function () {
    Route::get('my-account', 'Web\UserController@profile')->name('profile');
    Route::post('my-account', 'Web\UserController@updateProfile')->name('profile.update');
});

Route::get('bipolar', 'Web\LandingsController@bipolar')->name('landings.bipolar');
Route::get('shipping', 'Web\LandingsController@shipping')->name('landings.shipping');
Route::get('showroom', 'Web\LandingsController@showroom')->name('landings.showroom');

Route::post('ajax/oauth/facebook', 'Web\Auth\LoginController@facebookAuth');

Route::get('language/{language}', function ($language) {
    if ($language !== 'es' && $language !== 'en') {
        return redirect()->back();
    }

    App::setLocale($language);

    return redirect()->route('home');
})->name('change.language');