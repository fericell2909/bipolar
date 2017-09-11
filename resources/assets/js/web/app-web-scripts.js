window.$ = window.jQuery = require('jquery');

window.Popper = require('popper.js').default;
require('bootstrap');

let token = document.head.querySelector('meta[name="csrf-token"]');

window.$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': token.content}
});

window.$('#logoutLink').click(event => {
    event.preventDefault();
    window.$.post('/logout', {}).done(() => location.reload());
});