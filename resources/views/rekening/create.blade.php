<form action="{{ url('/master_rekening/store') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-rekening" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Tambah Rekening</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Kode Rekening</label>
                    <input type="text" name="kode_rekening" id="kode_rekening" class="form-control" required>
                    <small id="error-kode_rekening" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Rekening</label>
                    <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" required>
                    <small id="error-nama_rekening" class="error-text text-danger"></small>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Program</label>
                        <select name="id_program" id="id_program" class="form-control" required>
                            <option value="">-- Pilih Program --</option>
                            @foreach ($masterProgram as $p)
                                <option value="{{ $p->id_program }}">{{ $p->nama_program }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_program" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Kegiatan</label>
                        <select name="id_kegiatan" id="id_kegiatan" class="form-control" required>
                            <option value="">-- Pilih Kegiatan --</option>
                        </select>
                        <small id="error-id_kegiatan" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Sub Kegiatan</label>
                        <select name="id_sub_kegiatan" id="id_sub_kegiatan" class="form-control" required>
                            <option value="">-- Pilih Sub Kegiatan --</option>
                        </select>
                        <small id="error-id_sub_kegiatan" class="error-text form-text text-danger"></small>
                    </div>
                </div>


            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </div>
    </div>
</form>

{{-- 
<script>
$(document).ready(function() {
    // FORM VALIDATION
    $('#form-rekening').validate({
        rules: {
            kode_rekening: { required: true, maxlength: 10 },
            nama_rekening: { required: true, maxlength: 200 },
            id_program: { required: true },
            id_kegiatan: { required: true },
            id_sub_kegiatan: { required: true }
        },
        submitHandler: function(form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if (response.status) {
                        $('#modal-rekening').modal('hide');
                        Swal.fire('Berhasil', response.message, 'success');
                        dataMasterRekening.ajax.reload();
                    }
                },
                error: function(xhr) {
                    $('.error-text').text('');
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function(field, message) {
                            $('#error-' + field).text(message[0]);
                        });
                        Swal.fire('Validasi Gagal', 'Silakan periksa inputan Anda.', 'error');
                    } else {
                        Swal.fire('Server Error', 'Terjadi kesalahan di server.', 'error');
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

    // CLEAR ERROR ON INPUT
    $('#form-rekening input, #form-rekening select').on('input change', function() {
        const id = $(this).attr('id');
        $('#error-' + id).text('');
    });

    // CASCADING SELECT: PROGRAM → KEGIATAN
    $('#id_program').on('change', function() {
        const programID = $(this).val();

        // Reset kegiatan & sub kegiatan
        $('#id_kegiatan').html('<option value="">-- Pilih Kegiatan --</option>').prop('disabled', true);
        $('#id_sub_kegiatan').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true);

        if (programID) {
            $.get(`/master_rekening/program/${programID}/kegiatan`, function(data) {
                let options = '<option value="">-- Pilih Kegiatan --</option>';
                $.each(data, function(i, kegiatan) {
                    options += `<option value="${kegiatan.id_kegiatan}">${kegiatan.nama_kegiatan}</option>`;
                });
                $('#id_kegiatan').html(options).prop('disabled', false);
            });
        }
    });

    // CASCADING SELECT: KEGIATAN → SUB KEGIATAN
    $('#id_kegiatan').on('change', function() {
        const kegiatanID = $(this).val();

        $('#id_sub_kegiatan').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true);

        if (kegiatanID) {
            $.get(`/master_rekening/kegiatan/${kegiatanID}/sub_kegiatan`, function(data) {
                let options = '<option value="">-- Pilih Sub Kegiatan --</option>';
                $.each(data, function(i, sub) {
                    options += `<option value="${sub.id_sub_kegiatan}">${sub.nama_sub_kegiatan}</option>`;
                });
                $('#id_sub_kegiatan').html(options).prop('disabled', false);
            });
        }
    });

    // OPTIONAL: If you're editing a record and want to populate kegiatan & sub_kegiatan
    const selectedProgram = $('#id_program').val();
    const selectedKegiatan = $('#id_kegiatan').data('selected'); // <-- assign in blade if needed
    const selectedSubKegiatan = $('#id_sub_kegiatan').data('selected');

    if (selectedProgram) {
        $.get(`/master_rekening/program/${selectedProgram}/kegiatan`, function(data) {
            let options = '<option value="">-- Pilih Kegiatan --</option>';
            $.each(data, function(i, kegiatan) {
                const selected = (kegiatan.id_kegiatan == selectedKegiatan) ? 'selected' : '';
                options += `<option value="${kegiatan.id_kegiatan}" ${selected}>${kegiatan.nama_kegiatan}</option>`;
            });
            $('#id_kegiatan').html(options).prop('disabled', false);

            if (selectedKegiatan) {
                $.get(`/master_rekening/kegiatan/${selectedKegiatan}/sub_kegiatan`, function(data) {
                    let options = '<option value="">-- Pilih Sub Kegiatan --</option>';
                    $.each(data, function(i, sub) {
                        const selected = (sub.id_sub_kegiatan == selectedSubKegiatan) ? 'selected' : '';
                        options += `<option value="${sub.id_sub_kegiatan}" ${selected}>${sub.nama_sub_kegiatan}</option>`;
                    });
                    $('#id_sub_kegiatan').html(options).prop('disabled', false);
                });
            }
        });
    }
});
</script> --}}


<script>
$(document).ready(function () {
    // FORM VALIDATION
    $('#form-tambah').validate({
        rules: {
            kode_rekening: { required: true, maxlength: 10 },
            nama_rekening: { required: true, maxlength: 200 },
            id_program: { required: true },
            id_kegiatan: { required: true },
            id_sub_kegiatan: { required: true }
        },
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire('Berhasil', response.message, 'success');
                        dataMasterRekening.ajax.reload();
                    }
                },
                error: function (xhr) {
                    $('.error-text').text('');
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function (field, message) {
                            $('#error-' + field).text(message[0]);
                        });
                        Swal.fire('Validasi Gagal', 'Silakan periksa inputan Anda.', 'error');
                    } else {
                        Swal.fire('Server Error', 'Terjadi kesalahan di server.', 'error');
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

    // CLEAR ERROR ON INPUT
    $('#form-rekening input, #form-rekening select').on('input change', function () {
        const id = $(this).attr('id');
        $('#error-' + id).text('');
    });

    // CASCADING: PROGRAM → KEGIATAN
    $('#id_program').change(function () {
        const programId = $(this).val();
        $('#id_kegiatan').html('<option value="">Loading...</option>');
        $('#id_sub_kegiatan').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true);

        if (programId) {
            $.get(`/master_rekening/program/${programId}/kegiatan`, function (data) {
                let options = '<option value="">-- Pilih Kegiatan --</option>';
                data.forEach(item => {
                    options += `<option value="${item.id_kegiatan}">${item.nama_kegiatan}</option>`;
                });
                $('#id_kegiatan').html(options).prop('disabled', false);
            });
        } else {
            $('#id_kegiatan').html('<option value="">-- Pilih Kegiatan --</option>').prop('disabled', true);
        }
    });

    // CASCADING: KEGIATAN → SUB KEGIATAN
    $('#id_kegiatan').change(function () {
        const kegiatanId = $(this).val();
        $('#id_sub_kegiatan').html('<option value="">Loading...</option>');

        if (kegiatanId) {
            $.get(`/master_rekening/kegiatan/${kegiatanId}/sub_kegiatan`, function (data) {
                let options = '<option value="">-- Pilih Sub Kegiatan --</option>';
                data.forEach(item => {
                    options += `<option value="${item.id_sub_kegiatan}">${item.nama_sub_kegiatan}</option>`;
                });
                $('#id_sub_kegiatan').html(options).prop('disabled', false);
            });
        } else {
            $('#id_sub_kegiatan').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true);
        }
    });

    // IF EDIT MODE: Populate KEGIATAN & SUB KEGIATAN
    const selectedProgram = $('#id_program').val();
    const selectedKegiatan = $('#id_kegiatan').data('selected');
    const selectedSubKegiatan = $('#id_sub_kegiatan').data('selected');

    if (selectedProgram) {
        $.get(`/master_rekening/program/${selectedProgram}/kegiatan`, function (data) {
            let kegiatanOptions = '<option value="">-- Pilih Kegiatan --</option>';
            data.forEach(item => {
                const selected = item.id_kegiatan == selectedKegiatan ? 'selected' : '';
                kegiatanOptions += `<option value="${item.id_kegiatan}" ${selected}>${item.nama_kegiatan}</option>`;
            });
            $('#id_kegiatan').html(kegiatanOptions).prop('disabled', false);

            if (selectedKegiatan) {
                $.get(`/master_rekening/kegiatan/${selectedKegiatan}/sub_kegiatan`, function (data) {
                    let subOptions = '<option value="">-- Pilih Sub Kegiatan --</option>';
                    data.forEach(item => {
                        const selected = item.id_sub_kegiatan == selectedSubKegiatan ? 'selected' : '';
                        subOptions += `<option value="${item.id_sub_kegiatan}" ${selected}>${item.nama_sub_kegiatan}</option>`;
                    });
                    $('#id_sub_kegiatan').html(subOptions).prop('disabled', false);
                });
            }
        });
    }
});
</script>
