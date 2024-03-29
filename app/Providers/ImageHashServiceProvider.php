<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\DifferenceHash;

class ImageHashServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('image_hash', function ($app) {
            return new ImageHash(new DifferenceHash(config('astolfo.duplicate_checker_size')));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
