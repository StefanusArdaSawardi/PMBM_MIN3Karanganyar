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
        Schema::create('pmbm_phases', function (Blueprint $table) {
            $table->id('id_phase');
            $table->string('nama_phase'); // Pendaftaran, Verifikasi, Wawancara, Pengumuman, dll
            $table->text('deskripsi')->nullable(); // Deskripsi kegiatan
            $table->dateTime('tanggal_mulai'); // Waktu mulai fase
            $table->dateTime('tanggal_selesai'); // Waktu selesai fase
            $table->enum('status', ['active', 'inactive', 'completed'])->default('inactive');
            $table->integer('urutan')->default(0); // Untuk sorting urutan fase
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmbm_phases');
    }
};
