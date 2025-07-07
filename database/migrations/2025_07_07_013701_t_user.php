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
         Schema::create('t_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nip', 20)->unique();
            $table->enum('level', ['pegawai', 'admin']);
            $table->string('password', 225);
            $table->foreign('nip')->references('nip')->on('t_pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_user');
    }
};
