window.$ = window.jQuery = require('jquery');

window.$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': window.Laravel.csrfToken
    }
});

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
