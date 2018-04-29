try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap-sass');
} catch (e) {}

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.$.ajaxSetup({
        headers: {'X-CSRF-TOKEN': token.content}
    });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.$('#logoutLink').click(event => {
    event.preventDefault();
    window.$.post('/logout', {}).done(() => location.reload());
});

$('.cart-white-mobile').click(function () {
    const $cartMobile = $('.cart-inside-mobile');
    if ($cartMobile.css('visibility') === 'hidden') {
        $cartMobile.css('visibility', 'visible');
    } else if ($cartMobile.css('visibility') === 'visible') {
        $cartMobile.css('visibility', 'hidden');
    }
});

$('.bipolar-shopping-cart-content').click(function () {
    const $cart = $('.cart-inside');
    if ($cart.css('visibility') === 'hidden') {
        $cart.css('visibility', 'visible');
    } else if ($cart.css('visibility') === 'visible') {
        $cart.css('visibility', 'hidden');
    }
});

// This is for my account menu
$('.navbar-right-text').click(function () {
    $('.bipolar-dropdown-menu.in-desktop').toggle();
});
$('.text-heading-account').click(function () {
  $('.bipolar-dropdown-menu.in-mobile').toggle();
});

require('owl.carousel/dist/owl.carousel');
require('./theme-scripts');
require('./shop-scripts');
require('./product-scripts');
require('./select2-scripts');
require('./checkout-scripts');
require('./click-outside-handler');
//require('./react/app-react-scripts');