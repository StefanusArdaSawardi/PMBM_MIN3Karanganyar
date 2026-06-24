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
        if (!Schema::hasTable('school_contracts')) {
            Schema::create('school_contracts', function (Blueprint $table) {
                $table->id();
                $table->string('title')->default('Surat Kontrak Belajar & Komitmen Wali Murid');
                $table->longText('content')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('school_programs')) {
            Schema::create('school_programs', function (Blueprint $table) {
                $table->id();
                $table->string('tab_key')->unique();
                $table->string('title');
                $table->string('subtitle');
                $table->string('tag');
                $table->text('description');
                $table->text('features');
                $table->string('image_path')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('school_gallery')) {
            Schema::create('school_gallery', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('image_path');
                $table->integer('order')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_contracts');
        Schema::dropIfExists('school_programs');
        Schema::dropIfExists('school_gallery');
    }
};
