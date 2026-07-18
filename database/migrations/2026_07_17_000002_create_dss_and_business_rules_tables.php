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
        // 1. bobot_penilainans
        Schema::create('bobot_penilainans', function (Blueprint $table) {
            $table->string('id_bobot', 10)->primary();
            $table->decimal('bobot_hafalan', 5, 2)->default(0);
            $table->decimal('bobot_tasmi', 5, 2)->default(0);
            $table->decimal('bobot_calistung', 5, 2)->default(0);
            $table->decimal('bobot_wawancara', 5, 2)->default(0);
            $table->decimal('bobot_mandiri', 5, 2)->default(0);
            $table->decimal('bobot_aism', 5, 2)->default(0);
            $table->decimal('bobot_irqa', 5, 2)->default(0);
            $table->decimal('bobot_dikte', 5, 2)->default(0);
            $table->decimal('bobot_kemandirian', 5, 2)->default(0);
            $table->decimal('bobot_komitmenortu', 5, 2)->default(0);
            $table->timestamps();
        });

        // 2. dss_rankings
        Schema::create('dss_rankings', function (Blueprint $table) {
            $table->string('id_dss', 10)->primary();
            $table->string('id_pendaftaran', 10);
            $table->string('id_bobot', 10)->nullable();
            $table->decimal('nilai_total', 5, 2)->default(0);
            $table->integer('ranking')->nullable();
            $table->string('rekomendasi')->nullable();
            $table->timestamps();

            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftarans')->onDelete('cascade');
            $table->foreign('id_bobot')->references('id_bobot')->on('bobot_penilainans')->onDelete('set null');
        });

        // 3. bisnis_rule_programs
        Schema::create('bisnis_rule_programs', function (Blueprint $table) {
            $table->string('id_rule', 10)->primary();
            $table->string('id_program', 10);
            $table->integer('minimal_nilai_akhir')->default(0);
            $table->integer('minimal_hafalan')->default(0);
            $table->integer('minimal_tasmi')->default(0);
            $table->integer('minimal_calistung')->default(0);
            $table->timestamps();

            $table->foreign('id_program')->references('id_program')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bisnis_rule_programs');
        Schema::dropIfExists('dss_rankings');
        Schema::dropIfExists('bobot_penilainans');
    }
};
