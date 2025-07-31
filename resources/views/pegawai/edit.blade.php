<form action="{{ url('/pegawai/'.$pegawai->nip.'/update') }}" method="POST" id="form-edit" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Edit Data Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control" placeholder="Masukkan NIP" value="{{ $pegawai->nip }}" required>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama" value="{{ $pegawai->nama }}" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gelar Depan</label>
                            <input type="text" name="gelar_depan" id="gelar_depan" class="form-control" placeholder="Dr., Prof., dll" value="{{ $pegawai->gelar_depan }}">
                            <small id="error-gelar_depan" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gelar Belakang</label>
                            <input type="text" name="gelar_belakang" id="gelar_belakang" class="form-control" placeholder="S.Pd., M.Si., dll" value="{{ $pegawai->gelar_belakang }}">
                            <small id="error-gelar_belakang" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nik" id="nik" class="form-control" placeholder="Masukkan NIK" value="{{ $pegawai->nik }}" required>
                    <small id="error-nik" class="error-text form-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir" value="{{ $pegawai->tempat_lahir }}" required>
                            <small id="error-tempat_lahir" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ $pegawai->tanggal_lahir }}" required>
                            <small id="error-tanggal_lahir" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="laki-laki" {{ $pegawai->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ $pegawai->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <small id="error-jenis_kelamin" class="error-text form-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No. HP</label>
                            <input type="text" name="hp" id="hp" class="form-control" placeholder="Masukkan No. HP" value="{{ $pegawai->hp }}">
                            <small id="error-hp" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" value="{{ $pegawai->email }}">
                            <small id="error-email" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Masukkan Alamat" required>{{ $pegawai->alamat }}</textarea>
                    <small id="error-alamat" class="error-text form-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>RT</label>
                            <input type="text" name="rt" id="rt" class="form-control" placeholder="00" maxlength="2" pattern="\d{2}" value="{{ $pegawai->rt }}">
                            <small id="error-rt" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>RW</label>
                            <input type="text" name="rw" id="rw" class="form-control" placeholder="00" maxlength="2" pattern="\d{2}" value="{{ $pegawai->rw }}">
                            <small id="error-rw" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kode Pos</label>
                            <input type="text" name="kode_pos" id="kode_pos" class="form-control" placeholder="Kode Pos" value="{{ $pegawai->kode_pos }}">
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
                                <option value="{{ $row->id_provinsi }}" {{ $pegawai->id_provinsi == $row->id_provinsi ? 'selected' : '' }}>{{ $row->nama_provinsi }}</option>
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
                                    <option value="{{ $row->id_kabupaten_kota }}" {{ $pegawai->id_kabupaten_kota == $row->id_kabupaten_kota ? 'selected' : '' }}>{{ $row->nama_kabupaten_kota }}</option>
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
                                    <option value="{{ $row->id_kecamatan }}" {{ $pegawai->id_kecamatan == $row->id_kecamatan ? 'selected' : '' }}>{{ $row->nama_kecamatan }}</option>
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
                                    <option value="{{ $row->id_kelurahan }}" {{ $pegawai->id_kelurahan == $row->id_kelurahan ? 'selected' : '' }}>{{ $row->nama_kelurahan }}</option>
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
                                <option value="Islam" {{ $pegawai->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ $pegawai->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ $pegawai->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ $pegawai->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ $pegawai->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ $pegawai->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            <small id="error-agama" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status Kepegawaian</label>
                            <select name="status_kepegawaian" id="status_kepegawaian" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="cpns" {{ $pegawai->status_kepegawaian == 'cpns' ? 'selected' : '' }}>CPNS</option>
                                <option value="pns" {{ $pegawai->status_kepegawaian == 'pns' ? 'selected' : '' }}>PNS</option>
                                <option value="pppk" {{ $pegawai->status_kepegawaian == 'pppk' ? 'selected' : '' }}>PPPK</option>
                                <option value="ptt" {{ $pegawai->status_kepegawaian == 'ptt' ? 'selected' : '' }}>PTT</option>
                            </select>
                            <small id="error-status_kepegawaian" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Foto</label>
                    @if($pegawai->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$pegawai->foto) }}" alt="Foto Pegawai" class="img-thumbnail" style="max-width: 150px;">
                            <p class="small text-muted mt-1">Foto saat ini</p>
                        </div>
                    @endif
                    <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">
                    <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                    <small id="error-foto" class="error-text form-text text-danger"></small>
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
            nip: { required: true, minlength: 18, maxlength: 18 },
            nama: { required: true, minlength: 2 },
            nik: { required: true, minlength: 16, maxlength: 16 },
            tempat_lahir: { required: true },
            tanggal_lahir: { required: true, date: true },
            jenis_kelamin: { required: true },
            alamat: { required: true },
            id_provinsi: { required: true },
            id_kabupaten_kota: { required: true },
            id_kecamatan: { required: true },
            id_kelurahan: { required: true },
            agama: { required: true },
            status_kepegawaian: { required: true },
            email: { email: true },
            foto: { extension: "jpg|jpeg|png" },
            rt: { maxlength: 3 },
            rw: { maxlength: 3 },
            kode_pos: { maxlength: 5 },
            hp: { maxlength: 15 }
        },
        messages: {
            nip: {
                required: "NIP wajib diisi",
                minlength: "NIP harus 18 digit",
                maxlength: "NIP harus 18 digit"
            },
            nama: {
                required: "Nama wajib diisi",
                minlength: "Nama minimal 2 karakter"
            },
            nik: {
                required: "NIK wajib diisi",
                minlength: "NIK harus 16 digit",
                maxlength: "NIK harus 16 digit"
            },
            email: {
                email: "Format email tidak valid"
            },
            foto: {
                extension: "File harus berformat JPG, JPEG, atau PNG"
            }
        },
        submitHandler: function(form) {
            var formData = new FormData(form);

            $.ajax({
                url: form.action,
                type: 'POST', // Menggunakan POST dengan _method PUT
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status && response.message) {
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
                        text: res.message || 'Terjadi kesalahan saat mengupdate data.'
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

    // Cascade dropdown untuk wilayah - load data saat halaman dimuat
    var currentProvinsi = $('#id_provinsi').val();
    var currentKabupaten = $('#id_kabupaten_kota').val();
    var currentKecamatan = $('#id_kecamatan').val();
    var currentKelurahan = $('#id_kelurahan').val();

    // Load kabupaten/kota berdasarkan provinsi yang dipilih
    if (currentProvinsi) {
        loadKabupatenKota(currentProvinsi, currentKabupaten);
    }

    // Load kecamatan berdasarkan kabupaten/kota yang dipilih
    if (currentKabupaten) {
        loadKecamatan(currentKabupaten, currentKecamatan);
    }

    // Load kelurahan berdasarkan kecamatan yang dipilih
    if (currentKecamatan) {
        loadKelurahan(currentKecamatan, currentKelurahan);
    }

    // Event handlers untuk cascade dropdown
    $('#id_provinsi').change(function() {
        var provinsiId = $(this).val();
        $('#id_kabupaten_kota').html('<option value="">Loading...</option>');
        $('#id_kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
        $('#id_kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');
        
        if (provinsiId) {
            loadKabupatenKota(provinsiId);
        }
    });

    $('#id_kabupaten_kota').change(function() {
        var kabupatenId = $(this).val();
        $('#id_kecamatan').html('<option value="">Loading...</option>');
        $('#id_kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');
        
        if (kabupatenId) {
            loadKecamatan(kabupatenId);
        }
    });

    $('#id_kecamatan').change(function() {
        var kecamatanId = $(this).val();
        $('#id_kelurahan').html('<option value="">Loading...</option>');
        
        if (kecamatanId) {
            loadKelurahan(kecamatanId);
        }
    });

    // Fungsi untuk load kabupaten/kota
    function loadKabupatenKota(provinsiId, selectedKabupaten = null) {
        $.get(`/pegawai/provinsi/${provinsiId}/kabupaten`, function(data) {
            var options = '<option value="">-- Pilih Kabupaten/Kota --</option>';
            data.forEach(item => {
                var selected = selectedKabupaten == item.id_kabupaten_kota ? 'selected' : '';
                options += `<option value="${item.id_kabupaten_kota}" ${selected}>${item.nama_kabupaten_kota}</option>`;
            });
            $('#id_kabupaten_kota').html(options);
        });
    }

    // Fungsi untuk load kecamatan
    function loadKecamatan(kabupatenId, selectedKecamatan = null) {
        $.get(`/pegawai/kabupaten/${kabupatenId}/kecamatan`, function(data) {
            var options = '<option value="">-- Pilih Kecamatan --</option>';
            data.forEach(item => {
                var selected = selectedKecamatan == item.id_kecamatan ? 'selected' : '';
                options += `<option value="${item.id_kecamatan}" ${selected}>${item.nama_kecamatan}</option>`;
            });
            $('#id_kecamatan').html(options);
        });
    }

    // Fungsi untuk load kelurahan
    function loadKelurahan(kecamatanId, selectedKelurahan = null) {
        $.get(`/pegawai/kecamatan/${kecamatanId}/kelurahan`, function(data) {
            var options = '<option value="">-- Pilih Kelurahan --</option>';
            data.forEach(item => {
                var selected = selectedKelurahan == item.id_kelurahan ? 'selected' : '';
                options += `<option value="${item.id_kelurahan}" ${selected}>${item.nama_kelurahan}</option>`;
            });
            $('#id_kelurahan').html(options);
        });
    }
});
</script>