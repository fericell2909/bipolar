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

$(function () {
    $(document).scroll(function () {
        let $transparentHeader = $('.bipolar-header-desktop');
        let $grandHeader = $(".bipolar-grand-header");
        let $grandHeaderAlternate = $('.bipolar-alternate-grand-header');
        let isLongScroll = $(this).scrollTop() > $grandHeader.height();
        let homeIsLongScroll = $(this).scrollTop() > $transparentHeader.height();
        if (isLongScroll === true || homeIsLongScroll === true) {
            $transparentHeader.addClass('hidden');
            $grandHeader.addClass('hidden');
            $grandHeaderAlternate.removeClass('hidden');
        } else {
            $transparentHeader.removeClass('hidden');
            $grandHeader.removeClass('hidden');
            $grandHeaderAlternate.addClass('hidden');
        }
    });
});