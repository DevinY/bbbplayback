/*
npm install --save video.js
npm install --save videojs-contrib-hls
 */
const { mix } = require('laravel-mix');

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
   .scripts([
    'node_modules/video.js/dist/video.min.js',
    'node_modules/videojs-contrib-hls/dist/videojs-contrib-hls.min.js'
    ],'public/js/video.min.js')
   .styles([
    'node_modules/video.js/dist/video-js.min.css'
    ],'public/css/video-js.min.css')
   .copy('node_modules/video.js/dist/video-js.swf','public/js/video-js.swf');
