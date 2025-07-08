{{-- <form action="{{ url('/riwayat_pendidikan/store') }}" method="POST" id="form-tambah-riwayat-pendidikan">
    @csrf
    <div class="modal-dialog modal-lg" role="document" id="modal-riwayat-pendidikan">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Riwayat Pendidikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control" required>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" required>
                    <small id="error-nama_sekolah" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jenjang</label>
                    <select name="tingkat" id="tingkat" class="form-control" required>
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                    <small id="error-tingkat" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Prodi/Jurusan</label>
                    <input type="text" name="prodi_jurusan" id="prodi_jurusan" class="form-control" required>
                    <small id="error-prodi_jurusan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tahun Lulus</label>
                    <input type="number" name="tahun_lulus" id="tahun_lulus" class="form-control" required>
                    <small id="error-tahun_lulus" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="aktif" id="aktif" class="form-control" required>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                    <small id="error-aktif" class="error-text form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-light text-danger border-danger">Batal</button>
                <button type="submit" class="btn btn-danger">Simpan</button>
            </div>
        </div>
    </div>
</form> --}}




<div class="row justify-content-center mt-5">
  <div class="col-12">
    <div class="card mx-auto" style="max-width: 600px;">
      <form action="{{ url('/riwayat_pendidikan/store') }}" method="POST" id="form-tambah-riwayat-pendidikan">
        @csrf
        <div class="card-header">
          <h4>Tambah Riwayat Pendidikan</h4>
        </div>
        <div class="card-body">

          <div class="form-group">
            <label>NIP</label>
            <input type="text" name="nip" id="nip" class="form-control" required>
            <small id="error-nip" class="error-text form-text text-danger"></small>
          </div>

          <div class="form-group">
            <label>Nama Sekolah</label>
            <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" required>
            <small id="error-nama_sekolah" class="error-text form-text text-danger"></small>
          </div>

          <div class="form-group">
            <label>Jenjang</label>
            <select name="tingkat" id="tingkat" class="form-control" required>
              <option value="">-- Pilih Jenjang --</option>
              <option value="SD">SD</option>
              <option value="SMP">SMP</option>
              <option value="SMA">SMA</option>
              <option value="D3">D3</option>
              <option value="S1">S1</option>
              <option value="S2">S2</option>
              <option value="S3">S3</option>
            </select>
            <small id="error-tingkat" class="error-text form-text text-danger"></small>
          </div>

          <div class="form-group">
            <label>Prodi/Jurusan</label>
            <input type="text" name="prodi_jurusan" id="prodi_jurusan" class="form-control" required>
            <small id="error-prodi_jurusan" class="error-text form-text text-danger"></small>
          </div>

          <div class="form-group">
            <label>Tahun Lulus</label>
            <input type="number" name="tahun_lulus" id="tahun_lulus" class="form-control" required>
            <small id="error-tahun_lulus" class="error-text form-text text-danger"></small>
          </div>

          <div class="form-group">
            <label>Status</label>
            <select name="aktif" id="aktif" class="form-control" required>
              <option value="">-- Pilih Status --</option>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
            <small id="error-aktif" class="error-text form-text text-danger"></small>
          </div>

        </div>
        <div class="card-footer text-right">
<button type="reset" class="btn btn-light text-danger border-danger">Batal</button>

          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>





<script>
    $(document).ready(function () {
        $("#form-tambah-riwayat-pendidikan").validate({
            rules: {
                nip: { required: true },
                nama_sekolah: { required: true },
                tingkat: { required: true },
                prodi_jurusan: { required: true },
                tahun_lulus: { required: true, digits: true, minlength: 4, maxlength: 4 },
                aktif: { required: true }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#modal-riwayat-pendidikan').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataRiwayatPendidikan.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
