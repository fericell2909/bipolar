import Popper from 'popper.js/dist/umd/popper';

try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = Popper;
    require('bootstrap');
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