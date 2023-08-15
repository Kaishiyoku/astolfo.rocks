<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ScriptFUSION\Byte\ByteFormatter;

class ByteFormatterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('byte_formatter', function ($app) {
            return new ByteFormatter();
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
