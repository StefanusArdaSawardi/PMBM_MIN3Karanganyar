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
            $table->foreignId('periode_pendaftaran_id')->constrained('periode_pendaftarans')->cascadeOnDelete();
            $table->string('id_panitia', 10); // varchar FK referencing panitia_pmbms
            $table->timestamps();

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
