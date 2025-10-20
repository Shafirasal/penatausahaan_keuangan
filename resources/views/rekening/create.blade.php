<form action="{{ url('/master_rekening/store') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Tambah Master Rekening</h5>
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
                    <label>Kode Rekening</label>
                    <input type="text" name="kode_rekening" id="kode_rekening" class="form-control" required>
                    <small id="error-kode_rekening" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Rekening</label>
                    <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" required>
                    <small id="error-nama_rekening" class="error-text form-text text-danger"></small>
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

    // Inisialisasi Select2 untuk Kegiatan (disabled dulu)
    $('#id_kegiatan').select2({
        placeholder: "Pilih Kegiatan",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#myModal')
    }).prop('disabled', true);

    // Inisialisasi Select2 untuk Sub Kegiatan (disabled dulu)
    $('#id_sub_kegiatan').select2({
        placeholder: "Pilih Sub Kegiatan",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#myModal')
    }).prop('disabled', true);

    // Form Validation
    $("#form-tambah").validate({
        rules: {
            id_program: { required: true },
            id_kegiatan: { required: true },
            id_sub_kegiatan: { required: true },
            kode_rekening: { required: true, maxlength: 12, minlength: 12 },
            nama_rekening: { required: true, maxlength: 200 }
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
                        dataMasterRekening.ajax.reload();
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
    $('#kode_rekening, #nama_rekening').on('input', function () {
        const id = $(this).attr('id');
        $('#error-' + id).text('');
    });

    // Hapus error untuk select2
    $('#id_program, #id_kegiatan, #id_sub_kegiatan').on('select2:select select2:clear', function () {
        const id = $(this).attr('id');
        $('#error-' + id).text('');
    });

    // FIX: Cascading Program → Kegiatan (sama seperti sub_kegiatan)
    //$('#id_program').on('select2:select select2:clear', function (e) {
    //    const programId = $(this).val();

    //    if (e.type === 'select2:select' && programId) {
            // Tampilkan Loading di Select2
    //        $('#id_kegiatan').empty().append('<option value="">Loading...</option>');
    //        $('#id_kegiatan').prop('disabled', true).trigger('change');
    //        $('#id_sub_kegiatan').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>');
    //        $('#id_sub_kegiatan').prop('disabled', true).trigger('change');

            // Update placeholder Select2 ke Loading
    //        $('#id_kegiatan').select2('destroy').select2({
    //            placeholder: "Loading...",
    //            allowClear: true,
        //        width: '100%',
        //        dropdownParent: $('#myModal')
        //    }).prop('disabled', true);

            // Reset sub kegiatan dengan placeholder normal
        //    $('#id_sub_kegiatan').select2('destroy').select2({
        //        placeholder: "Pilih Sub Kegiatan",
        //        allowClear: true,
        //        width: '100%',
        //        dropdownParent: $('#myModal')
        //    }).prop('disabled', true);

        //    $.get(`/master_rekening/program/${programId}/kegiatan`, function (data) {
                // Clear options dan tambah default
        //        $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');

                // Tambah data kegiatan
        //        data.forEach(item => {
        //            let optionText = item.kode_kegiatan ?
        //                `${item.kode_kegiatan} - ${item.nama_kegiatan}` :
        //                item.nama_kegiatan;
        //            $('#id_kegiatan').append(new Option(optionText, item.id_kegiatan));
        //        });

        //        // Reinitialize Select2 dengan placeholder normal
        //        $('#id_kegiatan').select2('destroy').select2({
        //            placeholder: "-- Pilih Kegiatan --",
        //            allowClear: true,
        //            width: '100%',
        //            dropdownParent: $('#myModal')
        //        }).prop('disabled', false);

        //    }).fail(function () {
        //        alert('Gagal memuat data kegiatan');
        //        $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');
        //        $('#id_kegiatan').select2('destroy').select2({
        //            placeholder: "-- Pilih Kegiatan --",
        //            allowClear: true,
        //            width: '100%',
        //            dropdownParent: $('#myModal')
        //        }).prop('disabled', true);
        // Fungsi umum untuk memuat data ke Select2


//        } else {
//            // Reset kegiatan dan sub kegiatan saat program di-clear
//            $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');
//            $('#id_kegiatan').select2('destroy').select2({
//                placeholder: "Pilih Kegiatan",
//                allowClear: true,
//                width: '100%',
//                dropdownParent: $('#myModal')
//            }).prop('disabled', true);

//            $('#id_sub_kegiatan').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>');
//            $('#id_sub_kegiatan').select2('destroy').select2({
//                placeholder: "Pilih Sub Kegiatan",
//                allowClear: true,
//                width: '100%',
//                dropdownParent: $('#myModal')
//            }).prop('disabled', true);
//        }
//    });


// // FIX: Cascading Program → Kegiatan (menggunakan formatted_kode)
// $('#id_program').on('select2:select select2:clear', function (e) {
//     const programId = $(this).val();

//     if (e.type === 'select2:select' && programId) {
//         // Tampilkan Loading di Select2
//         $('#id_kegiatan').empty().append('<option value="">Loading...</option>');
//         $('#id_kegiatan').prop('disabled', true).trigger('change');
//         $('#id_sub_kegiatan').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>');
//         $('#id_sub_kegiatan').prop('disabled', true).trigger('change');

//         // Update placeholder Select2 ke Loading
//         $('#id_kegiatan').select2('destroy').select2({
//             placeholder: "Loading...",
//             allowClear: true,
//             width: '100%',
//             dropdownParent: $('#myModal')
//         }).prop('disabled', true);

//         // Reset sub kegiatan dengan placeholder normal
//         $('#id_sub_kegiatan').select2('destroy').select2({
//             placeholder: "Pilih Sub Kegiatan",
//             allowClear: true,
//             width: '100%',
//             dropdownParent: $('#myModal')
//         }).prop('disabled', true);

//         $.get(`/master_rekening/program/${programId}/kegiatan`, function (data) {
//             // Clear options dan tambah default
//             $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');

//             // Tambah data kegiatan - GUNAKAN formatted_kode dari backend
//             data.forEach(item => {
//                 let optionText = item.formatted_kode ?
//                     `${item.formatted_kode} - ${item.nama_kegiatan}` :
//                     item.nama_kegiatan;
//                 $('#id_kegiatan').append(new Option(optionText, item.id_kegiatan));
//             });

//             // Reinitialize Select2 dengan placeholder normal
//             $('#id_kegiatan').select2('destroy').select2({
//                 placeholder: "-- Pilih Kegiatan --",
//                 allowClear: true,
//                 width: '100%',
//                 dropdownParent: $('#myModal')
//             }).prop('disabled', false);

//         }).fail(function () {
//             alert('Gagal memuat data kegiatan');
//             $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');
//             $('#id_kegiatan').select2('destroy').select2({
//                 placeholder: "-- Pilih Kegiatan --",
//                 allowClear: true,
//                 width: '100%',
//                 dropdownParent: $('#myModal')
//             }).prop('disabled', true);
//         });

//     } else {
//         // Reset kegiatan dan sub kegiatan saat program di-clear
//         $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');
//         $('#id_kegiatan').select2('destroy').select2({
//             placeholder: "Pilih Kegiatan",
//             allowClear: true,
//             width: '100%',
//             dropdownParent: $('#myModal')
//         }).prop('disabled', true);

//         $('#id_sub_kegiatan').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>');
//         $('#id_sub_kegiatan').select2('destroy').select2({
//             placeholder: "Pilih Sub Kegiatan",
//             allowClear: true,
//             width: '100%',
//             dropdownParent: $('#myModal')
//         }).prop('disabled', true);
//     }
// });

// FIX: Cascading Kegiatan → Sub Kegiatan (menggunakan formatted_kode)
//$('#id_kegiatan').on('select2:select select2:clear', function (e) {
//    const kegiatanId = $(this).val();

//    if (e.type === 'select2:select' && kegiatanId) {
        // Tampilkan Loading di Select2
//        $('#id_sub_kegiatan').empty().append('<option value="">Loading...</option>');
//        $('#id_sub_kegiatan').prop('disabled', true).trigger('change');

        // Update placeholder Select2 ke Loading
//        $('#id_sub_kegiatan').select2('destroy').select2({
//            placeholder: "Loading...",
//            allowClear: true,
//            width: '100%',
//            dropdownParent: $('#myModal')
//        }).prop('disabled', true);

//        $.get(`/master_rekening/kegiatan/${kegiatanId}/sub_kegiatan`, function (data) {
            // Clear options dan tambah default
//            $('#id_sub_kegiatan').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>');

            // Tambah data sub kegiatan - GUNAKAN formatted_kode dari backend
//            data.forEach(item => {
//                let optionText = item.kode_sub_kegiatan ?
//                    `${item.kode_sub_kegiatan} - ${item.nama_sub_kegiatan}` :
//                    item.nama_sub_kegiatan;
//                $('#id_sub_kegiatan').append(new Option(optionText, item.id_sub_kegiatan));
//            });

//            // Reinitialize Select2 dengan placeholder normal
//            $('#id_sub_kegiatan').select2('destroy').select2({
//                placeholder: "-- Pilih Sub Kegiatan --",
//                allowClear: true,
//                width: '100%',
//                dropdownParent: $('#myModal')
//            }).prop('disabled', false);

//        }).fail(function () {
//            alert('Gagal memuat data sub kegiatan');
//            $('#id_sub_kegiatan').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>');
//            $('#id_sub_kegiatan').select2('destroy').select2({
//                placeholder: "-- Pilih Sub Kegiatan --",
//                allowClear: true,
//                width: '100%',
//                dropdownParent: $('#myModal')
//            }).prop('disabled', true);
//        });

//    } else {
//        // Reset sub kegiatan saat kegiatan di-clear
//        $('#id_sub_kegiatan').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>');
//        $('#id_sub_kegiatan').select2('destroy').select2({
//            placeholder: "Pilih Sub Kegiatan",
//            allowClear: true,
//            width: '100%',
//            dropdownParent: $('#myModal')
//        }).prop('disabled', true);
//    }
//});

// Fungsi umum untuk memuat data ke dalam Select2
    function loadOptions(url, id, target, placeholderText = "-- Pilih Opsi --") {
        const select = $('#' + target);

        // Tampilkan loading sementara
        select.empty()
            .append('<option value="">Loading...</option>')
            .prop('disabled', true)
            .trigger('change');

        // Re-inisialisasi Select2 dengan placeholder Loading
        select.select2('destroy').select2({
            placeholder: "Loading...",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#myModal')
        });

        // Request data dari server
        $.get(`${url}/${id}`, function (data) {
            select.empty().append(`<option value="">${placeholderText}</option>`);
            data.forEach(item => {
                // Tentukan format teks (jika ada kode + nama)
                const text = item.kode_kegiatan
                    ? `${item.kode_kegiatan} - ${item.nama_kegiatan}`
                    : item.kode_sub_kegiatan
                    ? `${item.kode_sub_kegiatan} - ${item.nama_sub_kegiatan}`
                    : item.nama_kegiatan || item.nama_sub_kegiatan || item.nama;

                // Tentukan value ID (bisa id_kegiatan atau id_sub_kegiatan)
                const value = item.id_kegiatan || item.id_sub_kegiatan || item.id;
                select.append(new Option(text, value));
            });

            // Re-enable Select2 dengan placeholder normal
            select.select2('destroy').select2({
                placeholder: placeholderText,
                allowClear: true,
                width: '100%',
                dropdownParent: $('#myModal')
            }).prop('disabled', false).trigger('change');

        }).fail(() => {
            alert(`Gagal memuat data untuk ${placeholderText.toLowerCase()}`);
            select.empty().append(`<option value="">${placeholderText}</option>`);
            select.select2('destroy').select2({
                placeholder: placeholderText,
                allowClear: true,
                width: '100%',
                dropdownParent: $('#myModal')
            }).prop('disabled', true).trigger('change');
        });
    }

    // Cascading Program → Kegiatan
    $('#id_program').on('select2:select select2:clear', function (e) {
        const idProgram = $(this).val();
        const kegiatanSelect = $('#id_kegiatan');
        const subKegiatanSelect = $('#id_sub_kegiatan');

        // Reset kegiatan & sub kegiatan
        kegiatanSelect.empty()
            .append('<option value="">-- Pilih Kegiatan --</option>')
            .prop('disabled', true)
            .trigger('change');

        subKegiatanSelect.empty()
            .append('<option value="">-- Pilih Sub Kegiatan --</option>')
            .prop('disabled', true)
            .trigger('change');

        // Re-inisialisasi Select2
        kegiatanSelect.select2('destroy').select2({
            placeholder: "Pilih Kegiatan",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#myModal')
        });

        subKegiatanSelect.select2('destroy').select2({
            placeholder: "Pilih Sub Kegiatan",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#myModal')
        });

        // Jika program dipilih → muat kegiatan
        if (e.type === 'select2:select' && idProgram) {
            loadOptions('/master_rekening/program', idProgram + '/kegiatan', 'id_kegiatan', '-- Pilih Kegiatan --');
        }
    });

    // ===========================================================
    // 🔹 Cascading Kegiatan → Sub Kegiatan
    $('#id_kegiatan').on('select2:select select2:clear', function (e) {
        const idKegiatan = $(this).val();
        const subKegiatanSelect = $('#id_sub_kegiatan');

        // Reset sub kegiatan
        subKegiatanSelect.empty()
            .append('<option value="">-- Pilih Sub Kegiatan --</option>')
            .prop('disabled', true)
            .trigger('change');

        subKegiatanSelect.select2('destroy').select2({
            placeholder: "Pilih Sub Kegiatan",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#myModal')
        });

        // Jika kegiatan dipilih → muat sub kegiatan
        if (e.type === 'select2:select' && idKegiatan) {
            loadOptions('/master_rekening/kegiatan', idKegiatan + '/sub_kegiatan', 'id_sub_kegiatan', '-- Pilih Sub Kegiatan --');
        }
    });




// IF EDIT MODE: Populate KEGIATAN & SUB KEGIATAN (menggunakan formatted_kode)
const selectedProgram = $('#id_program').val();
const selectedKegiatan = $('#id_kegiatan').data('selected');
const selectedSubKegiatan = $('#id_sub_kegiatan').data('selected');

if (selectedProgram) {
    $.get(`/master_rekening/program/${selectedProgram}/kegiatan`, function (data) {
        $('#id_kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');

        data.forEach(item => {
            let optionText = item.formatted_kode ?
                `${item.formatted_kode} - ${item.nama_kegiatan}` :
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

        if (selectedKegiatan) {
            $.get(`/master_rekening/kegiatan/${selectedKegiatan}/sub_kegiatan`, function (data) {
                $('#id_sub_kegiatan').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>');

                data.forEach(item => {
                    let optionText = item.formatted_kode ?
                        `${item.formatted_kode} - ${item.nama_sub_kegiatan}` :
                        item.nama_sub_kegiatan;
                    const selected = item.id_sub_kegiatan == selectedSubKegiatan;
                    $('#id_sub_kegiatan').append(new Option(optionText, item.id_sub_kegiatan, false, selected));
                });

                $('#id_sub_kegiatan').select2('destroy').select2({
                    placeholder: "-- Pilih Sub Kegiatan --",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#myModal')
                }).prop('disabled', false);
            });
        }
    });
}
});
</script>


{{--

//rekening
<script>
$(document).ready(function () {
    // Select2 Init
    $('#id_program').select2({
        placeholder: "Pilih Program",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#myModal')
    });

    $('#id_kegiatan').select2({
        placeholder: "Pilih Kegiatan",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#myModal')
    }).prop('disabled', true);

    $('#id_sub_kegiatan').select2({
        placeholder: "Pilih Sub Kegiatan",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#myModal')
    }).prop('disabled', true);

    // Form Validation
    $("#form-tambah").validate({
        rules: {
            id_program: { required: true },
            id_kegiatan: { required: true },
            id_sub_kegiatan: { required: true },
            kode_rekening: { required: true, maxlength: 12, minlength: 12 },
            nama_rekening: { required: true, maxlength: 200 }
        },
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                        dataMasterRekening.ajax.reload();
                    }
                },
                error: function (xhr) {
                    $('.error-text').text('');
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function (field, message) {
                            $('#error-' + field).text(message[0]);
                        });
                        Swal.fire({ icon: 'error', title: 'Validasi Gagal', text: 'Silakan periksa inputan Anda.' });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Server Error', text: 'Terjadi kesalahan di server.' });
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
        highlight: function (element) { $(element).addClass('is-invalid'); },
        unhighlight: function (element) { $(element).removeClass('is-invalid'); }
    });

    // Remove error on input
    $('#kode_rekening, #nama_rekening').on('input', function () {
        $('#error-' + $(this).attr('id')).text('');
    });

    $('#id_program, #id_kegiatan, #id_sub_kegiatan').on('select2:select select2:clear', function () {
        $('#error-' + $(this).attr('id')).text('');
    });

    // Cascading Program → Kegiatan
    $('#id_program').on('select2:select select2:clear', function (e) {
        const programId = $(this).val();
        $('#id_kegiatan').empty().append('<option value="">Loading...</option>').prop('disabled', true).trigger('change');
        $('#id_sub_kegiatan').empty().append('<option value="">Pilih Sub Kegiatan</option>').prop('disabled', true).trigger('change');

        if (e.type === 'select2:select' && programId) {
            $.get(`/master_rekening/program/${programId}/kegiatan`, function (data) {
                $('#id_kegiatan').empty().append('<option value="">Pilih Kegiatan</option>');
                data.forEach(item => {
                    $('#id_kegiatan').append(new Option(item.nama_kegiatan, item.id_kegiatan));
                });
                $('#id_kegiatan').prop('disabled', false).trigger('change');
            });
        }
    });

    // Cascading Kegiatan → Sub Kegiatan
    $('#id_kegiatan').on('select2:select select2:clear', function (e) {
        const kegiatanId = $(this).val();
        $('#id_sub_kegiatan').empty().append('<option value="">Loading...</option>').prop('disabled', true).trigger('change');

        if (e.type === 'select2:select' && kegiatanId) {
            $.get(`/master_rekening/kegiatan/${kegiatanId}/sub_kegiatan`, function (data) {
                $('#id_sub_kegiatan').empty().append('<option value="">Pilih Sub Kegiatan</option>');
                data.forEach(item => {
                    $('#id_sub_kegiatan').append(new Option(item.nama_sub_kegiatan, item.id_sub_kegiatan));
                });
                $('#id_sub_kegiatan').prop('disabled', false).trigger('change');
            });
        }
    });

    // IF EDIT MODE
    const selectedProgram = $('#id_program').val();
    const selectedKegiatan = $('#id_kegiatan').data('selected');
    const selectedSubKegiatan = $('#id_sub_kegiatan').data('selected');

    if (selectedProgram) {
        $.get(`/master_rekening/program/${selectedProgram}/kegiatan`, function (data) {
            $('#id_kegiatan').empty().append('<option value="">Pilih Kegiatan</option>');
            data.forEach(item => {
                const selected = item.id_kegiatan == selectedKegiatan;
                $('#id_kegiatan').append(new Option(item.nama_kegiatan, item.id_kegiatan, false, selected));
            });
            $('#id_kegiatan').prop('disabled', false).trigger('change');

            if (selectedKegiatan) {
                $.get(`/master_rekening/kegiatan/${selectedKegiatan}/sub_kegiatan`, function (data) {
                    $('#id_sub_kegiatan').empty().append('<option value="">Pilih Sub Kegiatan</option>');
                    data.forEach(item => {
                        const selected = item.id_sub_kegiatan == selectedSubKegiatan;
                        $('#id_sub_kegiatan').append(new Option(item.nama_sub_kegiatan, item.id_sub_kegiatan, false, selected));
                    });
                    $('#id_sub_kegiatan').prop('disabled', false).trigger('change');
                });
            }
        });
    }
});
</script> --}}