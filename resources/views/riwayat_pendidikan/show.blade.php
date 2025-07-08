{{-- @if (empty($riwayatPendidikan))
  <div class="modal fade" tabindex="-1" role="dialog" id="modalRiwayatPendidikanKosong">
    <div class="modal-dialog" role="document">
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
            Data riwayat pendidikan tidak ditemukan.
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <a href="{{ url('/riwayat_pendidikan') }}" class="btn btn-warning">Kembali</a>
        </div>
      </div>
    </div>
  </div>
@else
  <div class="modal fade" tabindex="-1" role="dialog" id="modalRiwayatPendidikanDetail">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Riwayat Pendidikan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-sm table-bordered table-striped">
            <tr>
              <th class="text-right col-4">Nama Sekolah</th>
              <td class="col-8">{{ $riwayatPendidikan->nama_sekolah }}</td>
            </tr>
            <tr>
              <th class="text-right col-4">Jenjang</th>
              <td>{{ $riwayatPendidikan->tingkat }}</td>
            </tr>
            <tr>
              <th class="text-right col-4">Prodi/Jurusan</th>
              <td>{{ $riwayatPendidikan->jurusan }}</td>
            </tr>
            <tr>
              <th class="text-right col-4">Tahun Lulus</th>
              <td>{{ $riwayatPendidikan->tahun_lulus }}</td>
            </tr>
          </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endif --}}


{{-- @if (empty($data))
  <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
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
            Data riwayat pendidikan tidak ditemukan.
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <a href="{{ url('/riwayat_pendidikan') }}" class="btn btn-warning">Kembali</a>
        </div>
      </div>
    </div>
  </div>
@else
  <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Riwayat Pendidikan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-sm table-bordered table-striped">
            <tr>
              <th class="text-right col-4">Nama Sekolah</th>
              <td class="col-8">{{ $data->nama_sekolah }}</td>
            </tr>
            <tr>
              <th class="text-right col-4">Jenjang</th>
              <td>{{ $data->tingkat }}</td>
            </tr>
            <tr>
              <th class="text-right col-4">Prodi/Jurusan</th>
              <td>{{ $data->prodi_jurusan }}</td>
            </tr>
            <tr>
              <th class="text-right col-4">Tahun Lulus</th>
              <td>{{ $data->tahun_lulus }}</td>
            </tr>
          </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endif --}}




<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Detail Riwayat Pendidikan</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <table class="table table-sm table-bordered table-striped">
        <tr>
          <th class="text-right col-4">Nama Sekolah</th>
          <td class="col-8">{{ $pendidikan->nama_sekolah }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Jenjang</th>
          <td>{{ $pendidikan->tingkat }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Prodi/Jurusan</th>
          <td>{{ $pendidikan->prodi_jurusan }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Tahun Lulus</th>
          <td>{{ $pendidikan->tahun_lulus }}</td>
        </tr>
      </table>
    </div>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
    </div>
  </div>
</div>






{{-- <div class="modal fade" tabindex="-1" role="dialog" id="modalDetailPendidikan" style="display: block;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Riwayat Pendidikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-sm table-bordered table-striped">
          <tr>
            <th class="text-right col-4">Nama Sekolah</th>
            <td>{{ $pendidikan->nama_sekolah }}</td>
          </tr>
          <tr>
            <th class="text-right col-4">Jenjang</th>
            <td>{{ $pendidikan->tingkat }}</td>
          </tr>
          <tr>
            <th class="text-right col-4">Prodi/Jurusan</th>
            <td>{{ $pendidikan->prodi_jurusan }}</td>
          </tr>
          <tr>
            <th class="text-right col-4">Tahun Lulus</th>
            <td>{{ $pendidikan->tahun_lulus }}</td>
          </tr>
        </table>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#modalDetailPendidikan').modal('show');
</script>
 --}}
