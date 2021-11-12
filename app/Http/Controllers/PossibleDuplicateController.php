<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\PossibleDuplicate;

class PossibleDuplicateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('possible_duplicate.index', [
            'totalImageCount' => Image::count(),
            'possibleDuplicates' => PossibleDuplicate::where('is_false_positive', false)->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PossibleDuplicate  $possibleDuplicate
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(PossibleDuplicate $possibleDuplicate)
    {
        return view('possible_duplicate.show', [
            'possibleDuplicate' => $possibleDuplicate,
        ]);
    }

    public function ignore(PossibleDuplicate $possibleDuplicate)
    {
        $possibleDuplicate->is_false_positive = true;

        $possibleDuplicate->save();

        return redirect()->route('possible_duplicates.index');
    }

    public function keepImage(PossibleDuplicate $possibleDuplicate, Image $image)
    {
        $imageToBeDeleted = $possibleDuplicate->image_id_left === $image->id ? $possibleDuplicate->imageRight : $possibleDuplicate->imageLeft;

        deletePossibleDuplicatesForImage($imageToBeDeleted);
        deleteImage($imageToBeDeleted);

        return redirect()->route('possible_duplicates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PossibleDuplicate  $possibleDuplicate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PossibleDuplicate $possibleDuplicate)
    {
        $possibleDuplicate->delete();

        return redirect()->route('possible_duplicates.index');
    }
}
