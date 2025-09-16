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

        return view('realisasipbj.index', compact('breadcrumb', 'page', 'activeMenu', 'listProgram'));
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


private function parseRupiahToInt($rupiah)
{
    // Hapus semua karakter non-digit
    $number = preg_replace('/[^\d]/', '', $rupiah);
    return (int) $number;
}

public function store(Request $request)
{
    // Validasi input
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

        // Normalisasi nilai realisasi
        $nilai = str_replace('.', '', $validated['nilai_realisasi']);
        $nilai = str_replace(',', '.', $nilai);
        $validated['nilai_realisasi'] = (float) $nilai;

        // Handle file upload
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('realisasi', $fileName, 'public');
            $validated['file'] = $fileName;
        }

        // Simpan ke DB
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

// public function store(Request $request)
// {
//     // Validasi input
//     $validator = Validator::make($request->all(), [
//         'id_program' => 'required|integer|exists:t_master_program,id_program',
//         'id_kegiatan' => 'required|integer|exists:t_master_kegiatan,id_kegiatan',
//         'id_sub_kegiatan' => 'required|integer|exists:t_master_sub_kegiatan,id_sub_kegiatan',
//         'id_rekening' => 'required|integer|exists:t_rekening,id_rekening',
//         'id_ssh' => 'required|integer|exists:t_ssh,id_ssh',
//         'jenis_realisasi' => 'required|string|in:Kwitansi,Nota,Dokumen Lainnya',
//         'no_dokumen' => 'nullable|string|max:255',
//         'nilai_realisasi' => 'required|integer|min:0',
//         'tanggal_realisasi' => 'required|date',
//         'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
//     ]);

//     if ($validator->fails()) {
//         if ($request->expectsJson()) {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Validasi gagal.',
//                 'msgField' => $validator->errors()
//             ]);
//         }
        
//         return redirect()->back()
//             ->withErrors($validator)
//             ->withInput();
//     }

//     try {
//         DB::beginTransaction();

//         // Persiapkan data untuk disimpan
//         $data = [
//             'id_program' => $request->id_program,
//             'id_kegiatan' => $request->id_kegiatan,
//             'id_sub_kegiatan' => $request->id_sub_kegiatan,
//             'id_rekening' => $request->id_rekening,
//             'id_ssh' => $request->id_ssh,
//             'jenis_realisasi' => $request->jenis_realisasi,
//             'no_dokumen' => $request->no_dokumen,
//             'nilai_realisasi' => (int) $request->nilai_realisasi, // Langsung cast ke integer
//             'tanggal_realisasi' => $request->tanggal_realisasi,
//         ];

//         // Handle file upload
//         if ($request->hasFile('file')) {
//             $file = $request->file('file');
//             $fileName = time() . '_' . $file->getClientOriginalName();
//             $filePath = $file->storeAs('realisasi', $fileName, 'public');
//             $data['file'] = $fileName;
//         }

//         // Simpan data realisasi
//         $realisasi = RealisasiModel::create($data);

//         DB::commit();

//         if ($request->expectsJson()) {
//             return response()->json([
//                 'status' => true,
//                 'message' => 'Data realisasi berhasil disimpan.',
//                 'data' => $realisasi
//             ]);
//         }

//         return redirect()->route('realisasipbj.index')
//             ->with('success', 'Data realisasi berhasil disimpan.');

//     } catch (QueryException $e) {
//         DB::rollBack();
        
//         $message = 'Gagal menyimpan data realisasi. ';
//         if ($e->getCode() == '23000') {
//             $message .= 'Data yang sama sudah ada.';
//         } else {
//             $message .= 'Silakan coba lagi.';
//         }

//         if ($request->expectsJson()) {
//             return response()->json([
//                 'status' => false,
//                 'message' => $message,
//                 'error' => $e->getMessage() // Tambahkan detail error untuk debugging
//             ]);
//         }

//         return redirect()->back()
//             ->with('error', $message)
//             ->withInput();

//     } catch (\Exception $e) {
//         DB::rollBack();

//         if ($request->expectsJson()) {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
//                 'error' => $e->getMessage() // Tambahkan detail error untuk debugging
//             ]);
//         }

//         return redirect()->back()
//             ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.')
//             ->withInput();
//     }
// }

    
}