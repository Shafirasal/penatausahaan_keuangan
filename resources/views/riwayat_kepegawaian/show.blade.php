<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title text-primary">Detail Riwayat Kepegawaian</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <table class="table table-sm table-bordered table-striped">
        <tr>
          <th class="text-right col-4">Nama Pegawai</th>
          <td class="col-8">{{ $kepegawaian->pegawai->nama ?? '-' }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Golongan</th>
          <td>{{ $kepegawaian->golongan->nama_golongan ?? '-' }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Jenis Kenaikan Pangkat</th>
          <td>{{ $kepegawaian->jenisKenaikanPangkat->nama_jenis ?? '-' }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">TMT Pangkat</th>
          <td>{{ $kepegawaian->tmt_pangkat }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Masa Kerja</th>
          <td>{{ $kepegawaian->masa_kerja_tahun }} th {{ $kepegawaian->masa_kerja_bulan }} bln</td>
        </tr>
        <tr>
          <th class="text-right col-4">File</th>
          <td>
            @if ($kepegawaian->file)
              <a href="{{ asset('storage/' . $kepegawaian->file) }}" target="_blank">Lihat File</a>
            @else
              -
            @endif
          </td>
        </tr>
        <tr>
          <th class="text-right col-4">Keterangan</th>
          <td>{{ $kepegawaian->keterangan }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Status</th>
          <td>{{ ucfirst($kepegawaian->aktif) }}</td>
        </tr>
      </table>
    </div>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
    </div>
  </div>
</div>
