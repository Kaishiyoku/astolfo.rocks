<?php

use App\Models\Image;
use App\Models\Tag;
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

if (!function_exists('getExternalContent')) {
    function getExternalContent($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        $content = curl_exec($ch);

        curl_close($ch);

        return $content;
    }
}

if (!function_exists('getAstolfoContent')) {
    function getAstolfoContent($uri)
    {
        return getExternalContent(env('CRAWLER_BASE_URL') . $uri);
    }
}

if (!function_exists('replaceNewLines')) {
    function replaceNewLines($content)
    {
        return preg_replace("/\n|\t/", '', $content);
    }
}

if (!function_exists('getImageInfoFieldValues')) {
    function getImageInfoFieldValues(Crawler $crawler)
    {
        $converter = new CssSelectorConverter();

        $image = $crawler->filterXPath($converter->toXPath('img#main_image, video#main_image source'));
        $imageUrl = env('CRAWLER_BASE_URL') . $image->attr('src');

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
        $str = env('SOCIAL_MEDIA_LINKS');

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

                createImageFileIfNotExists($image);

                if ($verbose) {
                    logInfoWithPrintout('  #' . $externalId . ' - updated');
                }
            } else {
                $image = new Image($values);

                createImageFile($image);

                if ($verbose) {
                    logInfoWithPrintout('  #' . $externalId . ' - created');
                }
            }

            $image->save();
            $image->tags()->sync($tagIds);
        } else {
            if ($verbose) {
                logInfoWithPrintout('  #' . $externalId . ' - imageUrl is empty');
            }
        }
    }
}

if (!function_exists('createImageFileIfNotExists')) {
    function createImageFileIfNotExists($image)
    {
        try {
            $imageFile = Storage::disk('local')->get(getImageFilePathFor($image));
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            createImageFile($image);
        }
    }
}

if (!function_exists('createImageFile')) {
    function createImageFile($image)
    {
        Storage::disk('local')->put(getImageFilePathFor($image), getExternalContent($image->url));
    }
}

if (!function_exists('getImageFilePathFor')) {
    function getImageFilePathFor($image)
    {
        $fileExtension = File::extension($image->url);
        $fileName = $image->external_id . '.' . $fileExtension;

        return env('CRAWLER_FILESYSTEM_PATH') . '/' . $fileName;
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
