<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendidikanModel;
use App\Models\PegawaiModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            ->editColumn('tahun_lulus', function ($row) {
                return \Carbon\Carbon::parse($row->tahun_lulus)->format('Y');
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
            'tahun_lulus' => 'nullable|date',
            'aktif' => 'required|in:ya,tidak',
        ]);

        RiwayatPendidikanModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
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


    public function edit(String $id)
    {
        $riwayat = RiwayatPendidikanModel::find($id);

        return view('riwayat_pendidikan.edit', ['riwayat' => $riwayat]);
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_sekolah'   => 'required|string|max:255',
                'tingkat'        => 'required|string|max:50',
                'prodi_jurusan'  => 'nullable|string|max:100',
                'tahun_lulus'    => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'aktif'          => 'required|in:ya,tidak',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $riwayat = RiwayatPendidikanModel::find($id);
            if ($riwayat) {
                // Siapkan data untuk update
                $data = $request->except(['_token', '_method']);
                $data['tahun_lulus'] = $request->tahun_lulus . '-01-01';

                // *** CLEANER WAY: Use fill() then check isDirty() ***
                $riwayat->fill($data);

                // Check if any attributes were actually changed
                if (!$riwayat->isDirty()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada perubahan data yang dilakukan.'
                    ]);
                }

                // Save the changes
                $riwayat->save();
                // *** END OF CLEANER METHOD ***

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    // public function update(Request $request, $id)
    // {
    //     if ($request->ajax() || $request->wantsJson()) {
    //         $rules = [
    //             'nama_sekolah'   => 'required|string|max:255',
    //             'tingkat'        => 'required|string|max:50',
    //             'prodi_jurusan'  => 'nullable|string|max:100',
    //             'tahun_lulus'    => 'required|digits:4|integer|min:1900|max:' . date('Y'),
    //             'aktif'          => 'required|in:ya,tidak',
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Validasi gagal.',
    //                 'msgField' => $validator->errors()
    //             ]);
    //         }

    //         $riwayat = RiwayatPendidikanModel::find($id);
    //         if ($riwayat) {
    //             // Ubah tahun jadi format DATE
    //             $data = $request->except(['_token', '_method']);
    //             $data['tahun_lulus'] = $request->tahun_lulus . '-01-01';

    //             $riwayat->update($data);

    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data berhasil diupdate'
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data tidak ditemukan'
    //             ]);
    //         }
    //     }

    //     return redirect('/');
    // }



    //REKOMENDASI MAIN FUNGSINYA
    // public function update(Request $request, $id)
    // {
    //     if ($request->ajax() || $request->wantsJson()) {
    //         $rules = [
    //             'nama_sekolah'   => 'required|string|max:255',
    //             'tingkat'        => 'required|string|max:50',
    //             'prodi_jurusan'  => 'nullable|string|max:100',
    //             'tahun_lulus'    => 'required|digits:4|integer|min:1900|max:' . date('Y'),
    //             'aktif'          => 'required|in:ya,tidak',
    //         ];

    //         $validator = Validator::make($request->all(), $rules);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Validasi gagal.',
    //                 'msgField' => $validator->errors()
    //             ]);
    //         }

    //         $riwayat = RiwayatPendidikanModel::find($id);
    //         if ($riwayat) {
    //             $riwayat->update($request->all());
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Data berhasil diupdate'
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data tidak ditemukan'
    //             ]);
    //         }
    //     }

    //     return redirect('/');
    // }

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
