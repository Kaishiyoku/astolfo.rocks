<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use ImageHash;
use Throwable;

class GenerateImageIdentifiers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'astolfo:generate_identifiers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate image identifiers';

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
     */
    public function handle(): int
    {
        $images = Image::orderBy('id')->get();

        $images->each(function (Image $image) {
            try {
                $image->identifier = ImageHash::hash($image->getImageFilePath())->toBits();
                $image->save();

                $this->line("generated identifier for image #{$image->id}");
            } catch (Throwable $e) {
                $warningMessage = "Could not generate identifier for image #{$image->id}";

                $this->warn($warningMessage);
                Log::warning($warningMessage);
            }
        });

        return Command::SUCCESS;
    }
}
