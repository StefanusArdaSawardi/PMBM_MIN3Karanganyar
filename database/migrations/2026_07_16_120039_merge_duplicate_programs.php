<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Duplicate Program rows (ids 4-9) point to same 3 programs as canonical ids 1-3.
        // Remap pendaftarans.id_program to canonical id, then drop the duplicate rows.
        $map = [
            4 => 1, 7 => 1, // Tahfidz
            5 => 2, 8 => 2, // Sains
            6 => 3, 9 => 3, // Fullday
        ];

        foreach ($map as $duplicateId => $canonicalId) {
            DB::table('pendaftarans')
                ->where('id_program', $duplicateId)
                ->update(['id_program' => $canonicalId]);
        }

        DB::table('programs')->whereIn('id_program', array_keys($map))->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Data merge is not reversible.
    }
};
