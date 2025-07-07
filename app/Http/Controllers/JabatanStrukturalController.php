<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PegawaiModel;
use App\Models\JabatanStrukturalModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JabatanStrukturalController extends Controller
{
    // Tampilkan halaman index saja
public function index()
{
    $breadcrumb = (object)[
        'title' => 'Jabatan Struktural',
        'list' => ['Home','Jabatan Struktural']
    ];

    return view('jabatan_struktural.index', compact('breadcrumb'));
}


    // Endpoint untuk datatables AJAX
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = JabatanStrukturalModel::with('pegawai')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pegawai_nama', function($row) {
                    return $row->pegawai->nama ?? '-';
                })
                ->addColumn('action', function($row) {
                    $editUrl = route('jabatan_struktural.edit', $row->id_jabatan_stuktural);
                    $deleteUrl = route('jabatan_struktural.destroy', $row->id_jabatan_stuktural);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    return '
                        <a href="'.$editUrl.'" class="btn btn-warning btn-sm">Edit</a>
                        <form action="'.$deleteUrl.'" method="POST" style="display:inline-block;">
                            '.$csrf.'
                            '.$method.'
                            <button onclick="return confirm(\'Yakin hapus?\')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    // Tampilkan form create
    public function create()
    {
        return view('jabatan_struktural.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string',
            'nama_jabatan' => 'required|string',
            'jenis_pelantikan' => 'required|string',
            'id_unit_kerja' => 'required|integer',
            'tmt_jabatan' => 'required|date',
            'status_jabatan' => 'required|string',
            'aktif' => 'required|boolean',
        ]);

        JabatanStrukturalModel::create($validated);
        return redirect()->route('jabatan_struktural.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $jabatan = JabatanStrukturalModel::findOrFail($id);
        return view('jabatan_struktural.edit', compact('jabatan'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $jabatan = JabatanStrukturalModel::findOrFail($id);

        $validated = $request->validate([
            'nip' => 'required|string',
            'nama_jabatan' => 'required|string',
            'jenis_pelantikan' => 'required|string',
            'id_unit_kerja' => 'required|integer',
            'tmt_jabatan' => 'required|date',
            'status_jabatan' => 'required|string',
            'aktif' => 'required|boolean',
        ]);

        $jabatan->update($validated);
        return redirect()->route('jabatan_struktural.index')->with('success', 'Data berhasil diupdate!');
    }

    // Hapus data
    public function destroy($id)
    {
        $jabatan = JabatanStrukturalModel::findOrFail($id);
        $jabatan->delete();
        return redirect()->route('jabatan_struktural.index')->with('success', 'Data berhasil dihapus!');
    }
}
