<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowImageRequest;
use App\Models\Image;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function index(ShowImageRequest $request): JsonResponse
    {
        return response()->json(Image::query()
            ->when($request->validated('rating'), fn (Builder $query, string $rating) => $query->where('rating', $rating))
            ->orderBy('id', 'desc')
            ->with('tags')
            ->cursorPaginate()
        );
    }

    public function show(Image $image): JsonResponse
    {
        return response()->json($image);
    }

    public function showRandom(ShowImageRequest $request): JsonResponse
    {
        $randomImage = Image::query()
            ->when($request->validated('rating'), fn (Builder $query, string $rating) => $query->where('rating', $rating))
            ->inRandomOrder()
            ->first();

        if (! $randomImage) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return response()->json($randomImage);
    }
}
