<?php

namespace App\Http\Controllers;

use App\Enums\ImageRating;
use App\Models\Image;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        Http::get('url')->json();

        $randomImage = Image::whereRating(ImageRating::Safe())->inRandomOrder()->first();

        return view('welcome', compact('randomImage'));
    }
}
