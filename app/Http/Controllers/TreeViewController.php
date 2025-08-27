<?php

namespace App\Http\Controllers;

use App\Models\MasterProgramModel;
use App\Models\MasterKegiatanModel;
use App\Models\MasterSubKegiatanModel;
use App\Models\RekeningModel;
use App\Models\SshModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;


class TreeViewController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Tree View SSH',
            'list'  => ['Home', 'Tree View SSH']
        ];

        $page = (object)[
            'title' => 'Data Rekening ➜ SSH (Tree)'
        ];

        $activeMenu = 'tree_view';

        // dropdown Program (tampilkan kode yang sudah diformat)
        $listProgram = MasterProgramModel::select('id_program', 'kode_program', 'nama_program')
            ->orderBy('kode_program')
            ->get()
            ->map(function ($p) {
                $p->kode_program = formatKode($p->kode_program, 'program');
                return $p;
            });

        // view: resources/views/tree_view/index.blade.php
        return view('tree_view.index', compact('breadcrumb', 'page', 'activeMenu', 'listProgram'));
    }

    /** Dropdown: Kegiatan by Program (kode diformat) */
    public function getKegiatanByProgram($id_program)
    {
        $rows = MasterKegiatanModel::where('id_program', $id_program)
            ->select('id_kegiatan', 'kode_kegiatan', 'nama_kegiatan')
            ->orderBy('kode_kegiatan')
            ->get()
            ->map(function ($r) {
                $r->kode_kegiatan = formatKode($r->kode_kegiatan, 'kegiatan');
                return $r;
            });

        return response()->json($rows);
    }

    /** Dropdown: Sub Kegiatan by Kegiatan (kode diformat) */
    public function getSubKegiatanByKegiatan($id_kegiatan)
    {
        $rows = MasterSubKegiatanModel::where('id_kegiatan', $id_kegiatan)
            ->select('id_sub_kegiatan', 'kode_sub_kegiatan', 'nama_sub_kegiatan')
            ->orderBy('kode_sub_kegiatan')
            ->get()
            ->map(function ($r) {
                $r->kode_sub_kegiatan = formatKode($r->kode_sub_kegiatan, 'sub_kegiatan');
                return $r;
            });

        return response()->json($rows);
    }

    /**
     * DataTables level-1: Rekening (terfilter Program/Kegiatan/Sub Kegiatan)
     * Kolom yang diminta: Kode, Uraian, P1, P2, Realisasi, Sisa
     *
     * ASUMSI: ada tabel t_realisasi_ssh(id_rekening, kode_ssh, amount).
     * Jika beda, sesuaikan join/agregatnya.
     */

