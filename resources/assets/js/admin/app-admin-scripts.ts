const windowObject: any = window;

try {
  windowObject.$ = windowObject.jQuery = require('jquery');
  windowObject.Popper = require('popper.js').default;
  require('bootstrap');
  windowObject.moment = require('moment');
} catch (e) {}

let token = document.head.querySelector('meta[name="csrf-token"]') as any;

if (token) {
  windowObject.$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': token.content },
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
require('./coupon-scripts');
