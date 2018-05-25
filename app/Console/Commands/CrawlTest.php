<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;
use App\Mail\CrawlerTestFailed;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\DomCrawler\Crawler;

class CrawlTest extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'astolfo:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run crawler tests.';

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
        $hasError = false;
        $crawler = new Crawler(getAstolfoContent('/post/view/1'));
        $imageInfoFieldValues = getImageInfoFieldValues($crawler);

        $collectedFields = collect($imageInfoFieldValues)->map(function ($value, $key) {
            return [$key];
        })->flatten()->toArray();

        if ($collectedFields != getImageInfoFields()) {
            $hasError = true;
        }

        if ($hasError) {
            $this->logError('Crawler test failed.');

            Mail::to(env('CRAWLER_NOTIFICATION_MAIL'))->send(new CrawlerTestFailed($collectedFields, getImageInfoFields()));
        } else {
            $this->logInfo('No errors occurred.');
        }
    }
}
