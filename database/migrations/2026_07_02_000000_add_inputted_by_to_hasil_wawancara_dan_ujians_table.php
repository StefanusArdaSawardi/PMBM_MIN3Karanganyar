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
        Schema::table('hasil_wawancara_dan_ujians', function (Blueprint $table) {
            $table->string('inputted_by')->nullable()->after('catatan_manual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_wawancara_dan_ujians', function (Blueprint $table) {
            $table->dropColumn('inputted_by');
        });
    }
};
