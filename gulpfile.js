var elixir = require('laravel-elixir'),
    CONFIG = {
        'sass_watch_dir': 'resources/assets/stylesheets/**',
        'js_watch_dir': 'resources/assets/js/**'
    };

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */


elixir(function(mix) {
    mix.sass([
        '../stylesheets/app.scss'
    ]);

    mix.scripts([
        'app.js'
    ]);

    mix.version([
        '/css/app.css',
        '/js/all.js'
    ]);
});


/**
 |--------------------------------------------------------------------------
 | Elixir Custom Configuration
 |--------------------------------------------------------------------------
 */

elixir.Task.find('sass').watch(CONFIG.sass_watch_dir);
elixir.Task.find('scripts').watch(CONFIG.js_watch_dir);
