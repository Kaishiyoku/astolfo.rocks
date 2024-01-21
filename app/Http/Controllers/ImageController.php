<?php

namespace App\Http\Controllers;

use App\Enums\ImageRating;
use App\Models\Image;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use ImageHash;
use Intervention\Image\Constraint;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request, ?string $rating = null): View
    {
        $this->validateRating($request, $rating);

        $images = Image::query()
            ->when($rating, fn ($query) => $query->whereRating($rating))
            ->orderBy('id', 'desc')
            ->paginate();

        $ratingCounts = collect(ImageRating::getValues())
            ->mapWithKeys(fn ($imageRating) => [$imageRating => Image::whereRating($imageRating)->count()]);

        return view('image.index')->with([
            'totalImageCount' => Image::count(),
            'imagesByRatingCounts' => $ratingCounts,
            'images' => $images,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create(): View
    {
        return view('image.create')->with([
            'image' => new Image(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => ['required', new EnumValue(ImageRating::class)],
            'source' => ['nullable', 'string:255'],
            'image' => ['image', 'mimetypes:image/jpeg,image/png,image/gif', 'max:10000'],
        ]);

        $image = $this->saveAndUploadImage($validated, $request->file('image'));

        return redirect()->route('images.show', $image);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(Image $image): View
    {
        return view('image.show')->with([
            'image' => $image,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Image $image): View
    {
        return view('image.edit')->with([
            'image' => $image,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => ['required', new EnumValue(ImageRating::class)],
            'source' => ['nullable', 'string:255'],
            'image' => ['nullable', 'image', 'mimetypes:image/jpeg,image/png,image/gif', 'max:10000'],
        ]);

        if ($request->hasFile('image')) {
            $savedImage = $this->saveAndUploadImage($validated, $request->file('image'), $image);

            // remove possible duplicates when a new image has been uploaded
            PossibleDuplicateController::deletePossibleDuplicatesForImage($savedImage);
        } else {
            $image->update($validated);
            $savedImage = $image;
        }

        return redirect()->route('images.show', $savedImage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image): RedirectResponse
    {
        PossibleDuplicateController::deletePossibleDuplicatesForImage($image);
        static::deleteImage($image);

        return redirect()->route('images.index');
    }

    private function validateRating(Request $request, ?string $rating = null)
    {
        $request->merge(['rating' => $rating]);
        $request->validate([
            'rating' => ['nullable', new EnumValue(ImageRating::class)],
        ]);
    }

    private function saveAndUploadImage($validated, UploadedFile $imageFile, ?Image $image = null)
    {
        $fileExtension = $imageFile->getClientOriginalExtension();
        [$width, $height] = getimagesize($imageFile->getRealPath());

        $image = Image::updateOrCreate(['id' => $image?->id],
            array_merge($validated, [
                'file_extension' => $fileExtension,
                'mimetype' => $imageFile->getMimeType(),
                'file_size' => $imageFile->getSize(),
                'width' => $width,
                'height' => $height,
            ]));

        $imageFile->storeAs('astolfo', "{$image->id}.{$fileExtension}");

        $image->identifier = ImageHash::hash($image->getImageFilePath());
        $image->save();

        static::saveThumbnail($image);

        return $image;
    }

    public static function saveThumbnail(Image $image)
    {
        $thumbnail = $image->getImageFromStorage()
            ->resize(config('astolfo.thumbnail_max_width'), null, function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->psrResponse('jpg', config('visual_kei.thumbnail_quality'));

        Storage::disk('astolfo')->put("thumbnails/{$image->id}.jpg", $thumbnail->getBody()->getContents());
    }

    public static function deleteImage(Image $image)
    {
        PossibleDuplicateController::deletePossibleDuplicatesForImage($image);

        $image->tags()->detach();

        Storage::disk('astolfo')->delete($image->getFileName());
        Storage::disk('astolfo')->delete("thumbnails/{$image->getThumbnailFileName()}");

        $image->delete();
    }
}
