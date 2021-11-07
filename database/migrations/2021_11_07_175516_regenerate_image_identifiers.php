<?php

use Illuminate\Database\Migrations\Migration;

class RegenerateImageIdentifiers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $imgFing = imgFing();
        $images = \App\Models\Image::orderBy('id')->get();

        $images->each(function (\App\Models\Image $image) use ($imgFing) {
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
