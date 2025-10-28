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
        Schema::table('t_user', function (Blueprint $table) {
            // Ubah enum level: tambahkan 'pimpinan'
            DB::statement("ALTER TABLE t_user MODIFY level ENUM('pegawai', 'admin', 'operator', 'pimpinan') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_user', function (Blueprint $table) {
            // Kembalikan ke enum semula
            DB::statement("ALTER TABLE t_user MODIFY level ENUM('pegawai', 'admin', 'operator') NOT NULL");
        });
    }
};
