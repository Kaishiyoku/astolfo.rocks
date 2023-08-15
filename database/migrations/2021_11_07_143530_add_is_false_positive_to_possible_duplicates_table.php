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
        Schema::table('possible_duplicates', function (Blueprint $table) {
            $table->boolean('is_false_positive')->default(false)->after('image_id_right');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('possible_duplicates', function (Blueprint $table) {
            $table->dropColumn('is_false_positive');
        });
    }
};
