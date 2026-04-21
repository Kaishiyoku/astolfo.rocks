<?php

return [

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'astolfo' => [
            'driver' => 'local',
            'root' => storage_path('app/astolfo'),
            'url' => env('APP_URL').'/astolfo',
            'visibility' => 'public',
        ],
    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('astolfo') => storage_path('app/astolfo'),
    ],

];
