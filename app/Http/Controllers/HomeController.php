<?php

namespace App\Http\Controllers;

use App\Enums\ImageRating;
use App\Models\Image;

class HomeController extends Controller
{
    public function index()
    {
        $randomImage = Image::whereRating(ImageRating::Safe())->inRandomOrder()->first();

        return view('welcome', compact('randomImage'));
    }
}
