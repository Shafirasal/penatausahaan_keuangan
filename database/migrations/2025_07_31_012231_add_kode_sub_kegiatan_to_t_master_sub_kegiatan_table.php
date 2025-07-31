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
        Schema::table('t_master_sub_kegiatan', function (Blueprint $table) {
            // Menambahkan kolom 'kode_sub_kegiatan' setelah kolom 'id_sub_kegiatan'
            $table->string('kode_sub_kegiatan', 12)->after('id_sub_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_master_sub_kegiatan', function (Blueprint $table) {
            // Menghapus kolom 'kode_sub_kegiatan' jika migrasi dibatalkan
            $table->dropColumn('kode_sub_kegiatan');
        });
    }
};
