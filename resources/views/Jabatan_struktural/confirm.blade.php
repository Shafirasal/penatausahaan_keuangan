@if(empty($jabatan))
    <div id="modal-jabatan-struktural" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data jabatan struktural tidak ditemukan.
                </div>
                <a href="{{ route('jabatan_struktural.index') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form method="POST" id="form-delete-jabatan-struktural" data-id="{{ $jabatan->id_jabatan_struktural }}">
        @csrf
        @method('DELETE')
        <div id="modal-jabatan-struktural" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Jabatan Struktural</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi</h5>
                        Apakah Anda yakin ingin menghapus data jabatan struktural berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-4">Nama Pegawai:</th>
                            <td class="col-8">{{ $jabatan->pegawai->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Nama Jabatan:</th>
                            <td>{{ $jabatan->nama_jabatan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Unit Kerja:</th>
                            <td>{{ $jabatan->unitKerja->nama_unit_kerja ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">TMT Jabatan:</th>
                            <td>{{ \Carbon\Carbon::parse($jabatan->tmt_jabatan)->format('d-m-Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal" style="color: #EF5428; background: white; border-color: #EF5428;">Batal</button>
                    <button type="submit" class="btn" style="color: white; background: #EF5428; border-color: #EF5428;">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
@endif
