<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ScriptFUSION\Byte\ByteFormatter;

class ByteFormatterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('byte_formatter', function ($app) {
            return new ByteFormatter();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
