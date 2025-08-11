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
            'nip' => '678901234567890123',
            'file' => 'dokumen_kenaikan.pdf',
            'id_golongan' => 1,
            'id_jenis_kp' => 1,
            'tmt_pangkat' => '2023-01-01',
            'keterangan' => 'Kenaikan pangkat reguler',
            'aktif' => 'ya',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
