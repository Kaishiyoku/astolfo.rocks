<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [


    'aliases' => Facade::defaultAliases()->merge([
        'ImageManager' => App\Facades\ImageManagerFacade::class,
        'ImageHash' => App\Facades\ImageHashFacade::class,
    ])->toArray(),

];
