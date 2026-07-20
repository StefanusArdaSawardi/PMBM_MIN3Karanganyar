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
        Schema::create('periode_koordinator', function (Blueprint $table) {
            $table->id();
            $table->string('periode_pendaftaran_id', 10);
            $table->string('id_panitia', 10); // varchar FK referencing panitia_pmbms
            $table->timestamps();

            $table->foreign('periode_pendaftaran_id')->references('id')->on('periode_pendaftarans')->cascadeOnDelete();
            $table->foreign('id_panitia')->references('id_panitia')->on('panitia_pmbms')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_koordinator');
    }
};
