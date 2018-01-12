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

require('owl.carousel/dist/owl.carousel');
require('./theme-scripts');
require('./shop-scripts');
require('./product-scripts');