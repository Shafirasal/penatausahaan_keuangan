@empty($jabatan)
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
                    Data jabatan struktural tidak tersedia.
                </div>
            </div>
        </div>
    </div>
@else
<form action="{{ url('/jabatan/' . $jabatan->id_jabatan . '/update') }}" method="POST" id="form-edit-jabatan-struktural">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Jabatan Struktural</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input type="text" name="nama_jabatan" class="form-control" value="{{ $jabatan->nama_jabatan }}" required>
                    <small id="error-nama_jabatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Unit Kerja</label>
                    <select name="unit_kerja_id" class="form-control" required>
                        <option value="">-- Pilih Unit Kerja --</option>
                        @foreach ($unitKerja as $uk)
                            <option value="{{ $uk->id }}"
                                {{ $jabatan->unit_kerja_id == $uk->id ? 'selected' : '' }}>
                                {{ $uk->nama_unit_kerja }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-unit_kerja_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>TMT Jabatan</label>
                    <input type="date" name="tmt_jabatan" class="form-control" value="{{ $jabatan->tmt_jabatan }}" required>
                    <small id="error-tmt_jabatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status Struktural</label>
                    <select name="status_struktural" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="definitif" {{ $jabatan->status_struktural == 'definitif' ? 'selected' : '' }}>Definitif</option>
                        <option value="pelaksana tugas" {{ $jabatan->status_struktural == 'pelaksana tugas' ? 'selected' : '' }}>Pelaksana Tugas</option>
                    </select>
                    <small id="error-status_struktural" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status Aktif</label>
                    <select name="aktif" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="ya" {{ $jabatan->aktif == 'ya' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak" {{ $jabatan->aktif == 'tidak' ? 'selected' : '' }}>Tidak Aktif</option>
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
        $('#form-edit-jabatan-struktural').validate({
            rules: {
                nama_jabatan: { required: true },
                unit_kerja_id: { required: true },
                tmt_jabatan: { required: true, date: true },
                status_struktural: { required: true },
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
                            dataJabatanStruktural.ajax.reload();
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
