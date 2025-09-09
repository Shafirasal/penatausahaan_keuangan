<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SshSeeder extends Seeder
{
    public function run(): void
    {
        // Struktur yang diperbaiki
        $data = [
            // PROGRAM 40107 - PROGRAM KEBIJAKAN DAN PELAYANAN PENGADAAN BARANG DAN JASA
            // '40107' => [
            //     '40107103' => [
            //         '401071030001' => [
            //             '510201010025' => [
            //                 ['kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi', 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            '40107' => [
                '40107103' => [
                    '401071030001' => [
                        ['510201010025'  => [
                            'kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi', 'pagu' => 472844, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510201010032'  =>[
                            'kode_ssh' => '11120103000900071', 'nama_ssh' => 'Pakaian Dinas Lapangan ', 'pagu' => 14628000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510201010035'  => [
                            'kode_ssh' => '11120103001200018', 'nama_ssh' => 'Hand Bag', 'pagu' => 31040000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510201010052'  =>[
                            'kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 18480000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 9200000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                        ['510202010026'  =>[
                            'kode_ssh' => '81020201002600012', 'nama_ssh' => 'Honorarium Jasa Tenaga Administrasi', 'pagu' => 168000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020201002600038', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 84000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600072', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 54720000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010047'  =>[
                            'kode_ssh' => '81020201004700018', 'nama_ssh' => 'Jasa Event Organizer', 'pagu' => 71200000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020201004700020', 'nama_ssh' => 'Jasa Event Organizer Pameran/Pelaksanaan Kegiatan ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201004700067', 'nama_ssh' => 'Jasa Event Organizer Pameran/Pelaksanaan Kegiatan', 'pagu' => 50450600, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020005'  =>[
                            'kode_ssh' => '81020202000500053', 'nama_ssh' => '# Iuran Jaminan Kesehatan (BPJS) Non ASN  ', 'pagu' => 7144956, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202020006'  =>[
                            'kode_ssh' => '81020202000600007', 'nama_ssh' => 'Jaminan Kecelakaan Kerja (JKK) Non ASN  ', 'pagu' => 345600, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202020007'  => [
                            'kode_ssh' => '81020202000700007', 'nama_ssh' => 'Jaminan Kematian (JKM) Non ASN', 'pagu' => 432000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202040036'  => [
                            'kode_ssh' => '81020204003600117', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4 ', 'pagu' => 1231000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202120001'  => [
                            'kode_ssh' => '81020213000100017', 'nama_ssh' => 'Beban Kursus Singkat/Pelatihan', 'pagu' => 294400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510204010001' =>[
                            'kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan) ', 'pagu' => 7800000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020204003600056', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di tempat tujuan (yang berada di luar Daerah/Provinsi)', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100128', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I)', 'pagu' => 7326000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100133', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I) ', 'pagu' => 2190000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100226', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP)', 'pagu' => 8022000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100880', 'nama_ssh' => 'Transportasi Darat dari Ibu Kota Provinsi ke Kabupaten/Kota dalam Provinsi yang Sama (One Way) ', 'pagu' => 3648000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota ', 'pagu' => 7380000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100984', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 3180000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                        ['510204010003'  => [
                            'kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam ', 'pagu' => 13600000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                    ],
                    '401071030002' => [
                        ['510201010025'  => [
                            'kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi', 'pagu' => 136200, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510201010032'  => [
                            'kode_ssh' => '11120103000900070', 'nama_ssh' => 'Pakaian Batik', 'pagu' => 5310000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510201010035'  => [
                            'kode_ssh' => '11120103001200063', 'nama_ssh' => 'Tas Souvenir Goodiebag  ', 'pagu' => 37392000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510201010052'  => [
                            'kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 14960000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur  ', 'pagu' => 15840000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 7820000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 16560000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005200004', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005200005', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005300002', 'nama_ssh' => 'Hidangan untuk Tamu Pemerintah Provinsi Jawa Timur', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005300004', 'nama_ssh' => 'Hidangan untuk Tamu Pemerintah Provinsi Jawa Timur', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                        ['510202010003'  => [
                            'kode_ssh' => '81020201000300004', 'nama_ssh' => 'Honorarium Moderator', 'pagu' => 	2100000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020201000300005', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas', 'pagu' => 10800000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020201000300005', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas ', 'pagu' => 14400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020201000300007', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas ', 'pagu' => 4800000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020201000300008', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas  ', 'pagu' => 5600000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020201000300010', 'nama_ssh' => 'Honorarium Pembawa Acara ', 'pagu' => 400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                        ['510202010030'  => [
                            'kode_ssh' => '81020201003000125', 'nama_ssh' => 'Upah Tenaga Kebersihan ', 'pagu' => 1475400, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202010047'  => [
                            'kode_ssh' => '81020201004700066', 'nama_ssh' => 'Jasa Event Organizer', 'pagu' => 40360400, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202040036'  => [
                            'kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4 ', 'pagu' => 14544000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510204010001'  => [
                            'kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan)', 'pagu' => 2600000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            [
                            'kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan)', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            [
                            'kode_ssh' => '81020401000100032', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Kepala Daerah/Wakil Kepala Daerah/Ketua DPRD/Wakil Ketua DPRD/Pejabat Eselon I)', 'pagu' => 8898000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020401000100085', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon III/ Gol. IV) ', 'pagu' => 6918000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100128', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I)', 'pagu' => 16280000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100128', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I) ', 'pagu' => 4884000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100226', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP) ', 'pagu' => 8022000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100485', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP)', 'pagu' => 5466000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100880', 'nama_ssh' => 'Transportasi Darat dari Ibu Kota Provinsi ke Kabupaten/Kota dalam Provinsi yang Sama (One Way) ', 'pagu' => 6840000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 12300000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 3280000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                        ['510204010003'  => 
                            ['kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam  ', 'pagu' => 3000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                        ['520210020003'  => 
                            ['kode_ssh' => '13021002000300042', 'nama_ssh' => 'Printer Inkjet', 'pagu' => 4805000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                    ],
                    '401071030003' => [
                        ['510201010025'  => [
                            'kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi', 'pagu' => 1585444, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510201010032'  => [
                            'kode_ssh' => '11120103000900070', 'nama_ssh' => 'Pakaian Batik ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510201010035'  => [
                            'kode_ssh' => '11120103001200065', 'nama_ssh' => 'Piagam Berpigora ', 'pagu' => 11460000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '11120103001200070', 'nama_ssh' => 'Paket Suvenir VIP', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '11120103001200071', 'nama_ssh' => 'Tas Souvenir', 'pagu' => 52800000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                        ['510201010052'  => [
                            'kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 58080000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 14080000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur ', 'pagu' => 7360000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 30360000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                        ['510202010003'  => [
                            'kode_ssh' => '81020201000300004', 'nama_ssh' => 'Honorarium Moderator ', 'pagu' => 1400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020201000300004', 'nama_ssh' => 'Honorarium Moderator', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300004', 'nama_ssh' => 'Honorarium Moderator', 'pagu' => 2800000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300005', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas', 'pagu' => 3600000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300005', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas ', 'pagu' => 21600000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300008', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300009', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300010', 'nama_ssh' => 'Honorarium Pembawa Acara ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300010', 'nama_ssh' => 'Honorarium Pembawa Acara', 'pagu' => 800000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300011', 'nama_ssh' => 'Honorarium Pembaca Doa', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010026'  => [
                            'kode_ssh' => '81020201002600012', 'nama_ssh' => 'Honorarium Jasa Tenaga Administrasi', 'pagu' => 168000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020201002600038', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 84000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020201002600072', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi ', 'pagu' => 54720000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                        ['510202010030'  => [
                            'kode_ssh' => '81020201003000125', 'nama_ssh' => 'Upah Tenaga Kebersihan ', 'pagu' => 2459000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202010047'  => [
                            'kode_ssh' => '81020201004700066', 'nama_ssh' => 'Jasa Event Organizer', 'pagu' => 40360400, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020201004700076', 'nama_ssh' => 'Jasa Event Organizer Pameran/Pelaksanaan Kegiatan', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010055'  => [
                            'kode_ssh' => '81020201005500137', 'nama_ssh' => 'Publikasi Media Cetak Lokal', 'pagu' => 25225300, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202020005'  => [
                            'kode_ssh' => '81020202000500053', 'nama_ssh' => '# Iuran Jaminan Kesehatan (BPJS) Non ASN', 'pagu' => 7144956, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202020006'  => [
                            'kode_ssh' => '81020202000600007', 'nama_ssh' => 'Jaminan Kecelakaan Kerja (JKK) Non ASN', 'pagu' => 345600, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202020007'  => [
                            'kode_ssh' => '81020202000700007', 'nama_ssh' => 'Jaminan Kematian (JKM) Non ASN', 'pagu' => 432000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202040036'  => [
                            'kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4', 'pagu' => 7272000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202040133'  => [
                            'kode_ssh' => '81020204013300004', 'nama_ssh' => 'Sewa Videotron LED', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510204010001'  => [
                            'kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan)', 'pagu' => 5200000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020401000100032', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Kepala Daerah/Wakil Kepala Daerah/Ketua DPRD/Wakil Ketua DPRD/Pejabat Eselon I)', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100085', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon III/ Gol. IV) ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100128', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I) ', 'pagu' => 14652000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100133', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I) ', 'pagu' => 4380000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100226', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP) ', 'pagu' => 16044000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100226', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP)', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100485', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP)', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100880', 'nama_ssh' => 'Transportasi Darat dari Ibu Kota Provinsi ke Kabupaten/Kota dalam Provinsi yang Sama (One Way)', 'pagu' => 13680000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100880', 'nama_ssh' => 'Transportasi Darat dari Ibu Kota Provinsi ke Kabupaten/Kota dalam Provinsi yang Sama (One Way) ', 'pagu' => 13680000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 24600000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 7380000	, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100984', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota ', 'pagu' => 6360000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100990', 'nama_ssh' => 'Uang Harian yang diberikan kepada masyarakat yang mendukung kegiatan pemerintahan dan pembangunan ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000101188', 'nama_ssh' => '# Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I)', 'pagu' => 26560000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010003'  => 
                            ['kode_ssh' => '81020401000300337', 'nama_ssh' => 'Transport Peserta Pelatihan', 'pagu' => 68500, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            [
                            'kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam', 'pagu' => 1000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510204010004'  => [
                            'kode_ssh' => '81020401000101061', 'nama_ssh' => 'Biaya Paket Meeting Dalam Provinsi - Eselon II ke bawah ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            [
                            'kode_ssh' => '81020401000400043', 'nama_ssh' => 'Uang Harian Kegiatan Rapat Atau Pertemuan Di Luar Kantor Provinsi Jawa Timu', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['520210010002'  => 
                            ['kode_ssh' => '13021001000200001', 'nama_ssh' => 'Komputer / PC', 'pagu' => 17436000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                    ],
                ],
                '40107102' => [
                    '401071020001' => [
                        ['510201010025'  => [
                            'kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi', 'pagu' => 163296, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510201010032'  => [
                            'kode_ssh' => '11120103000900151', 'nama_ssh' => 'Pakaian Dinas Lapangan', 'pagu' => 10575000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510201010035'  => [
                            'kode_ssh' => '11120103001300425', 'nama_ssh' => 'Tas', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510201010052'  => [
                            'kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur ', 'pagu' => 6688000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            [
                            'kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 6380000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            [
                            'kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur ', 'pagu' => 6688000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            [
                            'kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 6688000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            [
                            'kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 19360000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 6688000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 6688000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 3496000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 3335000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 3496000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 3496000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur ', 'pagu' => 3496000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur ', 'pagu' => 9660000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 3496000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005300002', 'nama_ssh' => 'Hidangan untuk Tamu Pemerintah Provinsi Jawa Timur', 'pagu' => 1400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005300004', 'nama_ssh' => 'Hidangan untuk Tamu Pemerintah Provinsi Jawa Timur', 'pagu' => 6000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010003'  => 
                            ['kode_ssh' => '81020201000300004', 'nama_ssh' => 'Honorarium Moderator ', 'pagu' => 700000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300005', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas', 'pagu' => 13500000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300010', 'nama_ssh' => 'Honorarium Pembawa Acara ', 'pagu' => 400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010026'  => 
                            ['kode_ssh' => '81020201002600012', 'nama_ssh' => 'Honorarium Jasa Tenaga Administrasi', 'pagu' => 112000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600038', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi ', 'pagu' => 56000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600072', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi ', 'pagu' => 36480000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010047'  => 
                            ['kode_ssh' => '81020201004700005', 'nama_ssh' => 'Jasa Dekorasi Kegiatan/Pameran/Promosi/Ekshibishi', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020005'  => 
                            ['kode_ssh' => '81020202000500053', 'nama_ssh' => '# Iuran Jaminan Kesehatan (BPJS) Non ASN ', 'pagu' => 4763304, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020006'  => [
                            'kode_ssh' => '81020202000600007', 'nama_ssh' => 'Jaminan Kecelakaan Kerja (JKK) Non ASN ', 'pagu' => 230400, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202020007'  => [
                            'kode_ssh' => '81020202000700007', 'nama_ssh' => 'Jaminan Kematian (JKM) Non ASN ', 'pagu' => 288000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202040036'  => [
                            'kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510202040133'  => [
                            'kode_ssh' => '81020204013300002', 'nama_ssh' => 'Sewa Videotron LED', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510203020410'  => [
                            'kode_ssh' => '81020302041000006', 'nama_ssh' => 'Biaya Pemeliharaan Jaringan Server', 'pagu' => 14985000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020302041000020', 'nama_ssh' => 'Pemeliharaan jaringan', 'pagu' => 33600000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                        ['510203060005'  => [
                            'kode_ssh' => '81020306000500008', 'nama_ssh' => 'Pemeliharaan Aplikasi', 'pagu' => 50000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510204010001'  => [
                            'kode_ssh' => '81020204003600047', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas dari tempat kedudukan ke tempat tujuan (yang berada di luar Daerah/Provinsi)', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                            ['kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan) ', 'pagu' => 11700000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100133', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I) ', 'pagu' => 1460000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100226', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP)', 'pagu' => 5348000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100880', 'nama_ssh' => 'Transportasi Darat dari Ibu Kota Provinsi ke Kabupaten/Kota dalam Provinsi yang Sama (One Way)', 'pagu' => 3648000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 14760000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000100984', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 2120000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                            ['kode_ssh' => '81020401000101048', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Gol. I/II) ', 'pagu' => 11952000, 'pagu2' => 999.999, 'tahun' => '2025-01-01'],
                        ],
                        ['510204010003'  => [
                            'kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam ', 'pagu' => 5000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['510204010005'  => [
                            'kode_ssh' => '81020401000101063', 'nama_ssh' => 'Biaya Paket Meeting Dalam Provinsi - Eselon II ke bawah ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                        ['520210010002'  => [
                            'kode_ssh' => '13021001000200001', 'nama_ssh' => 'Komputer / PC', 'pagu' => 87180000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' 
                            ],
                        ],
                    ],
                    '401071020002' => [
                        ['510201010025'  => 
                            ['kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi ', 'pagu' => 360496, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010031'  => 
                            ['kode_ssh' => '11120103000800091', 'nama_ssh' => 'Connector Rj45', 'pagu' => 1200000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010035'  => 
                            ['kode_ssh' => '11120103001300344', 'nama_ssh' => 'Tas Selempang', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010052'  => 
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 38720000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur ', 'pagu' => 19320000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005300002', 'nama_ssh' => 'Hidangan untuk Tamu Pemerintah Provinsi Jawa Timur', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005300004', 'nama_ssh' => 'Hidangan untuk Tamu Pemerintah Provinsi Jawa Timur', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010003'  => 
                            ['kode_ssh' => '81020201000300004', 'nama_ssh' => 'Honorarium Moderator', 'pagu' => 700000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300005', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas', 'pagu' => 10800000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300010', 'nama_ssh' => 'Honorarium Pembawa Acara', 'pagu' => 400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010026'  => 
                            ['kode_ssh' => '81020201002600012', 'nama_ssh' => 'Honorarium Jasa Tenaga Administrasi ', 'pagu' => 112000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600038', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 56000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600072', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 36480000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010047'  =>  
                            ['kode_ssh' => '81020201004700054', 'nama_ssh' => 'Jasa Dekorasi Kegiatan/Pameran/Promosi/Ekshibishi ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010063'  =>  
                            ['kode_ssh' => '81020201006300130', 'nama_ssh' => 'Langganan Layanan Chat Blast', 'pagu' => 89836800, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020005'  =>  
                            ['kode_ssh' => '81020202000500053', 'nama_ssh' => '# Iuran Jaminan Kesehatan (BPJS) Non ASN', 'pagu' => 4763304, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020006'  =>  
                            ['kode_ssh' => '81020202000600007', 'nama_ssh' => 'Jaminan Kecelakaan Kerja (JKK) Non ASN ', 'pagu' => 230400, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020007'  =>  
                            ['kode_ssh' => '81020202000700007', 'nama_ssh' => 'Jaminan Kematian (JKM) Non ASN', 'pagu' => 288000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202040036'  =>  
                            ['kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4', 'pagu' => 2462000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4 ', 'pagu' => 9696000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202040133'  =>  
                            ['kode_ssh' => '81020204013300002', 'nama_ssh' => 'Sewa Videotron LED', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510203020410'  =>  
                            ['kode_ssh' => '81020302041000006', 'nama_ssh' => 'Biaya Pemeliharaan Jaringan Server', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510203060005'  =>  
                            ['kode_ssh' => '81020306000500008', 'nama_ssh' => 'Pemeliharaan Aplikasi', 'pagu' => 50000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010001'  =>  
                            ['kode_ssh' => '81020204003600047', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas dari tempat kedudukan ke tempat tujuan (yang berada di luar Daerah/Provinsi) ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan) ', 'pagu' => 13000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100133', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I)', 'pagu' => 2190000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100226', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP)', 'pagu' => 8022000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100880', 'nama_ssh' => 'Transportasi Darat dari Ibu Kota Provinsi ke Kabupaten/Kota dalam Provinsi yang Sama (One Way) ', 'pagu' => 5472000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota ', 'pagu' => 19680000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100984', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 3180000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000101048', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Gol. I/II)', 'pagu' => 11952000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010003'  =>  
                            ['kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam ', 'pagu' => 8400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010005'  =>  
                            ['kode_ssh' => '81020401000101063', 'nama_ssh' => 'Biaya Paket Meeting Dalam Provinsi - Eselon II ke bawah', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['520205020006'  =>  
                            ['kode_ssh' => '13020502000600019', 'nama_ssh' => 'UPS', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '13020502000600146', 'nama_ssh' => 'Ups', 'pagu' => 21446000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['520210010001'  =>  
                            ['kode_ssh' => '13021001000100002', 'nama_ssh' => 'Server', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['520210010002'  =>  
                            ['kode_ssh' => '13021001000200001', 'nama_ssh' => 'Komputer / PC ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '13021001000200001', 'nama_ssh' => 'Komputer / PC ', 'pagu' => 87180000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '13021001000200005', 'nama_ssh' => 'Laptop ', 'pagu' => 17676000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['520210020004'  =>  
                            ['kode_ssh' => '13021002000400018', 'nama_ssh' => 'Kabel Jaringan', 'pagu' => 2585000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                    ],
                    '401071020003' => [
                        ['510201010025'  =>  
                            ['kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi', 'pagu' => 24296, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010052'  =>  
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 32560000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 17020000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010026'  =>  
                            ['kode_ssh' => '81020201002600012', 'nama_ssh' => 'Honorarium Jasa Tenaga Administrasi', 'pagu' => 112000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600038', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi ', 'pagu' => 56000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600072', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi ', 'pagu' => 36480000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020005'  =>  
                            ['kode_ssh' => '81020202000500053', 'nama_ssh' => '# Iuran Jaminan Kesehatan (BPJS) Non ASN', 'pagu' => 4763304, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020006'  =>  
                            ['kode_ssh' => '81020202000600007', 'nama_ssh' => 'Jaminan Kecelakaan Kerja (JKK) Non ASN ', 'pagu' => 230400, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020007'  =>  
                            ['kode_ssh' => '81020202000700007', 'nama_ssh' => 'Jaminan Kematian (JKM) Non ASN', 'pagu' => 288000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202040036'  =>  
                            ['kode_ssh' => '81020204003600117', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4 ', 'pagu' => 2462000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010001'  =>  
                            ['kode_ssh' => '81020204003600047', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas dari tempat kedudukan ke tempat tujuan (yang berada di luar Daerah/Provinsi) ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan) ', 'pagu' => 27300000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100133', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I)', 'pagu' => 2190000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100226', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP) ', 'pagu' => 8022000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100873', 'nama_ssh' => 'Transportasi Darat dari Ibu Kota Provinsi ke Kabupaten/Kota dalam Provinsi yang Sama (One Way)', 'pagu' => 3600000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100883', 'nama_ssh' => 'Transportasi Darat dari Ibu Kota Provinsi ke Kabupaten/Kota dalam Provinsi yang Sama (One Way) ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota ', 'pagu' => 25830000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100984', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 3180000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000101048', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Gol. I/II)', 'pagu' => 23904000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010003'  =>  
                            ['kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam ', 'pagu' => 12800000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['520210010002'  =>  
                            ['kode_ssh' => '13021001000200001', 'nama_ssh' => 'Komputer / PC ', 'pagu' => 34872000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                    ],
                ],
                '40107101' => [
                    '401071010001' => [
                        ['510201010025'  =>  
                            ['kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi ', 'pagu' => 688796, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010029'  =>  
                            ['kode_ssh' => '11120103000600010', 'nama_ssh' => 'Flashdisk', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010032'  =>  
                            ['kode_ssh' => 'Pakaian Dinas Lapangan', 'nama_ssh' => 999.999, 'pagu' => 6338800, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010035'  =>  
                            ['kode_ssh' => '11120103001300425', 'nama_ssh' => 'Tas', 'pagu' => 29029000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010052'  =>  
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur ', 'pagu' => 11440000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 21120000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 11040000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 8970000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200004', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 1040000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200005', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 1560000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010003'  =>  
                            ['kode_ssh' => '81020201000300004', 'nama_ssh' => 'Honorarium Moderator', 'pagu' => 2100000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300006', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas', 'pagu' => 6000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300006', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas ', 'pagu' => 12000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300010', 'nama_ssh' => 'Honorarium Pembawa Acara', 'pagu' => 400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010026'  =>  
                            ['kode_ssh' => '81020201002600012', 'nama_ssh' => 'Honorarium Jasa Tenaga Administrasi', 'pagu' => 112000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600038', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 56000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600072', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi ', 'pagu' => 36480000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010029'  =>  
                            ['kode_ssh' => '81020201002900090', 'nama_ssh' => 'Tenaga Ahli Individual ', 'pagu' => 14450000	, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002900101', 'nama_ssh' => 'Tenaga Ahli Individual', 'pagu' => 8115000	, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010047'  =>  
                            ['kode_ssh' => '81020201004700025', 'nama_ssh' => 'Jasa Event Organizer Pameran/Pelaksanaan Kegiatan ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201004700072', 'nama_ssh' => 'Jasa Event Organizer Pameran/Pelaksanaan Kegiatan', 'pagu' => 50450500, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010064'  =>  
                            ['kode_ssh' => '81020201006400030', 'nama_ssh' => 'Pengiriman paket Lokal Provinsi Jatim', 'pagu' => 712000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020005'  =>  
                            ['kode_ssh' => '81020202000500053', 'nama_ssh' => '# Iuran Jaminan Kesehatan (BPJS) Non ASN', 'pagu' => 4763304	, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020006'  =>  
                            ['kode_ssh' => '81020202000600007', 'nama_ssh' => 'Jaminan Kecelakaan Kerja (JKK) Non ASN', 'pagu' => 230400, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020007'  =>   
                            ['kode_ssh' => '81020202000700007', 'nama_ssh' => 'Jaminan Kematian (JKM) Non ASN', 'pagu' => 288000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202040036'  =>   
                            ['kode_ssh' => '81020204003600117', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4 ', 'pagu' => 2462000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4 ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4 ', 'pagu' => 4848000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010001'  =>   
                            ['kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan)', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan) ', 'pagu' => 10400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600056', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di tempat tujuan (yang berada di luar Daerah/Provinsi) ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100077', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon III/ Gol. IV) ', 'pagu' => 3968000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100085', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon III/ Gol. IV) ', 'pagu' => 4612000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100085', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon III/ Gol. IV) ', 'pagu' => 17295000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100128', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I)', 'pagu' => 7326000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100227', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP) ', 'pagu' => 10696000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100227', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP) ', 'pagu' => 5348000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100880', 'nama_ssh' => 'Transportasi Darat dari Ibu Kota Provinsi ke Kabupaten/Kota dalam Provinsi yang Sama (One Way)', 'pagu' => 10944000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota ', 'pagu' => 12300000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 10660000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100984', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota ', 'pagu' => 4240000	, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010003'  =>   
                            ['kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam ', 'pagu' => 6000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['520210010002'  =>   
                            ['kode_ssh' => '13021001000200012', 'nama_ssh' => 'Tablet PC ', 'pagu' => 10005000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '13021001000200034', 'nama_ssh' => 'Laptop', 'pagu' => 38466000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['520210020003'  =>   
                            ['kode_ssh' => '13021002000300004', 'nama_ssh' => 'Printer Laserjet Warna ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '13021002000300042', 'nama_ssh' => 'Printer Inkjet', 'pagu' => 9610000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                    ],
                    '401071010002' => [
                        ['510201010025'  =>   
                            ['kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi', 'pagu' => 1142796, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010029'  =>   
                            ['kode_ssh' => '11120103000600010', 'nama_ssh' => 'Flashdisk', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010032'  =>   
                            ['kode_ssh' => '11120103000900071', 'nama_ssh' => 'Pakaian Dinas Lapangan', 'pagu' => 6338800, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010035'  =>   
                            ['kode_ssh' => '11120103001300425', 'nama_ssh' => 'Tas', 'pagu' => 29029000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010052'  =>   
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 11440000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 26400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 14260000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 8970000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200004', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 2080000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020101005200005', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 1560000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010003'  =>   
                            ['kode_ssh' => '81020201000300004', 'nama_ssh' => 'Honorarium Moderator', 'pagu' => 2100000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300006', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas', 'pagu' => 12000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300006', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas', 'pagu' => 6000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300010', 'nama_ssh' => 'Honorarium Pembawa Acara', 'pagu' => 400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010026'  =>   
                            ['kode_ssh' => '81020201002600038', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 56000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600072', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 36480000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010047'  =>   
                            ['kode_ssh' => '81020201004700072', 'nama_ssh' => 'Jasa Event Organizer Pameran/Pelaksanaan Kegiatan', 'pagu' => 50450500, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010064'  =>   
                            ['kode_ssh' => '81020201006400030', 'nama_ssh' => 'Pengiriman paket Lokal Provinsi Jatim', 'pagu' => 1068000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010081'  =>   
                            ['kode_ssh' => '81010307000200006', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Konstruksi', 'pagu' => 6120000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200007', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Konstruksi', 'pagu' => 7620000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200008', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Konstruksi', 'pagu' => 9120000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200009', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Konstruksi', 'pagu' => 21360000	, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200010', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Konstruksi', 'pagu' => 38160000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200011', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Konstruksi', 'pagu' => 29400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200012', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Konstruksi', 'pagu' => 33480000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200013', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Konstruksi', 'pagu' => 18780000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200014', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Konstruksi', 'pagu' => 21480000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200020', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Pengadaan Barang', 'pagu' => 11040000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200021', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Pengadaan Barang', 'pagu' => 13680000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200022', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Pengadaan Barang', 'pagu' => 8220000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200023', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Pengadaan Barang', 'pagu' => 9600000	, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200033', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Jasa Konsultansi', 'pagu' => 28800000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200034', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Jasa Konsultansi', 'pagu' => 57600000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200035', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Jasa Konsultansi', 'pagu' => 47520000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200036', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Jasa Konsultansi', 'pagu' => 32760000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81010307000200037', 'nama_ssh' => 'Honorarium Kelompok Kerja Pemilihan Unit Kerja Pengadaan Jasa Konsultansi', 'pagu' => 6540000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020005'  =>   
                            ['kode_ssh' => '81020202000500053', 'nama_ssh' => '# Iuran Jaminan Kesehatan (BPJS) Non ASN', 'pagu' => 4763304, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020006'  =>   
                            ['kode_ssh' => '81020202000600007', 'nama_ssh' => 'Jaminan Kecelakaan Kerja (JKK) Non ASN', 'pagu' => 230400, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020007'  =>   
                            ['kode_ssh' => '81020202000700007', 'nama_ssh' => 'Jaminan Kematian (JKM) Non ASN', 'pagu' => 288000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202040036'  =>   
                            ['kode_ssh' => '81020204003600117', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4', 'pagu' => 4924000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4', 'pagu' => 4848000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4 ', 'pagu' => 4848000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010001'  =>   
                            ['kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan)', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan)', 'pagu' => 10400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600056', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di tempat tujuan (yang berada di luar Daerah/Provinsi)', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100077', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon III/ Gol. IV)', 'pagu' => 7936000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100085', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon III/ Gol. IV)', 'pagu' => 38049000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100085', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon III/ Gol. IV)', 'pagu' => 4612000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100128', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I)', 'pagu' => 7326000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100227', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP) ', 'pagu' => 5348000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100227', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP)', 'pagu' => 21392000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100880', 'nama_ssh' => 'Transportasi Darat dari Ibu Kota Provinsi ke Kabupaten/Kota dalam Provinsi yang Sama (One Way)', 'pagu' => 14592000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota ', 'pagu' => 10660000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 27060000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100984', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota ', 'pagu' => 8480000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010003'  =>   
                            ['kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam', 'pagu' => 5000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                    ],
                    '401071010003' => [
                        ['510201010025'  =>   
                            ['kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi', 'pagu' => 508296, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010029'  =>   
                            ['kode_ssh' => '11120103000600010', 'nama_ssh' => 'Flashdisk ', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010032'  =>   
                            ['kode_ssh' => '11120103000900071', 'nama_ssh' => 'Pakaian Dinas Lapangan', 'pagu' => 6338800, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010035'  =>   
                            ['kode_ssh' => '11120103001300425', 'nama_ssh' => 'Tas', 'pagu' => 29029000	, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510201010052'  =>   
                            ['kode_ssh' => 999.999, 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 11440000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => 999.999, 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 15840000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => 999.999, 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 8280000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => 999.999, 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 8970000	, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => 999.999, 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 2080000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => 999.999, 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu' => 1560000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010003'  =>   
                            ['kode_ssh' => '81020201000300004', 'nama_ssh' => 'Honorarium Moderator', 'pagu' => 2100000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300006', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas', 'pagu' => 4000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300006', 'nama_ssh' => 'Honorarium Narasumber atau Pembahas', 'pagu' => 12000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201000300010', 'nama_ssh' => 'Honorarium Pembawa Acara', 'pagu' => 400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010026'  =>   
                            ['kode_ssh' => '81020201002600012', 'nama_ssh' => 'Honorarium Jasa Tenaga Administrasi', 'pagu' => 112000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600038', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 56000000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002600072', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu' => 36480000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010029'  =>   
                            ['kode_ssh' => '81020201002900090', 'nama_ssh' => 'Tenaga Ahli Individual  ', 'pagu' => 14450000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020201002900101', 'nama_ssh' => 'Tenaga Ahli Individual', 'pagu' => 8115000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202010047'  =>   
                            ['kode_ssh' => '81020201004700072', 'nama_ssh' => 'Jasa Event Organizer Pameran/Pelaksanaan Kegiatan ', 'pagu' => 50450500	, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020005'  =>   
                            ['kode_ssh' => '81020202000500053', 'nama_ssh' => '# Iuran Jaminan Kesehatan (BPJS) Non ASN ', 'pagu' => 4763304	, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020006'  =>   
                            ['kode_ssh' => '81020202000600007', 'nama_ssh' => 'Jaminan Kecelakaan Kerja (JKK) Non ASN', 'pagu' => 230400, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202020007'  =>   
                            ['kode_ssh' => '81020202000700007', 'nama_ssh' => 'Jaminan Kematian (JKM) Non ASN', 'pagu' => 288000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510202040036'  =>   
                            ['kode_ssh' => '81020204003600117', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4', 'pagu' => 2462000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4 ', 'pagu' => 2424000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600120', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4', 'pagu' => 7272000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510203060005'  =>   
                            ['kode_ssh' => '81020306000500007', 'nama_ssh' => 'Pemeliharaan Aplikasi', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010001'  =>   
                            ['kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan) ', 'pagu' => 7800000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600052', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di dalam Daerah/Provinsi (dari tempat kedudukan sampai tempat tujuan)', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020204003600056', 'nama_ssh' => 'Sewa Kendaraan Perjalanan Dinas di tempat tujuan (yang berada di luar Daerah/Provinsi)', 'pagu' => 0, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100077', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon III/ Gol. IV) ', 'pagu' => 2976000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100085', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon III/ Gol. IV)', 'pagu' => 4612000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100085', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon III/ Gol. IV) ', 'pagu' => 24213000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100128', 'nama_ssh' => 'Penginapan Perjalanan Dinas Dalam Negeri (Pejabat Eselon IV / Gol.ongan III, II, dan I) ', 'pagu' => 7326000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100227', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP) ', 'pagu' => 5348000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100227', 'nama_ssh' => 'Tiket Pesawat Perjalanan Dinas Dalam Negeri Pergi Pulang (PP)', 'pagu' => 8022000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100880', 'nama_ssh' => 'Transportasi Darat dari Ibu Kota Provinsi ke Kabupaten/Kota dalam Provinsi yang Sama (One Way)', 'pagu' => 5472000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 10660000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100972', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 17220000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                            ['kode_ssh' => '81020401000100984', 'nama_ssh' => 'Uang Harian Perjalanan Dinas - Luar Kota', 'pagu' => 3180000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['510204010003'  =>   
                            ['kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam', 'pagu' => 3400000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['520210010002'  =>   
                            ['kode_ssh' => '13021001000200006', 'nama_ssh' => 'Laptop ', 'pagu' => 26304000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                        ['520210020003'  =>   
                            ['kode_ssh' => '13021002000300042', 'nama_ssh' => 'Printer Inkjet ', 'pagu' => 9610000, 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
                        ],
                    ],
                ],
            ],

            // PROGRAM 40101 - PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH PROVINSI
            // '40101' => [
            //     '40101101' => [
            //         '401011010001' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010001'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011010002' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011010003' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011010004' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011010005' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052' =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011010006' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011010007' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //     ],
            //     '40101102' => [
            //         '401011020002' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010026'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010080'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010081'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202020005'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202020006'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202020007'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202040036' =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202120004'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010001'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010004'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010005'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011020003' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011020004' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011020005' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011020006' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011020007' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011020008' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //     ],
            //     '40101103' => [
            //         '401011030001' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011030003' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011030005' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011030006' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //     ],
            //     '40101105' => [
            //         '401011050002' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010032'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010034'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010061'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010065'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011050003' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052' =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011050004' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011050005' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010032'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010047'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010005'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011050010' => [
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //     ],
            //     '40101106' => [
            //         '401011060004' => [
            //             ['510201010024'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010027'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010029'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010036'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011060006' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010062'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011060008' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011060010' => [
            //             ['510201010024'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['520205010004'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011060011' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010052'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510204010003'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //     ],
            //     '40101107' => [
            //         '401011070006' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010029'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['520205010005'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['520205020001'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['520205020006'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['520210010002'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //     ],
            //     '40101108' => [
            //         '401011080001' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010064'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011080002' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010063'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011080003' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010029'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011080004' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510201010035'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010028'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010033'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010036'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202040035'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202070057'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202090014'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202150005'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //     ],
            //     '40101109' => [
            //         '401011090001' => [
            //             ['510201010004'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510202010067'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510203020035'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510203020036'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011090006' => [
            //             ['510201010025'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510203020121'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510203020405'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //             ['510203020409'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //         '401011090010' => [
            //             ['510203030001'  =>   
            //                 ['kode_ssh' => 999.999, 'nama_ssh' => 999.999, 'pagu' => '2025-01-01', 'pagu2' => 999.999, 'tahun' => '2025-01-01' ],
            //             ],
            //         ],
            //     ],
            // ],
        ];

        $insertedCount = 0;
        $skippedCount = 0;

        foreach ($data as $kodeProgram => $listKegiatan) {
            echo "Processing Program: $kodeProgram\n";
            
            $programId = DB::table('t_master_program')
                ->where('kode_program', $kodeProgram)
                ->value('id_program');

            if (!$programId) {
                echo "❌ Program $kodeProgram tidak ditemukan\n";
                continue;
            }
            echo "✅ Program ID: $programId\n";

            foreach ($listKegiatan as $kodeKegiatan => $listSubKegiatan) {
                echo "  Processing Kegiatan: $kodeKegiatan\n";
                
                $kegiatanId = DB::table('t_master_kegiatan')
                    ->where('kode_kegiatan', $kodeKegiatan)
                    ->where('id_program', $programId)
                    ->value('id_kegiatan');

                if (!$kegiatanId) {
                    echo "  ❌ Kegiatan $kodeKegiatan tidak ditemukan\n";
                    continue;
                }
                echo "  ✅ Kegiatan ID: $kegiatanId\n";

                foreach ($listSubKegiatan as $kodeSubKegiatan => $listRekening) {
                    echo "    Processing Sub Kegiatan: $kodeSubKegiatan\n";
                    
                    $subKegiatanId = DB::table('t_master_sub_kegiatan')
                        ->where('kode_sub_kegiatan', $kodeSubKegiatan)
                        ->where('id_program', $programId)
                        ->where('id_kegiatan', $kegiatanId)
                        ->value('id_sub_kegiatan');

                    if (!$subKegiatanId) {
                        echo "    ❌ Sub Kegiatan $kodeSubKegiatan tidak ditemukan\n";
                        continue;
                    }
                    echo "    ✅ Sub Kegiatan ID: $subKegiatanId\n";

                    foreach ($listRekening as $kodeRekening => $listSsh) {
                        echo "      Processing Rekening: $kodeRekening\n";
                        
                        $rekeningId = DB::table('t_rekening')
                            ->where('kode_rekening', $kodeRekening)
                            ->where('id_program', $programId)
                            ->where('id_kegiatan', $kegiatanId)
                            ->where('id_sub_kegiatan', $subKegiatanId)
                            ->value('id_rekening');

                        if (!$rekeningId) {
                            echo "      ❌ Rekening $kodeRekening tidak ditemukan\n";
                            continue;
                        }
                        echo "      ✅ Rekening ID: $rekeningId\n";

                        foreach ($listSsh as $ssh) {
                            echo "        Processing SSH: {$ssh['kode_ssh']}\n";
                            
                            // Cek apakah SSH sudah ada
                            $existingSsh = DB::table('t_ssh')
                                ->where('kode_ssh', $ssh['kode_ssh'])
                                ->where('id_program', $programId)
                                ->where('id_kegiatan', $kegiatanId)
                                ->where('id_sub_kegiatan', $subKegiatanId)
                                ->where('id_rekening', $rekeningId)
                                ->exists();

                            if ($existingSsh) {
                                echo "        ⏭️  SSH {$ssh['kode_ssh']} sudah ada, skip\n";
                                $skippedCount++;
                                continue;
                            }

                            try {
                                DB::table('t_ssh')->insert([
                                    'kode_ssh' => $ssh['kode_ssh'],
                                    'id_program' => $programId,
                                    'id_kegiatan' => $kegiatanId,
                                    'id_sub_kegiatan' => $subKegiatanId,
                                    'id_rekening' => $rekeningId,
                                    'nama_ssh' => $ssh['nama_ssh'],
                                    'pagu1' => $ssh['pagu1'],
                                    'pagu2' => $ssh['pagu2'],
                                    'tahun' => $ssh['tahun'],
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                                
                                echo "        ✅ SSH {$ssh['kode_ssh']} berhasil disimpan\n";
                                $insertedCount++;
                                
                            } catch (\Exception $e) {
                                echo "        ❌ Error inserting SSH {$ssh['kode_ssh']}: " . $e->getMessage() . "\n";
                            }
                        }
                    }
                }
            }
        }

        echo "\n=== SUMMARY ===\n";
        echo "Data berhasil disimpan: $insertedCount\n";
        echo "Data di-skip: $skippedCount\n";
        echo "Total: " . ($insertedCount + $skippedCount) . "\n";
    }
}