<?php

use Symfony\Component\DomCrawler\Crawler;

if (!function_exists('getImageInfoFields')) {
    function getImageInfoFields()
    {
        return [
            'views',
            'tags',
            'source',
            'rating',
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
        return collect($crawler
            ->filterXPath('//table[@class="image_info form"]/tr')
            ->each(function (Crawler $node) {
                $label = strtolower(str_replace_first(':', '', replaceNewLines($node->children()->getNode(0)->textContent)));
                $value = replaceNewLines($node->children()->getNode(1)->textContent);

                return [$label => $value];
            })
        )->filter(function ($item) {
            return in_array(key($item), getImageInfoFields());
        })->flatMap(function ($item) {
            $key = key($item);
            $value = $item[$key];

            if ($key == 'tags') {
                $item[$key] = explode(' ', strtolower($value));
            }

            if ($key == 'source' && $value == 'Unknown') {
                $item[$key] = null;
            }

            if (empty($value)) {
                return null;
            }

            return $item;
        });
    }
}