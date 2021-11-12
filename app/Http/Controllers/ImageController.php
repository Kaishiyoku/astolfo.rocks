<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\PossibleDuplicate;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('image.index', [
            'images' => Image::orderBy('id', 'desc')->paginate(),
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
}
