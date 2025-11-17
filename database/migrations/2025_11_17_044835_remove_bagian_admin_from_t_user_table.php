<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan tidak ada data 'ADMIN'
        DB::table('t_user')
            ->where('bagian', 'ADMIN')
            ->update(['bagian' => null]);

        // Hapus 'ADMIN' dari enum
        DB::statement("ALTER TABLE t_user MODIFY bagian ENUM('PBJ', 'LPSE', 'PEMBINAAN', 'TU') NULL AFTER level");
    }

    public function down(): void
    {
        // Tambahkan kembali 'ADMIN' ke enum
        DB::statement("ALTER TABLE t_user MODIFY bagian ENUM('PBJ', 'LPSE', 'PEMBINAAN', 'TU', 'ADMIN') NULL AFTER level");
    }
};
