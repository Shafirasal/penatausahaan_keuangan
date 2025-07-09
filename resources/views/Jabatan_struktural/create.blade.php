<form action="{{ url('/jabatan_struktural/store') }}" method="POST" id="form-tambah-jabatan-struktural">
    @csrf
    <div id="modal-jabatan-struktural" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Tambah Jabatan Struktural</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control" value="{{ session('nip') }}" readonly>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control" required>
                    <small id="error-nama_jabatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jenis Pelantikan</label>
                    <select name="jenis_pelantikan" id="jenis_pelantikan" class="form-control" required>
                        <option value="">-- Pilih Jenis Pelantikan --</option>
                        <option value="definitif">Definitif</option>
                        <option value="pj(pejabat)">Pj (Pejabat)</option>
                    </select>
                    <small id="error-jenis_pelantikan" class="error-text form-text text-danger"></small>
                </div>  


                <div class="form-group">
                    <label>Unit Kerja</label>
                    <select name="id_unit_kerja" id="id_unit_kerja" class="form-control" required>
                        <option value="">-- Pilih Unit Kerja --</option>
                        @foreach($unitKerja as $unit)
                            <option value="{{ $unit->id_unit_kerja }}">{{ $unit->nama_unit_kerja }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_unit_kerja" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>TMT Jabatan</label>
                    <input type="date" name="tmt_jabatan" id="tmt_jabatan" class="form-control" required>
                    <small id="error-tmt_jabatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status Jabatan</label>
                    <select name="status_jabatan" id="status_jabatan" class="form-control" required>
                        <option value="">-- Pilih Status Jabatan --</option>
                        <option value="mutasi">Mutasi</option>
                        <option value="promosi">Promosi</option>
                    </select>
                    <small id="error-status_jabatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status Aktif</label>
                    <select name="aktif" id="aktif" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                    <small id="error-aktif" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </div>
    </div>
</form>


@push('js')
<script>
    $(document).ready(function () {
        $("#form-tambah-jabatan-struktural").validate({
            rules: {
                nip: { required: true },
                nama_jabatan: { required: true },
                jenis_pelantikan: { required: true },
                id_unit_kerja: { required: true },
                tmt_jabatan: { required: true, date: true },
                status_jabatan: { required: true },
                aktif: { required: true }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        if (typeof dataJabatanStruktural !== 'undefined') {
                            dataJabatanStruktural.ajax.reload();
                        }
                    },
                    error: function (xhr) {
                        const res = xhr.responseJSON;
                        $('.error-text').text('');
                        if (res && res.errors) {
                            $.each(res.errors, function (key, val) {
                                $('#error-' + key).text(val[0]);
                            });
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message || 'Terjadi kesalahan saat menyimpan data.'
                        });
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
@endpush
