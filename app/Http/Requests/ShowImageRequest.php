<?php

namespace App\Http\Requests;

use App\Enums\ImageRating;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class ShowImageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            /**
             * The rating of the image.
             * Available values: `unknown`, `safe`, `questionable`, `explicit`
             *
             * @var string|null
             *
             * @example safe
             */
            'rating' => ['nullable', new EnumValue(ImageRating::class)],
        ];
    }
}
