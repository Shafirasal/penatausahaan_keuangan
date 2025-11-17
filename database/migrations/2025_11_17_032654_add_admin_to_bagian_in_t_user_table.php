<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('t_user', function () {
            // Tambahkan 'ADMIN' ke enum 'bagian' tanpa mengganggu data lain
            DB::statement("ALTER TABLE t_user MODIFY bagian ENUM('PBJ', 'LPSE', 'PEMBINAAN', 'TU', 'ADMIN') NULL AFTER level");
        });
    }

    /**
     * Rollback perubahan.
     */
    public function down(): void
    {
        Schema::table('t_user', function () {
            // Pastikan tidak ada data 'ADMIN' sebelum menghapus enum ini
            DB::table('t_user')
                ->where('bagian', 'ADMIN')
                ->update(['bagian' => NULL]); // Bisa ganti NULL dengan 'PBJ' jika mau default lain

            // Hapus 'ADMIN' dari enum
            DB::statement("ALTER TABLE t_user MODIFY bagian ENUM('PBJ', 'LPSE', 'PEMBINAAN', 'TU') NULL AFTER level");
        });
    }
};
