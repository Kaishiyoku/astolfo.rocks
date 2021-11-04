<?php

use App\Models\Image;
use ImgFing\ImgFing;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManager;

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

if (!function_exists('getImageDataFromStorage')) {
    function getImageDataFromStorage(Image $image)
    {
        if (!$image->mimetype) {
            return null;
        }

        try {
            return getImageManager()->make(Storage::disk('local')->get($image->getFilePath()))->psrResponse()->getBody()->getContents();
        } catch (NotReadableException $e) {
            return null;
        }
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
    /**
     * @return ImgFing
     */
    function imgFing(): ImgFing
    {
        return new ImgFing([
            'bitSize' => 6000,
            'avgColorAdjust' => 50,
            'cropFit' => false,
            'adapters' => [
                'GD',
            ],
        ]);
    }
}