try {
  window.$ = window.jQuery = require('jquery');
  window.Popper = require('popper.js').default;
  require('bootstrap');
  window.moment = require('moment');
} catch (e) {
}

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': token.content}
  });
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Plugins
require('dropzone');
require('tempusdominus-bootstrap-4');
require('./plugins/perfect-scrollbar.jquery.min');
require('./plugins/sidebarmenu');
require('./plugins/waves');
require('./plugins/theme-scripts');
require('./plugins/jscolor.min');
require('./common-scripts');
require('./settings-scripts');
require('./order-scripts');
require('./banner-scripts');
require('./buys-scripts');
