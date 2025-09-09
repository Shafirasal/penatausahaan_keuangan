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
            '40107' => [
                '40107103' => [
                    '401071030001' => [
                        '510201010025' => [
                            ['kode_ssh' => '11120103000200034', 'nama_ssh' => 'Fotokopi', 'pagu1' => 472844, 'pagu2' => 925.800, 'tahun' => '2025-01-15'],
                        ],
                        '510201010032' => [
                            ['kode_ssh' => '11120103000900071', 'nama_ssh' => 'Pakaian Dinas Lapangan', 'pagu1' => 14628000, 'pagu2' => 14628000, 'tahun' => '2025-02-20'],
                        ],
                        '510201010035' => [
                            ['kode_ssh' => '11120103001200018', 'nama_ssh' => 'Hand Bag', 'pagu1' => 31040000, 'pagu2' => 36860000, 'tahun' => '2025-03-10'],
                        ],
                        '510201010052' => [
                            ['kode_ssh' => '81020101005200002', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu1' => 18480000, 'pagu2' => 21120000, 'tahun' => '2025-04-05'],
                            ['kode_ssh' => '81020101005200003', 'nama_ssh' => 'Hidangan Rapat/Kegiatan Lainnya Provinsi Jawa Timur', 'pagu1' => 9200000, 'pagu2' => 11040000, 'tahun' => '2025-04-06'],
                        ],
                        '510202010026' => [
                            ['kode_ssh' => '81020201002600012', 'nama_ssh' => 'Honorarium Jasa Tenaga Administrasi', 'pagu1' => 168000000, 'pagu2' => 168000000, 'tahun' => '2025-05-12'],
                            ['kode_ssh' => '81020201002600038', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu1' => 84000000, 'pagu2' => 84000000, 'tahun' => '2025-05-13'],
                            ['kode_ssh' => '81020201002600072', 'nama_ssh' => 'Tambahan Honorarium Jasa Tenaga Administrasi', 'pagu1' => 54720000, 'pagu2' => 54720000, 'tahun' => '2025-05-14'],
                        ],
                        '510202010047' => [
                            ['kode_ssh' => '81020201004700018', 'nama_ssh' => 'Jasa Event Organizer', 'pagu1' => 71200000, 'pagu2' => 0, 'tahun' => '2025-06-18'],
                            ['kode_ssh' => '81020201004700020', 'nama_ssh' => 'Jasa Event Organizer Pameran/Pelaksanaan Kegiatan', 'pagu1' => 0, 'pagu2' => 62300000, 'tahun' => '2025-06-19'],
                            ['kode_ssh' => '81020201004700067', 'nama_ssh' => 'Jasa Event Organizer Pameran/Pelaksanaan Kegiatan', 'pagu1' => 50450600, 'pagu2' => 50450600, 'tahun' => '2025-06-20'],
                        ],
                        '510202020005' => [
                            ['kode_ssh' => '81020202000500053', 'nama_ssh' => '# Iuran Jaminan Kesehatan (BPJS) Non ASN', 'pagu1' => 7144956, 'pagu2' => 5760000, 'tahun' => '2025-07-08'],
                        ],
                        '510202020006' => [
                            ['kode_ssh' => '81020202000600007', 'nama_ssh' => 'Jaminan Kecelakaan Kerja (JKK) Non ASN', 'pagu1' => 345600, 'pagu2' => 345600, 'tahun' => '2025-07-09'],
                        ],
                        '510202020007' => [
                            ['kode_ssh' => '81020202000700007', 'nama_ssh' => 'Jaminan Kematian (JKM) Non ASN', 'pagu1' => 432000, 'pagu2' => 432000, 'tahun' => '2025-07-10'],
                        ],
                        '510202040036' => [
                            ['kode_ssh' => '81020204003600117', 'nama_ssh' => '# Sewa Kendaraan Pelaksanaan Kegiatan Insidentil - Roda 4', 'pagu1' => 1231000, 'pagu2' => 0, 'tahun' => '2025-08-22'],
                        ],
                        '510202120001' => [
                            ['kode_ssh' => '81020213000100017', 'nama_ssh' => 'Beban Kursus Singkat/Pelatihan', 'pagu1' => 294400000, 'pagu2' => 294400000, 'tahun' => '2025-09-15'],
                        ],
                        '510204010003' => [
                            ['kode_ssh' => '81020401000300340', 'nama_ssh' => 'Uang Transport Perjalanan dinas di dalam kota yang kurang dari 8 (delapan) jam', 'pagu1' => 13600000, 'pagu2' => 12800000, 'tahun' => '2025-10-30'],
                        ],
                    ],
                ],
            ],
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