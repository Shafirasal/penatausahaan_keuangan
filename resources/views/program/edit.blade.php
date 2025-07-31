@empty($program)
    <div id="modal-master" class="modal-dialog modal-md" role="document">
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
                    Data master program tidak tersedia.
                </div>
            </div>
        </div>
    </div>
@else
<form action="{{ url('/master_program/' . $program->id_program . '/update') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Master Program</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Program</label>
                    <input type="text" name="kode_program" id="kode_program" class="form-control" value="{{ $program->kode_program }}" required>
                    <small id="error-kode_program" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Program</label>
                    <input type="text" name="nama_program" id="nama_program" class="form-control" value="{{ $program->nama_program }}" required>
                    <small id="error-nama_program" class="error-text form-text text-danger"></small>
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
                kode_program: { required: true, maxlength: 5 },
                nama_program: { required: true, maxlength: 200 }
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
                            dataMasterProgram.ajax.reload();
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
                    },
                    error: function (xhr) {
                        $('.error-text').text('');
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (field, messages) {
                                $('#error-' + field).text(messages[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                text: 'Silakan periksa inputan Anda.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: 'Terjadi kesalahan di server.'
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

        // Optional: Hilangkan pesan error saat mengetik ulang
        $('#kode_program, #nama_program').on('input', function () {
            $('#error-' + $(this).attr('id')).text('');
        });
    });
</script>
@endempty
