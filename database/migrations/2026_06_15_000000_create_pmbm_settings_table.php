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
        Schema::create('pmbm_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('registration_open')->default(false);
            $table->integer('current_angkatan')->nullable();
            $table->json('dss_weights')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmbm_settings');
    }
};
