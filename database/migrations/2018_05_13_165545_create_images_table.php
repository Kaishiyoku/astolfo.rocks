<?php

use App\Enums\ImageRating;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->unsignedInteger('external_id')->unique();
            $table->string('url', 1528);
            $table->enum('rating', ImageRating::getValues());
            $table->timestamps();

            $table->primary('external_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
