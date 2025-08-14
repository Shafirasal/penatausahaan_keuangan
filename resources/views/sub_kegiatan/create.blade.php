<form action="{{ url('/master_sub_kegiatan/store') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Tambah Master Sub Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Program</label>
                    <select name="id_program" id="id_program" class="form-control" required style="width: 100%;">
                        <option value="">Pilih Program</option>
                        @foreach ($program as $p)
                            <option value="{{ $p->id_program }}">{{ $p->kode_program }} - {{ $p->nama_program }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_program" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Kegiatan</label>
                    <select name="id_kegiatan" id="id_kegiatan" class="form-control" required style="width: 100%;">
                        <option value="">Pilih Kegiatan</option>
                    </select>
                    <small id="error-id_kegiatan" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label>Kode Sub Kegiatan</label>
                    <input type="text" name="kode_sub_kegiatan" id="kode_sub_kegiatan" class="form-control" required>
                    <small id="error-kode_sub_kegiatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Sub Kegiatan</label>
                    <input type="text" name="nama_sub_kegiatan" id="nama_sub_kegiatan" class="form-control" required>
                    <small id="error-nama_sub_kegiatan" class="error-text form-text text-danger"></small>
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

        $("#form-tambah").validate({
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
        $('#kode_sub_kegiatan, #nama_sub_kegiatan').on('input', function() {
            const id = $(this).attr('id');
            $('#error-' + id).text('');
        });

        // Hapus error untuk select2
        $('#id_program, #id_kegiatan').on('select2:select select2:clear', function() {
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

                $.get(`/master_sub_kegiatan/program/${programId}/kegiatan`, function(data) {
                    // Clear options dan tambah default
                    $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');
                    
                    // Tambah data kegiatan
                    data.forEach(item => {
                        let optionText = item.kode_kegiatan ? 
                            `${item.kode_kegiatan} - ${item.nama_kegiatan}` : 
                            item.nama_kegiatan;
                        $('#id_kegiatan').append(new Option(optionText, item.id_kegiatan));
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
                    $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');
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

        // IF EDIT MODE: Populate KEGIATAN & SUB KEGIATAN
        const selectedProgram = $('#id_program').val();
        const selectedKegiatan = $('#id_kegiatan').data('selected');

        if (selectedProgram) {
            $.get(`/master_sub_kegiatan/program/${selectedProgram}/kegiatan`, function(data) {
                $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');
                
                data.forEach(item => {
                    let optionText = item.kode_kegiatan ? 
                        `${item.kode_kegiatan} - ${item.nama_kegiatan}` : 
                        item.nama_kegiatan;
                    const selected = item.id_kegiatan == selectedKegiatan;
                    $('#id_kegiatan').append(new Option(optionText, item.id_kegiatan, false, selected));
                });
                
                $('#id_kegiatan').select2('destroy').select2({
                    placeholder: "-- Pilih Kegiatan --",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#myModal')
                }).prop('disabled', false);
            });
        }
    });
</script>


