const mix = require('laravel-mix');

mix.setPublicPath('public')
    .sass('resources/css/app.scss', 'vendor/css')
    .js('resources/js/app.js', 'vendor/js')
    .extract(['axios', 'jquery', 'bootstrap', 'alertifyjs', 'jquery-autocomplete', 'chart.js', 'bootstrap-tagsinput', 'bootstrap-select', 'lightbox2', 'owl.carousel', 'trix']);
