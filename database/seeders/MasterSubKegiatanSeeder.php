<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSubKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        // Struktur: Program → Kegiatan → Sub Kegiatan
        $data = [
            // PROGRAM 40107 - PROGRAM KEBIJAKAN DAN PELAYANAN PENGADAAN BARANG DAN JASA
            '40107' => [
                '40107103' => [
                    ['kode_sub_kegiatan' => '401071030001', 'nama_sub_kegiatan' => 'Pembinaan Sumber Daya Manusia Pengadaan Barang dan Jasa'],
                    ['kode_sub_kegiatan' => '401071030002', 'nama_sub_kegiatan' => 'Pembinaan Kelembagaan Pengadaan Barang dan Jasa'],
                    ['kode_sub_kegiatan' => '401071030003', 'nama_sub_kegiatan' => 'Pendampingan, Konsultasi, dan/atau Bimbingan Teknis Pengadaan Barang dan Jasa'],
                ],
                '40107102' => [
                    ['kode_sub_kegiatan' => '401071020001', 'nama_sub_kegiatan' => 'Pengelolaan Sistem Pengadaan Secara Elektronik'],
                    ['kode_sub_kegiatan' => '401071020002', 'nama_sub_kegiatan' => 'Pengembangan Sistem Informasi Pengadaan Barang dan Jasa'],
                    ['kode_sub_kegiatan' => '401071020003', 'nama_sub_kegiatan' => 'Pengelolaan Informasi Pengadaan Barang dan Jasa'],
                ],
                '40107101' => [
                    ['kode_sub_kegiatan' => '401071010001', 'nama_sub_kegiatan' => 'Pengelolaan Strategi Pengadaan Barang dan Jasa'],
                    ['kode_sub_kegiatan' => '401071010002', 'nama_sub_kegiatan' => 'Pelaksanaan Pengadaan Barang dan Jasa'],
                    ['kode_sub_kegiatan' => '401071010003', 'nama_sub_kegiatan' => 'Pemantauan dan Evaluasi Pengadaan Barang dan Jasa'],
                ],
            ],

            // PROGRAM 40101 - PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH PROVINSI
            '40101' => [
                '40101101' => [
                    ['kode_sub_kegiatan' => '401011010001', 'nama_sub_kegiatan' => 'Penyusunan Dokumen Perencanaan Perangkat Daerah'],
                    ['kode_sub_kegiatan' => '401011010002', 'nama_sub_kegiatan' => 'Koordinasi dan Penyusunan Dokumen RKA-SKPD'],
                    ['kode_sub_kegiatan' => '401011010003', 'nama_sub_kegiatan' => 'Koordinasi dan Penyusunan Dokumen Perubahan RKA-SKPD'],
                    ['kode_sub_kegiatan' => '401011010004', 'nama_sub_kegiatan' => 'Koordinasi dan Penyusunan DPA-SKPD'],
                    ['kode_sub_kegiatan' => '401011010005', 'nama_sub_kegiatan' => 'Koordinasi dan Penyusunan Perubahan DPA-SKPD'],
                    ['kode_sub_kegiatan' => '401011010006', 'nama_sub_kegiatan' => 'Koordinasi dan Penyusunan Laporan Capaian Kinerja dan Ikhtisar Realisasi Kinerja SKPD'],
                    ['kode_sub_kegiatan' => '401011010007', 'nama_sub_kegiatan' => 'Evaluasi Kinerja Perangkat Daerah'],
                ],
                '40101102' => [
                    ['kode_sub_kegiatan' => '401011020002', 'nama_sub_kegiatan' => 'Penyediaan Administrasi Pelaksanaan Tugas ASN'],
                    ['kode_sub_kegiatan' => '401011020003', 'nama_sub_kegiatan' => 'Pelaksanaan Penatausahaan dan Pengujian/Verifikasi Keuangan SKPD'],
                    ['kode_sub_kegiatan' => '401011020004', 'nama_sub_kegiatan' => 'Koordinasi dan Pelaksanaan Akuntansi SKPD'],
                    ['kode_sub_kegiatan' => '401011020005', 'nama_sub_kegiatan' => 'Koordinasi dan Penyusunan Laporan Keuangan Akhir Tahun SKPD'],
                    ['kode_sub_kegiatan' => '401011020006', 'nama_sub_kegiatan' => 'Pengelolaan dan Penyiapan Bahan Tanggapan Pemeriksaan'],
                    ['kode_sub_kegiatan' => '401011020007', 'nama_sub_kegiatan' => 'Koordinasi dan Penyusunan Laporan Keuangan Bulanan/Triwulanan/Semesteran SKPD'],
                    ['kode_sub_kegiatan' => '401011020008', 'nama_sub_kegiatan' => 'Penyusunan Pelaporan dan Analisis Prognosis Realisasi Anggaran'],
                ],
                '40101103' => [
                    ['kode_sub_kegiatan' => '401011030001', 'nama_sub_kegiatan' => 'Penyusunan Perencanaan Kebutuhan Barang Milik Daerah SKPD'],
                    ['kode_sub_kegiatan' => '401011030003', 'nama_sub_kegiatan' => 'Koordinasi dan Penilaian Barang Milik Daerah SKPD'],
                    ['kode_sub_kegiatan' => '401011030005', 'nama_sub_kegiatan' => 'Rekonsiliasi dan Penyusunan Laporan Barang Milik Daerah pada SKPD'],
                    ['kode_sub_kegiatan' => '401011030006', 'nama_sub_kegiatan' => 'Penatausahaan Barang Milik Daerah pada SKPD'],
                ],
                '40101105' => [
                    ['kode_sub_kegiatan' => '401011050002', 'nama_sub_kegiatan' => 'Pengadaan Pakaian Dinas Beserta Atribut Kelengkapannya'],
                    ['kode_sub_kegiatan' => '401011050003', 'nama_sub_kegiatan' => 'Pendataan dan Pengolahan Administrasi Kepegawaian'],
                    ['kode_sub_kegiatan' => '401011050004', 'nama_sub_kegiatan' => 'Koordinasi dan Pelaksanaan Sistem Informasi Kepegawaian'],
                    ['kode_sub_kegiatan' => '401011050005', 'nama_sub_kegiatan' => 'Monitoring, Evaluasi, dan Penilaian Kinerja Pegawai'],
                    ['kode_sub_kegiatan' => '401011050010', 'nama_sub_kegiatan' => 'Sosialisasi Peraturan Perundang-Undangan'],
                ],
                '40101106' => [
                    ['kode_sub_kegiatan' => '401011060004', 'nama_sub_kegiatan' => 'Penyediaan Bahan Logistik Kantor'],
                    ['kode_sub_kegiatan' => '401011060006', 'nama_sub_kegiatan' => 'Penyediaan Bahan Bacaan dan Peraturan Perundang-Undangan'],
                    ['kode_sub_kegiatan' => '401011060008', 'nama_sub_kegiatan' => 'Fasilitasi Kunjungan Tamu'],
                    ['kode_sub_kegiatan' => '401011060010', 'nama_sub_kegiatan' => 'Penatausahaan Arsip Dinamis pada SKPD'],
                    ['kode_sub_kegiatan' => '401011060011', 'nama_sub_kegiatan' => 'Dukungan Pelaksanaan Sistem Pemerintahan Berbasis Elektronik pada SKPD'],
                ],
                '40101107' => [
                    ['kode_sub_kegiatan' => '401011070006', 'nama_sub_kegiatan' => 'Pengadaan Peralatan dan Mesin Lainnya'],
                ],
                '40101108' => [
                    ['kode_sub_kegiatan' => '401011080001', 'nama_sub_kegiatan' => 'Penyediaan Jasa Surat Menyurat'],
                    ['kode_sub_kegiatan' => '401011080002', 'nama_sub_kegiatan' => 'Penyediaan Jasa Komunikasi, Sumber Daya Air dan Listrik'],
                    ['kode_sub_kegiatan' => '401011080003', 'nama_sub_kegiatan' => 'Penyediaan Jasa Peralatan dan Perlengkapan Kantor'],
                    ['kode_sub_kegiatan' => '401011080004', 'nama_sub_kegiatan' => 'Penyediaan Jasa Pelayanan Umum Kantor'],
                ],
                '40101109' => [
                    ['kode_sub_kegiatan' => '401011090001', 'nama_sub_kegiatan' => 'Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan dan Pajak Kendaraan Perorangan Dinas atau Kendaraan Dinas Jabatan'],
                    ['kode_sub_kegiatan' => '401011090006', 'nama_sub_kegiatan' => 'Pemeliharaan Peralatan dan Mesin Lainnya'],
                    ['kode_sub_kegiatan' => '401011090010', 'nama_sub_kegiatan' => 'Pemeliharaan/Rehabilitasi Sarana dan Prasarana Gedung Kantor atau Bangunan Lainnya'],
                ],
            ],
        ];

        foreach ($data as $kodeProgram => $listKegiatan) {
            $programId = DB::table('t_master_program')
                ->where('kode_program', $kodeProgram)
                ->value('id_program');

            if (!$programId) {
                continue; // skip kalau program belum ada
            }

            foreach ($listKegiatan as $kodeKegiatan => $listSubKegiatan) {
                $kegiatanId = DB::table('t_master_kegiatan')
                    ->where('kode_kegiatan', $kodeKegiatan)
                    ->where('id_program', $programId)
                    ->value('id_kegiatan');

                if (!$kegiatanId) {
                    continue; // skip kalau kegiatan belum ada
                }

                foreach ($listSubKegiatan as $sub) {
                    DB::table('t_master_sub_kegiatan')->insert([
                        'kode_sub_kegiatan' => $sub['kode_sub_kegiatan'],
                        'id_program' => $programId,
                        'id_kegiatan' => $kegiatanId,
                        'nama_sub_kegiatan' => $sub['nama_sub_kegiatan'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
