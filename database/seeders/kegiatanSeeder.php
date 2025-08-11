<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar kegiatan per program
        $kegiatanPerProgram = [
            '40101' => [
                ['kode_kegiatan' => '40101102', 'nama_kegiatan' => 'Administrasi Keuangan Perangkat Daerah'],
                ['kode_kegiatan' => '40101103', 'nama_kegiatan' => 'Administrasi Barang Milik Daerah pada Perangkat Daerah'],
                ['kode_kegiatan' => '40101105', 'nama_kegiatan' => 'Administrasi Kepegawaian Perangkat Daerah'],
                ['kode_kegiatan' => '40101106', 'nama_kegiatan' => 'Administrasi Umum Perangkat Daerah'],
                ['kode_kegiatan' => '40101107', 'nama_kegiatan' => 'Pengadaan Barang Milik Daerah Penunjang Urusan Pemerintahan Daerah'],
                ['kode_kegiatan' => '40101108', 'nama_kegiatan' => 'Penyediaan Jasa Penunjang Urusan Pemerintahan Daerah'],
                ['kode_kegiatan' => '40101109', 'nama_kegiatan' => 'Pemeliharaan Barang Milik Daerah Penunjang Urusan Pemerintahan Daerah'],
                ['kode_kegiatan' => '40101101', 'nama_kegiatan' => 'Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah'],
                ],
            '40107' => [
                ['kode_kegiatan' => '40107101', 'nama_kegiatan' => 'Pengelolaan Pengadaan Barang dan Jasa'],
                ['kode_kegiatan' => '40107102', 'nama_kegiatan' => 'Pengelolaan Layanan Pengadaan Secara Elektronik integrasi	'],
                ['kode_kegiatan' => '40107103', 'nama_kegiatan' => 'Pembinaan dan Advokasi Pengadaan Barang dan Jasa'],
            ],
        ];

        // Loop tiap program
        foreach ($kegiatanPerProgram as $kodeProgram => $listKegiatan) {
            $programId = DB::table('t_master_program')
                ->where('kode_program', $kodeProgram)
                ->value('id');

            if (!$programId) {
                continue; // skip kalau program belum ada
            }

            foreach ($listKegiatan as $keg) {
                DB::table('t_master_kegiatan')->insert([
                    'id_program' => $programId,
                    'kode_kegiatan' => $keg['kode_kegiatan'],
                    'nama_kegiatan' => $keg['nama_kegiatan'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
