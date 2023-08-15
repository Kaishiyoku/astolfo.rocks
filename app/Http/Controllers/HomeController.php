<?php

namespace App\Http\Controllers;

use App\Enums\ImageRating;
use App\Models\Image;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $randomImage = Image::whereRating(ImageRating::Safe())->inRandomOrder()->first();

        return view('welcome', compact('randomImage'));
    }
}
