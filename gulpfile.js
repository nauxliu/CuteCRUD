var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss', 'public/build/css/app.css')
        .scripts([
            //jQuery
            'jquery.js',

            //Bootstrap
            'bootstrap/affix.js',
            'bootstrap/alert.js',
            'bootstrap/button.js',
            'bootstrap/carousel.js',
            'bootstrap/collapse.js',
            'bootstrap/dropdown.js',
            'bootstrap/modal.js',
            'bootstrap/scrollspy.js',
            'bootstrap/tab.js',
            'bootstrap/transition.js',
            'bootstrap/tooltip.js',
            'bootstrap/popover.js'
        ], 'public/build/js/app.js', 'resources/assets/js')
});
