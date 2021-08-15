<?php

namespace App\Console\Commands;

use App\Models\Image;
use App\Models\PossibleDuplicate;
use Illuminate\Console\Command;

class CheckForDuplicateImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'astolfo:check_duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for duplicate images';

    /**
     * @var float
     */
    private const THRESHOLD = 0.95;

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
        PossibleDuplicate::truncate();

        $imgFing = imgFing();
        $imagesAsc = Image::whereNotNull('identifier')->orderBy('external_id');
        $imagesDesc = Image::whereNotNull('identifier')->orderBy('external_id', 'desc');

        $imagesAsc->each(function (Image $imageAsc) use ($imagesDesc, $imgFing) {
            $imagesDesc->each(function (Image $imageDesc) use ($imageAsc, $imgFing) {
                if ($imageAsc->external_id === $imageDesc->external_id) {
                    return;
                }

                if ($imgFing->matchScore($imageAsc->identifier, $imageDesc->identifier) > static::THRESHOLD) {
                    $alreadyInsertedPossibleDuplicateCount = PossibleDuplicate::where('image_external_id_left', $imageDesc->external_id)
                        ->where('image_external_id_right', $imageAsc->external_id)
                        ->count();

                    if ($alreadyInsertedPossibleDuplicateCount === 0) {
                        PossibleDuplicate::create([
                            'image_external_id_left' => $imageAsc->external_id,
                            'image_external_id_right' => $imageDesc->external_id,
                        ]);
                    }
                }
            });
        });

        return 0;
    }
}
