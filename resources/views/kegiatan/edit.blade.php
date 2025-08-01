@empty($kegiatan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data kegiatan tidak ditemukan.
                </div>
                <a href="{{ url('/master_kegiatan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/master_kegiatan/' . $kegiatan->id_kegiatan . '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Edit Master Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Kegiatan</label>
                        <input type="text" name="kode_kegiatan" id="kode_kegiatan" class="form-control" 
                               value="{{ $kegiatan->kode_kegiatan }}" required>
                        <small id="error-kode_kegiatan" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Program</label>
                        <select name="id_program" id="id_program" class="form-control" required>
                            <option value="">Pilih Program</option>
                            @foreach($program as $p)
                                <option value="{{ $p->id_program }}" 
                                        {{ $kegiatan->id_program == $p->id_program ? 'selected' : '' }}>
                                    {{ $p->nama_program }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-id_program" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" 
                               value="{{ $kegiatan->nama_kegiatan }}" required>
                        <small id="error-nama_kegiatan" class="error-text form-text text-danger"></small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    kode_kegiatan: { required: true, maxlength: 8, minlength: 1 },
                    id_program: { required: true },
                    nama_kegiatan: { required: true, maxlength: 200 }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataMasterKegiatan.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                if (response.msgField) {
                                    $.each(response.msgField, function(field, messages) {
                                        $('#error-' + field).text(messages[0]);
                                    });
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
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

            // Hapus error ketika mengetik ulang atau memilih option
            $('#kode_kegiatan, #nama_kegiatan').on('input', function() {
                const id = $(this).attr('id');
                $('#error-' + id).text('');
            });

            $('#id_program').on('change', function() {
                $('#error-id_program').text('');
            });
        });
    </script>
@endempty