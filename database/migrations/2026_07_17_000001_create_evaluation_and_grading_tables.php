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
        // 1. nilai_ujians — Input Pengawas Ujian (integer 1-100)
        Schema::create('nilai_ujians', function (Blueprint $table) {
            $table->string('id_nilai', 10)->primary();
            $table->string('id_pendaftaran', 10);
            $table->string('id_panitia', 10); // FK ke panitia_pmbms (varchar)
            $table->integer('nilai_hafalan')->nullable();   // skala 1-100
            $table->integer('nilai_tasmi')->nullable();      // skala 1-100
            $table->integer('nilai_calistung')->nullable();  // skala 1-100
            $table->timestamps();

            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftarans')->onDelete('cascade');
            $table->foreign('id_panitia')->references('id_panitia')->on('panitia_pmbms')->onDelete('cascade');
        });

        // 2. wawancara_anaks — Input Petugas Wawancara (teks deskriptif / varchar)
        Schema::create('wawancara_anaks', function (Blueprint $table) {
            $table->string('id_wawancara_anak', 10)->primary();
            $table->string('id_pendaftaran', 10);
            $table->string('id_panitia', 10); // FK ke panitia_pmbms (varchar)
            $table->text('wawancara_aism')->nullable();
            $table->text('wawancara_irqa')->nullable();
            $table->text('wawancara_calistung')->nullable();
            $table->text('wawancara_dikte')->nullable();
            $table->text('wawancara_kemandirian')->nullable();
            $table->text('rekap_wawancara')->nullable();
            $table->timestamps();

            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftarans')->onDelete('cascade');
            $table->foreign('id_panitia')->references('id_panitia')->on('panitia_pmbms')->onDelete('cascade');
        });

        // 3. wawancara_ortus — Komitmen orang tua (teks deskriptif / varchar)
        Schema::create('wawancara_ortus', function (Blueprint $table) {
            $table->string('id_wawancara_ortu', 10)->primary();
            $table->string('id_pendaftaran', 10);
            $table->string('id_panitia', 10); // FK ke panitia_pmbms (varchar)
            $table->text('komitmen_ortu')->nullable();
            $table->timestamps();

            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftarans')->onDelete('cascade');
            $table->foreign('id_panitia')->references('id_panitia')->on('panitia_pmbms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wawancara_ortus');
        Schema::dropIfExists('wawancara_anaks');
        Schema::dropIfExists('nilai_ujians');
    }
};
