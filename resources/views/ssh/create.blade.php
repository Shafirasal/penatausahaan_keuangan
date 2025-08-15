<form action="{{ url('/ssh/store') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Tambah SSH</h5>
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
                            <option value="{{ $p->id_program }}">{{ $p->kode_program }} - {{ $p->nama_program }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_program" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Kegiatan</label>
                    <select name="id_kegiatan" id="id_kegiatan" class="form-control" required>
                        <option value="">Pilih Kegiatan</option>
                    </select>
                    <small id="error-id_kegiatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Sub Kegiatan</label>
                    <select name="id_sub_kegiatan" id="id_sub_kegiatan" class="form-control" required>
                        <option value="">Pilih Sub Kegiatan</option>
                    </select>
                    <small id="error-id_sub_kegiatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Rekening</label>
                    <select name="id_rekening" id="id_rekening" class="form-control" required>
                        <option value="">Pilih Rekening</option>
                    </select>
                    <small id="error-id_rekening" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Kode SSH</label>
                    <input type="text" name="kode_ssh" id="kode_ssh" class="form-control" required>
                    <small id="error-kode_ssh" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama SSH</label>
                    <input type="text" name="nama_ssh" id="nama_ssh" class="form-control" required>
                    <small id="error-nama_ssh" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Pagu</label>
                    <input type="number" name="pagu" id="pagu" class="form-control" required>
                    <small id="error-pagu" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Periode</label>
                    <input type="text" name="periode" id="periode" class="form-control" required>
                    <small id="error-periode" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tahun</label>
                    <input type="date" name="tahun" id="tahun" class="form-control" required>
                    <small id="error-tahun" class="error-text form-text text-danger"></small>
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

        // Inisialisasi Select2 untuk Program
        $('#id_program').select2({
            placeholder: "Pilih Program",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#myModal')
        });

        // Inisialisasi Select2 untuk Kegiatan (disabled dulu)
        $('#id_kegiatan').select2({
            placeholder: "Pilih Kegiatan", // ← FIX: Placeholder yang benar
            allowClear: true,
            width: '100%',
            dropdownParent: $('#myModal')
        }).prop('disabled', true);

        // Inisialisasi Select2 untuk Sub Kegiatan (disabled dulu)
        $('#id_sub_kegiatan').select2({
            placeholder: "Pilih Sub Kegiatan", // ← FIX: Placeholder yang benar
            allowClear: true,
            width: '100%',
            dropdownParent: $('#myModal')
        }).prop('disabled', true);

        // Inisialisasi Select2 untuk Rekening (disabled dulu)
        $('#id_rekening').select2({
            placeholder: "Pilih Rekening", // ← FIX: Placeholder yang benar
            allowClear: true,
            width: '100%',
            dropdownParent: $('#myModal')
        }).prop('disabled', true);

        $("#form-tambah").validate({
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
                pagu: {
                    required: true,
                    number: true,
                    min: 0
                },
                periode: {
                    required: true,
                    maxlength: 50
                },
                tahun: {
                    required: true,
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
        $('#kode_ssh, #nama_ssh').on('input', function() {
            const id = $(this).attr('id');
            $('#error-' + id).text('');
        });

        // Hapus error untuk select2
        $('#id_program, #id_kegiatan, #id_sub_kegiatan, #id_rekening').on('select2:select select2:clear', function() {
            const id = $(this).attr('id');
            $('#error-' + id).text('');
        });

        // FIX: Menggunakan Select2 events untuk cascading
        $('#id_program').on('select2:select select2:clear', function(e) {
            const programId = $(this).val();

            if (e.type === 'select2:select' && programId) {
                // Tampilkan Loading di Select2
                $('#id_kegiatan').empty().append('<option value="">Loading...</option>');
                $('#id_kegiatan').prop('disabled', true).trigger('change');

                // Update placeholder Select2 ke Loading
                $('#id_kegiatan').select2('destroy').select2({
                    placeholder: "Loading...",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#myModal')
                }).prop('disabled', true);

                $.get(`/ssh/program/${programId}/kegiatan`, function(data) {
                    // Clear options dan tambah default
                    $('#id_kegiatan').empty().append(
                        '<option value="">-- Pilih Kegiatan --</option>');

                    // Tambah data kegiatan
                    data.forEach(item => {
                        let optionText = item.kode_kegiatan ?
                            `${item.kode_kegiatan} - ${item.nama_kegiatan}` :
                            item.nama_kegiatan;
                        $('#id_kegiatan').append(new Option(optionText, item
                            .id_kegiatan));
                    });

                    // Reinitialize Select2 dengan placeholder normal
                    $('#id_kegiatan').select2('destroy').select2({
                        placeholder: "-- Pilih Kegiatan --",
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $('#myModal')
                    }).prop('disabled', false);

                }).fail(function() {
                    alert('Gagal memuat data kegiatan');
                    $('#id_kegiatan').empty().append(
                        '<option value="">-- Pilih Kegiatan --</option>');
                    $('#id_kegiatan').select2('destroy').select2({
                        placeholder: "-- Pilih Kegiatan --",
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $('#myModal')
                    }).prop('disabled', true);
                });

            } else {
                // Reset kegiatan saat program di-clear
                $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');
                $('#id_kegiatan').select2('destroy').select2({
                    placeholder: "Pilih Kegiatan",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#myModal')
                }).prop('disabled', true);
            }
        });
        // FIX: Menggunakan Select2 events untuk cascading
        $('#id_kegiatan').on('select2:select select2:clear', function(e) {
            const kegiatanId = $(this).val();

            if (e.type === 'select2:select' && kegiatanId) {
                // Tampilkan Loading di Select2
                $('#id_sub_kegiatan').empty().append('<option value="">Loading...</option>');
                $('#id_sub_kegiatan').prop('disabled', true).trigger('change');

                // Update placeholder Select2 ke Loading
                $('#id_sub_kegiatan').select2('destroy').select2({
                    placeholder: "Loading...",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#myModal')
                }).prop('disabled', true);

                $.get(`/ssh/kegiatan/${kegiatanId}/sub_kegiatan`, function(data) {
                    // Clear options dan tambah default
                    $('#id_sub_kegiatan').empty().append(
                        '<option value="">-- Pilih Sub Kegiatan --</option>');

                    // Tambah data kegiatan
                    data.forEach(item => {
                        let optionText = item.kode_sub_kegiatan ?
                            `${item.kode_sub_kegiatan} - ${item.nama_sub_kegiatan}` :
                            item.nama_sub_kegiatan;
                        $('#id_sub_kegiatan').append(new Option(optionText, item
                            .id_sub_kegiatan));
                    });

                    // Reinitialize Select2 dengan placeholder normal
                    $('#id_sub_kegiatan').select2('destroy').select2({
                        placeholder: "-- Pilih Sub Kegiatan --",
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $('#myModal')
                    }).prop('disabled', false);

                }).fail(function() {
                    alert('Gagal memuat data sub_kegiatan');
                    $('#id_sub_kegiatan').empty().append(
                        '<option value="">-- Pilih Sub Kegiatan --</option>');
                    $('#id_sub_kegiatan').select2('destroy').select2({
                        placeholder: "-- Pilih Sub Kegiatan --",
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $('#myModal')
                    }).prop('disabled', true);
                });

            } else {
                // Reset kegiatan saat program di-clear
                $('#id_sub_kegiatan').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>');
                $('#id_sub_kegiatan').select2('destroy').select2({
                    placeholder: "Pilih Sub Kegiatan",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#myModal')
                }).prop('disabled', true);
            }
        });
        // FIX: Menggunakan Select2 events untuk cascading
        $('#id_sub_kegiatan').on('select2:select select2:clear', function(e) {
            const subKegiatanId = $(this).val();

            if (e.type === 'select2:select' && subKegiatanId) {
                // Tampilkan Loading di Select2
                $('#id_rekening').empty().append('<option value="">Loading...</option>');
                $('#id_rekening').prop('disabled', true).trigger('change');

                // Update placeholder Select2 ke Loading
                $('#id_rekening').select2('destroy').select2({
                    placeholder: "Loading...",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#myModal')
                }).prop('disabled', true);

                $.get(`/ssh/sub_kegiatan/${subKegiatanId}/rekening`, function(data) {
                    // Clear options dan tambah default
                    $('#id_rekening').empty().append(
                        '<option value="">-- Pilih Rekening --</option>');

                    // Tambah data kegiatan
                    data.forEach(item => {
                        let optionText = item.kode_rekening ?
                            `${item.kode_rekening} - ${item.nama_rekening}` :
                            item.nama_rekening;
                        $('#id_rekening').append(new Option(optionText, item
                            .id_rekening));
                    });

                    // Reinitialize Select2 dengan placeholder normal
                    $('#id_rekening').select2('destroy').select2({
                        placeholder: "-- Pilih Rekening --",
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $('#myModal')
                    }).prop('disabled', false);

                }).fail(function() {
                    alert('Gagal memuat data rekening');
                    $('#id_rekening').empty().append(
                        '<option value="">-- Pilih Rekening --</option>');
                    $('#id_rekening').select2('destroy').select2({
                        placeholder: "-- Pilih Rekening --",
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $('#myModal')
                    }).prop('disabled', true);
                });

            } else {
                // Reset kegiatan saat program di-clear
                $('#id_rekening').empty().append('<option value="">-- Pilih Rekening --</option>');
                $('#id_rekening').select2('destroy').select2({
                    placeholder: "Pilih Rekening",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#myModal')
                }).prop('disabled', true);
            }
        });

        // IF EDIT MODE: Populate KEGIATAN & SUB KEGIATAN
        const selectedProgram = $('#id_program').val();
        const selectedKegiatan = $('#id_kegiatan').data('selected');
        const selectedSubKegiatan = $('#id_sub_kegiatan').data('selected');
        const selectedRekening = $('#id_rekening').data('selected');

        if (selectedProgram) {
            $.get(`/ssh/program/${selectedProgram}/kegiatan`, function(data) {
                $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');

                data.forEach(item => {
                    let optionText = item.kode_kegiatan ?
                        `${item.kode_kegiatan} - ${item.nama_kegiatan}` :
                        item.nama_kegiatan;
                    const selected = item.id_kegiatan == selectedKegiatan;
                    $('#id_kegiatan').append(new Option(optionText, item.id_kegiatan, false,
                        selected));
                });

                $('#id_kegiatan').select2('destroy').select2({
                    placeholder: "-- Pilih Kegiatan --",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#myModal')
                }).prop('disabled', false);
            });
        }
        if (selectedKegiatan) {
            $.get(`/ssh/kegiatan/${selectedKegiatan}/sub_kegiatan`, function(data) {
                $('#id_sub_kegiatan').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>');

                data.forEach(item => {
                    let optionText = item.kode_kegiatan ?
                        `${item.kode_sub_kegiatan} - ${item.nama_sub_kegiatan}` :
                        item.nama_sub_kegiatan;
                    const selected = item.id_sub_kegiatan == selectedSubKegiatan;
                    $('#id_sub_kegiatan').append(new Option(optionText, item.id_sub_kegiatan, false,
                        selected));
                });

                $('#id_sub_kegiatan').select2('destroy').select2({
                    placeholder: "-- Pilih Sub Kegiatan --",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#myModal')
                }).prop('disabled', false);
            });
        }
        if (selectedSubKegiatan) {
            $.get(`/ssh/sub_kegiatan/${selectedSubKegiatan}/rekening`, function(data) {
                $('#id_rekening').empty().append('<option value="">-- Pilih Rekening --</option>');

                data.forEach(item => {
                    let optionText = item.kode_rekening ?
                        `${item.kode_rekening} - ${item.nama_rekening}` :
                        item.nama_rekening;
                    const selected = item.id_rekening == selectedRekening;
                    $('#id_rekening').append(new Option(optionText, item.id_rekening, false,
                        selected));
                });

                $('#id_rekening').select2('destroy').select2({
                    placeholder: "-- Pilih Rekening --",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#myModal')
                }).prop('disabled', false);
            });
        }
    });
</script>
