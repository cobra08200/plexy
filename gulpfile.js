// Load Laravel elixir
var elixir = require('laravel-elixir'),
    config = {
        'sass_watch_dir': 'resources/assets/stylesheets/**',
        'js_watch_dir': 'resources/assets/js/**'
    };

// Load elixir busting, this append a new elixir task called "busting"
require('elixir-busting');

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
        '../stylesheets/**'
    ]);

    mix.scripts([
        'app.js'
    ]);

    // Instead used a mix.version() task, use a mix.busting() task
    mix.busting([
       // replace css files path with yours
       '/css/app.css',

       // replace script files path with yours
       '/js/all.js'
   ]);
});


/**
 |--------------------------------------------------------------------------
 | Elixir Custom Configuration
 |--------------------------------------------------------------------------
 */

elixir.Task.find('sass').watch(config.sass_watch_dir);
elixir.Task.find('scripts').watch(config.js_watch_dir);
