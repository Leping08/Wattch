const mix = require('laravel-mix');

require('laravel-mix-tailwind');
require('laravel-mix-purgecss');

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

mix.js('resources/js/app.js', 'public/js')
    .copyDirectory('resources/fonts', 'public/fonts')
    .postCss('resources/css/app.css', 'public/css')
    .copy('node_modules/@mdi/font/css/materialdesignicons.css', 'public/icons/css/')
    .copyDirectory('node_modules/@mdi/font/fonts/', 'public/icons/fonts/')
    .tailwind('./tailwind.config.js')
    .purgeCss();

if (mix.inProduction()) {
    mix.version();
}
