<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('image_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('image_external_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('image_external_id')->references('external_id')->on('images');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('image_tag');
    }
};
