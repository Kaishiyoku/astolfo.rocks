<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ImgFing\ImgFing;

class ImgFingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('img_fing', function ($app) {
            return new ImgFing([
                'bitSize' => 3000,
                'avgColorAdjust' => 50,
                'cropFit' => false,
                'adapters' => [
                    'GD',
                ],
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
