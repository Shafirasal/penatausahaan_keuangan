<?php

namespace App\Http\Controllers;

use App\Models\PegawaiModel;
use App\Models\JabatanStrukturalModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JabatanStrukturalController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Jabatan Struktural',
            'list' => ['Home', 'Jabatan Struktural']
        ];

        $page = (object) [
            'title' => 'Data Jabatan Struktural Pegawai'
        ];

        $activeMenu = 'jabatan';

        return view('jabatan_struktural.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = JabatanStrukturalModel::with('pegawai')->select(
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
            ->addColumn('nama_pegawai', function ($row) {
                return $row->pegawai->nama ?? '-';
            })
            ->addColumn('action', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/jabatan_struktural/' . $row->id_jabatan_struktural . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jabatan_struktural/' . $row->id_jabatan_struktural . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jabatan_struktural/' . $row->id_jabatan_struktural . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create()
    {
        $pegawai = PegawaiModel::all();
        return view('jabatan_struktural.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|exists:t_pegawai,nip',
            'nama_jabatan' => 'required|string',
            'jenis_pelantikan' => 'required|string',
            'id_unit_kerja' => 'required|integer',
            'tmt_jabatan' => 'required|date',
            'status_jabatan' => 'required|string',
            'aktif' => 'required|boolean',
        ]);

        JabatanStrukturalModel::create($validated);

        return response()->json(['message' => 'Data berhasil disimpan.']);
    }

    public function show($id)
    {
        $data = JabatanStrukturalModel::with('pegawai')->find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        return view('jabatan_struktural.show', compact('data'));
    }

    public function edit($id)
    {
        $data = JabatanStrukturalModel::find($id);
        $pegawai = PegawaiModel::all();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        return view('jabatan_struktural.edit', compact('data', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|string|exists:t_pegawai,nip',
            'nama_jabatan' => 'required|string',
            'jenis_pelantikan' => 'required|string',
            'id_unit_kerja' => 'required|integer',
            'tmt_jabatan' => 'required|date',
            'status_jabatan' => 'required|string',
            'aktif' => 'required|boolean',
        ]);

        $data = JabatanStrukturalModel::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $data->update($request->all());

        return response()->json(['message' => 'Data berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $data = JabatanStrukturalModel::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
