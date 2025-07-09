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
        return view('riwayat_kepegawaian.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = RiwayatKepegawaianModel::with(['pegawai', 'golongan', 'jenisKenaikanPangkat'])
                ->where('aktif', 1)
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pegawai_nama', function ($row) {
                    return $row->pegawai->nama ?? '-';
                })
                ->addColumn('golongan_nama', function ($row) {
                    return $row->golongan->nama_golongan ?? '-';
                })
                ->addColumn('jenis_kp_nama', function ($row) {
                    return $row->jenisKenaikanPangkat->nama_jenis_kp ?? '-';
                })
                ->addColumn('file', function ($row) {
                    if ($row->file) {
                        return '<a href="'.asset('storage/'.$row->file).'" target="_blank">Lihat File</a>';
                    }
                    return '-';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <button class="btn btn-sm btn-primary edit" data-id="'.$row->id_riwayat_kepegawaian.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete" data-id="'.$row->id_riwayat_kepegawaian.'">Hapus</button>
                    ';
                })
                ->rawColumns(['aksi', 'file'])
                ->make(true);
        }

        // KALAU BUKAN AJAX
        return abort(404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|exists:t_pegawai,nip',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'id_golongan' => 'required|exists:t_golongan,id_golongan',
            'id_jenis_kp' => 'required|exists:t_jenis_kenaikan_pangkat,id_jenis_kp',
            'masa_kerja_tahun' => 'required|integer',
            'masa_kerja_bulan' => 'required|integer',
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
            'masa_kerja_tahun',
            'masa_kerja_bulan',
            'tmt_pangkat',
            'keterangan'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('riwayat_kepegawaian', 'public');
            $data['file'] = $file;
        }

        $data['aktif'] = 1;

        RiwayatKepegawaianModel::create($data);

        return response()->json(['message' => 'Data berhasil disimpan']);
    }
    public function create() {
    $pegawai = PegawaiModel::all();
    $golongan = GolonganModel::all();
    $jenisKp = JenisKenaikanPangkatModel::all();
    return view('riwayat_kepegawaian.create', compact('pegawai', 'golongan', 'jenisKp'));
    }


    public function update(Request $request, $id)
    {
        $riwayat = RiwayatKepegawaianModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nip' => 'required|exists:t_pegawai,nip',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'id_golongan' => 'required|exists:t_golongan,id_golongan',
            'id_jenis_kp' => 'required|exists:t_jenis_kenaikan_pangkat,id_jenis_kp',
            'masa_kerja_tahun' => 'required|integer',
            'masa_kerja_bulan' => 'required|integer',
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
            'masa_kerja_tahun',
            'masa_kerja_bulan',
            'tmt_pangkat',
            'keterangan'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('riwayat_kepegawaian', 'public');
            $data['file'] = $file;
        }

        $riwayat->update($data);

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $riwayat = RiwayatKepegawaianModel::findOrFail($id);
        $riwayat->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
