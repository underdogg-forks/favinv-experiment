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
   .sass('resources/assets/sass/app.scss', 'public/css')
   // CoreUI 2.16 custom build with CSS variables
   .sass('resources/assets/coreui/coreui-custom.scss', 'public/css/coreui')
   .options({
     processCssUrls: false
   })
   // Copy CoreUI JavaScript files
   .copy('node_modules/@coreui/coreui/dist/js/coreui.min.js', 'public/js/coreui/coreui.min.js')
   .copy('node_modules/@coreui/coreui/dist/js/coreui-utilities.min.js', 'public/js/coreui/coreui-utilities.min.js')
   // Copy Perfect Scrollbar for better sidebar scrolling
   .copy('node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js', 'public/js/coreui/perfect-scrollbar.min.js')
   .copy('node_modules/perfect-scrollbar/css/perfect-scrollbar.css', 'public/css/coreui/perfect-scrollbar.css')
   .version();
