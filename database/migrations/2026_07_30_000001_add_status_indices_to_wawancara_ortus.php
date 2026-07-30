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
        Schema::table('wawancara_ortus', function (Blueprint $table) {
            $table->string('komitmen_ortu_status', 20)->nullable()->after('id_panitia');
            $table->string('dukungan_fasilitas_status', 20)->nullable()->after('komitmen_ortu_status');
            $table->string('visi_misi_status', 20)->nullable()->after('dukungan_fasilitas_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wawancara_ortus', function (Blueprint $table) {
            $table->dropColumn(['komitmen_ortu_status', 'dukungan_fasilitas_status', 'visi_misi_status']);
        });
    }
};
