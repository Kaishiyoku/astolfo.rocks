<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\ImageRating;
use App\Http\Controllers\Controller;
use App\Models\Image;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param string|null $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, string $rating = null)
    {
        $this->validateRating($request);

        $images = Image::orderBy('id', 'desc')->with('tags');

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
     * @param \Illuminate\Http\Request $request
     * @param string|null $rating
     * @retun \Illuminate\Http\JsonResponse
     */
    public function showRandom(Request $request, $rating = null)
    {
        $this->validateRating($request);

        $image = Image::query();

        if ($rating) {
            $image = $image->whereRating($rating);
        }

        $image = $image->inRandomOrder()->first();

        return response()->json($image);
    }

    private function validateRating(Request $request)
    {
        $request->merge(['rating' => $request->route('rating')]);
        $request->validate([
            'rating' => ['nullable', new EnumValue(ImageRating::class)],
        ]);
    }
}
