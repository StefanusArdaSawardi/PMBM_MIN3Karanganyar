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
        Schema::create('program_criteria', function (Blueprint $table) {
            $table->string('id_kriteria', 10)->primary();
            $table->string('id_program', 10);
            $table->string('nama_kriteria'); // 'hafalan', 'aism', 'iqro', 'calistung', 'dikte', 'kemandirian'
            $table->integer('nilai_minimum')->default(0);
            $table->timestamps();

            $table->foreign('id_program')->references('id_program')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_criteria');
    }
};
