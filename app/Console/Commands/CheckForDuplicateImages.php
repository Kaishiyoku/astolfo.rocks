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
        $imagesAsc = Image::whereNotNull('identifier')->orderBy('id');
        $imagesDesc = Image::whereNotNull('identifier')->orderBy('id', 'desc');

        $imagesAsc->each(function (Image $imageAsc) use ($imagesDesc, $imgFing) {
            $imagesDesc->each(function (Image $imageDesc) use ($imageAsc, $imgFing) {
                if ($imageAsc->id === $imageDesc->id) {
                    return;
                }

                if ($imgFing->matchScore($imageAsc->identifier, $imageDesc->identifier) > static::THRESHOLD) {
                    $alreadyInsertedPossibleDuplicateCount = PossibleDuplicate::where('image_id_left', $imageDesc->id)
                        ->where('image_id_right', $imageAsc->id)
                        ->count();

                    if ($alreadyInsertedPossibleDuplicateCount === 0) {
                        PossibleDuplicate::create([
                            'image_id_left' => $imageAsc->id,
                            'image_id_right' => $imageDesc->id,
                        ]);
                    }
                }
            });
        });

        return 0;
    }
}
