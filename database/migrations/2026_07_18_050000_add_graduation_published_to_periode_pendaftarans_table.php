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
        if (!Schema::hasColumn('periode_pendaftarans', 'graduation_published')) {
            Schema::table('periode_pendaftarans', function (Blueprint $table) {
                $table->boolean('graduation_published')->default(false)->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('periode_pendaftarans', 'graduation_published')) {
            Schema::table('periode_pendaftarans', function (Blueprint $table) {
                $table->dropColumn('graduation_published');
            });
        }
    }
};
