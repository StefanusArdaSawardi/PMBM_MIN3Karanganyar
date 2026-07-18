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
        Schema::create('periode_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_pendaftaran_id')->constrained('periode_pendaftarans')->cascadeOnDelete();
            $table->string('id_program', 10); // varchar FK referencing programs
            $table->timestamps();

            $table->foreign('id_program')->references('id_program')->on('programs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_program');
    }
};
