<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('t_user', function (Blueprint $table) {
            // Ubah kolom 'bagian' agar tidak memiliki default value
            DB::statement("ALTER TABLE t_user MODIFY bagian ENUM('PBJ', 'LPSE', 'PEMBINAAN', 'TU') NULL AFTER level");
        });
    }

    /**
     * Rollback perubahan.
     */
    public function down(): void
    {
        Schema::table('t_user', function (Blueprint $table) {
            // Kembalikan seperti sebelumnya (dengan default 'PBJ')
            DB::statement("ALTER TABLE t_user MODIFY bagian ENUM('PBJ', 'LPSE', 'PEMBINAAN', 'TU') NOT NULL DEFAULT 'PBJ' AFTER level");
        });
    }
};
