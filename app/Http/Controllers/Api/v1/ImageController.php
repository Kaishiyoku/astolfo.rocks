<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\ImageRating;
use App\Http\Controllers\Controller;
use App\Models\Image;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\Request;

/**
 * @group Image
 */
class ImageController extends Controller
{
    /**
     * @response [
     *  {
     *      "id": 4246,
     *      "rating": "safe",
     *      "created_at": "2021-12-06T08:30:38.000000Z",
     *      "updated_at": "2021-12-06T08:30:38.000000Z",
     *      "views": 0,
     *      "source": "https://www.pixiv.net/en/artworks/86487950",
     *      "file_extension": "jpeg",
     *      "mimetype": "image/jpeg",
     *      "file_size": 421671,
     *      "width": 1414,
     *      "height": 2000,
     *      "tags": []
     *  }
     * ]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->validateRating($request);

        $images = Image::orderBy('id', 'desc')->with('tags');

        return response()->json($images->get());
    }

    /**
     * @urlParam rating string ```unknown, safe, questionable, explicit```. Example: safe
     *
     * @response [
     *  {
     *      "id": 4246,
     *      "rating": "safe",
     *      "created_at": "2021-12-06T08:30:38.000000Z",
     *      "updated_at": "2021-12-06T08:30:38.000000Z",
     *      "views": 0,
     *      "source": "https://www.pixiv.net/en/artworks/86487950",
     *      "file_extension": "jpeg",
     *      "mimetype": "image/jpeg",
     *      "file_size": 421671,
     *      "width": 1414,
     *      "height": 2000,
     *      "tags": []
     *  }
     * ]
     *
     * @param  string  $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexRating(Request $request, $rating)
    {
        $this->validateRating($request);

        $images = Image::orderBy('id', 'desc')->with('tags');

        if ($rating) {
            $images = $images->whereRating($rating);
        }

        return response()->json($images->get());
    }

    /**
     * @urlParam id integer required The ID of the image. Example: 4246
     *
     * @response {
     *      "id": 4246,
     *      "rating": "safe",
     *      "created_at": "2021-12-06T08:30:38.000000Z",
     *      "updated_at": "2021-12-06T08:30:38.000000Z",
     *      "views": 0,
     *      "source": "https://www.pixiv.net/en/artworks/86487950",
     *      "file_extension": "jpeg",
     *      "mimetype": "image/jpeg",
     *      "file_size": 421671,
     *      "width": 1414,
     *      "height": 2000,
     *      "tags": []
     *  }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Image $image)
    {
        return response()->json($image);
    }

    /**
     * @urlParam rating string required ```unknown, safe, questionable, explicit```. Example: safe
     *
     * @response {
     *      "id": 4246,
     *      "rating": "safe",
     *      "created_at": "2021-12-06T08:30:38.000000Z",
     *      "updated_at": "2021-12-06T08:30:38.000000Z",
     *      "views": 0,
     *      "source": "https://www.pixiv.net/en/artworks/86487950",
     *      "file_extension": "jpeg",
     *      "mimetype": "image/jpeg",
     *      "file_size": 421671,
     *      "width": 1414,
     *      "height": 2000,
     *      "tags": []
     *  }
     *
     * @param  string|null  $rating
     *
     * @retun \Illuminate\Http\JsonResponse
     */
    public function showRandom(Request $request, $rating = null)
    {
        $this->validateRating($request);

        $image = Image::query();

        if ($rating) {
            $image = $image->whereRating($rating);
        }

        $image = $image->inRandomOrder()->first();

        return response()->json($image);
    }

    private function validateRating(Request $request)
    {
        $request->merge(['rating' => $request->route('rating')]);
        $request->validate([
            'rating' => ['nullable', new EnumValue(ImageRating::class)],
        ]);
    }
}
