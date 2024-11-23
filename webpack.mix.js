const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build step
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/gl.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/gl.scss', 'public/css');

/**
 * Datatables
 */
mix.copyDirectory('node_modules/datatables.net', 'public/vendor/');
mix.copyDirectory('node_modules/datatables.net-autofill', 'public/vendor/');
mix.copyDirectory('node_modules/datatables.net-autofill-bs4', 'public/vendor/');
mix.copyDirectory('node_modules/datatables.net-bs4', 'public/vendor/');
mix.copyDirectory('node_modules/datatables.net-buttons', 'public/vendor/');
mix.copyDirectory('node_modules/datatables.net-buttons-bs4', 'public/vendor/');
mix.copyDirectory('node_modules/datatables.net-responsive', 'public/vendor/');
mix.copyDirectory('node_modules/datatables.net-responsive-bs4', 'public/vendor/');
mix.copyDirectory('node_modules/datatables.net-select', 'public/vendor/');
mix.copyDirectory('node_modules/datatables.net-select-bs4', 'public/vendor/');
mix.copy('node_modules/chart.js/dist/chart.js', 'public/vendor/chartjs');
mix.copy('node_modules/chart.js/dist/chart.min.js', 'public/vendor/chartjs');

/**
 * Select2
 */
mix.copyDirectory('node_modules/select2/dist', 'public/vendor/select2/');
mix.copyDirectory('node_modules/select2-bootstrap-5-theme/dist', 'public/vendor/select2-bootstrap-5-theme');

/**
 * Axios
 */
mix.copyDirectory('node_modules/axios/dist', 'public/vendor/axios/');

/**
 * PACE
 */
mix.copyDirectory('node_modules/pace-js', 'public/vendor/pace/');
