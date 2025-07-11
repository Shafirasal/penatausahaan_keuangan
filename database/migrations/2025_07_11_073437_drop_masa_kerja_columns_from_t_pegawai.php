<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMasaKerjaColumnsFromTPegawai extends Migration
{
    public function up()
    {
        Schema::table('t_riwayat_kepegawaian', function (Blueprint $table) {
            $table->dropColumn('masa_kerja_tahun');
            $table->dropColumn('masa_kerja_bulan');
        });
    }

    public function down()
    {
        Schema::table('t_riwayat_kepegawaian', function (Blueprint $table) {
            $table->integer('masa_kerja_tahun')->nullable();
            $table->integer('masa_kerja_bulan')->nullable();
        });
    }
}
