<?php

namespace App\Http\Controllers;

use App\Enums\ImageRating;
use App\Models\Image;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('welcome')->with([
            'randomImage' => Image::whereRating(ImageRating::Safe())->inRandomOrder()->first(),
        ]);
    }
}
