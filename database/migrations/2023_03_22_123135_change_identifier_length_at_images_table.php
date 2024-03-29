<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // remove old identifiers
        DB::table('images')->update([
            'identifier_image' => null,
            'identifier' => null,
        ]);

        Schema::table('images', function (Blueprint $table) {
            $table->string('identifier', 400)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('identifier', 8000)->nullable()->change();
        });
    }
};
