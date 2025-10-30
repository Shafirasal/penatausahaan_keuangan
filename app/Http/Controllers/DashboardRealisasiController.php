<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\SshModel;
use App\Models\RealisasiModel;
use Illuminate\Http\request;
use Illuminate\Support\Facades\DB;

class DashboardRealisasiController extends Controller
{
    /**
     * Halaman landing dengan data realisasi anggaran
     */
    public function index()
    {
        // Ambil data realisasi untuk 3 bagian
        $dataBagian = $this->getRealisasiByBagian();
        
        // Hitung total keseluruhan
        $totalKeseluruhan = [
            'pagu' => $dataBagian['pbj']['pagu'] + $dataBagian['lpse']['pagu'] + $dataBagian['pembinaan']['pagu'],
            'realisasi' => $dataBagian['pbj']['realisasi'] + $dataBagian['lpse']['realisasi'] + $dataBagian['pembinaan']['realisasi'],
        ];
        $totalKeseluruhan['selisih'] = $totalKeseluruhan['pagu'] - $totalKeseluruhan['realisasi'];
        $totalKeseluruhan['persentase'] = $totalKeseluruhan['pagu'] > 0 
            ? round(($totalKeseluruhan['realisasi'] / $totalKeseluruhan['pagu']) * 100, 2) 
            : 0;
        
        return view('landing', compact('dataBagian', 'totalKeseluruhan'));
    }
    
    /**
     * Mengambil data realisasi untuk 3 bagian (PBJ, LPSE, Pembinaan)
     */
    private function getRealisasiByBagian()
    {
        // Definisi kode kegiatan untuk setiap bagian
        $kodeKegiatan = [
            'pbj' => '40107101',
            'lpse' => '40107102',
            'pembinaan' => '40107103'
        ];
        
        $result = [];
        
        foreach ($kodeKegiatan as $bagian => $kode) {
            $data = $this->hitungRealisasi($kode);
            $result[$bagian] = $data;
        }
        
        return $result;
    }
    
    /**
     * Menghitung total pagu, realisasi, selisih, dan persentase berdasarkan kode kegiatan
     */
    private function hitungRealisasi($kodeKegiatan)
    {
        // Ambil total pagu dari t_ssh berdasarkan kode_kegiatan
        // Menggunakan relasi: SSH -> SubKegiatan -> Kegiatan
        $totalPagu = SshModel::whereHas('sub_kegiatan.kegiatan', function($query) use ($kodeKegiatan) {
                $query->where('kode_kegiatan', $kodeKegiatan);
            })
            ->selectRaw('SUM(COALESCE(NULLIF(pagu2, 0), pagu1, 0)) as total')
            ->value('total') ?? 0;
        
        // Ambil total realisasi dari t_transaksional_realisasi_anggaran
        // Menggunakan relasi: Realisasi -> SSH -> SubKegiatan -> Kegiatan
        $totalRealisasi = RealisasiModel::whereHas('ssh.sub_kegiatan.kegiatan', function($query) use ($kodeKegiatan) {
                $query->where('kode_kegiatan', $kodeKegiatan);
            })
            ->selectRaw('SUM(COALESCE(nilai_realisasi, 0)) as total')
            ->value('total') ?? 0;
        
        // Hitung selisih dan persentase
        $selisih = $totalPagu - $totalRealisasi;
        $persentase = $totalPagu > 0 ? round(($totalRealisasi / $totalPagu) * 100, 2) : 0;
        
        return [
            'pagu' => $totalPagu,
            'realisasi' => $totalRealisasi,
            'selisih' => $selisih,
            'persentase' => $persentase
        ];
    }
    
    /**
     * Method tambahan: Get total anggaran keseluruhan (semua SSH)
     */
    public function getTotalAnggaran()
    {
        return SshModel::selectRaw('SUM(COALESCE(NULLIF(pagu2, 0), pagu1, 0)) as total')
            ->value('total') ?? 0;
    }
    
    /**
     * Method tambahan: Get total realisasi keseluruhan
     */
    public function getTotalRealisasi()
    {
        return RealisasiModel::selectRaw('SUM(COALESCE(nilai_realisasi, 0)) as total')
            ->value('total') ?? 0;
    }
    
    /**
     * Method tambahan: Get perbandingan per tahun
     */
    public function getPerbandinganRealisasiSisaAnggaran()
    {
        return DB::table('t_ssh')
            ->selectRaw('YEAR(t_ssh.tahun) as tahun')
            ->selectRaw('SUM(COALESCE(NULLIF(t_ssh.pagu2, 0), t_ssh.pagu1, 0)) as total_anggaran')
            ->selectRaw('COALESCE(SUM(r.nilai_realisasi), 0) as total_realisasi')
            ->leftJoin('t_transaksional_realisasi_anggaran as r', 't_ssh.id_ssh', '=', 'r.id_ssh')
            ->groupBy(DB::raw('YEAR(t_ssh.tahun)'))
            ->orderBy('tahun')
            ->get()
            ->map(function($item) {
                return [
                    'tahun' => (int) $item->tahun,
                    'total_anggaran' => (float) $item->total_anggaran,
                    'total_realisasi' => (float) $item->total_realisasi,
                    'total_sisa' => (float) ($item->total_anggaran - $item->total_realisasi),
                ];
            });
    }
}