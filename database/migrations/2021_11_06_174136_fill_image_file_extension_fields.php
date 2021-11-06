<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;

class FillImageFileExtensionFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Image::all()->each(function (\App\Models\Image $image) {
            $image->file_extension = File::extension($image->url);

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
