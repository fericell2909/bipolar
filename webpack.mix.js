let mix = require('laravel-mix');

mix
  /* .autoload({
    jquery: ["$", "window.jQuery", "jQuery"],
    "popper.js/dist/umd/popper.js": ["Popper"]
  }) */
  // This is only for the web app
  //.copy('node_modules/jquery/dist/jquery.min.js', 'public/js')
  .ts('resources/assets/js/admin/react/bipolar-admin-app.ts', 'public/js')
  .ts('resources/assets/js/admin/app-admin-scripts.ts', 'public/js')
  .js('resources/assets/js/web/app-web-scripts.js', 'public/js')
  .sass('resources/assets/sass/admin/style.scss', 'public/css/app-admin-styles.css')
  .sass('resources/assets/sass/web/app-web-styles.scss', 'public/css')
  .copy('node_modules/animate.css/animate.min.css', 'public/css')
  .copyDirectory('resources/assets/img', 'public/images');

if (mix.inProduction()) {
  mix.version();
}

mix.browserSync({
  proxy: 'bipolar.test',
  open: false,
});
