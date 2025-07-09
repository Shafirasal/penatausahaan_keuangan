<form action="{{ url('/jabatan_fungsional/store') }}" method="POST" id="form-tambah-jabatan-fungsional">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Tambah Jabatan Fungsional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control"
                        value="{{ session('nip') }}" readonly>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control" required>
                    <small id="error-nama_jabatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Instansi</label>
                    <input type="text" name="instansi" id="instansi" class="form-control" required>
                    <small id="error-instansi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>TMT Jabatan</label>
                    <input type="date" name="tmt_jabatan" id="tmt_jabatan" class="form-control" required>
                    <small id="error-tmt_jabatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>PAK</label>
                    <input type="number" name="PAK" id="PAK" class="form-control" min="0" required>
                    <small id="error-PAK" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status Fungsional</label>
                    <select name="status_fungsional" id="status_fungsional" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="promosi">Promosi</option>
                        <option value="perpindahan dari jabatan lain">Perpindahan dari jabatan lain</option>
                        <option value="pertama">Pertama</option>
                    </select>
                    <small id="error-status_fungsional" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status Diklat</label>
                    <input type="text" name="status_diklat" id="status_diklat" class="form-control" required>
                    <small id="error-status_diklat" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="aktif" id="aktif" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="ya">Aktif</option>
                        <option value="tidak">Tidak Aktif</option>
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


<script>
    $(document).ready(function() {
        $("#form-tambah-jabatan-fungsional").validate({
            rules: {
                nip: {
                    required: true
                },
                nama_jabatan: {
                    required: true
                },
                instansi: {
                    required: true
                },
                tmt_jabatan: {
                    required: true,
                    date: true
                },
                PAK: {
                    required: true,
                    number: true,
                    min: 0
                },
                status_fungsional: {
                    required: true
                },
                status_diklat: {
                    required: true
                },
                aktif: {
                    required: true
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.message) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            if (typeof dataJabatanFungsional !== 'undefined') {
                                dataJabatanFungsional.ajax.reload();
                            }
                        }
                    },
                    error: function(xhr) {
                        const res = xhr.responseJSON;
                        $('.error-text').text('');
                        if (res && res.errors) {
                            $.each(res.errors, function(key, val) {
                                $('#error-' + key).text(val[0]);
                            });
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message ||
                                'Terjadi kesalahan saat menyimpan data.'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
