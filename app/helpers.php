<?php

use App\Enums\ImageRating;
use Carbon\Carbon;
use Illuminate\Support\Str;

if (! function_exists('toString')) {
    function toString($value)
    {
        if (is_array($value)) {
            return implode(', ', $value);
        }

        return $value;
    }
}

if (! function_exists('getSocialMediaLinks')) {
    function getSocialMediaLinks()
    {
        $str = config('astolfo.social_media_links');

        $data = empty($str) ? collect() : collect(explode(';', $str))->map(function ($item) {
            $itemData = explode(',', $item);

            return [
                'title' => $itemData[0],
                'url' => $itemData[1],
            ];
        });

        return $data->toArray();
    }
}

if (! function_exists('formatFileSize')) {
    function formatFileSize(int $fileSize): string
    {
        return ByteFormatter::format($fileSize);
    }
}

if (! function_exists('formatDateTime')) {
    function formatDateTime(?Carbon $date): string
    {
        return optional($date, fn (Carbon $date) => $date->format(__('date.datetime')));
    }
}

if (! function_exists('getAvailableImageRatingOptions')) {
    function getAvailableImageRatingOptions(): array
    {
        return collect(ImageRating::getValues())->mapWithKeys(fn ($rating) => [$rating => __(Str::ucfirst($rating))])->toArray();
    }
}
