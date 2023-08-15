<?php

use App\Enums\ImageRating;
use App\Models\Image;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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
     */
    public function down(): void
    {
        //
    }
};
