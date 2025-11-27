<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Detail Riwayat Jabatan Fungsional</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <table class="table table-sm table-bordered table-striped">
        <tr>
          <th class="text-right col-4">Nama Jabatan</th>
          <td class="col-8">{{ $jabatan_fungsional->nama_jabatan }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Instansi</th>
          <td>{{ $jabatan_fungsional->instansi }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">tmt_jabatan</th>
          <td>{{ $jabatan_fungsional->tmt_jabatan }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">PAK</th>
          <td>{{ $jabatan_fungsional->PAK }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Status Fungsional</th>
          <td>{{ $jabatan_fungsional->status_fungsional }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Status Diklat</th>
          <td>{{ $jabatan_fungsional->status_diklat }}</td>
        </tr>
      </table>
    </div>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
    </div>
  </div>
  
</div>

