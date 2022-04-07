<?php

use App\Enums\ImageRating;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Image;
use Illuminate\Support\Str;

class AdjustRatingAtImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('rating')->change();
        });

        Image::all()->each(function (Image $image) {
            $image->rating = Str::lower($image->rating);
            $image->save();
        });

        Schema::table('images', function (Blueprint $table) {
            $table->enum('rating', ImageRating::getValues())->change();
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
