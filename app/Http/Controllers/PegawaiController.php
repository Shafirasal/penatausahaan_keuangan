<?php

namespace App\Http\Controllers;

use App\Models\PegawaiModel;
use App\Models\ProvinsiModel;
use App\Models\KabupatenKotaModel;
use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class PegawaiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Pegawai',
            'list' => ['Home', 'Daftar Pegawai']
        ];

        $page = (object)[
            'title' => 'Data Pegawai'
        ];

        $activeMenu = 'pegawai';

        return view('pegawai.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $data = PegawaiModel::with(['provinsi', 'kabupatenKota', 'kecamatan', 'kelurahan'])
        ->select(
            'nip', 
            'nama', 
            'tempat_lahir', 
            'tanggal_lahir',
            'jenis_kelamin', 
            'email', 
            'hp', 
            'status_kepegawaian', 
            'foto'
        );

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_lengkap', function($row) {
                $nama = '';
                if ($row->gelar_depan) {
                    $nama .= $row->gelar_depan . ' ';
                }
                $nama .= $row->nama;
                if ($row->gelar_belakang) {
                    $nama .= ', ' . $row->gelar_belakang;
                }
                return $nama;
            })
            ->addColumn('tempat_tanggal_lahir', function($row) {
                return $row->tempat_lahir . ', ' . date('d-m-Y', strtotime($row->tanggal_lahir));
            })
            ->addColumn('alamat_lengkap', function($row) {
                $alamat = $row->alamat;
                if ($row->kelurahan) {
                    $alamat .= ', ' . $row->kelurahan->nama_kelurahan;
                }
                if ($row->kecamatan) {
                    $alamat .= ', ' . $row->kecamatan->nama_kecamatan;
                }
                if ($row->kabupatenKota) {
                    $alamat .= ', ' . $row->kabupatenKota->nama_kabupaten_kota;
                }
                if ($row->provinsi) {
                    $alamat .= ', ' . $row->provinsi->nama_provinsi;
                }
                return $alamat;
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <button onclick="modalAction(`' . url('/pegawai/' . $row->nip . '/show') . '`)" class="btn btn-info btn-sm">Detail</button>
                    <button onclick="modalAction(`' . url('/pegawai/' . $row->nip . '/edit') . '`)" class="btn btn-warning btn-sm">Edit</button>
                    <button onclick="modalAction(`' . url('/pegawai/' . $row->nip . '/confirm') . '`)" class="btn btn-danger btn-sm">Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function show(string $nip)
    {
        $pegawai = PegawaiModel::with(['provinsi', 'kabupatenKota', 'kecamatan', 'kelurahan'])->findOrFail($nip);
        return view('pegawai.show', ['pegawai' => $pegawai]);
    }

    public function confirm(string $nip)
    {
        $pegawai = PegawaiModel::with(['provinsi', 'kabupatenKota', 'kecamatan', 'kelurahan'])->find($nip);

        return view('pegawai.confirm', ['pegawai' => $pegawai]);
    }

    public function delete(Request $request, $nip)
    {
        if ($request->ajax()) {
            $pegawai = PegawaiModel::find($nip);

            if (!$pegawai) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }

            $pegawai->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        }

        return redirect()->route('pegawai.index');
    }

public function edit($nip)
{
    $pegawai = PegawaiModel::findOrFail($nip);
    $provinsi = ProvinsiModel::all();
    
    // Ambil kab/kec/kelurahan sesuai data pegawai
    $kabupatenKota = KabupatenKotaModel::where('id_provinsi', $pegawai->id_provinsi)->get();
    $kecamatan = KecamatanModel::where('id_kabupaten_kota', $pegawai->id_kabupaten_kota)->get();
    $kelurahan = KelurahanModel::where('id_kecamatan', $pegawai->id_kecamatan)->get();

    return view('pegawai.edit', compact('pegawai', 'provinsi', 'kabupatenKota', 'kecamatan', 'kelurahan'));
}

public function update(Request $request, $nip)
{
    $pegawai = PegawaiModel::findOrFail($nip);

    $validator = Validator::make($request->all(), [
        'nama' => 'required|string|max:255',
        'gelar_depan' => 'nullable|string|max:50',
        'gelar_belakang' => 'nullable|string|max:50',
        'nik' => 'required|string|max:16|unique:t_pegawai,nik,' . $nip . ',nip',
        'tempat_lahir' => 'required|string|max:100',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:L,P',
        'hp' => 'nullable|string|max:15',
        'email' => 'nullable|email|max:255|unique:t_pegawai,email,' . $nip . ',nip',
        'alamat' => 'required|string',
        'rt' => 'nullable|string|max:3',
        'rw' => 'nullable|string|max:3',
        'kode_pos' => 'nullable|string|max:5',
        'agama' => 'required|string|max:50',
        'status_kepegawaian' => 'required|string|max:50',
        'id_provinsi' => 'required|exists:t_provinsi,id_provinsi',
        'id_kabupaten_kota' => 'required|exists:t_kabupaten_kota,id_kabupaten_kota',
        'id_kecamatan' => 'required|exists:t_kecamatan,id_kecamatan',
        'id_kelurahan' => 'required|exists:t_kelurahan,id_kelurahan',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $data = $request->only([
        'nama',
        'gelar_depan',
        'gelar_belakang',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'hp',
        'email',
        'alamat',
        'rt',
        'rw',
        'kode_pos',
        'agama',
        'status_kepegawaian',
        'id_provinsi',
        'id_kabupaten_kota',
        'id_kecamatan',
        'id_kelurahan'
    ]);

    // TAMBAHAN: Handle upload foto baru
    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($pegawai->foto && Storage::exists('public/' . $pegawai->foto)) {
            Storage::delete('public/' . $pegawai->foto);
        }

        // Upload foto baru
        $originalName = pathinfo($request->file('foto')->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $request->file('foto')->getClientOriginalExtension();
        $filename = time() . '_' . Str::slug($originalName) . '.' . $extension;
        
        // Simpan foto baru
        $request->file('foto')->storeAs('public/foto_profile', $filename);
        $data['foto'] = 'foto_profile/' . $filename;
    }

    $pegawai->update($data);

    return response()->json([
        'status' => true,
        'message' => 'Data berhasil diperbarui'
    ]);
}

public function store(Request $request)
{
    $request->validate([
        'nip' => 'required|string|max:18|unique:t_pegawai,nip',
        'nama' => 'required|string|max:255',
        'gelar_depan' => 'nullable|string|max:50',
        'gelar_belakang' => 'nullable|string|max:50',
        'nik' => 'required|string|max:16|unique:t_pegawai,nik',
        'tempat_lahir' => 'required|string|max:100',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:laki-laki,perempuan', // Perbaiki: sesuaikan dengan database
        'hp' => 'nullable|string|max:15',
        'email' => 'nullable|email|max:255|unique:t_pegawai,email',
        'alamat' => 'required|string',
        'rt' => 'nullable|regex:/^\d{2}$/',
        'rw' => 'nullable|regex:/^\d{2}$/',
        'kode_pos' => 'nullable|string|max:5',
        'agama' => 'required|string|max:50',
        'status_kepegawaian' => 'required|string|max:50',
        'id_provinsi' => 'required|exists:t_provinsi,id_provinsi',
        'id_kabupaten_kota' => 'required|exists:t_kabupaten_kota,id_kabupaten_kota',
        'id_kecamatan' => 'required|exists:t_kecamatan,id_kecamatan',
        'id_kelurahan' => 'required|exists:t_kelurahan,id_kelurahan',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'       
    ]);

    // Handle upload foto
    $fotoPath = null;
    if ($request->hasFile('foto')) {
        $originalName = pathinfo($request->file('foto')->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $request->file('foto')->getClientOriginalExtension();
        $filename = time() . '_' . Str::slug($originalName) . '.' . $extension;
        
        // PERBAIKI: Hapus "storage" ekstra dari path
        $request->file('foto')->storeAs('public/foto_profile', $filename);
        $fotoPath = 'foto_profile/' . $filename;
    }

    // Membuat data
    $data = new PegawaiModel();
    $data->nip = $request->nip;
    $data->nama = $request->nama;
    $data->gelar_depan = $request->gelar_depan;
    $data->gelar_belakang = $request->gelar_belakang;
    $data->nik = $request->nik;
    $data->tempat_lahir = $request->tempat_lahir;
    $data->tanggal_lahir = $request->tanggal_lahir;
    $data->jenis_kelamin = $request->jenis_kelamin;
    $data->hp = $request->hp;
    $data->email = $request->email;
    $data->alamat = $request->alamat;
    $data->rt = $request->rt;
    $data->rw = $request->rw;
    $data->kode_pos = $request->kode_pos;
    $data->agama = $request->agama;
    $data->status_kepegawaian = $request->status_kepegawaian;
    $data->id_provinsi = $request->id_provinsi;
    $data->id_kabupaten_kota = $request->id_kabupaten_kota;
    $data->id_kecamatan = $request->id_kecamatan;
    $data->id_kelurahan = $request->id_kelurahan;
    
    // PENTING: Simpan path foto ke database
    $data->foto = $fotoPath;
    
    $data->save();

    return response()->json([
        'status' => true,
        'message' => 'Data Pegawai berhasil disimpan!'
    ], 200);
}

public function create() 
{
    $provinsi = ProvinsiModel::all();
    return view('pegawai.create', compact('provinsi'));
}

public function getKabupatenByProvinsi($id_provinsi)
{
    $kabupaten = KabupatenKotaModel::where('id_provinsi', $id_provinsi)->get();
    return response()->json($kabupaten);
}

public function getKecamatanByKabupaten($id_kabupaten)
{
    $kecamatan = KecamatanModel::where('id_kabupaten_kota', $id_kabupaten)->get();
    return response()->json($kecamatan);
}

public function getKelurahanByKecamatan($id_kecamatan)
{
    $kelurahan = KelurahanModel::where('id_kecamatan', $id_kecamatan)->get();
    return response()->json($kelurahan);
}


}