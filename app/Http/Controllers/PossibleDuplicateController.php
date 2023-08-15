<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Image;
use App\Models\PossibleDuplicate;

class PossibleDuplicateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(): View
    {
        return view('possible_duplicate.index', [
            'totalImageCount' => Image::count(),
            'possibleDuplicates' => PossibleDuplicate::where('is_false_positive', false)->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(PossibleDuplicate $possibleDuplicate): View
    {
        return view('possible_duplicate.show', [
            'possibleDuplicate' => $possibleDuplicate,
        ]);
    }

    public function ignore(PossibleDuplicate $possibleDuplicate): RedirectResponse
    {
        $possibleDuplicate->is_false_positive = true;

        $possibleDuplicate->save();

        return redirect()->route('possible_duplicates.index');
    }

    public function keepImage(PossibleDuplicate $possibleDuplicate, Image $image): RedirectResponse
    {
        $imageToBeDeleted = $possibleDuplicate->image_id_left === $image->id ? $possibleDuplicate->imageRight : $possibleDuplicate->imageLeft;

        static::deletePossibleDuplicatesForImage($imageToBeDeleted);
        ImageController::deleteImage($imageToBeDeleted);

        return redirect()->route('possible_duplicates.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PossibleDuplicate $possibleDuplicate): RedirectResponse
    {
        $possibleDuplicate->delete();

        return redirect()->route('possible_duplicates.index');
    }

    public static function deletePossibleDuplicatesForImage(Image $image)
    {
        PossibleDuplicate::where('image_id_left', $image->id)->orWhere('image_id_right', $image->id)->delete();
    }
}
