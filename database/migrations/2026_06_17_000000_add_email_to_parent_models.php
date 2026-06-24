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
        Schema::table('ayah_calon_murids', function (Blueprint $table) {
            $table->string('email')->nullable()->unique();
        });

        Schema::table('ibu_calon_murids', function (Blueprint $table) {
            $table->string('email')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ayah_calon_murids', function (Blueprint $table) {
            $table->dropColumn('email');
        });

        Schema::table('ibu_calon_murids', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
