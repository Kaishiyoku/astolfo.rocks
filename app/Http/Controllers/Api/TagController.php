<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Tag::cursorPaginate());
    }

    public function show(Tag $tag): JsonResponse
    {
        return response()->json($tag);
    }
}
