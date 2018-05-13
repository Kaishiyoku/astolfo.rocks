<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class CrawlImages extends Command
{
    private $baseUrl = 'http://unlimitedastolfo.works';

    private $ratings = [
        'Unknown',
        'Safe',
        'Questionable',
        'Explicit',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'astolfo:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawls for Astolfo images';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = microtime(true);

        $this->line('Crawling images...this will take some time.');
        $this->line('');

        $content = file_get_contents($this->baseUrl . '/post/list');

        $crawler = new Crawler($content);

        $numberOfPages = collect($crawler
            ->filter('#paginator > a')
            ->each(function (Crawler $node, $i) {
                return $node->text();
            })
        )->filter(function ($value) {
            return $value != '>>';
        })->last();

        $urls = $crawler
            ->filter('a.thumb')
            ->each(function (Crawler $node, $i) {
                return $node->attr('href');
            });

        // get first page
        $this->getImages($urls);

        // get remaining pages
        for ($i = 2; $i <= $numberOfPages; $i++) {
            $curContent = file_get_contents($this->baseUrl . '/post/list/' . $i);

            $curCrawler = new Crawler($curContent);

            $curUrls = $curCrawler
                ->filter('a.thumb')
                ->each(function (Crawler $node) {
                    return $node->attr('href');
                });

            $this->getImages($curUrls);
        }

        $timeElapsedInSeconds = microtime(true) - $start;

        $this->line('');
        $this->line('...finished. Duration: ' . number_format($timeElapsedInSeconds, 2) . ' seconds.');
        $this->line('');
    }

    private function getImages($urls)
    {
        foreach ($urls as $url) {
            $externalId = collect(explode('/', $url))->last();
            $curContent = file_get_contents($this->baseUrl . $url);

            $curCrawler = new Crawler($curContent);

            $rating = collect(
                $curCrawler
                    ->filterXPath('//table/tr/td')
                    ->each(function (Crawler $node, $i) {
                        return preg_replace("/\n|\t/", '', $node->text());
                    })
            )->filter(function ($value) {
                return in_array($value, $this->ratings);
            })->first();

            $imageNode = $curCrawler
                ->filter('img#main_image')
                ->first();

            // only save not yet crawled images
            $image = Image::find($externalId);

            $imageUrl = $imageNode->count() > 0 ? $this->baseUrl . $imageNode->attr('src') : null;

            $values = [
                'external_id' => $externalId,
                'rating' => $rating,
                'url' => $imageUrl,
            ];

            if ($imageUrl != null) {
                if ($image) {
                    $image->fill($values);
                } else {
                    $image = new Image($values);
                }

                $image->save();
            }

            $this->line('  #' . $externalId);
        }

    }
}
