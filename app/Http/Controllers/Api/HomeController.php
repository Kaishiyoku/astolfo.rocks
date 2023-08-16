<?php

namespace App\Http\Controllers\Api;

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
        $statsPerRating = collect(explode(',', config('astolfo.available_ratings')))->flatMap(function ($rating) {
            $ratingLowerCase = strtolower($rating);

            return [
                $ratingLowerCase => Image::whereRating($rating)->count(),
            ];
        })->toArray();

        $stats = [
            'images' => array_merge([
                'total' => Image::count(),
            ], $statsPerRating),
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
