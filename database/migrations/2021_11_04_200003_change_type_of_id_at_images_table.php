<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeOfIdAtImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('image_tag', function (Blueprint $table) {
            $table->dropForeign(['image_external_id']);
            $table->dropForeign(['tag_id']);
        });

        Schema::table('possible_duplicates', function (Blueprint $table) {
            $table->dropForeign(['image_external_id_left']);
            $table->dropForeign(['image_external_id_right']);
        });

        Schema::table('images', function (Blueprint $table) {
            $table->id()->change();
        });

        Schema::table('image_tag', function (Blueprint $table) {
            $table->renameColumn('image_external_id', 'image_id');
        });

        Schema::table('possible_duplicates', function (Blueprint $table) {
            $table->renameColumn('image_external_id_left', 'image_id_left');
            $table->renameColumn('image_external_id_right', 'image_id_right');
        });

        Schema::table('image_tag', function (Blueprint $table) {
            $table->foreignId('image_id')->change();

            $table->foreign('image_id')->references('id')->on('images');
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
