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

        $tahunSekarang = now()->year;
        $tahunRange = range(2013, $tahunSekarang + 3);

        // view: resources/views/tree_view/index.blade.php
        return view('tree_view.index', compact('breadcrumb', 'page', 'activeMenu', 'listProgram', 'tahunSekarang', 'tahunRange'));
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

    public function listSubKegiatan(Request $request)
    {
        $id_program      = $request->id_program;
        $id_kegiatan     = $request->id_kegiatan;
        $id_sub_kegiatan = $request->id_sub_kegiatan;
        $tahun = $request->tahun ?? now()->year;


        $q = MasterSubKegiatanModel::query()
            ->select([
                't_master_sub_kegiatan.id_sub_kegiatan',
                't_master_sub_kegiatan.kode_sub_kegiatan',
                't_master_sub_kegiatan.nama_sub_kegiatan',
                DB::raw("COALESCE(SUM(t_ssh.pagu1),0) AS p1"),
                DB::raw("COALESCE(SUM(t_ssh.pagu2),0) AS p2"),
                DB::raw("SUM(CASE WHEN t_ssh.pagu2 > 0 THEN t_ssh.pagu2 ELSE t_ssh.pagu1 END) AS sisa_total")

            ])

            ->leftJoin('t_ssh', 't_ssh.id_sub_kegiatan', '=', 't_master_sub_kegiatan.id_sub_kegiatan')
            ->when($id_program, fn($x) => $x->where('t_master_sub_kegiatan.id_program', $id_program))
            ->when($id_kegiatan, fn($x) => $x->where('t_master_sub_kegiatan.id_kegiatan', $id_kegiatan))
            ->whereYear('t_ssh.tahun', $tahun) // filter tahun
            ->when($id_sub_kegiatan, fn($x) => $x->where('t_master_sub_kegiatan.id_sub_kegiatan', $id_sub_kegiatan))
            ->groupBy('t_master_sub_kegiatan.id_sub_kegiatan', 't_master_sub_kegiatan.kode_sub_kegiatan', 't_master_sub_kegiatan.nama_sub_kegiatan');


        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn(
                'expand',
                fn($row) =>
                '<a href="#" class="btn btn-sm btn-outline-primary btn-expand-sub" data-id="' . $row->id_sub_kegiatan . '">
                <i class="fas fa-chevron-right"></i>
             </a>'
            )
            ->addColumn('kode', fn($row) => formatKode($row->kode_sub_kegiatan, 'sub_kegiatan'))
            ->addColumn(
                'uraian',
                fn($row) =>
                '<span class="px-2 py-1" style="background-color: #ffA500; color:#663c00; border-radius:4px;">
        ' . e($row->nama_sub_kegiatan) . '
    </span>'
            )
            ->addColumn('p1', fn($row) => number_format((float)$row->p1, 0, ',', '.'))
            ->addColumn('p2', fn($row) => number_format((float)$row->p2, 0, ',', '.'))
            ->addColumn('real', fn($row) => number_format(0, 0, ',', '.')) // sementara 0
            ->addColumn('sisa', fn($row) => number_format((float)$row->sisa_total, 0, ',', '.'))


            ->rawColumns(['expand', 'uraian'])
            ->toJson();
    }

    public function listRekeningBySubKegiatan($id_sub_kegiatan, Request $request)
    {
        $id_program   = $request->query('id_program');
        $id_kegiatan  = $request->query('id_kegiatan');
        $filter_sub   = $request->query('id_sub_kegiatan'); // jangan timpa $id_sub_kegiatan dari parameter
        $tahun = $request->tahun ?? now()->year;


        $rekening = RekeningModel::query()
            ->from('t_rekening')
            ->select([
                't_rekening.id_rekening',
                't_rekening.kode_rekening',
                't_rekening.nama_rekening',
                't_master_sub_kegiatan.kode_sub_kegiatan',
                DB::raw("COALESCE(SUM(t_ssh.pagu1),0) AS p1"),
                DB::raw("COALESCE(SUM(t_ssh.pagu2),0) AS p2"),
                DB::raw("SUM(CASE WHEN t_ssh.pagu2 > 0 THEN t_ssh.pagu2 ELSE t_ssh.pagu1 END) AS sisa_total")
            ])
            ->leftJoin('t_master_sub_kegiatan', 't_master_sub_kegiatan.id_sub_kegiatan', '=', 't_rekening.id_sub_kegiatan')
            ->leftJoin('t_ssh', 't_ssh.id_rekening', '=', 't_rekening.id_rekening')
            ->where('t_rekening.id_sub_kegiatan', $id_sub_kegiatan) // parameter utama dari route
            ->when($id_program, fn($x) => $x->where('t_rekening.id_program', $id_program))
            ->when($id_kegiatan, fn($x) => $x->where('t_rekening.id_kegiatan', $id_kegiatan))
            ->when($filter_sub, fn($x) => $x->where('t_rekening.id_sub_kegiatan', $filter_sub))
            ->whereYear('t_ssh.tahun', $tahun) // filter tahun
            ->groupBy(
                't_rekening.id_rekening',
                't_rekening.kode_rekening',
                't_rekening.nama_rekening',
                't_master_sub_kegiatan.kode_sub_kegiatan',
            )

            ->orderBy('t_rekening.kode_rekening')
            ->get();


        $html = '';
        foreach ($rekening as $row) {
            $html .= '<tr class="child-of-' . $id_sub_kegiatan . '">';
            $html .= '<td class="text-center">
            <a href="#" class="btn btn-sm btn-outline-secondary btn-expand-rek" data-id="' . $row->id_rekening . '">
                <i class="fas fa-chevron-right"></i>
            </a>
        </td>';
            $html .= '<td>' .  e(formatKode($row->kode_sub_kegiatan, 'sub_kegiatan')) . '.' . e(formatKode($row->kode_rekening, 'rekening')) . '</td>';
            $html .= '<td><span class="px-2 py-1 rounded" style="background:#fff3cd; color:#856404;">' . e($row->nama_rekening) . '</span></td>';
            $html .= '<td class="text-right">' . number_format($row->p1, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format($row->p2, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format($row->real, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format((float)$row->sisa_total, 0, ',', '.') . '</td>';
            $html .= '</tr>';
        }

        if ($rekening->isEmpty()) {
            $html .= '<tr class="child-of-' . $id_sub_kegiatan . '"><td colspan="7" class="text-center text-muted">Tidak ada data rekening.</td></tr>';
        }

        return response($html);
    }




    public function listRekening(Request $request)
    {
        $id_program      = $request->id_program;
        $id_kegiatan     = $request->id_kegiatan;
        $id_sub_kegiatan = $request->id_sub_kegiatan;
        $tahun = $request->tahun ?? now()->year;


        $q = RekeningModel::query()
            ->from('t_rekening')
            ->select([
                't_rekening.id_rekening',
                't_rekening.kode_rekening',
                't_rekening.nama_rekening',
                't_rekening.id_program',
                't_rekening.id_kegiatan',
                't_rekening.id_sub_kegiatan',
                't_master_sub_kegiatan.kode_sub_kegiatan',
                DB::raw("COALESCE(SUM(t_ssh.pagu1),0) AS anggaran_periode1"),
                DB::raw("COALESCE(SUM(t_ssh.pagu2),0) AS anggaran_periode2"),
                DB::raw("SUM(CASE WHEN t_ssh.pagu2 > 0 THEN t_ssh.pagu2 ELSE t_ssh.pagu1 END) AS sisa_total")
            ])
            ->when($id_program, fn($x) => $x->where('t_rekening.id_program', $id_program))
            ->when($id_kegiatan, fn($x) => $x->where('t_rekening.id_kegiatan', $id_kegiatan))
            ->when($id_sub_kegiatan, fn($x) => $x->where('t_rekening.id_sub_kegiatan', $id_sub_kegiatan))
            ->leftJoin('t_ssh', 't_ssh.id_rekening', '=', 't_rekening.id_rekening')
            ->leftJoin('t_master_sub_kegiatan', 't_master_sub_kegiatan.id_sub_kegiatan', '=', 't_rekening.id_sub_kegiatan')
            ->when($id_program, fn($x) => $x->where('t_ssh.id_program', $id_program))
            ->when($id_kegiatan, fn($x) => $x->where('t_ssh.id_kegiatan', $id_kegiatan))
            ->whereYear('t_ssh.tahun', $tahun) // filter tahun
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
                    DB::raw("(COALESCE(SUM(t_ssh.pagu1),0)
                      + COALESCE(SUM(t_ssh.pagu2),0)
                      - COALESCE(rls.realisasi,0)) AS sisa_total"),
                ])
                ->groupBy('t_rekening.id_rekening', 't_rekening.kode_rekening', 't_rekening.nama_rekening', 't_rekening.id_program', 't_rekening.id_kegiatan', 't_rekening.id_sub_kegiatan', 'rls.realisasi');
        } else {
            // tanpa tabel realisasi
            $q->addSelect([
                DB::raw("0 AS realisasi"),
                DB::raw("(COALESCE(SUM(t_ssh.pagu1),0)
                      + COALESCE(SUM(t_ssh.pagu2),0)) AS sisa_total"),
            ])
                ->groupBy('t_rekening.id_rekening', 't_rekening.kode_rekening', 't_rekening.nama_rekening', 't_rekening.id_program', 't_rekening.id_kegiatan', 't_rekening.id_sub_kegiatan');
        }

        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn(
                'expand',
                fn($row) =>
                '<a href="#" class="btn btn-sm btn-outline-primary btn-expand" data-id="' . $row->id_rekening . '"><i class="fas fa-chevron-right"></i></a>'
            )
            ->addColumn('kode', function ($row) {
                return formatKode($row->kode_sub_kegiatan, 'sub_kegiatan') . '.' .
                    formatKode($row->kode_rekening, 'rekening');
            })
            ->addColumn(
                'uraian',
                fn($row) =>
                '<span class="px-2 py-1 rounded" style="background-color:#fff3cd; color:#856404;">'
                    . e($row->nama_rekening) .
                    '</span>'

            )
            ->addColumn('p1',     fn($row) => number_format((float)$row->anggaran_periode1, 0, ',', '.'))
            ->addColumn('p2',     fn($row) => number_format((float)$row->anggaran_periode2, 0, ',', '.'))
            ->addColumn('real', fn($row) => number_format(0, 0, ',', '.')) // sementara 0
            ->addColumn('sisa', fn($row) => number_format((float)$row->sisa_total, 0, ',', '.'))



            ->rawColumns(['expand', 'uraian'])
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
        $tahun = $request->tahun ?? now()->year;


        $ssh = SshModel::query()
            ->from('t_ssh')
            ->select([
                't_ssh.kode_ssh',
                't_ssh.nama_ssh',
                't_rekening.kode_rekening',
                't_master_sub_kegiatan.kode_sub_kegiatan',
                DB::raw("COALESCE(SUM(t_ssh.pagu1),0) AS p1"),
                DB::raw("COALESCE(SUM(t_ssh.pagu2),0) AS p2"),
                DB::raw("SUM(CASE WHEN t_ssh.pagu2 > 0 THEN t_ssh.pagu2 ELSE t_ssh.pagu1 END) AS sisa_total")
            ])
            ->leftJoin('t_master_sub_kegiatan', 't_master_sub_kegiatan.id_sub_kegiatan', '=', 't_ssh.id_sub_kegiatan')
            ->leftjoin('t_rekening', 't_rekening.id_rekening', '=', 't_ssh.id_rekening')
            ->where('t_ssh.id_rekening', $id_rekening)
            ->when($id_program, fn($x) => $x->where('t_ssh.id_program', $id_program))
            ->when($id_kegiatan, fn($x) => $x->where('t_ssh.id_kegiatan', $id_kegiatan))
            ->when($id_sub_kegiatan, fn($x) => $x->where('t_ssh.id_sub_kegiatan', $id_sub_kegiatan))
            ->whereYear('t_ssh.tahun', $tahun) // filter tahun
            ->groupBy(
                't_ssh.kode_ssh',
                't_ssh.nama_ssh',
                't_ssh.id_rekening',
                't_ssh.id_sub_kegiatan',
                't_master_sub_kegiatan.kode_sub_kegiatan',
                't_rekening.kode_rekening'
            )
            ->orderBy('t_ssh.kode_ssh')
            ->get();

        // realisasi per SSH: hanya jika tabel ada
        // $realisasiMap = [];
        // if (Schema::hasTable('t_realisasi_ssh')) {
        //     $realisasiMap = DB::table('t_realisasi_ssh')
        //         ->select('kode_ssh', DB::raw('COALESCE(SUM(amount),0) AS realisasi'))
        //         ->where('id_rekening', $id_rekening)
        //         ->groupBy('kode_ssh')
        //         ->pluck('realisasi', 'kode_ssh');
        // }

        // $html = '<table class="table table-sm table-bordered mb-0">';
        // $html .= '<thead class="thead-light"><tr>';
        // $html .= '<th style="width:140px">Kode</th><th>Uraian</th><th class="text-right">Periode 1</th><th class="text-right">Periode 2</th><th class="text-right">Realisasi</th><th class="text-right">Sisa</th>';
        // $html .= '</tr></thead><tbody>';
        $html = '';
        foreach ($ssh as $row) {
            // $real = (float)($realisasiMap[$row->kode_ssh] ?? 0);
            $real = 0;
            $sisa = (float)($row->p2 ?: $row->p1) - $real;

            $html .= '<tr class="child-of-' . $id_rekening . '">';
            $html .= '<td></td>'; // kolom expand kosong
            $html .= '<td>' . e(formatKode($row->kode_sub_kegiatan, 'sub_kegiatan')) . '.' . e(formatKode($row->kode_rekening, 'rekening')) . '.' . e(formatKode($row->kode_ssh, 'ssh')) . '</td>';
            $html .= '<td>
            <span class="px-2 py-1" style="background-color:#d4edda; color:#155724;">
            ' . e($row->nama_ssh) . '
        </span>
          </td>'; // SSH hijau dengan kotak
            $html .= '<td class="text-right">' . number_format($row->p1, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format($row->p2, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format($real, 0, ',', '.') . '</td>';
            $html .= '<td class="text-right">' . number_format($sisa, 0, ',', '.') . '</td>';
            $html .= '</tr>';
        }

        if ($ssh->isEmpty()) {
            $html .= '<tr class="child-of-' . $id_rekening . '"><td colspan="7" class="text-center text-muted">Tidak ada data SSH.</td></tr>';
        }

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
