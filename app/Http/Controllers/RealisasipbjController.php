<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\MasterProgramModel;
use App\Models\MasterSubKegiatanModel;
use App\Models\RekeningModel;
use App\Models\SshModel;
use App\Models\RealisasiModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use function formatKode;

class RealisasipbjController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Realisasi',
            'list' => ['Home', 'Realisasi']
        ];

        $page = (object)[
            'title' => 'Data Realisasi'
        ];

        $activeMenu = 'realisasi';
        $listProgram = MasterProgramModel::select('id_program', 'nama_program', 'kode_program')->get()->map(function ($program) {
            $program->kode_program = formatKode($program->kode_program, 'program');
            return $program;
        });

        $tahunSekarang = now()->year;
        $tahunRange = range(2013, $tahunSekarang + 3);

        return view('realisasipbj.index', compact('breadcrumb', 'page', 'activeMenu', 'listProgram', 'tahunRange', 'tahunSekarang'));
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Form Realisasi',
            'list' => ['Home', 'Realisasi', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Realisasi'
        ];

        $activeMenu = 'realisasi';
        $listProgram = MasterProgramModel::select('id_program', 'nama_program', 'kode_program')->get()->map(function ($program) {
            $program->kode_program = formatKode($program->kode_program, 'program');
            return $program;
        });

        return view('realisasipbj.create', compact('breadcrumb', 'page', 'activeMenu', 'listProgram'));
    }

    // ===== CASCADING DROPDOWN METHODS =====


    public function getKegiatanByProgram($id_program)
    {
        try {
            $kegiatan = MasterKegiatanModel::where('id_program', $id_program)
                ->select('id_kegiatan', 'kode_kegiatan', 'nama_kegiatan')
                ->orderBy('kode_kegiatan')
                ->get()
                ->map(function ($item) {
                    $item->kode_kegiatan = formatKode($item->kode_kegiatan, 'kegiatan');
                    return $item;
                });
            
            return response()->json($kegiatan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data kegiatan'], 500);
        }
    }

    public function getSubKegiatanByKegiatan($id_kegiatan)
    {
        try {
            $subKegiatan = MasterSubKegiatanModel::where('id_kegiatan', $id_kegiatan)
                ->select('id_sub_kegiatan', 'kode_sub_kegiatan', 'nama_sub_kegiatan')
                ->orderBy('kode_sub_kegiatan')
                ->get()
                ->map(function ($item) {
                    $item->kode_sub_kegiatan = formatKode($item->kode_sub_kegiatan, 'sub_kegiatan');
                    return $item;
                });
            
            return response()->json($subKegiatan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data sub kegiatan'], 500);
        }
    }

    public function getRekeningBySubKegiatan($id_sub_kegiatan)
    {
        try {
            $rekening = RekeningModel::where('id_sub_kegiatan', $id_sub_kegiatan)
                ->select('id_rekening', 'kode_rekening', 'nama_rekening')
                ->orderBy('kode_rekening')
                ->get()
                ->map(function ($item) {
                    $item->kode_rekening = formatKode($item->kode_rekening, 'rekening');
                    return $item;
                });
            
            return response()->json($rekening);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data rekening'], 500);
        }
    }

    public function getSshByRekening($id_rekening)
    {
        try {
            $ssh = SshModel::where('id_rekening', $id_rekening)
                ->select('id_ssh', 'kode_ssh', 'nama_ssh')
                ->orderBy('kode_ssh')
                ->get()
                ->map(function ($item) {
                    $item->kode_ssh = formatKode($item->kode_ssh, 'ssh');
                    return $item;
                });
            
            return response()->json([
                'success' => true,
                'data' => $ssh,
                'count' => $ssh->count(),
                'id_rekening' => $id_rekening
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Gagal memuat data SSH',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    // ===== CRUD METHODS (placeholder) =====

    public function list(Request $request)
    {
        // DataTables implementation
    }

    public function store(Request $request)
    {
        // Store implementation
    }

    public function edit($id)
    {
        // Edit implementation
    }

    public function update(Request $request, $id)
    {
        // Update implementation
    }

    public function confirm($id)
    {
        // Confirm implementation
    }

    public function delete($id)
    {
        // Delete implementation
    }
}