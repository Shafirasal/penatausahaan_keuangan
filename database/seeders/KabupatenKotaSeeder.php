<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenKotaSeeder extends Seeder
{
    public function run(): void
    {
        $provId = DB::table('t_provinsi')->where('nama_provinsi', 'Jawa Timur')->value('id');

        DB::table('t_kabupaten_kota')->insert([
            'nama_kabupaten_kota' => 'Surabaya',
            'id_provinsi' => $provId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
