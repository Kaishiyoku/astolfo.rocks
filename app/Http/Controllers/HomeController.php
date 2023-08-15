<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Enums\ImageRating;
use App\Models\Image;

class HomeController extends Controller
{
    public function index(): View
    {
        $randomImage = Image::whereRating(ImageRating::Safe())->inRandomOrder()->first();

        return view('welcome', compact('randomImage'));
    }
}
