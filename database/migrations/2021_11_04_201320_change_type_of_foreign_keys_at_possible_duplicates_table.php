<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeOfForeignKeysAtPossibleDuplicatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
