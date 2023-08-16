<?php

namespace App\Http\Controllers\Api;

use App\Enums\ImageRating;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function healthCheck(): JsonResponse
    {
        return response()->json();
    }

    public function stats()
    {
        $statsPerRating = collect(ImageRating::getValues())->mapWithKeys(fn ($rating) => [
            strtolower($rating) => Image::whereRating($rating)->count(),
        ]);

        $stats = [
            'images' => collect(['total' => Image::count()])->merge($statsPerRating),
            'tags' => [
                'total' => Tag::count(),
            ],
        ];

        return response()->json($stats);
    }

    public function version(): JsonResponse
    {
        return response()->json(config('app.version'));
    }
}
