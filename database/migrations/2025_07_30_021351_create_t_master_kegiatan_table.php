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
        Schema::create('t_master_kegiatan', function (Blueprint $table) {
            $table->increments('id_kegiatan'); // id_kegiatan as auto-increment primary key
            $table->integer('id_program')->unsigned(); // id_program as unsigned integer (foreign key reference)
            $table->string('nama_kegiatan', 200); // nama_kegiatan as varchar(200)
            $table->timestamps(); // created_at and updated_at fields

            // Adding foreign key constraint (if necessary)
            $table->foreign('id_program')->references('id_program')->on('t_master_program')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_master_kegiatan');
    }
};
