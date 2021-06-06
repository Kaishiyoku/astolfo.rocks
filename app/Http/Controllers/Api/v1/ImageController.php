<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * @param string|null $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($rating = null)
    {
        $images = Image::orderBy('external_id', 'desc')->with('tags');

        if ($rating) {
            $images = $images->whereRating($rating);
        }

        return response()->json($images->get());
    }

    /**
     * @param Image $image
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Image $image)
    {
        return response()->json($image);
    }

    /**
     * @param string|null $rating
     * @retun \Illuminate\Http\JsonResponse
     */
    public function showRandom($rating = null)
    {
        $availableRatings = collect(explode(',', config('astolfo.available_ratings')))->map(function ($rating) {
            return strtolower($rating);
        })->toArray();

        if (!empty($rating) && !in_array(strtolower($rating), $availableRatings)) {
            return response('The given rating is invalid.', 422);
        }

        if ($rating) {
            $image = Image::whereRating($rating)->inRandomOrder()->first();
        } else {
            $image = Image::inRandomOrder()->first();
        }

        return response()->json($image);
    }
}
