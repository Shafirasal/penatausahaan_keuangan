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
        Schema::create('t_jabatan_fungsional', function (Blueprint $table) {
            $table->id('id_jabatan_fungsional');
            $table->string('nip', 20);
            $table->string('nama_jabatan', 100);
            $table->string('instansi', 100);
            $table->date('tmt_jabatan');
            $table->integer('PAK');
            $table->enum('status_fungsional', ['promosi', 'perpindahan dari jabatan lain', 'pertama']);
            $table->string('status_diklat', 100);
            $table->enum('aktif', ['ya', 'tidak']);
            $table->timestamps();
            $table->foreign('nip')->references('nip')->on('t_pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_jabatan_fungsional');
    }
};
