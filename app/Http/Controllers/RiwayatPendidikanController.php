<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendidikanModel;
use App\Models\PegawaiModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RiwayatPendidikanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Riwayat Pendidikan',
            'list' => ['Home', 'Riwayat Pendidikan']
        ];

        $page = (object)[
            'title' => 'Data Riwayat Pendidikan Pegawai'
        ];

        $activeMenu = 'pendidikan';

        return view('riwayat_pendidikan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = RiwayatPendidikanModel::with('pegawai')->select(
            'id_pendidikan',
            'nip',
            'nama_sekolah',
            'tingkat',
            'prodi_jurusan',
            'tahun_lulus',
            'aktif'
        );

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_pegawai', function ($row) {
                return $row->pegawai->nama ?? '-';
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/riwayat_pendidikan/' . $row->id_pendidikan . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/riwayat_pendidikan/' . $row->id_pendidikan . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/riwayat_pendidikan/' . $row->id_pendidikan . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function create()
    {
        $pegawai = PegawaiModel::all();
        return view('riwayat_pendidikan.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|exists:t_pegawai,nip',
            'nama_sekolah' => 'required|string',
            'tingkat' => 'required|string',
            'prodi_jurusan' => 'nullable|string',
            'tahun_lulus' => 'nullable|digits:4',
            'aktif' => 'required|boolean',
        ]);

        RiwayatPendidikanModel::create($request->all());

        return response()->json(['message' => 'Data berhasil disimpan.']);
    }

      public function show(String $id)
    {
        $pendidikan = RiwayatPendidikanModel::with('pegawai')->find($id);
        return view('riwayat_pendidikan.show', ['pendidikan' => $pendidikan]);
    }


    public function delete(Request $request, $id)
{
    // Cek apakah request berasal dari AJAX
    if ($request->ajax() || $request->wantsJson()) {
        try {
            // Cari data berdasarkan primary key 'id_pendidikan'
            $riwayat = RiwayatPendidikanModel::find($id);

            if ($riwayat) {
                // Hapus data
                $riwayat->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data riwayat pendidikan berhasil dihapus.'
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
    return redirect()->route('riwayat_pendidikan.index');
}

public function confirm(string $id)
{
    $riwayatPendidikan = RiwayatPendidikanModel::find($id);

    return view('riwayat_pendidikan.confirm', ['riwayatPendidikan' => $riwayatPendidikan]);
}


    // public function edit($id)
    // {
    //     $data = RiwayatPendidikanModel::find($id);
    //     $pegawai = PegawaiModel::all();

    //     if (!$data) {
    //         return response()->json(['message' => 'Data tidak ditemukan.'], 404);
    //     }

    //     return view('riwayat_pendidikan.edit', compact('data', 'pegawai'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nip' => 'required|exists:t_pegawai,nip',
    //         'nama_sekolah' => 'required|string',
    //         'tingkat' => 'required|string',
    //         'prodi_jurusan' => 'nullable|string',
    //         'tahun_lulus' => 'nullable|digits:4',
    //         'aktif' => 'required|boolean',
    //     ]);

    //     $data = RiwayatPendidikanModel::find($id);

    //     if (!$data) {
    //         return response()->json(['message' => 'Data tidak ditemukan.'], 404);
    //     }

    //     $data->update($request->all());

    //     return response()->json(['message' => 'Data berhasil diperbarui.']);
    // }

    // public function destroy($id)
    // {
    //     $data = RiwayatPendidikanModel::find($id);

    //     if (!$data) {
    //         return response()->json(['message' => 'Data tidak ditemukan.'], 404);
    //     }

    //     $data->delete();

    //     return response()->json(['message' => 'Data berhasil dihapus.']);
    // }
}
