try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap-sass');
    require('./animate-css');
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

// Delete buy
$('.bipolar-delete-buy').click(function () {
    const confirmation = confirm($(this).data('confirmation'));
    if (!confirmation) {
        return false;
    }
    const buyHashId = $(this).data('buyHashId');
    $.post(`/ajax/buy/${buyHashId}/delete`).done(response => {
        if (response['success']) {
            return location.reload();
        }
    });
});

$('#archive-selector').change(function () {
    $('#form-archive-selector').submit();
});

require('owl.carousel/dist/owl.carousel');
require('./theme-scripts');
require('./shop-scripts');
require('./product-scripts');
require('./select2-scripts');
require('./checkout-scripts');
require('./click-outside-handler');
require('./hover-animation-script');
//require('./react/app-react-scripts');