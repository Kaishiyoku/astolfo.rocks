<?php

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

        $data = empty($str) ? collect() : collect(explode(';', env('SOCIAL_MEDIA_LINKS')))->map(function ($item) {
            $itemData = explode(',', $item);

            return [
                'title' => $itemData[0],
                'url' => $itemData[1],
            ];
        });

        return $data->toArray();
    }
}