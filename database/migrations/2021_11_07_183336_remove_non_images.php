<?php

use Illuminate\Database\Migrations\Migration;

class RemoveNonImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Image::where('mimetype', 'like', 'video/%')->each(function (\App\Models\Image $image) {
            deleteImage($image);
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
