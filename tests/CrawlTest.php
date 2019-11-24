<?php

namespace Tests;

use App\Models\Image;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Component\DomCrawler\Crawler;

class CrawlTest extends BaseTestCase
{
    use CreatesApplication;
    use MatchesSnapshots;

    public function testGetsFieldValuesOfAnImage()
    {
        $crawler = new Crawler(getAstolfoContent('/post/view/3407'));

        $fields = getImageInfoFieldValues($crawler);

        $this->assertMatchesJsonSnapshot($fields);
    }

    public function testCrawlsAndSavesASingleImage()
    {
        $imageReset = Image::find(3407);
        $imageReset->rating = 'Unknown';
        $imageReset->save();

        getImageForUri('/post/view/3407');

        $imageActual = Image::find(3407);

        $this->assertEquals('Questionable', $imageActual->rating);
    }
}
