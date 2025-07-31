<form action="{{ url('/master_program/store') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Tambah Master Program</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Program</label>
                    <input type="text" name="kode_program" id="kode_program" class="form-control" required>
                    <small id="error-kode_program" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Program</label>
                    <input type="text" name="nama_program" id="nama_program" class="form-control" required>
                    <small id="error-nama_program" class="error-text form-text text-danger"></small>
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
    $("#form-tambah").validate({
        rules: {
            kode_program: { required: true, maxlength: 5, minlength: 1 },
            nama_program: { required: true, maxlength: 200 }
        },
        submitHandler: function(form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide'); // Fix ID here
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        dataMasterProgram.ajax.reload();
                    }
                },
                error: function(xhr) {
                    $('.error-text').text(''); // clear previous error
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
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

        // Hapus error ketika mengetik ulang
    $('#kode_program, #nama_program').on('input', function() {
        const id = $(this).attr('id');
        $('#error-' + id).text('');
    });
});

</script>
