<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKepegawaianModel;
use App\Models\GolonganModel;
use App\Models\JenisKenaikanPangkatModel;
use App\Models\PegawaiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RiwayatKepegawaianController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Riwayat Kepegawaian',
            'list' => ['Home', 'Riwayat Kepegawaian']
        ];

        $page = (object)[
            'title' => 'Data Riwayat Kepegawaian'
        ];

        $activeMenu = 'riwayat-kepegawaian';

        return view('riwayat_kepegawaian.index', compact('breadcrumb', 'page', 'activeMenu'));
    }


    
    public function list(Request $request)
    {
        $data = RiwayatKepegawaianModel::with(['pegawai', 'golongan', 'jenisKenaikanPangkat'])->select(
            'id_riwayat_kepegawaian',
            'nip',
            'id_golongan',
            'id_jenis_kp',
            'tmt_pangkat',
            'file',
            'keterangan',
            'aktif'
        );

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_pegawai', fn($row) => $row->pegawai->nama ?? '-')
            ->addColumn('nama_golongan', fn($row) => $row->golongan->nama_golongan ?? '-')
            ->addColumn('nama_jenis_kp', fn($row) => $row->jenisKenaikanPangkat->nama_jenis ?? '-')
            ->addColumn('aksi', function ($row) {
                return '
                    <button onclick="modalAction(`' . url('/riwayat_kepegawaian/' . $row->id_riwayat_kepegawaian . '/show') . '`)" class="btn btn-info btn-sm">Detail</button>
                    <button onclick="modalAction(`' . url('/riwayat_kepegawaian/' . $row->id_riwayat_kepegawaian . '/edit') . '`)" class="btn btn-warning btn-sm">Edit</button>
                    <button onclick="modalAction(`' . url('/riwayat_kepegawaian/' . $row->id_riwayat_kepegawaian . '/confirm') . '`)" class="btn btn-danger btn-sm">Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function show(string $id)
{
    $kepegawaian = RiwayatKepegawaianModel::with(['pegawai', 'golongan', 'jenisKenaikanPangkat'])->findOrFail($id);
    return view('riwayat_kepegawaian.show', ['kepegawaian' => $kepegawaian]);
}

public function confirm(string $id)
{
    $kepegawaian = RiwayatKepegawaianModel::with(['pegawai', 'golongan', 'jenisKenaikanPangkat'])->find($id);

    return view('riwayat_kepegawaian.confirm', ['kepegawaian' => $kepegawaian]);
}

    public function delete(Request $request, $id)
    {
        if ($request->ajax()) {
            $kepegawaian = RiwayatKepegawaianModel::find($id);

            if (!$kepegawaian) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }

            $kepegawaian->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        }

        return redirect()->route('riwayat_kepegawaian.index');
    }
        public function edit($id)
    {
        $kepegawaian = RiwayatKepegawaianModel::findOrFail($id);
        $golongan = GolonganModel::all();
        $jenisKp = JenisKenaikanPangkatModel::all();

        if (!$jenisKp) {
            abort(404);
        }

        return view('riwayat_kepegawaian.edit', compact('kepegawaian', 'golongan', 'jenisKp'));
    }


    public function update(Request $request, $id)
    {
        $riwayat = RiwayatKepegawaianModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nip' => 'required|exists:t_pegawai,nip',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'id_golongan' => 'required|exists:t_golongan,id_golongan',
            'id_jenis_kp' => 'required|exists:t_jenis_kenaikan_pangkat,id_jenis_kp',
            'tmt_pangkat' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only([
            'nip',
            'id_golongan',
            'id_jenis_kp',
            'tmt_pangkat',
            'keterangan',
            'aktif'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('riwayat_kepegawaian', 'public');
            $data['file'] = $file;
        }

        $riwayat->update($data);

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }
    
    

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|exists:t_pegawai,nip',
            'id_golongan' => 'required|exists:t_golongan,id_golongan',
            'id_jenis_kp' => 'required|exists:t_jenis_kenaikan_pangkat,id_jenis_kp',
            'tmt_pangkat' => 'required|date',
            'keterangan' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('riwayat_kepegawaian', 'public');
        }

        // membuat data
        $data = new RiwayatKepegawaianModel();
        $data->nip = $request->nip;
        $data->id_golongan = $request->id_golongan;
        $data->id_jenis_kp = $request->id_jenis_kp;
        $data->tmt_pangkat = $request->tmt_pangkat;
        $data->keterangan = $request->keterangan;
        $data->file = $filePath;
        $data->aktif = 1;
        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Data Riwayat Kepegawaian berhasil disimpan!'
        ], 200);
    }

    public function create() {
    $pegawai = PegawaiModel::all();
    $golongan = GolonganModel::all();
    $jenisKp = JenisKenaikanPangkatModel::all();
    return view('riwayat_kepegawaian.create', compact('pegawai', 'golongan', 'jenisKp'));
    }


}
