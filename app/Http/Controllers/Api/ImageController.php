<?php

namespace App\Http\Controllers\Api;

use App\Enums\ImageRating;
use App\Http\Controllers\Controller;
use App\Models\Image;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->validateRating($request);

        $images = Image::orderBy('id', 'desc')->with('tags');

        return response()->json($images->get());
    }

    public function indexRating(Request $request, string $rating): JsonResponse
    {
        $this->validateRating($request);

        $images = Image::orderBy('id', 'desc')->with('tags');

        if ($rating) {
            $images = $images->whereRating($rating);
        }

        return response()->json($images->get());
    }

    public function show(Image $image): JsonResponse
    {
        return response()->json($image);
    }

    public function showRandom(Request $request, string $rating = null): JsonResponse
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
