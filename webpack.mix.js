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

mix.styles([
    'resources/librerias/css/trix.css'
],'public/css/librerias.css')
.scripts([
    'resources/librerias/js/trix.js',
    'resources/librerias/js/sweetalert2.all.js'
],'public/js/librerias.js')
.js('resources/js/app.js', 'public/js')
.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery']
})
.sass('resources/sass/app.scss', 'public/css');
