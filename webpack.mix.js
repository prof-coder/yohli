const mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
const purgeCss = require("laravel-mix-purgecss");

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
   .js('resources/js/websocket.js', 'public/js')
   .sass('resources/sass/style.scss', 'public/css')
   .sass('resources/sass/app.scss', 'public/css')
   .options({
         processCssUrls: false,
         postCss: [ tailwindcss('./tailwind.js') ],
      }).purgeCss({
         defaultExtractor: content => content.match(/[\w-/.:]+(?<!:)/g) || []
   });

    
