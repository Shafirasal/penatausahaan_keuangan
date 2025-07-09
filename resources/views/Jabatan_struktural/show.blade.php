<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title text-primary">Detail Jabatan Struktural</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      @if ($jabatan)
        <table class="table table-sm table-bordered table-striped">
          <tr>
            <th class="text-right col-4">Nama Pegawai</th>
            <td class="col-8">{{ $jabatan->pegawai->nama ?? '-' }}</td>
          </tr>
          <tr>
            <th class="text-right">Nama Jabatan</th>
            <td>{{ $jabatan->nama_jabatan ?? '-' }}</td>
          </tr>
          <tr>
            <th class="text-right">Jenis Pelantikan</th>
            <td>{{ $jabatan->jenis_pelantikan ?? '-' }}</td>
          </tr>
          <tr>
            <th class="text-right">Unit Kerja</th>
            <td>{{ $jabatan->unitKerja->nama_unit_kerja ?? '-' }}</td>
          </tr>
          <tr>
            <th class="text-right">TMT Jabatan</th>
            <td>{{ $jabatan->tmt_jabatan ? \Carbon\Carbon::parse($jabatan->tmt_jabatan)->format('d-m-Y') : '-' }}</td>
          </tr>
          <tr>
            <th class="text-right">Status Jabatan</th>
            <td>{{ $jabatan->status_jabatan ?? '-' }}</td>
          </tr>
          <tr>
            <th class="text-right">Aktif</th>
            <td>{{ $jabatan->aktif ? 'Aktif' : 'Tidak Aktif' }}</td>
          </tr>
        </table>
      @else
        <div class="alert alert-danger mb-0">
          Data jabatan struktural tidak ditemukan.
        </div>
      @endif
    </div>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
    </div>
  </div>
</div>
