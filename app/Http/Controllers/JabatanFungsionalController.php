<?php

namespace App\Http\Controllers;

use App\Models\JabatanFungsionalModel;
use App\Models\PegawaiModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JabatanFungsionalController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Jabatan Fungsional',
            'list' => ['Home', 'Jabatan Fungsional']
        ];

        $page = (object)[
            'title' => 'Data Jabatan Fungsional Pegawai'
        ];

        $activeMenu = 'jabatan_fungsional';

        return view('jabatan_fungsional.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        $data = JabatanFungsionalModel::with('pegawai')
        ->where('nip', $user->nip)
        ->select(
            'id_jabatan_fungsional',
            'nip',
            'nama_jabatan',
            'instansi',
            'tmt_jabatan',
            'PAK',
            'status_fungsional',
            'status_diklat',
            'aktif'
        );

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/jabatan_fungsional/' . $row->id_jabatan_fungsional . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jabatan_fungsional/' . $row->id_jabatan_fungsional . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jabatan_fungsional/' . $row->id_jabatan_fungsional . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function create()
    {
        $pegawai = PegawaiModel::all();
        return view('jabatan_fungsional.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|exists:t_pegawai,nip',
            'nama_jabatan' => 'required|string|max:100',
            'instansi' => 'required|string|max:100',
            'tmt_jabatan' => 'required|date',
            'PAK' => 'required|integer|min:0',
            'status_fungsional' => 'required|in:promosi,perpindahan dari jabatan lain, pertama',
            'status_diklat' => 'required|string|max:100',
            'aktif' => 'required|in:ya,tidak'
        ]);

        JabatanFungsionalModel::create($request->all());

        return response()->json(['message' => 'Data berhasil disimpan.']);
    }

    public function show(String $id)
    {
        $jabatan_fungsional = JabatanFungsionalModel::with('pegawai')->find($id);
        return view('jabatan_fungsional.show', ['jabatan_fungsional' => $jabatan_fungsional]);
    }

    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $jabatan_fungsional = JabatanFungsionalModel::find($id);

        if (!$jabatan_fungsional) {
            abort(404, 'Data tidak ditemukan.');
        }

        return view('jabatan_fungsional.edit', [
            'jabatan_fungsional' => $jabatan_fungsional,
        ]);
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_jabatan'       => 'required|string|max:100',
                'instansi'           => 'required|string|max:100',
                'tmt_jabatan'        => 'required|date',
                'PAK'                => 'required|integer|min:0',
                'status_fungsional'  => 'required|in:promosi,perpindahan dari jabatan lain,pertama',
                'status_diklat'      => 'required|string|max:100',
                'aktif'              => 'required|in:ya,tidak'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $jabatan = JabatanFungsionalModel::find($id);

            if ($jabatan) {
                $jabatan->update($request->only([
                    'nama_jabatan',
                    'instansi',
                    'tmt_jabatan',
                    'PAK',
                    'status_fungsional',
                    'status_diklat',
                    'aktif'
                ]));

                return response()->json([
                    'status' => true,
                    'message' => 'Data Jabatan Fungsional berhasil diupdate.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }
        }

        return redirect('/');
    }


     public function delete(Request $request, $id)
{
    // Cek apakah request berasal dari AJAX
    if ($request->ajax() || $request->wantsJson()) {
        try {
            // Cari data berdasarkan primary key 'id_pendidikan'
            $jabatan_fungsional = JabatanFungsionalModel::find($id);

            if ($jabatan_fungsional) {
                // Hapus data
                $jabatan_fungsional->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data Jabatan Fungsional berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak dapat dihapus karena masih terkait dengan data lain.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    // Jika bukan AJAX, redirect ke halaman daftar riwayat pendidikan
    return redirect()->route('jabatan_fungsional.index');
}

public function confirm(string $id)
{
    $jabatan_fungsional = JabatanFungsionalModel::find($id);

    return view('jabatan_fungsional.confirm', ['jabatan_fungsional' => $jabatan_fungsional]);
}

}
