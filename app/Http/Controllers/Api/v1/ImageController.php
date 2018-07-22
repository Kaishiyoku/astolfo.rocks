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
}
