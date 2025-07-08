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
         Schema::create('t_riwayat_kepegawaian', function (Blueprint $table) {
            $table->id('id_riwayat_kepegawaian');
            $table->string('nip', 20);
            $table->string('file', 255);
            $table->unsignedBigInteger('id_golongan');
            $table->unsignedBigInteger('id_jenis_kp');
            $table->integer('masa_kerja_tahun');
            $table->integer('masa_kerja_bulan');
            $table->date('tmt_pangkat');
            $table->string('keterangan', 255)->nullable();
            $table->enum('aktif', ['ya', 'tidak']);
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('t_pegawai')->onDelete('cascade');
            $table->foreign('id_golongan')->references('id_golongan')->on('t_golongan')->onDelete('cascade');
            $table->foreign('id_jenis_kp')->references('id_jenis_kp')->on('t_jenis_kenaikan_pangkat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_riwayat_kepegawaian');
    }
};
