<?php

namespace App\Http\Controllers;

use App\Models\Image;

class HomeController extends Controller
{
    public function index()
    {
        $randomImage = Image::whereRating('Safe')->inRandomOrder()->first();

        return view('welcome', compact('randomImage'));
    }
}
