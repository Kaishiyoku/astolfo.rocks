<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;

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
     *
     * @return int
     */
    public function handle()
    {
        $imgFing = imgFing();
        $images = Image::orderBy('id')->get();

        $images->each(function (Image $image) use ($imgFing) {
            $imageData = getImageDataFromStorage($image);

            $image->identifier = $imgFing->identifyString($imageData);
            $image->identifier_image = $imgFing->createIdentityImageFromString($imageData);
            $image->save();
        });

        return 0;
    }
}
