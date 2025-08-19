<form action="{{ url('/pegawai/store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Tambah Data Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control" placeholder="Masukkan NIP" required>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                </div>
                {{-- <div class="form-group">
                    <label>NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control" placeholder="Masukkan NIP" required>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                    <!-- TAMBAH INI -->
                    <div id="nip-spinner" class="spinner-border spinner-border-sm text-primary" role="status" style="display: none;">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div> --}}

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gelar Depan</label>
                            <input type="text" name="gelar_depan" id="gelar_depan" class="form-control" placeholder="Dr., Prof., dll">
                            <small id="error-gelar_depan" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gelar Belakang</label>
                            <input type="text" name="gelar_belakang" id="gelar_belakang" class="form-control" placeholder="S.Pd., M.Si., dll">
                            <small id="error-gelar_belakang" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nik" id="nik" class="form-control" placeholder="Masukkan NIK" required>
                    <small id="error-nik" class="error-text form-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <span class="badge" style="background-color:#6c757d; color:#fff; font-size: 11px; padding: 2px 6px; border-radius: 4px;">Wajib diisi</span>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir" required>
                            <small id="error-tempat_lahir" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                            <small id="error-tanggal_lahir" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                    <small id="error-jenis_kelamin" class="error-text form-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No. HP</label>
                            <input type="text" name="hp" id="hp" class="form-control" placeholder="Masukkan No. HP" required>
                            <small id="error-hp" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" required>
                            <small id="error-email" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Masukkan Alamat" required></textarea>
                    <small id="error-alamat" class="error-text form-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>RT</label>
                            <input type="text" name="rt" id="rt" class="form-control" placeholder="00" maxlength="2" pattern="\d{2}" required>
                            <small id="error-rt" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>RW</label>
                            <input type="text" name="rw" id="rw" class="form-control" placeholder="00" maxlength="2" pattern="\d{2}" required>
                            <small id="error-rw" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kode Pos</label>
                            <input type="text" name="kode_pos" id="kode_pos" class="form-control" placeholder="Kode Pos" required>
                            <small id="error-kode_pos" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Provinsi</label>
                            <select name="id_provinsi" id="id_provinsi" class="form-control" required>
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach ($provinsi as $row)
                                <option value="{{ $row->id_provinsi }}">{{ $row->nama_provinsi }}</option>
                                @endforeach
                            </select>
                            <small id="error-id_provinsi" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kabupaten/Kota</label>
                            <select name="id_kabupaten_kota" id="id_kabupaten_kota" class="form-control" required>
                                <option value="">-- Pilih Kabupaten/Kota --</option>
                                @if(isset($kabupatenKota))
                                    @foreach ($kabupatenKota as $row)
                                    <option value="{{ $row->id_kabupaten_kota }}">{{ $row->nama_kabupaten_kota }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <small id="error-id_kabupaten_kota" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select name="id_kecamatan" id="id_kecamatan" class="form-control" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @if(isset($kecamatan))
                                    @foreach ($kecamatan as $row)
                                    <option value="{{ $row->id_kecamatan }}">{{ $row->nama_kecamatan }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <small id="error-id_kecamatan" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kelurahan</label>
                            <select name="id_kelurahan" id="id_kelurahan" class="form-control" required>
                                <option value="">-- Pilih Kelurahan --</option>
                                @if(isset($kelurahan))
                                    @foreach ($kelurahan as $row)
                                    <option value="{{ $row->id_kelurahan }}">{{ $row->nama_kelurahan }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <small id="error-id_kelurahan" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Agama</label>
                            <select name="agama" id="agama" class="form-control" required>
                                <option value="">-- Pilih Agama --</option>
                                <option value="islam">Islam</option>
                                <option value="kristen">Kristen</option>
                                <option value="katolik">Katolik</option>
                                <option value="hindu">Hindu</option>
                                <option value="budha">Buddha</option>
                                <option value="konghucu">Konghucu</option>
                            </select>
                            <small id="error-agama" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status Kepegawaian</label>
                            <select name="status_kepegawaian" id="status_kepegawaian" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="cpns">CPNS</option>
                                <option value="pns">PNS</option>
                                <option value="pppk">PPPK</option>
                                <option value="ptt">PTT</option>
                            </select>
                            <small id="error-status_kepegawaian" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">
                    <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                    <small id="error-foto" class="error-text form-text text-danger"></small>
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

    // let nipCheckTimeout;
    // // Variabel untuk menyimpan status validasi NIP
    // let nipValid = false;

    //     // Event handler untuk real-time check NIP
    // $('#nip').on('input', function() {
    //     var nipValue = $(this).val();
    //     var currentNip = $('input[name="current_nip"]').val(); // untuk mode edit
        
    //     // Clear timeout sebelumnya
    //     clearTimeout(nipCheckTimeout);
        
    //     // Reset state
    //     $('#error-nip').text('');
    //     $('#nip').removeClass('is-invalid is-valid');
    //     $('#nip-spinner').hide();
    //     nipValid = false;
        
    //     if (nipValue.length >= 3) { // Mulai check setelah 3 karakter
    //         $('#nip-spinner').show();
            
    //         nipCheckTimeout = setTimeout(function() {
    //             $.ajax({
    //                 url: '/pegawai/check_nip',
    //                 type: 'POST',
    //                 data: {
    //                     _token: $('meta[name="csrf-token"]').attr('content'),
    //                     nip: nipValue,
    //                     current_nip: currentNip
    //                 },
    //                 success: function(response) {
    //                     $('#nip-spinner').hide();
                        
    //                     if (response.available) {
    //                         $('#nip').addClass('is-valid').removeClass('is-invalid');
    //                         $('#error-nip').text('').removeClass('text-danger').addClass('text-success');
    //                         nipValid = true;
    //                     } else {
    //                         $('#nip').addClass('is-invalid').removeClass('is-valid');
    //                         $('#error-nip').text(response.message).removeClass('text-success').addClass('text-danger');
    //                         nipValid = false;
    //                     }
                        
    //                     // Update status submit button
    //                     updateSubmitButton();
    //                 },
    //                 error: function() {
    //                     $('#nip-spinner').hide();
    //                     $('#nip').addClass('is-invalid').removeClass('is-valid');
    //                     $('#error-nip').text('Terjadi kesalahan saat memeriksa NIP').removeClass('text-success').addClass('text-danger');
    //                     nipValid = false;
    //                     updateSubmitButton();
    //                 }
    //             });
    //         }, 500); // Delay 500ms untuk mengurangi request
    //     }
    // });
    
    // function updateSubmitButton() {
    //     const submitBtn = $('#btn-submit');
    //     if (nipValid || $('#nip').val().length < 3) {
    //         submitBtn.prop('disabled', false);
    //     } else {
    //         submitBtn.prop('disabled', true);
    //     }
    // }

    
let nipCheckTimeout;     // Variabel untuk menyimpan status validasi NIP
let nipValid = false;         // Event handler untuk real-time check NIP

$('#nip').on('input', function() {
    var nipValue = $(this).val();
    var currentNip = $('input[name="current_nip"]').val(); // untuk mode edit
    
    // Clear timeout sebelumnya
    clearTimeout(nipCheckTimeout);
    
    // Reset state
    $('#error-nip').text('');
    $('#nip').removeClass('is-invalid is-valid');
    $('#nip-spinner').hide();
    nipValid = false;
    
    if (nipValue.length >= 3) { // Mulai check setelah 3 karakter
        $('#nip-spinner').show();
        
        nipCheckTimeout = setTimeout(function() {
            $.ajax({
                url: '/pegawai/check_nip',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    nip: nipValue,
                    current_nip: currentNip
                },
                success: function(response) {
                    $('#nip-spinner').hide();
                    
                    if (response.available) {
                        // Tidak menambahkan class 'is-valid' untuk menghilangkan icon centang hijau
                        $('#nip').removeClass('is-invalid');
                        $('#error-nip').text('').removeClass('text-danger');
                        nipValid = true;
                    } else {
                        $('#nip').addClass('is-invalid').removeClass('is-valid');
                        $('#error-nip').text(response.message).removeClass('text-success').addClass('text-danger');
                        nipValid = false;
                    }
                    
                    // Update status submit button
                    updateSubmitButton();
                },
                error: function() {
                    $('#nip-spinner').hide();
                    $('#nip').addClass('is-invalid').removeClass('is-valid');
                    $('#error-nip').text('Terjadi kesalahan saat memeriksa NIP').removeClass('text-success').addClass('text-danger');
                    nipValid = false;
                    updateSubmitButton();
                }
            });
        }, 500); // Delay 500ms untuk mengurangi request
    }
});

function updateSubmitButton() {
    const submitBtn = $('#btn-submit');
    if (nipValid || $('#nip').val().length < 3) {
        submitBtn.prop('disabled', false);
    } else {
        submitBtn.prop('disabled', true);
    }
}

    $("#form-tambah").validate({
        rules: {
            nip: { required: true, minlength: 18, maxlength: 18 },
            nama: { required: true, minlength: 2 },
            nik: { required: true, minlength: 16, maxlength: 16 },
            tempat_lahir: { required: true },
            tanggal_lahir: { required: true, date: true },
            jenis_kelamin: { required: true },
            hp: {required: true, minlength:1},
            alamat: { required: true },
            rt:{required: true, minlength:2,maxlength:2},
            rw:{required: true, minlength:2,maxlength:2},
            kode_pos:{required:true,minlength:5,maxlength:5},
            id_provinsi: { required: true },
            id_kabupaten_kota: { required: true },
            id_kecamatan: { required: true },
            id_kelurahan: { required: true },
            agama: { required: true },
            status_kepegawaian: { required: true },
            email: { required: true },
            foto: { extension: "jpg|jpeg|png" }
        },
        // messages: {
        //     nip: {
        //         required: "NIP wajib diisi",
        //         minlength: "NIP harus 18 digit",
        //         maxlength: "NIP harus 18 digit"
        //     },
        //     nama: {
        //         required: "Nama wajib diisi",
        //         minlength: "Nama minimal 2 karakter"
        //     },
        //     nik: {
        //         required: "NIK wajib diisi",
        //         minlength: "NIK harus 16 digit",
        //         maxlength: "NIK harus 16 digit"
        //     },
        //     email: {
        //         email: "Format email tidak valid"
        //     },
        //     foto: {
        //         extension: "File harus berformat JPG, JPEG, atau PNG"
        //     }
        // },
        submitHandler: function(form) {
            var formData = new FormData(form);

            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.message) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        dataPegawai.ajax.reload();
                    }
                },
                error: function(xhr) {
                    const res = xhr.responseJSON;
                    $('.error-text').text('');
                    if (res && res.errors) {
                        $.each(res.errors, function(key, val) {
                            $('#error-' + key).text(val[0]);
                        });
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message || 'Terjadi kesalahan saat menyimpan data.'
                    });
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

    // Cascade dropdown untuk wilayah (opsional - jika diperlukan)
    $('#id_provinsi').change(function() {
        var provinsiId = $(this).val();
        if (provinsiId) {
            // AJAX call untuk load kabupaten/kota berdasarkan provinsi
            // Implementasi sesuai kebutuhan
        }
    });

    $('#id_kabupaten_kota').change(function() {
        var kabupatenId = $(this).val();
        if (kabupatenId) {
            // AJAX call untuk load kecamatan berdasarkan kabupaten/kota
            // Implementasi sesuai kebutuhan
        }
    });

    $('#id_kecamatan').change(function() {
        var kecamatanId = $(this).val();
        if (kecamatanId) {
            // AJAX call untuk load kelurahan berdasarkan kecamatan
            // Implementasi sesuai kebutuhan
        }
    });


    //FORMAT TULISAN ISIAN FORM
    // Function untuk mengubah ke Title Case
    function toTitleCase(str) {
        return str.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    // Auto format Tempat Lahir saat user mengetik
    $('#tempat_lahir').on('input', function() {
        var currentValue = $(this).val();
        var formattedValue = toTitleCase(currentValue);
        $(this).val(formattedValue);
    });

    // Auto format saat blur (kehilangan fokus) untuk memastikan formatting
    $('#tempat_lahir').on('blur', function() {
        var currentValue = $(this).val().trim(); // Hapus spasi di awal/akhir
        if (currentValue) {
            var formattedValue = toTitleCase(currentValue);
            $(this).val(formattedValue);
        }
    });

    // Opsional: Format juga field nama agar konsisten
    $('#nama').on('input', function() {
        var currentValue = $(this).val();
        var formattedValue = toTitleCase(currentValue);
        $(this).val(formattedValue);
    });

    $('#nama').on('blur', function() {
        var currentValue = $(this).val().trim();
        if (currentValue) {
            var formattedValue = toTitleCase(currentValue);
            $(this).val(formattedValue);
        }
    });


});

$('#id_provinsi').change(function () {
    var provId = $(this).val();
    $('#id_kabupaten_kota').html('<option value="">Loading...</option>');
    $('#id_kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
    $('#id_kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');
    if (provId) {
        $.get(`/pegawai/provinsi/${provId}/kabupaten`, function (data) {
            var options = '<option value="">-- Pilih Kabupaten/Kota --</option>';
            data.forEach(item => {
                options += `<option value="${item.id_kabupaten_kota}">${item.nama_kabupaten_kota}</option>`;
            });
            $('#id_kabupaten_kota').html(options);
        });
    }
});

$('#id_kabupaten_kota').change(function () {
    var kabId = $(this).val();
    $('#id_kecamatan').html('<option value="">Loading...</option>');
    $('#id_kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');
    if (kabId) {
        $.get(`/pegawai/kabupaten/${kabId}/kecamatan`, function (data) {
            var options = '<option value="">-- Pilih Kecamatan --</option>';
            data.forEach(item => {
                options += `<option value="${item.id_kecamatan}">${item.nama_kecamatan}</option>`;
            });
            $('#id_kecamatan').html(options);
        });
    }
});

$('#id_kecamatan').change(function () {
    var kecId = $(this).val();
    $('#id_kelurahan').html('<option value="">Loading...</option>');
    if (kecId) {
        $.get(`/pegawai/kecamatan/${kecId}/kelurahan`, function (data) {
            var options = '<option value="">-- Pilih Kelurahan --</option>';
            data.forEach(item => {
                options += `<option value="${item.id_kelurahan}">${item.nama_kelurahan}</option>`;
            });
            $('#id_kelurahan').html(options);
        });
    }
});

</script>