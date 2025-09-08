@empty($ssh)
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
                    Data SSH tidak ditemukan.
                </div>
                <a href="{{ url('/ssh') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/ssh/' . $ssh->id_ssh . '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Edit SSH</h5>
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
                                    {{ old('id_program', optional($ssh->program)->id_program) == $p->id_program ? 'selected' : '' }}>
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
                                    {{ old('id_kegiatan', optional($ssh->kegiatan)->id_kegiatan) == $k->id_kegiatan ? 'selected' : '' }}>
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
                            @foreach ($sub_kegiatan as $s)
                                <option value="{{ $s->id_sub_kegiatan }}"
                                    {{ old('id_sub_kegiatan', optional($ssh->sub_kegiatan)->id_sub_kegiatan) == $s->id_sub_kegiatan ? 'selected' : '' }}>
                                    {{ $s->nama_sub_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-id_sub_kegiatan" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Rekening</label>
                        <select name="id_rekening" id="id_rekening" class="form-control" required>
                            <option value="">Pilih Rekening</option>
                            @foreach ($rekening as $r)
                                <option value="{{ $r->id_rekening }}"
                                    {{ old('id_rekening', optional($ssh->rekening)->id_rekening) == $r->id_rekening ? 'selected' : '' }}>
                                    {{ $r->nama_rekening }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-id_rekening" class="error-text form-text text-danger"></small>
                    </div>


                    <div class="form-group">
                        <label>Kode SSH</label>
                        <input type="text" name="kode_ssh" id="kode_ssh" class="form-control"
                            value="{{ $ssh->kode_ssh }}" required>
                        <small id="error-kode_ssh" class="error-text form-text text-danger"></small>
                    </div>



                    <div class="form-group">
                        <label>Nama SSH</label>
                        <input type="text" name="nama_ssh" id="nama_ssh" class="form-control"
                            value="{{ $ssh->nama_ssh }}" required>
                        <small id="error-nama_ssh" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Periode 1</label>
                        <input type="number" name="pagu1" id="pagu1" class="form-control"
                            value="{{ $ssh->pagu1 }}" required>
                        <small id="error-pagu1" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Periode 2</label>
                        <input type="text" name="pagu2" id="pagu2" class="form-control"
                            value="{{ $ssh->pagu2 }}" required>
                        <small id="error-pagu2" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <input type="date" name="tahun" id="tahun" class="form-control"
                            value="{{ $ssh->tahun }}" required>
                        <small id="error-tahun" class="error-text form-text text-danger"></small>
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
                    id_rekening: {
                        required: true
                    },
                    kode_ssh: {
                        required: true,
                        maxlength: 17,
                        minlength: 1
                    },
                    nama_ssh: {
                        required: true,
                        maxlength: 200
                    },
                    pagu1: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    pagu2: {
                    required: true,
                    number: true,
                    min: 0
                },
                    tahun: {
                        required: true,
                        date: true
                    },
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
                                dataSSH.ajax.reload();
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

            // ======== BERSIHKAN ERROR SAAT INPUT ========
            $('#form-edit input, #form-edit select').on('input change', function() {
                const id = $(this).attr('id');
                $('#error-' + id).text('');
            });

            // Ambil nilai yang sudah terseleksi dari Blade (mode edit)
            const selectedProgramId = "{{ old('id_program', $ssh->id_program ?? '') }}";
            const selectedKegiatanId = "{{ old('id_kegiatan', $ssh->id_kegiatan ?? '') }}";
            const selectedSubKegiatanId = "{{ old('id_sub_kegiatan', $ssh->id_sub_kegiatan ?? '') }}";
            const selectedRekeningId = "{{ old('id_rekening', $ssh->id_rekening ?? '') }}";

            // ======== CASCADING PROGRAM ➝ KEGIATAN ========
            $('#id_program').change(function() {
                const programId = $(this).val();
                $('#id_kegiatan').html('<option value="">-- Pilih Kegiatan --</option>').prop('disabled',
                    true);
                $('#id_sub_kegiatan').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop(
                    'disabled', true);
                $('#id_rekening').html('<option value="">-- Pilih Rekening --</option>').prop('disabled',
                    true); // reset juga rekening

                if (programId) {
                    $.get(`/ssh/program/${programId}/kegiatan`, function(data) {
                        let options = '<option value="">-- Pilih Kegiatan --</option>';
                        data.forEach(item => {
                            const selected = item.id_kegiatan == selectedKegiatanId ?
                                'selected' : '';
                            options +=
                                `<option value="${item.id_kegiatan}" ${selected}>${item.nama_kegiatan}</option>`;
                        });
                        $('#id_kegiatan').html(options).prop('disabled', false).trigger(
                            'change'); // ← trigger ke sub-kegiatan
                    });
                }
            });


            // ======== CASCADING KEGIATAN ➝ SUB KEGIATAN ========
            $('#id_kegiatan').change(function() {
                const kegiatanId = $(this).val();
                $('#id_sub_kegiatan').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop(
                    'disabled', true);
                $('#id_rekening').html('<option value="">-- Pilih Rekening --</option>').prop('disabled',
                    true); // reset juga rekening

                if (kegiatanId) {
                    $.get(`/ssh/kegiatan/${kegiatanId}/sub_kegiatan`, function(data) {
                        let options = '<option value="">-- Pilih Sub Kegiatan --</option>';
                        data.forEach(item => {
                            const selected = item.id_sub_kegiatan == selectedSubKegiatanId ?
                                'selected' : '';
                            options +=
                                `<option value="${item.id_sub_kegiatan}" ${selected}>${item.nama_sub_kegiatan}</option>`;
                        });
                        $('#id_sub_kegiatan').html(options).prop('disabled', false).trigger(
                            'change'); // ← trigger ke rekening
                    });
                }
            });


            // CASCADING: SUB KEGIATAN → REKENING
            $('#id_sub_kegiatan').change(function() {
                const subKegiatanId = $(this).val();
                $('#id_rekening').html('<option value="">-- Pilih Rekening --</option>').prop('disabled',
                    true);

                if (subKegiatanId) {
                    $.get(`/ssh/sub_kegiatan/${subKegiatanId}/rekening`, function(data) {
                        let options = '<option value="">-- Pilih Rekening --</option>';
                        data.forEach(item => {
                            const selected = item.id_rekening == selectedRekeningId ?
                                'selected' : '';
                            options +=
                                `<option value="${item.id_rekening}" ${selected}>${item.nama_rekening}</option>`;
                        });
                        $('#id_rekening').html(options).prop('disabled', false);
                    });
                }
            });



            // ======== TRIGGER AUTOLOAD (mode edit) ========
            if (selectedProgramId) {
                $('#id_program').val(selectedProgramId).trigger('change');
            }
        });
    </script>
@endempty
