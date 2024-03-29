<?php

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
        Schema::table('possible_duplicates', function (Blueprint $table) {
            $table->foreignId('image_id_left')->change();
            $table->foreignId('image_id_right')->change();

            $table->foreign('image_id_left')->references('id')->on('images');
            $table->foreign('image_id_right')->references('id')->on('images');
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
