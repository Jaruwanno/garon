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

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');

// MAIN STYLE
mix.sass('resources/assets/sass/frontend/main_style.scss', '../../css/frontend')
   .sass('resources/assets/sass/frontend/news/news_show.scss', '../../css/frontend/news');


// NEWS STYLE
// mix.sass('resources/assets/sass/frontend/news/news_show.scss', '../../css/frontend/news');
