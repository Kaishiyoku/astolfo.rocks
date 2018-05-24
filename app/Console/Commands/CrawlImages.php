<?php

namespace App\Console\Commands;

use App\Mail\CrawlerTestFailed;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\DomCrawler\Crawler;

class CrawlImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'astolfo:crawl {--test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawls for Astolfo images';

    /**
     * @var int
     */
    private $errorCount = 0;

    /**
     * @var array
     */
    private $imageInfoFields = [
        'views',
        'tags',
        'source',
        'rating',
    ];

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
        $isTest = $this->option('test');

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

        $this->getImages(collect($this->getFullImageUris($crawler)), $isTest);

        // get remaining pages
        if (!$isTest) {
            $pages->each(function ($page) {
                $this->logInfo('Page ' . $page);

                $crawler = new Crawler($this->getListContent($page));

                $this->getImages(collect($this->getFullImageUris($crawler)));
            });
        }

        $timeElapsedInSeconds = microtime(true) - $start;

        $this->line('');
        $this->logInfo('...finished. Duration: ' . number_format($timeElapsedInSeconds, 2) . ' seconds.');
        $this->line('');

        if ($isTest) {
            if ($this->errorCount == 0) {
                $this->logInfo('No errors occurred.');
            } else {
                $this->logError($this->errorCount . ' errors occurred.');

                Mail::to(env('CRAWLER_NOTIFICATION_MAIL'))->send(new CrawlerTestFailed());
            }
        }
    }

    private function getContent($uri)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_URL, env('CRAWLER_BASE_URL') . $uri);

        $content = curl_exec($ch);

        curl_close($ch);

        return $content;
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

    private function getImages(Collection $uris, $isTest = false)
    {
        $uris->each(function ($uri) use ($isTest) {
            $externalId = $this->getExternalIdByUri($uri);

            $crawler = new Crawler($this->getContent($uri));

            $imageInfoFields = collect($crawler
                ->filterXPath('//table[@class="image_info form"]/tr')
                ->each(function (Crawler $node) {
                    $label = strtolower(str_replace_first(':', '', $this->replaceNewLines($node->children()->getNode(0)->textContent)));
                    $value = $this->replaceNewLines($node->children()->getNode(1)->textContent);

                    return [$label => $value];
                })
            )->filter(function ($item) {
                return in_array(key($item), $this->imageInfoFields);
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

            $imageNode = $crawler->filter('img#main_image')->first();

            // only save not yet crawled images, update others
            $image = Image::find($externalId);

            $imageUrl = $imageNode->count() > 0 ? env('CRAWLER_BASE_URL') . $imageNode->attr('src') : null;

            $tags = collect($imageInfoFields['tags']);

            $tagIds = $tags->map(function ($name) {
                return Tag::whereName($name)->firstOrCreate(compact('name'))->id;
            });

            $values = array_merge([
                'external_id' => $externalId,
                'url' => $imageUrl,
            ], $imageInfoFields->reject(function ($item, $key) {
                return $key == 'tags';
            })->toArray());

            if ($isTest) {
                collect($values)->each(function ($value, $key) {
                    if (empty($value)) {
                        $this->logError($key . ' is empty');

                        $this->incrementErrorCount();
                    }
                });
            }

            if (!$isTest && $imageUrl != null) {
                if ($image) {
                    $image->fill($values);
                } else {
                    $image = new Image($values);
                }

                $image->save();
                $image->tags()->sync($tagIds);
            }

            $this->verbose(function () use ($externalId) {$this->logInfo('  #' . $externalId);});
        });
    }

    private function verbose(\Closure $closure)
    {
        if ($this->option('verbose')) {
            $closure();
        }
    }

    private function incrementErrorCount()
    {
        $this->errorCount++;
    }

    private function logInfo($message)
    {
        $this->line($message);
        Log::info($message);
    }

    private function logError($message)
    {
        $this->error($message);
        Log::error($message);
    }
}