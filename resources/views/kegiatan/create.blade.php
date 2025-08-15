<form action="{{ url('/master_kegiatan/store') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Tambah Master Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Program</label>
                    <select name="id_program" id="id_program" class="form-control" required>
                        <option value="">Pilih Program</option>
                        @foreach($program as $p)
                            <option value="{{ $p->id_program }}">{{ $p->kode_program }} - {{ $p->nama_program }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_program" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kode Kegiatan</label>
                    <input type="text" name="kode_kegiatan" id="kode_kegiatan" class="form-control" required>
                    <small id="error-kode_kegiatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required>
                    <small id="error-nama_kegiatan" class="error-text form-text text-danger"></small>
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
    $(document).ready(function () {
        // Inisialisasi Select2 untuk Program
        $('#id_program').select2({
            placeholder: "Pilih Program",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#myModal')
        });
        $("#form-tambah").validate({
            rules: {
                kode_kegiatan: { required: true, maxlength: 8, minlength: 1 },
                id_program: { required: true },
                nama_kegiatan: { required: true, maxlength: 200 }
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
                            dataMasterKegiatan.ajax.reload();
                        }
                    },
                    error: function (xhr) {
                        $('.error-text').text(''); // clear previous error
                        if (xhr.status === 422) {
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

        // Hapus error ketika mengetik ulang atau memilih option
        $('#kode_kegiatan, #nama_kegiatan').on('input', function () {
            const id = $(this).attr('id');
            $('#error-' + id).text('');
        });

        // Hapus error untuk select2
        $('#id_program').on('select2:select select2:clear', function() {
            const id = $(this).attr('id');
            $('#error-' + id).text('');
        });

        $('#id_program').on('change', function () {
            $('#error-id_program').text('');
        });
    });

</script>