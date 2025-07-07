<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanStrukturalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_jabatan_struktural')->insert([
            'nip' => '12345',
            'nama_jabatan' => 'Kepala Seksi',
            'jenis_pelantikan' => 'Pelantikan Biasa',
            'id_unit_kerja' => 1,
            'tmt_jabatan' => now(),
            'status_jabatan' => 'Aktif',
            'aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
