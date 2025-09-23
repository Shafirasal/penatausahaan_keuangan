<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\MasterProgramModel;
use App\Models\MasterSubKegiatanModel;
use App\Models\RekeningModel;
use App\Models\SshModel;
use App\Models\RealisasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function formatKode;

class RealisasipbjController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Realisasi PBJ',
            'list'  => ['Home', 'Realisasi']
        ];

        $page = (object)[
            'title' => 'Data Realisasi PBJ'
        ];

        $activeMenu = 'realisasi';

        // LOCK: program 40107
        $program = MasterProgramModel::where('kode_program', '40107')->first();
        if ($program) {
            $program->kode_program_formatted = formatKode($program->kode_program, 'program');
        }

        // LOCK: kegiatan 40107101
        $kegiatan = MasterKegiatanModel::where('kode_kegiatan', '40107101')->first();
        if ($kegiatan) {
            $kegiatan->kode_kegiatan_formatted = formatKode($kegiatan->kode_kegiatan, 'kegiatan');
        }

        // Hitung pagu & sisa awal kegiatan (fallback p2 -> p1)
        if ($kegiatan) {
            $pagu = $kegiatan->p2 ?? $kegiatan->p1;
            $real = RealisasiModel::where('id_kegiatan', $kegiatan->id_kegiatan)->sum('nilai_realisasi');
            $sisa = (float)$pagu - (float)$real;
        } else {
            $pagu = 0;
            $sisa = 0;
        }

        $tahunSekarang = now()->year;
        $tahunRange    = range(2013, $tahunSekarang + 3);

        return view('realisasipbj.index', compact(
            'breadcrumb',
            'page',
            'activeMenu',
            'program',
            'kegiatan',
            'pagu',
            'sisa',
            'tahunRange',
            'tahunSekarang'
        ));
    }

    // ===== Summary =====
    public function getSummaryByKegiatan($id_kegiatan)
    {
        try {
            $kegiatan = MasterKegiatanModel::with(['rekening.ssh.realisasi'])->findOrFail($id_kegiatan);

            $total_pagu = 0;
            $total_realisasi = 0;

            foreach ($kegiatan->rekening as $rek) {
                foreach ($rek->ssh as $ssh) {
                    $total_pagu       += (float)$ssh->pagu_final;
                    $total_realisasi  += (float)$ssh->realisasi->sum('nilai_realisasi');
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'total_pagu'       => $total_pagu,
                    'total_realisasi'  => $total_realisasi,
                    'sisa'             => $total_pagu - $total_realisasi,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getSummaryBySsh($id_ssh)
    {
        try {
            $ssh = SshModel::with('realisasi')->findOrFail($id_ssh);

            $total_pagu       = (float)$ssh->pagu_final;
            $total_realisasi  = (float)$ssh->realisasi->sum('nilai_realisasi');

            return response()->json([
                'success' => true,
                'data' => [
                    'pagu_final'      => $total_pagu,
                    'total_realisasi' => $total_realisasi,
                    'sisa'            => $total_pagu - $total_realisasi,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung summary SSH: ' . $e->getMessage()
            ], 500);
        }
    }

    // ===== Cascading =====
    public function getSubKegiatanByKegiatan($id_kegiatan)
    {
        try {
            $subKegiatan = MasterSubKegiatanModel::with(['rekening.ssh.realisasi'])
                ->where('id_kegiatan', $id_kegiatan)
                ->orderBy('kode_sub_kegiatan')
                ->get()
                ->map(function ($item) {
                    $total_pagu = 0;
                    $total_realisasi = 0;
                    foreach ($item->rekening as $rek) {
                        foreach ($rek->ssh as $ssh) {
                            $total_pagu      += (float)$ssh->pagu_final;
                            $total_realisasi += (float)$ssh->realisasi->sum('nilai_realisasi');
                        }
                    }
                    return [
                        'id_sub_kegiatan'   => $item->id_sub_kegiatan,
                        'kode_sub_kegiatan' => formatKode($item->kode_sub_kegiatan, 'sub_kegiatan'),
                        'nama_sub_kegiatan' => $item->nama_sub_kegiatan,
                        'total_pagu'        => $total_pagu,
                        'total_realisasi'   => $total_realisasi,
                        'sisa'              => $total_pagu - $total_realisasi,
                    ];
                });

            return response()->json(['success' => true, 'data' => $subKegiatan]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memuat data sub kegiatan: ' . $e->getMessage()], 500);
        }
    }

    public function getRekeningBySubKegiatan($id_sub_kegiatan)
    {
        try {
            $rekening = RekeningModel::with(['ssh.realisasi'])
                ->where('id_sub_kegiatan', $id_sub_kegiatan)
                ->orderBy('kode_rekening')
                ->get()
                ->map(function ($item) {
                    $total_pagu = 0;
                    $total_realisasi = 0;
                    foreach ($item->ssh as $ssh) {
                        $total_pagu      += (float)$ssh->pagu_final;
                        $total_realisasi += (float)$ssh->realisasi->sum('nilai_realisasi');
                    }
                    return [
                        'id_sub_kegiatan' => $item->id_sub_kegiatan,
                        'id_rekening'     => $item->id_rekening,
                        'kode_rekening'   => formatKode($item->kode_rekening, 'rekening'),
                        'nama_rekening'   => $item->nama_rekening,
                        'total_pagu'      => $total_pagu,
                        'total_realisasi' => $total_realisasi,
                        'sisa'            => $total_pagu - $total_realisasi,
                    ];
                });

            return response()->json(['success' => true, 'data' => $rekening]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getSshByRekening($id_rekening)
    {
        try {
            $ssh = DB::table('t_ssh as s')
                ->leftJoin('t_transaksional_realisasi_anggaran as r', 's.id_ssh', '=', 'r.id_ssh')
                ->where('s.id_rekening', $id_rekening)
                ->select(
                    's.id_ssh',
                    's.kode_ssh',
                    's.nama_ssh',
                    's.pagu1',
                    's.pagu2',
                    DB::raw('COALESCE(SUM(r.nilai_realisasi), 0) as realisasi'),
                    DB::raw('(CASE WHEN s.pagu2 IS NOT NULL AND s.pagu2 > 0 THEN s.pagu2 ELSE s.pagu1 END) as pagu_final')
                )
                ->groupBy('s.id_ssh', 's.kode_ssh', 's.nama_ssh', 's.pagu1', 's.pagu2')
                ->orderBy('s.kode_ssh')
                ->get()
                ->map(function ($item) {
                    $item->kode_ssh = formatKode($item->kode_ssh, 'ssh');
                    $item->sisa     = (float)$item->pagu_final - (float)$item->realisasi;
                    return $item;
                });

            return response()->json([
                'success'     => true,
                'data'        => $ssh,
                'count'       => $ssh->count(),
                'id_rekening' => $id_rekening
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => 'Gagal memuat data SSH',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ===== Store =====
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_program'        => 'required|integer|exists:t_master_program,id_program',
            'id_kegiatan'       => 'required|integer|exists:t_master_kegiatan,id_kegiatan',
            'id_sub_kegiatan'   => 'required|integer|exists:t_master_sub_kegiatan,id_sub_kegiatan',
            'id_rekening'       => 'required|integer|exists:t_rekening,id_rekening',
            'id_ssh'            => 'required|integer|exists:t_ssh,id_ssh',
            'jenis_realisasi'   => 'required|string|in:Kwitansi,Nota,Dokumen Lainnya',
            'no_dokumen'        => 'nullable|string|max:255',
            'nilai_realisasi'   => 'required|string',
            'tanggal_realisasi' => 'required|date',
            'file'              => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // Normalisasi numeric string ke float (IDR)
            $nilai = str_replace('.', '', $validated['nilai_realisasi']);
            $nilai = str_replace(',', '.', $nilai);
            $validated['nilai_realisasi'] = (float)$nilai;

            // Upload file (opsional)
            if ($request->hasFile('file')) {
                $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
                $request->file('file')->storeAs('realisasi', $fileName, 'public');
                $validated['file'] = $fileName;
            }

            $realisasi = RealisasiModel::create($validated);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Data realisasi berhasil disimpan.',
                'data'    => $realisasi
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
