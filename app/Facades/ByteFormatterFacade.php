<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ByteFormatterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return 'byte_formatter';
    }
}
