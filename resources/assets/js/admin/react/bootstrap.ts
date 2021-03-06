/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

const windowAdmin: any = window;
windowAdmin.axios = require('axios');
windowAdmin.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let adminToken: any = document.head.querySelector('meta[name="csrf-token"]');

if (adminToken) {
  windowAdmin.axios.defaults.headers.common['X-CSRF-TOKEN'] = adminToken.content;
  windowAdmin.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
