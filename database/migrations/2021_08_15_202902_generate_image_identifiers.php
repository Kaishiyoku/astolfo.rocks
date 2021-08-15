<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Image;
use ImgFing\ImgFing;

class GenerateImageIdentifiers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $imgFing = imgFing();
        $images = Image::orderBy('external_id')->get();

        $images->each(function (Image $image) use ($imgFing) {
            $imageData = getImageDataFromStorage($image);

            if (!$imageData) {
                return;
            }

            $image->identifier = $imgFing->identifyString($imageData);
            $image->identifier_image = $imgFing->createIdentityImageFromString($imageData);
            $image->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
