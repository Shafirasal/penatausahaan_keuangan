<?php

namespace App\Http\Controllers;

use App\Models\RealisasiModel;
use App\Models\SshModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralDashboardController extends Controller
{
    /**
     * Halaman utama dashboard
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'General Dashboard',
            'list'  => ['Home', 'General Dashboard']
        ];

        $page = (object) [
            'title' => 'General Dashboard'
        ];

        $activeMenu = 'General Dashboard';
        $totalAnggaran = $this->getTotalAnggaran();
        $totalRealisasi = $this->getTotalRealisasi();
        $totalSisa = $totalAnggaran - $totalRealisasi; 
        $perbandinganPerTahun = $this->getPerbandinganRealisasiSisaAnggaran();
        

        return view('dashboard.index', compact('breadcrumb', 'page', 'activeMenu', 'totalAnggaran', 'totalSisa', 'totalRealisasi', 'perbandinganPerTahun'));
    }

    /**
     * Mengambil total anggaran dari tabel SSH
     */
    public function getTotalAnggaran()
    {
        return SshModel::selectRaw('SUM(COALESCE(NULLIF(pagu2, 0), pagu1, 0)) as total')->value('total') ?? 0;
    }

    public function getTotalRealisasi()
    {
        return RealisasiModel::selectRaw('SUM(nilai_realisasi) as total')->value('total') ?? 0;
    }

//   public function getPerbandinganRealisasiSisaAnggaran()
//     {
//         $sshData = SshModel::with('realisasi')->get();

//         return $sshData->groupBy('tahun')->map(function ($items, $tahun) {
//             $totalAnggaran = $items->sum(fn($item) => $item->pagu2 ?: $item->pagu1 ?: 0);
//             $totalRealisasi = $items->sum(fn($item) => $item->realisasi->sum('nilai_realisasi'));
//             $totalSisa = $totalAnggaran - $totalRealisasi;

//             return [
//                 'tahun' => $tahun,
//                 'total_anggaran' => $totalAnggaran,
//                 'total_realisasi' => $totalRealisasi,
//                 'total_sisa' => $totalSisa,
//             ];
//         })->values();
//     }

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
