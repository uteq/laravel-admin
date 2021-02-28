const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/move.js', 'dist')

    .postCss('stubs/resources/css/app.css', 'stubs/public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .postCss('resources/css/move.css', 'dist', [
        require('postcss-import'),
    ])
    .webpackConfig(require('./stubs/webpack.config'));
