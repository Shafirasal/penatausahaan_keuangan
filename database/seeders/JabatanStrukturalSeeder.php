<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'jenis_penilaian' => '...',
            'id_unit_kerja' => 1,
            'unit_jabatan' => 'Kassub Bagian Pengelolaan Layanan Pengadaan Secara Elektronik',
            'status_jabatan' => 'ya',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
