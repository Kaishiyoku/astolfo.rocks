<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Tag;

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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
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
     *
     * @param Tag $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Tag $tag)
    {
        return response()->json($tag);
    }
}
