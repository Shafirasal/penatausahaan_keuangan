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
        Schema::create('t_transaksional_realisasi_anggaran', function (Blueprint $table) {
            $table->increments('id_transaksional_realisasi'); // id_SSH as auto-increment primary key
            $table->integer('id_program')->unsigned(); // id_program as unsigned integer (foreign key reference)
            $table->integer('id_kegiatan')->unsigned(); // id_kegiatan as unsigned integer (foreign key reference)
            $table->integer('id_sub_kegiatan')->unsigned(); // id_sub_kegiatan as unsigned integer (foreign key reference)
            $table->integer('id_rekening')->unsigned(); 
            $table->integer('id_ssh')->unsigned();
            $table->enum('jenis_realisasi', ['Kwitansi', 'Nota', 'Dokumen Lainnya']);
            $table->string('no_dokumen'); // nama_ssh as varchar(200)
            $table->decimal('nilai_realisasi', 15, 2);
            $table->date('tanggal_realisasi');
            $table->string('file', 255);
            $table->timestamps();

            // Adding foreign key constraints (if necessary)
            $table->foreign('id_program')->references('id_program')->on('t_master_program')->onDelete('cascade');
            $table->foreign('id_kegiatan')->references('id_kegiatan')->on('t_master_kegiatan')->onDelete('cascade');
            $table->foreign('id_sub_kegiatan')->references('id_sub_kegiatan')->on('t_master_sub_kegiatan')->onDelete('cascade');
            $table->foreign('id_rekening')->references('id_rekening')->on('t_rekening')->onDelete('cascade');
            $table->foreign('id_ssh')->references('id_ssh')->on('t_ssh')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_transaksional_realisasi_anggaran');
    }
};
