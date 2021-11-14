<?php

namespace App\Http\Controllers;

use App\Enums\ImageRating;
use App\Models\Image;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null $rating
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request, $rating = null)
    {
        $this->validateRating($request, $rating);

        $images = Image::query()
            ->when($rating, fn($query) => $query->whereRating($rating))
            ->orderBy('id', 'desc')
            ->paginate();

        return view('image.index', [
            'totalImageCount' => Image::count(),
            'images' => $images,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(Image $image)
    {
        return view('image.show', [
            'image' => $image,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Image $image)
    {
        deletePossibleDuplicatesForImage($image);
        deleteImage($image);

        return redirect()->route('images.index');
    }

    private function validateRating(Request $request, string $rating = null)
    {
        $request->merge(['rating' => $rating]);
        $request->validate([
            'rating' => ['nullable', new EnumValue(ImageRating::class)],
        ]);
    }
}
