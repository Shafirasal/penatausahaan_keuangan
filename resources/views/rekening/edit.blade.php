@empty($rekening)
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
                    Data rekening tidak ditemukan.
                </div>
                <a href="{{ url('/master_rekening') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/master_rekening/' . $rekening->id_rekening . '/update') }}" method="POST"
        id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Edit Master Rekening</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Program</label>
                        <select name="id_program" id="id_program" class="form-control" required>
                            <option value="">Pilih Program</option>
                            @foreach ($masterProgram as $p)
                                <option value="{{ $p->id_program }}"
                                    {{ old('id_program', optional($rekening->program)->id_program) == $p->id_program ? 'selected' : '' }}>
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
                                    {{ old('id_kegiatan', optional($rekening->kegiatan)->id_kegiatan) == $k->id_kegiatan ? 'selected' : '' }}>
                                    {{ $k->nama_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-id_kegiatan" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Sub Kegiatan</label>
                        <select name="id_sub_kegiatan" id="id_sub_kegiatan" class="form-control" required>
                            <option value="">Pilih Sub Kegiatan</option>
                            @foreach ($sub_kegiatan as $sk)
                                <option value="{{ $sk->id_sub_kegiatan }}"
                                    {{ old('id_sub_kegiatan', optional($rekening->subKegiatan)->id_sub_kegiatan) == $sk->id_sub_kegiatan ? 'selected' : '' }}>
                                    {{ $sk->nama_sub_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-id_sub_kegiatan" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Kode Rekening</label>
                        <input type="text" name="kode_rekening" id="kode_rekening" class="form-control"
                            value="{{ $rekening->kode_rekening }}" required>
                        <small id="error-kode_rekening" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Nama Rekening</label>
                        <input type="text" name="nama_rekening" id="nama_rekening" class="form-control"
                            value="{{ $rekening->nama_rekening }}" required>
                        <small id="error-nama_rekening" class="error-text form-text text-danger"></small>
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
                    id_sub_kegiatan: {
                        required: true
                    },
                    kode_rekening: {
                        required: true,
                        maxlength: 12,
                        minlength: 12
                    },
                    nama_rekening: {
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
                                dataMasterRekening.ajax.reload();
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
            $('#kode_rekening, #nama_rekening').on('input', function() {
                const id = $(this).attr('id');
                $('#error-' + id).text('');
            });

            // Ambil nilai selected dari Blade agar bisa dipakai di JS
            const selectedKegiatanId = "{{ old('id_kegiatan', optional($rekening->kegiatan)->id_kegiatan) }}";
            const selectedSubKegiatanId = "{{ old('id_sub_kegiatan', optional($rekening->subKegiatan)->id_sub_kegiatan) }}";

            // CASCADING: PROGRAM → KEGIATAN
            $('#id_program').change(function() {
                const programId = $(this).val();
                $('#id_kegiatan').html('<option value="">Loading...</option>').prop('disabled', true);
                $('#id_sub_kegiatan').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true);

                if (programId) {
                    $.get(`/master_rekening/program/${programId}/kegiatan`, function(data) {
                        let options = '<option value="">-- Pilih Kegiatan --</option>';
                        data.forEach(item => {
                            const selected = item.id_kegiatan == selectedKegiatanId ? 'selected' : '';
                            options += `<option value="${item.id_kegiatan}" ${selected}>${item.nama_kegiatan}</option>`;
                        });
                        $('#id_kegiatan').html(options).prop('disabled', false);
                        
                        // Auto trigger kegiatan change jika ada selected value
                        if (selectedKegiatanId && $('#id_kegiatan').val()) {
                            $('#id_kegiatan').trigger('change');
                        }
                    });
                } else {
                    $('#id_kegiatan').html('<option value="">-- Pilih Kegiatan --</option>').prop('disabled', true);
                    $('#id_sub_kegiatan').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true);
                }
            });

            // CASCADING: KEGIATAN → SUB KEGIATAN
            $('#id_kegiatan').change(function() {
                const kegiatanId = $(this).val();
                $('#id_sub_kegiatan').html('<option value="">Loading...</option>').prop('disabled', true);

                if (kegiatanId) {
                    $.get(`/master_rekening/kegiatan/${kegiatanId}/sub_kegiatan`, function(data) {
                        let options = '<option value="">-- Pilih Sub Kegiatan --</option>';
                        data.forEach(item => {
                            const selected = item.id_sub_kegiatan == selectedSubKegiatanId ? 'selected' : '';
                            options += `<option value="${item.id_sub_kegiatan}" ${selected}>${item.nama_sub_kegiatan}</option>`;
                        });
                        $('#id_sub_kegiatan').html(options).prop('disabled', false);
                    });
                } else {
                    $('#id_sub_kegiatan').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true);
                }
            });

            // Trigger change jika ingin auto-load saat halaman dibuka (edit form)
            if ($('#id_program').val()) {
                $('#id_program').trigger('change');
            }
        });
    </script>
@endempty