const mix = require('laravel-mix');

const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')

var webpackeConfig = {
    plugins: [
        new VuetifyLoaderPlugin
    ]
}

mix.webpackConfig( webpackeConfig );
 
mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
 