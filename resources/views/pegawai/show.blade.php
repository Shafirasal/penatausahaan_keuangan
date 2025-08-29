<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title text-primary">Detail Data Pegawai</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <!-- Foto Pegawai -->
      @if($pegawai->foto)
        <div class="text-center mb-3">
          <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto Pegawai" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
        </div>
      @endif

      <table class="table table-sm table-bordered table-striped">
        <!-- Data Utama -->
        <tr>
          <th class="text-right col-4">NIP</th>
          <td class="col-8">{{ $pegawai->nip ?? '-' }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Nama Lengkap</th>
          <td>
            {{ $pegawai->gelar_depan ? $pegawai->gelar_depan . ' ' : '' }}
            {{ $pegawai->nama ?? '-' }}
            {{ $pegawai->gelar_belakang ? ', ' . $pegawai->gelar_belakang : '' }}
          </td>
        </tr>
        <tr>
          <th class="text-right col-4">NIK</th>
          <td>{{ $pegawai->nik ?? '-' }}</td>
        </tr>

        <!-- Data Kelahiran -->
        <tr>
          <th class="text-right col-4">Tempat, Tanggal Lahir</th>
          <td>
            {{ $pegawai->tempat_lahir ?? '-' }}{{ $pegawai->tanggal_lahir ? ', ' . \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d F Y') : '' }}
          </td>
        </tr>
        <tr>
          <th class="text-right col-4">Jenis Kelamin</th>
          <td>{{ $pegawai->jenis_kelamin == 'laki-laki' ? 'Laki-laki' : ($pegawai->jenis_kelamin == 'perempuan' ? 'Perempuan' : '-') }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Agama</th>
          <td>{{ $pegawai->agama ?? '-' }}</td>
        </tr>

        <!-- Kontak -->
        <tr>
          <th class="text-right col-4">No. HP</th>
          <td>{{ $pegawai->hp ?? '-' }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Email</th>
          <td>{{ $pegawai->email ?? '-' }}</td>
        </tr>

        <!-- Alamat -->
        <tr>
          <th class="text-right col-4">Alamat</th>
          <td>{{ $pegawai->alamat ?? '-' }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">RT/RW</th>
          <td>
            @if($pegawai->rt || $pegawai->rw)
              RT {{ $pegawai->rt ?? '00' }} / RW {{ $pegawai->rw ?? '00' }}
            @else
              -
            @endif
          </td>
        </tr>
        <tr>
          <th class="text-right col-4">Kode Pos</th>
          <td>{{ $pegawai->kode_pos ?? '-' }}</td>
        </tr>

        <!-- Wilayah -->
        <tr>
          <th class="text-right col-4">Provinsi</th>
          <td>{{ $pegawai->provinsi->nama_provinsi ?? '-' }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Kabupaten/Kota</th>
          <td>{{ $pegawai->kabupatenKota->nama_kabupaten_kota ?? '-' }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Kecamatan</th>
          <td>{{ $pegawai->kecamatan->nama_kecamatan ?? '-' }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Kelurahan</th>
          <td>{{ $pegawai->kelurahan->nama_kelurahan ?? '-' }}</td>
        </tr>

        <!-- Status Kepegawaian -->
        <tr>
          <th class="text-right col-4">Status Kepegawaian</th>
          <td>{{ strtoupper($pegawai->status_kepegawaian) ?? '-' }}</td>
        </tr>

        <!-- Timestamps -->
        <tr>
          <th class="text-right col-4">Dibuat Pada</th>
          <td>{{ $pegawai->created_at ? \Carbon\Carbon::parse($pegawai->created_at)->format('d F Y H:i:s') : '-' }}</td>
        </tr>
        <tr>
          <th class="text-right col-4">Diperbarui Pada</th>
          <td>{{ $pegawai->updated_at ? \Carbon\Carbon::parse($pegawai->updated_at)->format('d F Y H:i:s') : '-' }}</td>
        </tr>
      </table>
    </div>
    <div class="modal-footer bg-whitesmoke br">
      <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
    </div>
  </div>
  
</div>