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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('image.create', [
            'image' => new Image(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => ['required', new EnumValue(ImageRating::class)],
            'source' => ['nullable', 'string:255'],
            'image' => ['image', 'mimetypes:image/jpeg,image/png,image/gif', 'max:10000'],
        ]);

        $imageFile = $request->file('image');
        $fileExtension = $imageFile->getClientOriginalExtension();
        [$width, $height] = getimagesize($imageFile->getRealPath());

        $image = Image::create(array_merge($validated, [
            'file_extension' => $fileExtension,
            'mimetype' => $imageFile->getMimeType(),
            'file_size' => $imageFile->getSize(),
            'width' => $width,
            'height' => $height,
        ]));

        $request->file('image')->storeAs('astolfo', "{$image->id}.{$fileExtension}");

        $imgFing = imgFing();

        $imageData = getImageDataFromStorage($image);
        $image->identifier = $imgFing->identifyString($imageData);
        $image->identifier_image = $imgFing->createIdentityImageFromString($imageData);
        $image->save();

        return redirect()->route('images.show', $image);
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Image $image)
    {
        return view('image.edit', [
            'image' => $image,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Image $image)
    {
        $validated = $request->validate([
            'rating' => ['required', new EnumValue(ImageRating::class)],
            'source' => ['nullable', 'string:255'],
        ]);

        $image->fill($validated);
        $image->save();

        return redirect()->route('images.show', $image);
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
