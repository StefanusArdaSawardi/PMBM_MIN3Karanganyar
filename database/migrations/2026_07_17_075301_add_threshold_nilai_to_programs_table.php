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
        Schema::table('programs', function (Blueprint $table) {
            $table->string('jenis_penilaian')->nullable()->after('poin_unggulan');
            $table->unsignedInteger('threshold_nilai_min')->nullable()->after('jenis_penilaian');
            $table->unsignedInteger('threshold_nilai_max')->nullable()->after('threshold_nilai_min');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['jenis_penilaian', 'threshold_nilai_min', 'threshold_nilai_max']);
        });
    }
};
