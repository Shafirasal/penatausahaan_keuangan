<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatKepegawaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_riwayat_kepegawaian')->insert([
            'nip' => '12345',
            'file' => 'dokumen_kenaikan.pdf',
            'id_golongan' => 1,
            'id_jenis' => 1,
            'masa_kerja_tahun' => 15,
            'masa_kerja_bulan' => 6,
            'unit_penempatan' => 'Dispendik Surabaya',
            'aktif' => 'ya',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
