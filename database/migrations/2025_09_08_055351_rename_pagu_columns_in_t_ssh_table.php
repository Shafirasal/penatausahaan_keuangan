<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('t_ssh', function (Blueprint $table) {
            // ubah kolom
            $table->renameColumn('pagu', 'pagu1');
            $table->renameColumn('periode', 'pagu2');
        });
    }

    public function down(): void
    {
        Schema::table('t_ssh', function (Blueprint $table) {
            // rollback (balikin ke nama awal)
            $table->renameColumn('pagu1', 'pagu');
            $table->renameColumn('pagu2', 'periode');
        });
    }
};
