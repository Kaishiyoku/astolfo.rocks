<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Tag;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function healthCheck()
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
            ]
        ];

        return response()->json($stats);
    }

    public function version()
    {
        return response()->json(config('app.version'));
    }
}
