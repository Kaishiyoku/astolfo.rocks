<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageMetadataToImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->unsignedBigInteger('file_size');
            $table->unsignedBigInteger('width');
            $table->unsignedBigInteger('height');
        });

        \App\Models\Image::all()->each(function (\App\Models\Image $image) {
            $imageData = $image->getImageFromStorage();

            if ($imageData) {
                $image->file_size = $imageData->filesize();
                $image->width = $imageData->width();
                $image->height = $imageData->height();

                $image->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('file_size');
            $table->dropColumn('width');
            $table->dropColumn('height');
        });
    }
}
