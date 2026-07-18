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
        // Hubungkan pendaftarans ke periode_pendaftarans & tambahkan program kelulusan
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->unsignedBigInteger('periode_pendaftaran_id')->nullable()->after('id_pendaftaran');
            $table->string('program_kelulusan')->nullable()->after('status_kelulusan');
            $table->timestamp('batas_konfirmasi')->nullable()->after('tanggal_konfirmasi'); // deadline untuk daftar ulang
            
            $table->foreign('periode_pendaftaran_id')->references('id')->on('periode_pendaftarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropForeign(['periode_pendaftaran_id']);
            $table->dropColumn(['periode_pendaftaran_id', 'program_kelulusan', 'batas_konfirmasi']);
        });
    }
};
