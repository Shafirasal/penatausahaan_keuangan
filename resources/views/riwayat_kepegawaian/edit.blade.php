<form action="{{ url('/riwayat_kepegawaian/' . $data->id_riwayat_kepegawaian . '/update') }}" method="POST" id="form-edit" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary">Edit Riwayat Kepegawaian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label>NIP</label>
          <input type="text" name="nip" class="form-control" value="{{ $data->nip }}" readonly>
        </div>

        <div class="form-group">
          <label>Golongan</label>
          <select name="id_golongan" class="form-control" required>
            <option value="">-- Pilih Golongan --</option>
            @foreach ($golongan as $row)
              <option value="{{ $row->id_golongan }}" {{ $row->id_golongan == $data->id_golongan ? 'selected' : '' }}>
                {{ $row->nama_golongan }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Jenis KP</label>
          <select name="id_jenis_kp" class="form-control" required>
            <option value="">-- Pilih Jenis KP --</option>
            @foreach ($jenisKp as $row)
              <option value="{{ $row->id_jenis_kp }}" {{ $row->id_jenis_kp == $data->id_jenis_kp ? 'selected' : '' }}>
                {{ $row->nama_jenis }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Masa Kerja Tahun</label>
          <input type="number" name="masa_kerja_tahun" class="form-control" value="{{ $data->masa_kerja_tahun }}" min="0" required>
        </div>

        <div class="form-group">
          <label>Masa Kerja Bulan</label>
          <input type="number" name="masa_kerja_bulan" class="form-control" value="{{ $data->masa_kerja_bulan }}" min="0" max="12" required>
        </div>

        <div class="form-group">
          <label>TMT Pangkat</label>
          <input type="date" name="tmt_pangkat" class="form-control" value="{{ $data->tmt_pangkat }}" required>
        </div>

        <div class="form-group">
          <label>Keterangan</label>
          <textarea name="keterangan" class="form-control">{{ $data->keterangan }}</textarea>
        </div>

        <div class="form-group">
          <label>File (Kosongkan jika tidak diubah)</label>
          <input type="file" name="file" class="form-control">
          @if ($data->file)
            <small><a href="{{ asset('storage/'.$data->file) }}" target="_blank">Lihat File Lama</a></small>
          @endif
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Batal</button>
        <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</form>

@push('js')
<script>
  $(document).ready(function() {
    $('#form-edit').validate({
      rules: {
        id_golongan: { required: true },
        id_jenis_kp: { required: true },
        masa_kerja_tahun: { required: true, number: true, min: 0 },
        masa_kerja_bulan: { required: true, number: true, min: 0, max: 12 },
        tmt_pangkat: { required: true, date: true },
        file: { extension: "pdf|jpg|jpeg|png", filesize: 2048 * 1024 }
      },
      submitHandler: function(form) {
        var formData = new FormData(form);
        $.ajax({
          url: form.action,
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(res) {
            $('#myModal').modal('hide');
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: res.message
            });
            if (typeof dataRiwayatKepegawaian !== 'undefined') {
              dataRiwayatKepegawaian.ajax.reload();
            }
          },
          error: function(xhr) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: 'Terjadi kesalahan saat menyimpan data.'
            });
          }
        });
        return false;
      }
    });
  });

  $.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param);
  }, 'Ukuran file terlalu besar');
</script>
@endpush
