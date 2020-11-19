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

mix.js('resources/js/app.js', 'public/js')
    .copyDirectory('node_modules/tinymce/skins', 'public/tinymce/skins')
    .js('resources/js/admin/resourses/*', 'public/js/admin/resourses')
    .sass('resources/sass/app.scss', 'public/css')

    // Assembly for site
    .sass('resources/sass/site/app.scss', 'public/css/site')
    .options({
        processCssUrls: false
    })
    .js('resources/js/site/app.js', 'public/js/site');


mix.autoload({
    jquery: ['$', 'window.jQuery', "jQuery", "window.$", "jquery", "window.jquery"]
});