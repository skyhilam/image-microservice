<?php

namespace App\Providers;

use App\Cache\RedisCache;
use App\Files\FileStore;
use App\Image\Manipulator;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('image', function ($app) {
            return new Manipulator(new ImageManager);
        });

        $this->app->singleton('rediscache', function ($app) {
            return new RedisCache(app('redis'));
        });

        $this->app->singleton('cloudfile', function($app) {
            return new FileStore($app->loadComponent(
                'filesystems',
                FilesystemServiceProvider::class,
                'filesystem'
            ));
        });
    }
}
