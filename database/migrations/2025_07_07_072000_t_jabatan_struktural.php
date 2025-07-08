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
        Schema::create('t_jabatan_struktural', function (Blueprint $table) {
            $table->id('id_jabatan_struktural');
            $table->string('nip', 20);
            $table->string('nama_jabatan', 100);
            $table->enum('jenis_pelantikan', ['definitif', 'pj(pejabat)']); // sesuaikan nilainya
            $table->unsignedBigInteger('id_unit_kerja');
            $table->enum('status_jabatan', ['mutasi', 'promosi']);
            $table->date('tmt_jabatan');
            $table->enum('aktif', ['ya', 'tidak']);
            $table->timestamps();
            $table->foreign('nip')->references('nip')->on('t_pegawai')->onDelete('cascade');
            $table->foreign('id_unit_kerja')->references('id_unit_kerja')->on('t_unit_kerja')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_jabatan_struktural');
    }
};
