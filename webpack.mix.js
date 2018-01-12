let mix = require('laravel-mix');

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    'popper.js/dist/umd/popper.js': ['Popper']
})
    .react('resources/assets/js/admin/react/bipolar-admin-app.js', 'public/js')
    .js('resources/assets/js/admin/app-admin-scripts.js', 'public/js')
    .js('resources/assets/js/web/app-web-scripts.js', 'public/js')
    .sass('resources/assets/sass/admin/app-admin-styles.scss', 'public/css')
    .sass('resources/assets/sass/web/app-web-styles.scss', 'public/css')
    .copyDirectory('resources/assets/img', 'public/images')
    //todo: remover esto cuando se pase a produccion
    .version();

if (mix.inProduction()) {
    mix.version();
}

mix.browserSync({
    proxy: 'bipolar.wtf',
    open: false,
});