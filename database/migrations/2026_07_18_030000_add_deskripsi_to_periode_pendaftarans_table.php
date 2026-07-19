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
        Schema::table('periode_pendaftarans', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('judul');
            $table->boolean('graduation_published')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periode_pendaftarans', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'graduation_published']);
        });
    }
};
