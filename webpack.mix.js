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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/cs')
    .less('resources/assets/less/app.less', 'public/css')
        .copy('node_modules/tinymce/themes', 'public/js/themes')
        .copy('node_modules/tinymce/plugins', 'public/js/plugins')
        .copy('node_modules/tinymce/skins', 'public/js/skins')
        .copy('node_modules/tinymce-i18n/langs', 'public/js/langs');
