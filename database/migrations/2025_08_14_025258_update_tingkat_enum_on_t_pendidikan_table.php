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
        Schema::table('t_pendidikan', function (Blueprint $table) {
            $table->enum('tingkat', ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_pendidikan', function (Blueprint $table) {
            $table->enum('tingkat', ['sd', 'smp', 'sma/smk', 'd1', 'd2', 'd3', 'd4', 's1', 's2', 's3'])
                  ->change();
        });
    }
};
