<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CrawlerTestFailed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    private $collectedFields;

    /**
     * @var array
     */
    private $expectedFields;

    /**
     * Create a new message instance.
     * @param array $collectedFields
     * @param array $expectedFields
     */
    public function __construct($collectedFields, $expectedFields)
    {
        $this->collectedFields = $collectedFields;
        $this->expectedFields = $expectedFields;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.crawler.failed', [
            'collectedFields' => $this->collectedFields,
            'expectedFields' => $this->expectedFields,
        ]);
    }
}
