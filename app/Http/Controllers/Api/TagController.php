<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

/**
 * @group Tag
 */
class TagController extends Controller
{
    /**
     * @response [
     *  {
     *      "id": 512,
     *      "name": "astolfo"
     *  }
     * ]
     */
    public function index(): JsonResponse
    {
        $tags = Tag::all();

        return response()->json($tags);
    }

    /**
     * @urlParam id integer required The ID of the tag. Example: 512
     *
     * @response {
     *      "id": 512,
     *      "name": "astolfo"
     *  }
     */
    public function show(Tag $tag): JsonResponse
    {
        return response()->json($tag);
    }
}
