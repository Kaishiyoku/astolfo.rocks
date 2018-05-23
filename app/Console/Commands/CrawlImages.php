<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

class CrawlImages extends Command
{
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

        $crawler = new Crawler($this->getListContent());

        $lastPageNumber = $this->getLastPageNumber($crawler);
        $pages = collect(range(2, $lastPageNumber));

        $this->line('Number of pages: ' . $lastPageNumber);
        $this->line('');

        // get first page
        $this->line('Page 1');

        $this->getImages(collect($this->getFullImageUris($crawler)));

        // get remaining pages
        $pages->each(function ($page) {
            $this->line('Page ' . $page);

            $crawler = new Crawler($this->getListContent($page));

            $this->getImages(collect($this->getFullImageUris($crawler)));
        });

        $timeElapsedInSeconds = microtime(true) - $start;

        $this->line('');
        $this->line('...finished. Duration: ' . number_format($timeElapsedInSeconds, 2) . ' seconds.');
        $this->line('');
    }

    private function getContent($uri)
    {
        return file_get_contents(env('CRAWLER_BASE_URL') . $uri);
    }

    private function getListContent($pageNumber = null)
    {
        $uri = $pageNumber == null ? '/post/list' : "/post/list/$pageNumber";

        return $this->getContent($uri);
    }

    private function getLastPageNumber(Crawler $crawler)
    {
        return collect($crawler
            ->filter('#paginator > a')
            ->each(function (Crawler $node) {
                return $node->text();
            })
        )->filter(function ($value) {
            return $value != '>>';
        })->last();
    }

    private function getFullImageUris(Crawler $crawler)
    {
        return $crawler
            ->filter('a.thumb')
            ->each(function (Crawler $node) {
                return $node->attr('href');
            });
    }

    private function getExternalIdByUri($uri)
    {
        return collect(explode('/', $uri))->last();
    }

    private function replaceNewLines($content)
    {
        return preg_replace("/\n|\t/", '', $content);
    }

    private function getImages(Collection $uris)
    {
        $uris->each(function ($uri) {
            $externalId = $this->getExternalIdByUri($uri);

            $crawler = new Crawler($this->getContent($uri));

            $rating = collect(
                $crawler
                    ->filterXPath('//table/tr/td')
                    ->each(function (Crawler $node) {
                        return $this->replaceNewLines($node->text());
                    })
            )->filter(function ($value) {
                return in_array($value, $this->getRatings());
            })->first();

            $imageNode = $crawler->filter('img#main_image')->first();

            // only save not yet crawled images, update others
            $image = Image::find($externalId);

            $imageUrl = $imageNode->count() > 0 ? env('CRAWLER_BASE_URL') . $imageNode->attr('src') : null;

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

            $this->verbose(function () use ($externalId) {$this->line('  #' . $externalId);});
        });
    }

    private function getRatings()
    {
        return explode(',', env('CRAWLER_RATINGS'));
    }

    private function verbose(\Closure $closure)
    {
        if ($this->option('verbose')) {
            $closure();
        }
    }
}
