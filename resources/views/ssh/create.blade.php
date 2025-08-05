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
                            <option value="{{ $p->id_program }}">{{ $p->nama_program }}</option>
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

        // CASCADING: PROGRAM → KEGIATAN
        $('#id_program').change(function() {
            const programId = $(this).val();
            $('#id_kegiatan').html('<option value="">Loading...</option>').prop('disabled', true);
            $('#id_sub_kegiatan').html('<option value="">Loading...</option>').prop('disabled', true);
            $('#id_rekening').html('<option value="">Loading...</option>').prop('disabled', true);

            if (programId) {
                $.get(`/ssh/program/${programId}/kegiatan`, function(data) {
                    let options = '<option value="">-- Pilih Kegiatan --</option>';
                    data.forEach(item => {
                        options +=
                            `<option value="${item.id_kegiatan}">${item.nama_kegiatan}</option>`;
                    });
                    $('#id_kegiatan').html(options).prop('disabled', false);
                });
            } else {
                $('#id_kegiatan').html('<option value="">-- Pilih Kegiatan --</option>').prop(
                    'disabled', true);
            }
        });

        // CASCADING: KEGIATAN → SUB KEGIATAN
        $('#id_kegiatan').change(function() {
            const kegiatanId = $(this).val();
            $('#id_sub_kegiatan').html('<option value="">Loading...</option>').prop('disabled', true);
            $('#id_rekening').html('<option value="">Loading...</option>').prop('disabled', true);
            if (kegiatanId) {
                $.get(`/ssh/kegiatan/${kegiatanId}/sub_kegiatan`, function(data) {
                    let options = '<option value="">-- Pilih Sub Kegiatan --</option>';
                    data.forEach(item => {
                        options +=
                            `<option value="${item.id_sub_kegiatan}">${item.nama_sub_kegiatan}</option>`;
                    });
                    $('#id_sub_kegiatan').html(options).prop('disabled', false);
                });
            } else {
                $('#id_sub_kegiatan').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop(
                    'disabled', true);
            }
        });
        // CASCADING: SUB KEGIATAN → REKENING
        $('#id_sub_kegiatan').change(function() {
            const subKegiatanId = $(this).val();
            $('#id_rekening').html('<option value="">Loading...</option>').prop('disabled', true);
            if (subKegiatanId) {
                $.get(`/ssh/sub_kegiatan/${subKegiatanId}/rekening`, function(data) {
                    let options = '<option value="">-- Pilih Rekening --</option>';
                    data.forEach(item => {
                        options +=
                            `<option value="${item.id_rekening}">${item.nama_rekening}</option>`;
                    });
                    $('#id_rekening').html(options).prop('disabled', false);
                });
            } else {
                $('#id_rekening').html('<option value="">-- Pilih Rekening --</option>').prop(
                    'disabled', true);
            }
        });

        // IF EDIT MODE: Populate KEGIATAN & SUB KEGIATAN
        const selectedProgram = $('#id_program').val();
        const selectedKegiatan = $('#id_kegiatan').data('selected');
        const selectedSubKegiatan = $('#id_sub_kegiatan').data('selected');

        if (selectedProgram) {
            $.get(`/ssh/program/${selectedProgram}/kegiatan`, function(data) {
                let kegiatanOptions = '<option value="">-- Pilih Kegiatan --</option>';
                data.forEach(item => {
                    const selected = item.id_kegiatan == selectedKegiatan ? 'selected' : '';
                    kegiatanOptions +=
                        `<option value="${item.id_kegiatan}" ${selected}>${item.nama_kegiatan}</option>`;
                });
                $('#id_kegiatan').html(kegiatanOptions).prop('disabled', false);
            });
        } else if (selectedKegiatan) {
            $.get(`/ssh/kegiatan/${selectedKegiatan}/sub_kegiatan`, function(data) {
                let subKegiatanOptions = '<option value="">-- Pilih Sub Kegiatan --</option>';
                data.forEach(item => {
                    const selected = item.id_sub_kegiatan == selectedSubKegiatan ? 'selected' :
                        '';
                    subKegiatanOptions +=
                        `<option value="${item.id_sub_kegiatan}" ${selected}>${item.nama_sub_kegiatan}</option>`;
                });
                $('#id_sub_kegiatan').html(subKegiatanOptions).prop('disabled', false);
            });
        } else if (selectedSubKegiatan) {
            $.get(`/ssh/sub_kegiatan/${selectedSubKegiatan}/rekening`, function(data) {
                let rekeningOptions = '<option value="">-- Pilih Rekening --</option>';
                data.forEach(item => {
                    const selected = item.id_rekening == selectedRekening ? 'selected' : '';
                    rekeningOptions +=
                        `<option value="${item.id_rekening}" ${selected}>${item.nama_rekening}</option>`;
                });
                $('#id_rekening').html(rekeningOptions).prop('disabled', false);
            });
        }
    });
</script>
