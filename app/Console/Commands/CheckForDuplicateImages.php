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
        PossibleDuplicate::where('is_false_positive', false)->delete();

        $imgFing = imgFing();
        $imagesAsc = Image::select(['identifier', 'id'])->whereNotNull('identifier')->orderBy('id')->get();
        $imagesDesc = Image::select(['identifier', 'id'])->whereNotNull('identifier')->orderBy('id', 'desc')->get();

        $imagesAsc->each(function (Image $imageAsc, int $i) use ($imagesDesc, $imgFing) {
            $imagesDesc->each(function (Image $imageDesc) use ($imageAsc, $imgFing) {
                if ($imageAsc->id === $imageDesc->id) {
                    return;
                }

                if ($imgFing->matchScore($imageAsc->identifier, $imageDesc->identifier) > config('astolfo.duplicate_checker_threshold')) {
                    $alreadyInsertedPossibleDuplicateCount = PossibleDuplicate::query()
                        ->where('image_id_left', $imageDesc->id)
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

            $this->line($i + 1 . ' images checked');
        });

        return Command::SUCCESS;
    }
}
