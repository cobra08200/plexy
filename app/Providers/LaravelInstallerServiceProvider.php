<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelInstallerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishFiles();

        include __DIR__ . '/../Http/routes.php';
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        app('router')->middleware('canInstall', '\App\Http\Middleware\canInstall');
        app('router')->middleware('canUpgrade', '\App\Http\Middleware\canUpgrade');
    }

    /**
     * Publish config file for the installer.
     *
     * @return void
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__.'/../config/installer.php' => base_path('config/installer.php'),
        ]);

        $this->publishes([
            __DIR__.'/../assets' => public_path('installer'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/installer'),
        ]);

        $this->publishes([
            __DIR__.'/../lang' => base_path('resources/lang'),
        ]);
    }
}
