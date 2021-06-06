<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;
use App\Mail\CrawlerTestFailed;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\CssSelector\CssSelectorConverter;
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
        $expectedFieldNames = ['views', 'uploader', 'tags', 'source', 'locked', 'parent', 'rating', 'imageUrl'];
        $crawler = new Crawler(getAstolfoContent('/post/view/1'));

        $fields = getImageInfoFieldValues($crawler);

        $fieldChecks = array_map(function ($fieldName) use ($fields) {
            return array_key_exists($fieldName, $fields) && hasValueOrNull($fields[$fieldName]);
        }, $expectedFieldNames);

        $hasError = !array_reduce($fieldChecks, function ($acc, $value) {
            return $acc && $value;
        }, true);

        if ($hasError) {
            $this->logError('Crawler test failed.');

            Mail::to(config('astolfo.crawler_notification_mail'))->send(new CrawlerTestFailed($fields, getImageInfoFields()));
        } else {
            $this->logInfo('No errors occurred.');
        }
    }
}
