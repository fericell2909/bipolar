let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/admin/app-admin-scripts.js', 'public/js')
    .js('resources/assets/js/web/app-web-scripts.js', 'public/js')
    .sass('resources/assets/sass/admin/app-admin-styles.scss', 'public/css')
    .sass('resources/assets/sass/web/app-web-styles.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}

mix.browserSync('bipolar.dev');