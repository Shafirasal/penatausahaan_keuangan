<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('t_pendidikan')->insert([
            'nip' => '12345',
            'nama_sekolah' => 'Universitas Negeri Surabaya',
            'tingkat' => 'S2',
            'prodi_jurusan' => 'Teknologi Pendidikan',
            'tahun_lulus' => 2010,
            'aktif' => 'tidak',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
