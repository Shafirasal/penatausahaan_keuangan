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

    /**
     * Get kegiatan berdasarkan program
     */
    public function getKegiatanByProgram($id_program)
    {
        try {
            $kegiatan = MasterKegiatanModel::where('id_program', $id_program)
                ->select('id_kegiatan', 'kode_kegiatan', 'nama_kegiatan')
                ->orderBy('kode_kegiatan')
                ->get();
            
            return response()->json($kegiatan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data kegiatan'], 500);
        }
    }

    /**
     * Get sub kegiatan berdasarkan kegiatan
     */
    public function getSubKegiatanByKegiatan($id_kegiatan)
    {
        try {
            $subKegiatan = MasterSubKegiatanModel::where('id_kegiatan', $id_kegiatan)
                ->select('id_sub_kegiatan', 'kode_sub_kegiatan', 'nama_sub_kegiatan')
                ->orderBy('kode_sub_kegiatan')
                ->get();
            
            return response()->json($subKegiatan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data sub kegiatan'], 500);
        }
    }

    /**
     * Get rekening berdasarkan sub kegiatan
     */
    public function getRekeningBySubKegiatan($id_sub_kegiatan)
    {
        try {
            $rekening = RekeningModel::where('id_sub_kegiatan', $id_sub_kegiatan)
                ->select('id_rekening', 'kode_rekening', 'nama_rekening')
                ->orderBy('kode_rekening')
                ->get();
            
            return response()->json($rekening);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data rekening'], 500);
        }
    }

    /**
     * Get SSH berdasarkan rekening
     */
public function getSshByRekening($id_rekening)
{
    try {
        $ssh = SshModel::where('id_rekening', $id_rekening)
            ->select('id_ssh', 'kode_ssh', 'nama_ssh')
            ->orderBy('kode_ssh')
            ->get()
            ->map(function ($item) {
                // Format kode SSH sama seperti di SSHController
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


    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_program' => 'required|integer|exists:t_master_program,id_program',
            'id_kegiatan' => 'required|integer|exists:t_master_kegiatan,id_kegiatan',
            'id_sub_kegiatan' => 'required|integer|exists:t_master_sub_kegiatan,id_sub_kegiatan',
            'id_rekening' => 'required|integer|exists:t_rekening,id_rekening',
            'id_ssh' => 'required|integer|exists:t_ssh,id_ssh',
            'jenis_realisasi' => 'required|string|in:Kwitansi,Nota,Dokumen Lainnya',
            'no_dokumen' => 'nullable|string|max:100',
            'nilai_realisasi' => 'required|string',
            'tanggal_realisasi' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120', // max 5MB
            'keterangan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Konversi nilai realisasi dari format "1.000,00" ke float
            $nilaiRealisasi = $this->parseRupiahToNumber($request->nilai_realisasi);

            // Persiapkan data untuk disimpan
            $data = [
                'id_program' => $request->id_program,
                'id_kegiatan' => $request->id_kegiatan,
                'id_sub_kegiatan' => $request->id_sub_kegiatan,
                'id_rekening' => $request->id_rekening,
                'id_ssh' => $request->id_ssh,
                'jenis_realisasi' => $request->jenis_realisasi,
                'no_dokumen' => $request->no_dokumen,
                'nilai_realisasi' => $nilaiRealisasi,
                'tanggal_realisasi' => $request->tanggal_realisasi,
                'keterangan' => $request->keterangan,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Handle file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('realisasi', $fileName, 'public');
                $data['file_path'] = $filePath;
                $data['file_name'] = $file->getClientOriginalName();
            }

            // Simpan data realisasi
            $realisasi = RealisasiModel::create($data);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data realisasi berhasil disimpan.',
                    'data' => $realisasi
                ]);
            }

            return redirect()->route('realisasipbj.index')
                ->with('success', 'Data realisasi berhasil disimpan.');

        } catch (QueryException $e) {
            DB::rollBack();
            
            $message = 'Gagal menyimpan data realisasi. ';
            if ($e->getCode() == '23000') {
                $message .= 'Data yang sama sudah ada.';
            } else {
                $message .= 'Silakan coba lagi.';
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => $message
                ]);
            }

            return redirect()->back()
                ->with('error', $message)
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
                ]);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.')
                ->withInput();
        }
    }
    // ===== CRUD METHODS (placeholder) =====

    public function list(Request $request)
    {
        // DataTables implementation
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