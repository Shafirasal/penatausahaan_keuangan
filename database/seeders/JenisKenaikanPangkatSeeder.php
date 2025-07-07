<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKenaikanPangkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_jenis_kenaikan_pangkat')->insert([
            ['kode' => '11', 'nama_jenis' => 'Gol. Dari Pengadaan CPNS'],
            ['kode' => '12', 'nama_jenis' => 'Gol. Dari Pengangkatan PNS'],
            ['kode' => '13', 'nama_jenis' => 'Reguler'],
            ['kode' => '14', 'nama_jenis' => 'Tambahan Masa Kerja'],
            ['kode' => '1501', 'nama_jenis' => 'Pilihan (Jabatan Struktural)'],
            ['kode' => '1502', 'nama_jenis' => 'Pilihan (Jabatan Fungsional Tertentu)'],
            ['kode' => '1503', 'nama_jenis' => 'Pilihan (Penyesuaian Ijazah)'],
            ['kode' => '1504', 'nama_jenis' => 'Pilihan (Sedang melaksanakan tugas belajar)'],
            ['kode' => '1505', 'nama_jenis' => 'Pilihan (Setelah Selesai Tugas Belajar)'],
            ['kode' => '1506', 'nama_jenis' => 'Pilihan (Diperbantukan atau Dipekerjakan pada instansi lain)'],
            ['kode' => '1507', 'nama_jenis' => 'Pilihan (Penemuan Baru)'],
            ['kode' => '1508', 'nama_jenis' => 'Pilihan (Prestasi Luar Biasa)'],
            ['kode' => '1509', 'nama_jenis' => 'Pilihan (Pejabat Negara)'],
            ['kode' => '1510', 'nama_jenis' => 'Pilihan (Selama DPK/DPB)'],
            ['kode' => '16', 'nama_jenis' => 'Hukuman Disiplin'],
            ['kode' => '17', 'nama_jenis' => 'Pengabdian'],
        ]);
    }
}
