<?php

namespace App\Http\Controllers;

use App\Models\JabatanStrukturalModel;
use App\Models\PegawaiModel;
use App\Models\UnitKerjaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JabatanStrukturalController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Jabatan Struktural',
            'list'  => ['Home', 'Jabatan Struktural']
        ];

        $page = (object) [
            'title' => 'Data Jabatan Struktural Pegawai'
        ];

        $activeMenu = 'jabatan-struktural';

        return view('jabatan_struktural.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = JabatanStrukturalModel::with(['pegawai', 'unitKerja'])
            ->select(
                'id_jabatan_struktural',
                'nip',
                'nama_jabatan',
                'jenis_pelantikan',
                'id_unit_kerja',
                'tmt_jabatan',
                'status_jabatan',
                'aktif'
            );

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_pegawai', fn($row) => $row->pegawai->nama ?? '-')
            ->addColumn('nama_unit_kerja', fn($row) => $row->unitKerja->nama_unit_kerja ?? '-')
            ->editColumn('tmt_jabatan', fn($row) => \Carbon\Carbon::parse($row->tmt_jabatan)->format('d-m-Y'))
            ->addColumn('aksi', function ($row) {
                return '
                    <button onclick="modalAction(`' . url('/jabatan_struktural/' . $row->id_jabatan_struktural . '/show') . '`)" class="btn btn-info btn-sm">Detail</button>
                    <button onclick="modalAction(`' . url('/jabatan_struktural/' . $row->id_jabatan_struktural . '/edit') . '`)" class="btn btn-warning btn-sm">Edit</button>
                    <button onclick="modalAction(`' . url('/jabatan_struktural/' . $row->id_jabatan_struktural . '/confirm') . '`)" class="btn btn-danger btn-sm">Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function create()
    {
        $pegawai   = PegawaiModel::all();
        $unitKerja = UnitKerjaModel::all();

        return view('jabatan_struktural.create', compact('pegawai', 'unitKerja'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nip'              => 'required|exists:t_pegawai,nip',
        'nama_jabatan'     => 'required|string|max:255',
        'jenis_pelantikan' => 'required|string|max:100',
        'id_unit_kerja'    => 'required|exists:t_unit_kerja,id_unit_kerja',
        'tmt_jabatan'      => 'required|date',
        'status_jabatan'   => 'required|in:mutasi,promosi',
        'aktif'            => 'required|boolean',
    ]);

    JabatanStrukturalModel::create($request->all());

    return response()->json([
        'status'  => true,
        'message' => 'Data berhasil disimpan.'
    ]);
}


    public function show($id)
    {
        $jabatan = JabatanStrukturalModel::with(['pegawai', 'unitKerja'])->find($id);

        if (!$jabatan) {
            abort(404);
        }

        return view('jabatan_struktural.show', compact('jabatan'));
    }

    public function edit($id)
    {
        $jabatan   = JabatanStrukturalModel::find($id);
        $pegawai   = PegawaiModel::all();
        $unitKerja = UnitKerjaModel::all();

        if (!$jabatan) {
            abort(404);
        }

        return view('jabatan_struktural.edit', compact('jabatan', 'pegawai', 'unitKerja'));
    }

    public function update(Request $request, $id)
{
    if ($request->ajax()) {
        $validator = Validator::make($request->all(), [
            'nama_jabatan'     => 'required|string|max:255',
            'jenis_pelantikan' => 'required|string|max:100',
            'id_unit_kerja'    => 'required|exists:t_unit_kerja,id_unit_kerja',
            'tmt_jabatan'      => 'required|date',
            'status_jabatan'   => 'required|in:mutasi,promosi',
            'aktif'            => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $jabatan = JabatanStrukturalModel::find($id);
        if (!$jabatan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan.'
            ]);
        }

        $jabatan->fill($request->except(['_token', '_method']));

        if (!$jabatan->isDirty()) {
            return response()->json([
                'status'  => false,
                'message' => 'Tidak ada perubahan data.'
            ]);
        }

        $jabatan->save();

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diupdate.'
        ]);
    }

    return redirect()->route('jabatan_struktural.index');
}


    public function confirm($id)
    {
        $jabatan = JabatanStrukturalModel::with(['pegawai', 'unitKerja'])->find($id);

        if (!$jabatan) {
            abort(404);
        }

        return view('jabatan_struktural.confirm', compact('jabatan'));
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax()) {
            $jabatan = JabatanStrukturalModel::find($id);

            if (!$jabatan) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }

            $jabatan->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        }

        return redirect()->route('jabatan_struktural.index');
    }
}
