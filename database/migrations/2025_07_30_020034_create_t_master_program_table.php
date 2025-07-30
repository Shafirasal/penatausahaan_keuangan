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
        Schema::create('t_master_program', function (Blueprint $table) {
            $table->increments('id_program'); // id_program as auto-increment primary key
            $table->string('nama_program', 200); // nama_program as varchar(200)
            $table->timestamps(); // created_at and updated_at fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_master_program');
    }
};
