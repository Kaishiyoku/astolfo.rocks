<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ImageHashFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return 'image_hash';
    }
}
