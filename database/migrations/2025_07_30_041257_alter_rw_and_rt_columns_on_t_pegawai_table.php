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
          Schema::table('t_pegawai', function (Blueprint $table) {
            // Mengubah tipe data kolom 'rw' menjadi varchar(2)
            $table->string('rw', 2)->change();

            // Mengubah tipe data kolom 'rt' menjadi varchar(2)
            $table->string('rt', 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_pegawai', function (Blueprint $table) {
            // Mengembalikan kolom 'rw' ke tipe data int
            $table->integer('rw')->change();

            // Mengembalikan kolom 'rt' ke tipe data int
            $table->integer('rt')->change();
        });
    }
};
