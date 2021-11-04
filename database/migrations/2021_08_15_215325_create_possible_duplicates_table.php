<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePossibleDuplicatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('possible_duplicates', function (Blueprint $table) {
            $table->id();
            $table->integer('image_external_id_left')->unsigned();
            $table->integer('image_external_id_right')->unsigned();
            $table->timestamps();

            $table->foreign('image_external_id_left')->references('external_id')->on('images');
            $table->foreign('image_external_id_right')->references('external_id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('possible_duplicates');
    }
}