public function listRekening(Request $request)
{
    $id_program      = $request->id_program;
    $id_kegiatan     = $request->id_kegiatan;
    $id_sub_kegiatan = $request->id_sub_kegiatan;

    $q = RekeningModel::query()
        ->from('t_rekening')
        ->select([
            't_rekening.id_rekening',
            't_rekening.kode_rekening',
            't_rekening.nama_rekening',
            't_rekening.id_program',
            't_rekening.id_kegiatan',
            't_rekening.id_sub_kegiatan',
            DB::raw("COALESCE(SUM(CASE WHEN t_ssh.periode = 1 THEN t_ssh.pagu ELSE 0 END),0) AS anggaran_periode1"),
            DB::raw("COALESCE(SUM(CASE WHEN t_ssh.periode = 2 THEN t_ssh.pagu ELSE 0 END),0) AS anggaran_periode2"),
        ])
        ->when($id_program, fn($x) => $x->where('t_rekening.id_program', $id_program))
        ->when($id_kegiatan, fn($x) => $x->where('t_rekening.id_kegiatan', $id_kegiatan))
        ->when($id_sub_kegiatan, fn($x) => $x->where('t_rekening.id_sub_kegiatan', $id_sub_kegiatan))
        ->leftJoin('t_ssh', 't_ssh.id_rekening', '=', 't_rekening.id_rekening')
        ->when($id_program, fn($x) => $x->where('t_ssh.id_program', $id_program))
        ->when($id_kegiatan, fn($x) => $x->where('t_ssh.id_kegiatan', $id_kegiatan))
        ->when($id_sub_kegiatan, fn($x) => $x->where('t_ssh.id_sub_kegiatan', $id_sub_kegiatan));

    // === OPTIONAL JOIN REALISASI ===
    $hasRealisasi = Schema::hasTable('t_realisasi_ssh');

    if ($hasRealisasi) {
        $q->leftJoin(DB::raw("
                (SELECT id_rekening, COALESCE(SUM(amount),0) AS realisasi
                 FROM t_realisasi_ssh
                 GROUP BY id_rekening) AS rls
            "), 'rls.id_rekening', '=', 't_rekening.id_rekening')
          ->addSelect([
              DB::raw("COALESCE(rls.realisasi,0) AS realisasi"),
              DB::raw("(COALESCE(SUM(CASE WHEN t_ssh.periode = 1 THEN t_ssh.pagu ELSE 0 END),0)
                      + COALESCE(SUM(CASE WHEN t_ssh.periode = 2 THEN t_ssh.pagu ELSE 0 END),0)
                      - COALESCE(rls.realisasi,0)) AS sisa_total"),
          ])
          ->groupBy('t_rekening.id_rekening','t_rekening.kode_rekening','t_rekening.nama_rekening','t_rekening.id_program','t_rekening.id_kegiatan','t_rekening.id_sub_kegiatan','rls.realisasi');
    } else {
        // tanpa tabel realisasi
        $q->addSelect([
              DB::raw("0 AS realisasi"),
              DB::raw("(COALESCE(SUM(CASE WHEN t_ssh.periode = 1 THEN t_ssh.pagu ELSE 0 END),0)
                      + COALESCE(SUM(CASE WHEN t_ssh.periode = 2 THEN t_ssh.pagu ELSE 0 END),0)) AS sisa_total"),
          ])
          ->groupBy('t_rekening.id_rekening','t_rekening.kode_rekening','t_rekening.nama_rekening','t_rekening.id_program','t_rekening.id_kegiatan','t_rekening.id_sub_kegiatan');
    }

    return DataTables::of($q)
        ->addIndexColumn()
        ->addColumn('expand', fn($row) =>
            '<a href="#" class="btn btn-sm btn-outline-primary btn-expand" data-id="'.$row->id_rekening.'"><i class="fas fa-chevron-right"></i></a>'
        )
        ->addColumn('kode',   fn($row) => formatKode($row->kode_rekening, 'rekening'))
        ->addColumn('uraian', fn($row) => e($row->nama_rekening))
        ->addColumn('p1',     fn($row) => number_format((float)$row->anggaran_periode1, 0, ',', '.'))
        ->addColumn('p2',     fn($row) => number_format((float)$row->anggaran_periode2, 0, ',', '.'))
        ->addColumn('real',   fn($row) => number_format((float)$row->realisasi, 0, ',', '.'))
        ->addColumn('sisa',   fn($row) => number_format((float)$row->sisa_total, 0, ',', '.'))
        ->rawColumns(['expand'])
        ->toJson();
}


    /**
     * Child rows: tabel kecil daftar SSH di bawah suatu Rekening
     * Terfilter oleh Program/Kegiatan/Sub Kegiatan bila dikirim via query string.
     */
public function listSshByRekening($id_rekening, Request $request)
{
    $id_program      = $request->query('id_program');
    $id_kegiatan     = $request->query('id_kegiatan');
    $id_sub_kegiatan = $request->query('id_sub_kegiatan');

    $ssh = SshModel::query()
        ->from('t_ssh')
        ->select([
            't_ssh.kode_ssh',
            't_ssh.nama_ssh',
            DB::raw("COALESCE(SUM(CASE WHEN t_ssh.periode = 1 THEN t_ssh.pagu ELSE 0 END),0) AS p1"),
            DB::raw("COALESCE(SUM(CASE WHEN t_ssh.periode = 2 THEN t_ssh.pagu ELSE 0 END),0) AS p2"),
        ])
        ->where('t_ssh.id_rekening', $id_rekening)
        ->when($id_program, fn($x) => $x->where('t_ssh.id_program', $id_program))
        ->when($id_kegiatan, fn($x) => $x->where('t_ssh.id_kegiatan', $id_kegiatan))
        ->when($id_sub_kegiatan, fn($x) => $x->where('t_ssh.id_sub_kegiatan', $id_sub_kegiatan))
        ->groupBy('t_ssh.kode_ssh','t_ssh.nama_ssh')
        ->orderBy('t_ssh.kode_ssh')
        ->get();

    // realisasi per SSH: hanya jika tabel ada
    $realisasiMap = [];
    if (Schema::hasTable('t_realisasi_ssh')) {
        $realisasiMap = DB::table('t_realisasi_ssh')
            ->select('kode_ssh', DB::raw('COALESCE(SUM(amount),0) AS realisasi'))
            ->where('id_rekening', $id_rekening)
            ->groupBy('kode_ssh')
            ->pluck('realisasi','kode_ssh');
    }

    $html = '<table class="table table-sm table-bordered mb-0">';
    $html .= '<thead class="thead-light"><tr>';
    $html .= '<th style="width:140px">Kode</th><th>Uraian</th><th class="text-right">Periode 1</th><th class="text-right">Periode 2</th><th class="text-right">Realisasi</th><th class="text-right">Sisa</th>';
    $html .= '</tr></thead><tbody>';

    foreach ($ssh as $row) {
        $real = (float)($realisasiMap[$row->kode_ssh] ?? 0);
        $sisa = ((float)$row->p1 + (float)$row->p2) - $real;

        $html .= '<tr>';
        $html .= '<td>'.e(formatKode($row->kode_ssh, 'ssh')).'</td>';
        $html .= '<td>'.e($row->nama_ssh).'</td>';
        $html .= '<td class="text-right">'.number_format((float)$row->p1, 0, ',', '.').'</td>';
        $html .= '<td class="text-right">'.number_format((float)$row->p2, 0, ',', '.').'</td>';
        $html .= '<td class="text-right">'.number_format($real, 0, ',', '.').'</td>';
        $html .= '<td class="text-right">'.number_format($sisa, 0, ',', '.').'</td>';
        $html .= '</tr>';
    }

    if ($ssh->isEmpty()) {
        $html .= '<tr><td colspan="6" class="text-center text-muted">Tidak ada data SSH pada rekening ini.</td></tr>';
    }

    $html .= '</tbody></table>';

    return response($html);
}


// public function listSshByRekening($id_rekening, Request $request)
// {
//     $id_program      = $request->query('id_program');
//     $id_kegiatan     = $request->query('id_kegiatan');
//     $id_sub_kegiatan = $request->query('id_sub_kegiatan');

//     $ssh = SshModel::query()
//         ->from('t_ssh')
//         ->select([
//             't_ssh.kode_ssh',
//             't_ssh.nama_ssh',
//             DB::raw("COALESCE(SUM(CASE WHEN t_ssh.periode = 1 THEN t_ssh.pagu ELSE 0 END),0) AS p1"),
//             DB::raw("COALESCE(SUM(CASE WHEN t_ssh.periode = 2 THEN t_ssh.pagu ELSE 0 END),0) AS p2"),
//         ])
//         ->where('t_ssh.id_rekening', $id_rekening)
//         ->when($id_program, fn($x) => $x->where('t_ssh.id_program', $id_program))
//         ->when($id_kegiatan, fn($x) => $x->where('t_ssh.id_kegiatan', $id_kegiatan))
//         ->when($id_sub_kegiatan, fn($x) => $x->where('t_ssh.id_sub_kegiatan', $id_sub_kegiatan))
//         ->groupBy('t_ssh.kode_ssh', 't_ssh.nama_ssh')
//         ->orderBy('t_ssh.kode_ssh')
//         ->get();

//     // realisasi per SSH (opsional bila ada tabel)
//     $realisasiMap = [];
//     if (Schema::hasTable('t_realisasi_ssh')) {
//         $realisasiMap = DB::table('t_realisasi_ssh')
//             ->select('kode_ssh', DB::raw('COALESCE(SUM(amount),0) AS realisasi'))
//             ->where('id_rekening', $id_rekening)
//             ->groupBy('kode_ssh')
//             ->pluck('realisasi', 'kode_ssh');
//     }

//     // === Jika diminta JSON ===
//     if ($request->query('format') === 'json' || $request->wantsJson()) {
//         $rows = $ssh->map(function($r) use ($realisasiMap){
//             $real = (float)($realisasiMap[$r->kode_ssh] ?? 0);
//             $sisa = ((float)$r->p1 + (float)$r->p2) - $real;
//             return [
//                 'kode' => formatKode($r->kode_ssh, 'ssh'),
//                 'uraian' => $r->nama_ssh,
//                 'p1' => number_format((float)$r->p1, 0, ',', '.'),
//                 'p2' => number_format((float)$r->p2, 0, ',', '.'),
//                 'real' => number_format($real, 0, ',', '.'),
//                 'sisa' => number_format($sisa, 0, ',', '.'),
//             ];
//         })->values();

//         return response()->json(['data' => $rows]);
//     }

//     // === (fallback lama) HTML kecil untuk child rows (kalau masih dibutuhkan di tempat lain) ===
//     $html = '<table class="table table-sm table-bordered mb-0">';
//     $html .= '<thead class="thead-light"><tr>';
//     $html .= '<th style="width:140px">Kode</th><th>Uraian</th><th class="text-right">Periode 1</th><th class="text-right">Periode 2</th><th class="text-right">Realisasi</th><th class="text-right">Sisa</th>';
//     $html .= '</tr></thead><tbody>';

//     foreach ($ssh as $row) {
//         $real = (float)($realisasiMap[$row->kode_ssh] ?? 0);
//         $sisa = ((float)$row->p1 + (float)$row->p2) - $real;

//         $html .= '<tr>';
//         $html .= '<td>'.e(formatKode($row->kode_ssh, 'ssh')).'</td>';
//         $html .= '<td>'.e($row->nama_ssh).'</td>';
//         $html .= '<td class="text-right">'.number_format((float)$row->p1, 0, ',', '.').'</td>';
//         $html .= '<td class="text-right">'.number_format((float)$row->p2, 0, ',', '.').'</td>';
//         $html .= '<td class="text-right">'.number_format($real, 0, ',', '.').'</td>';
//         $html .= '<td class="text-right">'.number_format($sisa, 0, ',', '.').'</td>';
//         $html .= '</tr>';
//     }
//     if ($ssh->isEmpty()) {
//         $html .= '<tr><td colspan="6" class="text-center text-muted">Tidak ada data SSH pada rekening ini.</td></tr>';
//     }
//     $html .= '</tbody></table>';

//     return response($html);
// }
}
