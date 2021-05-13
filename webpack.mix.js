const mix = require('laravel-mix');
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

mix
    //.copyDirectory('node_modules/tinymce/skins', 'public/tinymce/skins')
    //.js('resources/js/admin/resourses/*', 'public/js/admin/resourses')

    // Assembly for site
    .sass('resources/sass/site/app.scss', 'public/css/site')
    .options({
        processCssUrls: false
    })

    .js('resources/js/site/app.js', 'public/js/site')
    //.js('resources/js/site/page/checkout.js', 'public/js/site/page')

    .version();

mix.autoload({
    jquery: ['$', 'window.jQuery', "jQuery", "window.$", "jquery", "window.jquery"]
});
