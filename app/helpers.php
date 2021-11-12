<?php

use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use ImgFing\ImgFing;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManager;
use ScriptFUSION\Byte\ByteFormatter;

if (!function_exists('toString')) {
    function toString($value)
    {
        if (is_array($value)) {
            return implode(', ', $value);
        }

        return $value;
    }
}

if (!function_exists('getSocialMediaLinks')) {
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

if (!function_exists('getImageFromStorage')) {
    function getImageFromStorage(Image $image): ?\Intervention\Image\Image
    {
        if (!$image->mimetype) {
            return null;
        }

        try {
            return getImageManager()->make(Storage::disk('local')->path($image->getFilePath()));
        } catch (NotReadableException $e) {
            return null;
        }
    }
}

if (!function_exists('getImageDataFromStorage')) {
    function getImageDataFromStorage(Image $image): ?string
    {
        return optional(getImageFromStorage($image), function ($data) {
            return $data->psrResponse()->getBody()->getContents();
        });
    }
}

if (!function_exists('getImageFileMimetype')) {
    function getImageFileMimetype(Image $image)
    {
        if (Storage::disk('local')->exists($image->getFilePath())) {
            return Storage::disk('local')->mimeType($image->getFilePath());
        }

        return null;
    }
}

if (!function_exists('formatFileSize')) {
    function formatFileSize(int $fileSize): string
    {
        return byteFormatter()->format($fileSize);
    }
}

if (!function_exists('deleteImage')) {
    function deleteImage(Image $image)
    {
        $image->tags()->detach();

        Storage::disk('local')->delete($image->getFilePath());

        $image->delete();
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime(?Carbon $date): string
    {
        return optional($date, fn(Carbon $date) => $date->format(__('date.datetime')));
    }
}

if (!function_exists('getImageManager')) {
    /**
     * @return ImageManager
     */
    function getImageManager(): ImageManager
    {
        return new ImageManager();
    }
}

if (!function_exists('imgFing')) {
    function imgFing(): ImgFing
    {
        return new ImgFing([
            'bitSize' => 3000,
            'avgColorAdjust' => 50,
            'cropFit' => false,
            'adapters' => [
                'GD',
            ],
        ]);
    }
}

if (!function_exists('byteFormatter')) {
    function byteFormatter(): ByteFormatter
    {
        return new ByteFormatter();
    }
}