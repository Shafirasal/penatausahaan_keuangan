@empty($sub_kegiatan)
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
                    Data sub kegiatan tidak ditemukan.
                </div>
                <a href="{{ url('/master_sub_kegiatan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/master_sub_kegiatan/' . $sub_kegiatan->id_sub_kegiatan . '/update') }}" method="POST"
        id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Edit Master Sub Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Program</label>
                        <select name="id_program" id="id_program" class="form-control" required>
                            <option value="">Pilih Program</option>
                            @foreach ($program as $p)
                                <option value="{{ $p->id_program }}"
                                    {{ old('id_program', optional($sub_kegiatan->program)->id_program) == $p->id_program ? 'selected' : '' }}>
                                    {{ $p->nama_program }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-id_program" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Kegiatan</label>
                        <select name="id_kegiatan" id="id_kegiatan" class="form-control" required>
                            <option value="">Pilih Kegiatan</option>
                            @foreach ($kegiatan as $k)
                                <option value="{{ $k->id_kegiatan }}"
                                    {{ old('id_kegiatan', optional($sub_kegiatan->kegiatan)->id_kegiatan) == $k->id_kegiatan ? 'selected' : '' }}>
                                    {{ $k->nama_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-id_kegiatan" class="error-text form-text text-danger"></small>
                    </div>


                    <div class="form-group">
                        <label>Kode Sub Kegiatan</label>
                        <input type="text" name="kode_sub_kegiatan" id="kode_sub_kegiatan" class="form-control"
                            value="{{ $sub_kegiatan->kode_sub_kegiatan }}" required>
                        <small id="error-kode_sub_kegiatan" class="error-text form-text text-danger"></small>
                    </div>



                    <div class="form-group">
                        <label>Nama Sub Kegiatan</label>
                        <input type="text" name="nama_sub_kegiatan" id="nama_sub_kegiatan" class="form-control"
                            value="{{ $sub_kegiatan->nama_sub_kegiatan }}" required>
                        <small id="error-nama_sub_kegiatan" class="error-text form-text text-danger"></small>
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
                    id_program: {
                        required: true
                    },
                    id_kegiatan: {
                        required: true
                    },
                    kode_sub_kegiatan: {
                        required: true,
                        maxlength: 12,
                        minlength: 12
                    },

                    nama_sub_kegiatan: {
                        required: true,
                        maxlength: 200
                    }
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
                                dataMasterSubKegiatan.ajax.reload();
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

            // Ambil nilai selected dari Blade agar bisa dipakai di JS
            const selectedKegiatanId = "{{ old('id_kegiatan', optional($sub_kegiatan->kegiatan)->id_kegiatan) }}";

            // CASCADING: PROGRAM → KEGIATAN
            $('#id_program').change(function() {
                const programId = $(this).val();
                $('#id_kegiatan').html('<option value="">Loading...</option>').prop('disabled', true);

                if (programId) {
                    $.get(`/master_sub_kegiatan/program/${programId}/kegiatan`, function(data) {
                        let options = '<option value="">-- Pilih Kegiatan --</option>';
                        data.forEach(item => {
                            const selected = item.id_kegiatan == selectedKegiatanId ?
                                'selected' : '';
                            options +=
                                `<option value="${item.id_kegiatan}" ${selected}>${item.nama_kegiatan}</option>`;
                        });
                        $('#id_kegiatan').html(options).prop('disabled', false);
                    });
                } else {
                    $('#id_kegiatan').html('<option value="">-- Pilih Kegiatan --</option>').prop(
                        'disabled', true);
                }
            });

            // Trigger change jika ingin auto-load saat halaman dibuka (edit form misalnya)
            $(document).ready(function() {
                if ($('#id_program').val()) {
                    $('#id_program').trigger('change');
                }
            });
            // IF EDIT MODE: Populate KEGIATAN & SUB KEGIATAN
            const selectedProgram = $('#id_program').val();
            const selectedKegiatan = $('#id_kegiatan').data('selected');


        });
    </script>
@endempty
