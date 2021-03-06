const mix = require('laravel-mix');


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

mix.setPublicPath('public/build')
    .setResourceRoot('build')
    .js('resources/assets/js/app.js', 'js')
    .js('resources/assets/js/front.js', 'js')
    .js('resources/assets/js/homefront.js', 'js')
    .copy('node_modules/font-awesome/fonts', 'public/build/fonts/vendor/font-awesome')
    .sass('resources/assets/sass/app.scss', 'css')
    .version();