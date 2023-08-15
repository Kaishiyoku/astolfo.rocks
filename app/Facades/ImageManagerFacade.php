<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ImageManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return 'image_manager';
    }
}
