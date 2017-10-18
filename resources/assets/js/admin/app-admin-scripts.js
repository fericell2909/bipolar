window.$ = window.jQuery = require('jquery');

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.$.ajaxSetup({
        headers: {'X-CSRF-TOKEN': token.content}
    });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Plugins
window.Popper = require('popper.js').default;
require('bootstrap/dist/js/bootstrap.min');
require('./plugins/bootstrap-extension.min');
require('jquery-slimscroll');
require('./plugins/sidebar-nav.min');
require('./plugins/waves');
require('./plugins/theme-scripts');
require('./plugins/jscolor.min');
require('./settings-scripts');
