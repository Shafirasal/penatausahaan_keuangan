<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RekeningSeeder extends Seeder
{
    public function run(): void
    {
        // Struktur: Program → Kegiatan → Sub Kegiatan → Rekening
        $data = [
            // PROGRAM 40107 - PROGRAM KEBIJAKAN DAN PELAYANAN PENGADAAN BARANG DAN JASA
            '40107' => [
                '40107103' => [
                    '401071030001' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010032', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Dinas'],
                        ['kode_rekening' => '510201010035', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Suvenir/Cendera Mata'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010026', 'nama_rekening' => 'Belanja Jasa Tenaga Administrasi'],
                        ['kode_rekening' => '510202010047', 'nama_rekening' => 'Belanja Jasa Penyelenggaraan Acara'],
                        ['kode_rekening' => '510202020005', 'nama_rekening' => 'Belanja Iuran Jaminan Kesehatan bagi Non ASN'],
                        ['kode_rekening' => '510202020006', 'nama_rekening' => 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN'],
                        ['kode_rekening' => '510202020007', 'nama_rekening' => 'Belanja Iuran Jaminan Kematian bagi Non ASN'],
                        ['kode_rekening' => '510202040036', 'nama_rekening' => 'Belanja Sewa Kendaraan Bermotor Penumpang'],
                        ['kode_rekening' => '510202120001', 'nama_rekening' => 'Belanja Kursus Singkat/Pelatihan'],
                        ['kode_rekening' => '510204010001', 'nama_rekening' => 'Belanja Perjalanan Dinas Biasa'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                    ],
                    '401071030002' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010032', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Dinas'],
                        ['kode_rekening' => '510201010035', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Suvenir/Cendera Mata'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010003', 'nama_rekening' => 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
                        ['kode_rekening' => '510202010030', 'nama_rekening' => 'Belanja Jasa Tenaga Kebersihan'],
                        ['kode_rekening' => '510202010047', 'nama_rekening' => 'Belanja Jasa Penyelenggaraan Acara'],
                        ['kode_rekening' => '510202040036', 'nama_rekening' => 'Belanja Sewa Kendaraan Bermotor Penumpang'],
                        ['kode_rekening' => '510204010001', 'nama_rekening' => 'Belanja Perjalanan Dinas Biasa'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                        ['kode_rekening' => '520210020003', 'nama_rekening' => 'Belanja Modal Peralatan Personal Computer'],
                    ],
                    '401071030003' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010032', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Dinas'],
                        ['kode_rekening' => '510201010035', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Suvenir/Cendera Mata'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010003', 'nama_rekening' => 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
                        ['kode_rekening' => '510202010026', 'nama_rekening' => 'Belanja Jasa Tenaga Administrasi'],
                        ['kode_rekening' => '510202010030', 'nama_rekening' => 'Belanja Jasa Tenaga Kebersihan'],
                        ['kode_rekening' => '510202010047', 'nama_rekening' => 'Belanja Jasa Penyelenggaraan Acara'],
                        ['kode_rekening' => '510202010055', 'nama_rekening' => 'Belanja Jasa Iklan/Reklame, Film, dan Pemotretan'],
                        ['kode_rekening' => '510202020005', 'nama_rekening' => 'Belanja Iuran Jaminan Kesehatan bagi Non ASN'],
                        ['kode_rekening' => '510202020006', 'nama_rekening' => 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN'],
                        ['kode_rekening' => '510202020007', 'nama_rekening' => 'Belanja Iuran Jaminan Kematian bagi Non ASN'],
                        ['kode_rekening' => '510202040036', 'nama_rekening' => 'Belanja Sewa Kendaraan Bermotor Penumpang'],
                        ['kode_rekening' => '510202040133', 'nama_rekening' => 'Belanja Sewa Peralatan Studio Video dan Film'],
                        ['kode_rekening' => '510204010001', 'nama_rekening' => 'Belanja Perjalanan Dinas Biasa'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                        ['kode_rekening' => '510204010004', 'nama_rekening' => 'Belanja Perjalanan Dinas Paket Meeting Dalam Kota'],
                        ['kode_rekening' => '520210010002', 'nama_rekening' => 'Belanja Modal Personal Computer'],
                    ],
                ],
                '40107102' => [
                    '401071020001' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010032', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Dinas'],
                        ['kode_rekening' => '510201010035', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Suvenir/Cendera Mata'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010003', 'nama_rekening' => 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
                        ['kode_rekening' => '510202010026', 'nama_rekening' => 'Belanja Jasa Tenaga Administrasi'],
                        ['kode_rekening' => '510202010047', 'nama_rekening' => 'Belanja Jasa Penyelenggaraan Acara'],
                        ['kode_rekening' => '510202020005', 'nama_rekening' => 'Belanja Iuran Jaminan Kesehatan bagi Non ASN'],
                        ['kode_rekening' => '510202020006', 'nama_rekening' => 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN'],
                        ['kode_rekening' => '510202020007', 'nama_rekening' => 'Belanja Iuran Jaminan Kematian bagi Non ASN'],
                        ['kode_rekening' => '510202040036', 'nama_rekening' => 'Belanja Sewa Kendaraan Bermotor Penumpang'],
                        ['kode_rekening' => '510202040133', 'nama_rekening' => 'Belanja Sewa Peralatan Studio Video dan Film'],
                        ['kode_rekening' => '510203020410', 'nama_rekening' => 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Jaringan'],
                        ['kode_rekening' => '510203060005', 'nama_rekening' => 'Belanja Pemeliharaan Aset Tidak Berwujud-Software'],
                        ['kode_rekening' => '510204010001', 'nama_rekening' => 'Belanja Perjalanan Dinas Biasa'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                        ['kode_rekening' => '510204010005', 'nama_rekening' => 'Belanja Perjalanan Dinas Paket Meeting Luar Kota'],
                        ['kode_rekening' => '520210010002', 'nama_rekening' => 'Belanja Modal Personal Computer'],
                    ],
                    '401071020002' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010031', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Listrik'],
                        ['kode_rekening' => '510201010035', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Suvenir/Cendera Mata'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010003', 'nama_rekening' => 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
                        ['kode_rekening' => '510202010026', 'nama_rekening' => 'Belanja Jasa Tenaga Administrasi'],
                        ['kode_rekening' => '510202010047', 'nama_rekening' => 'Belanja Jasa Penyelenggaraan Acara'],
                        ['kode_rekening' => '510202010063', 'nama_rekening' => 'Belanja Kawat/Faksimili/Internet/TV Berlangganan'],
                        ['kode_rekening' => '510202020005', 'nama_rekening' => 'Belanja Iuran Jaminan Kesehatan bagi Non ASN'],
                        ['kode_rekening' => '510202020006', 'nama_rekening' => 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN'],
                        ['kode_rekening' => '510202020007', 'nama_rekening' => 'Belanja Iuran Jaminan Kematian bagi Non ASN'],
                        ['kode_rekening' => '510202040036', 'nama_rekening' => 'Belanja Sewa Kendaraan Bermotor Penumpang'],
                        ['kode_rekening' => '510202040133', 'nama_rekening' => 'Belanja Sewa Peralatan Studio Video dan Film'],
                        ['kode_rekening' => '510203020410', 'nama_rekening' => 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Jaringan'],
                        ['kode_rekening' => '510203060005', 'nama_rekening' => 'Belanja Pemeliharaan Aset Tidak Berwujud-Software'],
                        ['kode_rekening' => '510204010001', 'nama_rekening' => 'Belanja Perjalanan Dinas Biasa'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                        ['kode_rekening' => '510204010005', 'nama_rekening' => 'Belanja Perjalanan Dinas Paket Meeting Luar Kota'],
                        ['kode_rekening' => '520205020006', 'nama_rekening' => 'Belanja Modal Alat Rumah Tangga Lainnya (Home Use)'],
                        ['kode_rekening' => '520210010001', 'nama_rekening' => 'Belanja Modal Komputer Jaringan'],
                        ['kode_rekening' => '520210010002', 'nama_rekening' => 'Belanja Modal Personal Computer'],
                        ['kode_rekening' => '520210020004', 'nama_rekening' => 'Belanja Modal Peralatan Jaringan'],
                    ],
                    '401071020003' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010026', 'nama_rekening' => 'Belanja Jasa Tenaga Administrasi'],
                        ['kode_rekening' => '510202020005', 'nama_rekening' => 'Belanja Iuran Jaminan Kesehatan bagi Non ASN'],
                        ['kode_rekening' => '510202020006', 'nama_rekening' => 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN'],
                        ['kode_rekening' => '510202020007', 'nama_rekening' => 'Belanja Iuran Jaminan Kematian bagi Non ASN'],
                        ['kode_rekening' => '510202040036', 'nama_rekening' => 'Belanja Sewa Kendaraan Bermotor Penumpang'],
                        ['kode_rekening' => '510204010001', 'nama_rekening' => 'Belanja Perjalanan Dinas Biasa'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                        ['kode_rekening' => '520210010002', 'nama_rekening' => 'Belanja Modal Personal Computer'],
                    ],
                ],
                '40107101' => [
                    '401071010001' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010029', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer'],
                        ['kode_rekening' => '510201010032', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Dinas'],
                        ['kode_rekening' => '510201010035', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Suvenir/Cendera Mata'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010003', 'nama_rekening' => 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
                        ['kode_rekening' => '510202010026', 'nama_rekening' => 'Belanja Jasa Tenaga Administrasi'],
                        ['kode_rekening' => '510202010029', 'nama_rekening' => 'Belanja Jasa Tenaga Ahli'],
                        ['kode_rekening' => '510202010047', 'nama_rekening' => 'Belanja Jasa Penyelenggaraan Acara'],
                        ['kode_rekening' => '510202010064', 'nama_rekening' => 'Belanja Paket/Pengiriman'],
                        ['kode_rekening' => '510202020005', 'nama_rekening' => 'Belanja Iuran Jaminan Kesehatan bagi Non ASN'],
                        ['kode_rekening' => '510202020006', 'nama_rekening' => 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN'],
                        ['kode_rekening' => '510202020007', 'nama_rekening' => 'Belanja Iuran Jaminan Kematian bagi Non ASN'],
                        ['kode_rekening' => '510202040036', 'nama_rekening' => 'Belanja Sewa Kendaraan Bermotor Penumpang'],
                        ['kode_rekening' => '510204010001', 'nama_rekening' => 'Belanja Perjalanan Dinas Biasa'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                        ['kode_rekening' => '520210010002', 'nama_rekening' => 'Belanja Modal Personal Computer'],
                        ['kode_rekening' => '520210020003', 'nama_rekening' => 'Belanja Modal Peralatan Personal Computer'],
                    ],
                    '401071010002' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010029', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer'],
                        ['kode_rekening' => '510201010032', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Dinas'],
                        ['kode_rekening' => '510201010035', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Suvenir/Cendera Mata'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010003', 'nama_rekening' => 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
                        ['kode_rekening' => '510202010026', 'nama_rekening' => 'Belanja Jasa Tenaga Administrasi'],
                        ['kode_rekening' => '510202010047', 'nama_rekening' => 'Belanja Jasa Penyelenggaraan Acara'],
                        ['kode_rekening' => '510202010064', 'nama_rekening' => 'Belanja Paket/Pengiriman'],
                        ['kode_rekening' => '510202010081', 'nama_rekening' => 'Belanja Honorarium Pengadaan Barang/Jasa'],
                        ['kode_rekening' => '510202020005', 'nama_rekening' => 'Belanja Iuran Jaminan Kesehatan bagi Non ASN'],
                        ['kode_rekening' => '510202020006', 'nama_rekening' => 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN'],
                        ['kode_rekening' => '510202020007', 'nama_rekening' => 'Belanja Iuran Jaminan Kematian bagi Non ASN'],
                        ['kode_rekening' => '510202040036', 'nama_rekening' => 'Belanja Sewa Kendaraan Bermotor Penumpang'],
                        ['kode_rekening' => '510204010001', 'nama_rekening' => 'Belanja Perjalanan Dinas Biasa'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                    ],
                    '401071010003' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010029', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer'],
                        ['kode_rekening' => '510201010032', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Dinas'],
                        ['kode_rekening' => '510201010035', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Suvenir/Cendera Mata'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010003', 'nama_rekening' => 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
                        ['kode_rekening' => '510202010026', 'nama_rekening' => 'Belanja Jasa Tenaga Administrasi'],
                        ['kode_rekening' => '510202010029', 'nama_rekening' => 'Belanja Jasa Tenaga Ahli'],
                        ['kode_rekening' => '510202010047', 'nama_rekening' => 'Belanja Jasa Penyelenggaraan Acara'],
                        ['kode_rekening' => '510202020005', 'nama_rekening' => 'Belanja Iuran Jaminan Kesehatan bagi Non ASN'],
                        ['kode_rekening' => '510202020006', 'nama_rekening' => 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN'],
                        ['kode_rekening' => '510202020007', 'nama_rekening' => 'Belanja Iuran Jaminan Kematian bagi Non ASN'],
                        ['kode_rekening' => '510202040036', 'nama_rekening' => 'Belanja Sewa Kendaraan Bermotor Penumpang'],
                        ['kode_rekening' => '510203060005', 'nama_rekening' => 'Belanja Pemeliharaan Aset Tidak Berwujud-Software'],
                        ['kode_rekening' => '510204010001', 'nama_rekening' => 'Belanja Perjalanan Dinas Biasa'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                        ['kode_rekening' => '520210010002', 'nama_rekening' => 'Belanja Modal Personal Computer'],
                        ['kode_rekening' => '520210020003', 'nama_rekening' => 'Belanja Modal Peralatan Personal Computer'],
                    ],
                ],
            ],

            // PROGRAM 40101 - PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH PROVINSI
            '40101' => [
                '40101101' => [
                    '401011010001' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510204010001', 'nama_rekening' => 'Belanja Perjalanan Dinas Biasa'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                    ],
                    '401011010002' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011010003' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011010004' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011010005' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011010006' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                    ],
                    '401011010007' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010003', 'nama_rekening' => 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                    ],
                ],
                '40101102' => [
                    '401011020002' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010026', 'nama_rekening' => 'Belanja Jasa Tenaga Administrasi'],
                        ['kode_rekening' => '510202010080', 'nama_rekening' => 'Belanja Honorarium Penanggungjawaban Pengelola Keuangan'],
                        ['kode_rekening' => '510202010081', 'nama_rekening' => 'Belanja Honorarium Pengadaan Barang/Jasa'],
                        ['kode_rekening' => '510202020005', 'nama_rekening' => 'Belanja Iuran Jaminan Kesehatan bagi Non ASN'],
                        ['kode_rekening' => '510202020006', 'nama_rekening' => 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN'],
                        ['kode_rekening' => '510202020007', 'nama_rekening' => 'Belanja Iuran Jaminan Kematian bagi Non ASN'],
                        ['kode_rekening' => '510202040036', 'nama_rekening' => 'Belanja Sewa Kendaraan Bermotor Penumpang'],
                        ['kode_rekening' => '510202120004', 'nama_rekening' => 'Belanja Diklat Kepemimpinan'],
                        ['kode_rekening' => '510204010001', 'nama_rekening' => 'Belanja Perjalanan Dinas Biasa'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                        ['kode_rekening' => '510204010004', 'nama_rekening' => 'Belanja Perjalanan Dinas Paket Meeting Dalam Kota'],
                        ['kode_rekening' => '510204010005', 'nama_rekening' => 'Belanja Perjalanan Dinas Paket Meeting Luar Kota'],
                    ],
                    '401011020003' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011020004' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011020005' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011020006' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                    ],
                    '401011020007' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011020008' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                ],
                '40101103' => [
                    '401011030001' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011030003' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011030005' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011030006' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                ],
                '40101105' => [
                    '401011050002' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010032', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Dinas'],
                        ['kode_rekening' => '510201010034', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Perlengkapan Pendukung Olahraga'],
                        ['kode_rekening' => '510201010061', 'nama_rekening' => 'Belanja Pakaian Sipil Harian (PSH)'],
                        ['kode_rekening' => '510201010065', 'nama_rekening' => 'Belanja Pakaian Sipil Resmi (PSR)'],
                    ],
                    '401011050003' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                    ],
                    '401011050004' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                    ],
                    '401011050005' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010032', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Dinas'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010003', 'nama_rekening' => 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
                        ['kode_rekening' => '510202010047', 'nama_rekening' => 'Belanja Jasa Penyelenggaraan Acara'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                        ['kode_rekening' => '510204010005', 'nama_rekening' => 'Belanja Perjalanan Dinas Paket Meeting Luar Kota'],
                    ],
                    '401011050010' => [
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010003', 'nama_rekening' => 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                    ],
                ],
                '40101106' => [
                    '401011060004' => [
                        ['kode_rekening' => '510201010024', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Tulis Kantor'],
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010027', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Benda Pos'],
                        ['kode_rekening' => '510201010029', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer'],
                        ['kode_rekening' => '510201010036', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat/Bahan untuk Kegiatan Kantor Lainnya'],
                    ],
                    '401011060006' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510202010062', 'nama_rekening' => 'Belanja Langganan Jurnal/Surat Kabar/Majalah'],
                    ],
                    '401011060008' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                    ],
                    '401011060010' => [
                        ['kode_rekening' => '510201010024', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Tulis Kantor'],
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510202010003', 'nama_rekening' => 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
                        ['kode_rekening' => '520205010004', 'nama_rekening' => 'Belanja Modal Alat Penyimpan Perlengkapan Kantor'],
                    ],
                    '401011060011' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010052', 'nama_rekening' => 'Belanja Makanan dan Minuman Rapat'],
                        ['kode_rekening' => '510204010003', 'nama_rekening' => 'Belanja Perjalanan Dinas Dalam Kota'],
                    ],
                ],
                '40101107' => [
                    '401011070006' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010029', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer'],
                        ['kode_rekening' => '520205010005', 'nama_rekening' => 'Belanja Modal Alat Kantor Lainnya'],
                        ['kode_rekening' => '520205020001', 'nama_rekening' => 'Belanja Modal Mebel'],
                        ['kode_rekening' => '520205020006', 'nama_rekening' => 'Belanja Modal Alat Rumah Tangga Lainnya (Home Use)'],
                        ['kode_rekening' => '520210010002', 'nama_rekening' => 'Belanja Modal Personal Computer'],
                    ],
                ],
                '40101108' => [
                    '401011080001' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510202010064', 'nama_rekening' => 'Belanja Paket/Pengiriman'],
                    ],
                    '401011080002' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510202010063', 'nama_rekening' => 'Belanja Kawat/Faksimili/Internet/TV Berlangganan'],
                    ],
                    '401011080003' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010029', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer'],
                    ],
                    '401011080004' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510201010035', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Suvenir/Cendera Mata'],
                        ['kode_rekening' => '510202010028', 'nama_rekening' => 'Belanja Jasa Tenaga Pelayanan Umum'],
                        ['kode_rekening' => '510202010033', 'nama_rekening' => 'Belanja Jasa Tenaga Supir'],
                        ['kode_rekening' => '510202010036', 'nama_rekening' => 'Belanja Jasa Audit/Surveillance ISO'],
                        ['kode_rekening' => '510202040035', 'nama_rekening' => 'Belanja Sewa Kendaraan Dinas Bermotor Perorangan'],
                        ['kode_rekening' => '510202070057', 'nama_rekening' => 'Belanja Sewa Tanaman'],
                        ['kode_rekening' => '510202090014', 'nama_rekening' => 'Belanja Jasa Konsultansi Berorientasi Layanan-Jasa Khusus'],
                        ['kode_rekening' => '510202150005', 'nama_rekening' => 'Belanja Sewa Aset Tidak Berwujud-Software'],
                        ['kode_rekening' => '510203020132', 'nama_rekening' => 'Belanja Sewa Aset Tidak Berwujud-Belanja Pemeliharaan Alat Studio, Komunikasi, dan Pemancar-Alat Studio-Peralatan Studio Audio'],
                    ],
                ],
                '40101109' => [
                    '401011090001' => [
                        ['kode_rekening' => '510201010004', 'nama_rekening' => 'Belanja Bahan-Bahan Bakar dan Pelumas'],
                        ['kode_rekening' => '510202010067', 'nama_rekening' => 'Belanja Pembayaran Pajak, Bea, dan Perizinan'],
                        ['kode_rekening' => '510203020035', 'nama_rekening' => 'Belanja Pemeliharaan Alat Angkutan-Alat Angkutan Darat Bermotor-Kendaraan Dinas Bermotor Perorangan'],
                        ['kode_rekening' => '510203020036', 'nama_rekening' => 'Belanja Pemeliharaan Alat Angkutan-Alat Angkutan Darat Bermotor-Kendaraan Bermotor Penumpang'],
                    ],
                    '401011090006' => [
                        ['kode_rekening' => '510201010025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
                        ['kode_rekening' => '510203020121', 'nama_rekening' => 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Alat Pendingin'],
                        ['kode_rekening' => '510203020405', 'nama_rekening' => 'Belanja Pemeliharaan Komputer-Komputer Unit-Personal Computer'],
                        ['kode_rekening' => '510203020409', 'nama_rekening' => 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Personal Computer'],
                    ],
                    '401011090010' => [
                        ['kode_rekening' => '510203030001', 'nama_rekening' => 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Gedung Kantor'],
                    ],
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

                foreach ($listSubKegiatan as $kodeSubKegiatan => $listRekening) {
                    $subKegiatanId = DB::table('t_master_sub_kegiatan')
                        ->where('kode_sub_kegiatan', $kodeSubKegiatan)
                        ->where('id_program', $programId)
                        ->where('id_kegiatan', $kegiatanId)
                        ->value('id_sub_kegiatan');

                    if (!$subKegiatanId) {
                        continue; // skip kalau sub kegiatan belum ada
                    }

                    foreach ($listRekening as $rekening) {
                        DB::table('t_rekening')->insert([
                            'kode_rekening' => $rekening['kode_rekening'],
                            'id_program' => $programId,
                            'id_kegiatan' => $kegiatanId,
                            'id_sub_kegiatan' => $subKegiatanId,
                            'nama_rekening' => $rekening['nama_rekening'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
