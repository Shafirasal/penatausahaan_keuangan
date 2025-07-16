<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoToPegawaiTable extends Migration
{
    public function up()
    {
        Schema::table('t_pegawai', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('t_pegawai', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
}

