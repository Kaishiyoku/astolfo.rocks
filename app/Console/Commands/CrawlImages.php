<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;
use App\Models\Image;
use App\Models\Tag;
use App\Models\UpdateLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class CrawlImages extends BaseCommand
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

        $this->logInfo('Crawling images...this will take some time.');
        $this->line('');

        $crawler = new Crawler($this->getListContent());

        $lastPageNumber = $this->getLastPageNumber($crawler);
        $pages = collect(range(2, $lastPageNumber));

        $this->logInfo('Number of pages: ' . $lastPageNumber);
        $this->line('');

        // get first page
        $this->logInfo('Page 1');

        $this->getImages(collect($this->getFullImageUris($crawler)));

        // get remaining pages
        $pages->each(function ($page) {
            $this->logInfo('Page ' . $page);

            $crawler = new Crawler($this->getListContent($page));

            $this->getImages(collect($this->getFullImageUris($crawler)));
        });

        $timeElapsedInSeconds = microtime(true) - $start;

        $updateLog = new UpdateLog();
        $updateLog->save();

        $this->line('');
        $this->logInfo('...finished. Duration: ' . number_format($timeElapsedInSeconds, 2) . ' seconds.');
        $this->line('');
    }

    private function getListContent($pageNumber = null)
    {
        $uri = $pageNumber == null ? '/post/list' : "/post/list/$pageNumber";

        return getAstolfoContent($uri);
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

    private function getImages(Collection $uris)
    {
        $uris->each(function ($uri) {
            getImageForUri($uri, $this->option('verbose'));
        });
    }
}
