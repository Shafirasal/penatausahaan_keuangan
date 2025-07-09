@empty($jabatan_fungsional)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Data Tidak Ditemukan</h5>
                    Data jabatan fungsional tidak tersedia.
                </div>
            </div>
        </div>
    </div>
@else
<form action="{{ url('/jabatan_fungsional/' . $jabatan_fungsional->id_jabatan_fungsional . '/update') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Jabatan Fungsional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input type="text" name="nama_jabatan" class="form-control" value="{{ $jabatan_fungsional->nama_jabatan }}" required>
                    <small id="error-nama_jabatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Instansi</label>
                    <input type="text" name="instansi" class="form-control" value="{{ $jabatan_fungsional->instansi }}" required>
                    <small id="error-instansi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>TMT Jabatan</label>
                    <input type="date" name="tmt_jabatan" class="form-control" value="{{ $jabatan_fungsional->tmt_jabatan }}" required>
                    <small id="error-tmt_jabatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>PAK</label>
                    <input type="number" name="PAK" class="form-control" value="{{ $jabatan_fungsional->PAK }}" required>
                    <small id="error-PAK" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status Fungsional</label>
                    <select name="status_fungsional" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="promosi" {{ $jabatan_fungsional->status_fungsional == 'promosi' ? 'selected' : '' }}>Promosi</option>
                        <option value="perpindahan dari jabatan lain" {{ $jabatan_fungsional->status_fungsional == 'perpindahan dari jabatan lain' ? 'selected' : '' }}>Perpindahan dari jabatan lain</option>
                        <option value="pertama" {{ $jabatan_fungsional->status_fungsional == 'pertama' ? 'selected' : '' }}>Pertama</option>
                    </select>
                    <small id="error-status_fungsional" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status Diklat</label>
                    <input type="text" name="status_diklat" class="form-control" value="{{ $jabatan_fungsional->status_diklat }}" required>
                    <small id="error-status_diklat" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status Aktif</label>
                    <select name="aktif" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="ya" {{ $jabatan_fungsional->aktif == 'ya' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak" {{ $jabatan_fungsional->aktif == 'tidak' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    <small id="error-aktif" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#form-edit').validate({
            rules: {
                nama_jabatan: { required: true },
                instansi: { required: true },
                tmt_jabatan: { required: true, date: true },
                PAK: { required: true, number: true, min: 0 },
                status_fungsional: { required: true },
                status_diklat: { required: true },
                aktif: { required: true }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataJabatanFungsional.ajax.reload();
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
@endempty
