<?php

use App\Models\Image;
use App\Models\Tag;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use ImgFing\ImgFing;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManager;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;

if (!function_exists('getImageInfoFields')) {
    function getImageInfoFields()
    {
        return [
            'views',
            'uploader',
            'tags',
            'source',
            'locked',
            'parent',
            'rating',
            'imageUrl',
        ];
    }
}

if (!function_exists('getAstolfoContent')) {
    function getAstolfoContent($uri)
    {
        return Http::get(config('astolfo.crawler_base_url') . $uri)->body();
    }
}

if (!function_exists('getImageInfoFieldValues')) {
    function getImageInfoFieldValues(Crawler $crawler)
    {
        $converter = new CssSelectorConverter();

        $image = $crawler->filterXPath($converter->toXPath('img#main_image, video#main_image source'));
        $imageUrl = config('astolfo.crawler_base_url') . $image->attr('src');

        list($views, $uploader, $tags, $source, $locked, $parent, $rating) = $crawler->filterXPath($converter->toXPath('table.image_info tr'))->each(function (Crawler $crawler) {
            return trim($crawler->children()->getNode(1)->textContent);
        });

        $tags = explode(' ', $tags);
        $source = $source == 'Unknown' ? null : $source;
        $locked = $locked == 'No' ? false : true;
        $parent = $parent == 'None' ? null : $parent;

        return compact('views', 'uploader', 'tags', 'source', 'locked', 'parent', 'rating', 'imageUrl');
    }
}

if (!function_exists('hasValueOrNull')) {
    function hasValueOrNull($value)
    {
        return !empty($value) || $value == null;
    }
}

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

if (!function_exists('getExternalIdByUri')) {
    function getExternalIdByUri($uri)
    {
        return collect(explode('/', $uri))->last();
    }
}

if (!function_exists('getImageForUri')) {
    function getImageForUri($uri, $verbose = false)
    {
        $externalId = getExternalIdByUri($uri);

        $crawler = new Crawler(getAstolfoContent($uri));
        $imageInfoFieldValues = collect(getImageInfoFieldValues($crawler));

        // only save not yet crawled images, update others
        $image = Image::find($externalId);

        $tags = collect($imageInfoFieldValues['tags'])
            ->reject(function ($value) {
                return $value == 'tagme';
            });

        $tagIds = $tags->map(function ($name) {
            return Tag::whereName($name)->firstOrCreate(compact('name'))->id;
        });

        $values = array_merge([
            'external_id' => $externalId,
            'url' => $imageInfoFieldValues['imageUrl'],
        ], $imageInfoFieldValues->reject(function ($item, $key) {
            return $key == 'tags';
        })->toArray());

        if ($imageInfoFieldValues['imageUrl'] != null) {
            if ($image) {
                $image->fill($values);

                $isImageFileValid = createImageFileIfNotExists($image);

                if (!$image->mimetype) {
                    $image->mimetype = getImageFileMimetype($image);
                }

                if ($verbose) {
                    logInfoWithPrintout('  #' . $externalId . ' - updated');
                }
            } else {
                $image = new Image($values);

                $isImageFileValid = createImageFile($image);

                $image->mimetype = getImageFileMimetype($image);

                if ($verbose) {
                    logInfoWithPrintout('  #' . $externalId . ' - created');
                }
            }

            if ($isImageFileValid) {
                $imgFing = imgFing();
                $imageData = getImageDataFromStorage($image);

                $image->identifier = $imgFing->identifyString($imageData);
                $image->identifier_image = $imgFing->createIdentityImageFromString($imageData);

                $image->save();
                $image->tags()->sync($tagIds);
            } else {
                logInfoWithPrintout('  #' . $externalId . ' - invalid file format');
            }
        } else {
            if ($verbose) {
                logInfoWithPrintout('  #' . $externalId . ' - imageUrl is empty');
            }
        }
    }
}

if (!function_exists('createImageFileIfNotExists')) {
    function createImageFileIfNotExists(Image $image)
    {
        try {
            Storage::disk('local')->get($image->getFilePath());

            return true;
        } catch (FileNotFoundException $e) {
            return createImageFile($image);
        }
    }
}

if (!function_exists('createImageFile')) {
    function createImageFile(Image $image)
    {
        try {
            $imageFile = getImageManager()->make(Http::get($image->url)->body());

            return Storage::disk('local')->put($image->getFilePath(), $imageFile->psrResponse()->getBody()->getContents());
        } catch (NotReadableException $e) {
            return false;
        }
    }
}

if (!function_exists('logInfoWithPrintout')) {
    function logInfoWithPrintout($line)
    {
        $out = new ConsoleOutput();
        $out->writeln($line);

        info($line);
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