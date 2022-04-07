<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Image;

class GenerateImageIdentifiers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $images = Image::orderBy('external_id')->get();

        $images->each(function (Image $image) {
            $imageData = $image->getImageDataFromStorage();

            if (!$imageData) {
                return;
            }

            $image->identifier = ImgFing::identifyString($imageData);
            $image->identifier_image = ImgFing::createIdentityImageFromString($imageData);
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
