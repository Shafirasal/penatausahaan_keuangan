{{-- @empty($riwayat)
    <div id="modal-riwayat-pendidikan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/riwayat_pendidikan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
<form action="{{ url('/riwayat_pendidikan/' . $riwayat->id_pendidikan . '/update') }}" method="POST" id="form-edit-riwayat-pendidikan">
    @csrf
    @method('PUT')
    <div id="modal-riwayat-pendidikan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Riwayat Pendidikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Sekolah</label>
                    <input value="{{ $riwayat->nama_sekolah }}" type="text" name="nama_sekolah" class="form-control" required>
                    <small id="error-nama_sekolah" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tingkat</label>
                    <input value="{{ $riwayat->tingkat }}" type="text" name="tingkat" class="form-control" required>
                    <small id="error-tingkat" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Prodi / Jurusan</label>
                    <input value="{{ $riwayat->prodi_jurusan }}" type="text" name="prodi_jurusan" class="form-control">
                    <small id="error-prodi_jurusan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tahun Lulus</label>
                    <input value="{{ $riwayat->tahun_lulus }}" type="number" name="tahun_lulus" class="form-control" required>
                    <small id="error-tahun_lulus" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Aktif</label>
                    <select name="aktif" class="form-control" required>
                        <option value="ya" {{ $riwayat->aktif == 'ya' ? 'selected' : '' }}>Ya</option>
                        <option value="tidak" {{ $riwayat->aktif == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <small id="error-aktif" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-outline-warning">Batal</button>
                <button type="submit" class="btn btn-warning text-white">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-edit-riwayat-pendidikan").validate({
            rules: {
                nama_sekolah: { required: true, minlength: 3 },
                tingkat: { required: true },
                tahun_lulus: { required: true, digits: true, minlength: 4, maxlength: 4 },
                aktif: { required: true }
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
                            dataRiwayatPendidikan.ajax.reload(); // ganti dengan nama datatable kamu
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
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
    });
</script>
@endempty --}}


{{-- 
@empty($riwayat)
    <div id="modal-riwayat-pendidikan" class="modal-dialog modal-lg" role="document">
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
                    Data yang Anda cari tidak ditemukan
                </div>
                <a href="{{ url('/riwayat_pendidikan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
<form action="{{ url('/riwayat_pendidikan/' . $riwayat->id_pendidikan . '/update') }}" method="POST" id="form-edit-riwayat-pendidikan">
    @csrf
    @method('PUT')
    <div id="modal-riwayat-pendidikan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Riwayat Pendidikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>NIP</label>
                    <input value="{{ $riwayat->nip }}" type="text" name="nip" id="nip" class="form-control" required>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Sekolah</label>
                    <input value="{{ $riwayat->nama_sekolah }}" type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" required>
                    <small id="error-nama_sekolah" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jenjang</label>
                    <select name="tingkat" id="tingkat" class="form-control" required>
                        <option value="">-- Pilih Jenjang --</option>
                        @foreach(['SD','SMP','SMA','D1','D2','D3','D4','S1','S2','S3'] as $jenjang)
                            <option value="{{ $jenjang }}" {{ $riwayat->tingkat == $jenjang ? 'selected' : '' }}>{{ $jenjang }}</option>
                        @endforeach
                    </select>
                    <small id="error-tingkat" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Prodi/Jurusan</label>
                    <input value="{{ $riwayat->prodi_jurusan }}" type="text" name="prodi_jurusan" id="prodi_jurusan" class="form-control" required>
                    <small id="error-prodi_jurusan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tahun Lulus</label>
                    <input value="{{ $riwayat->tahun_lulus }}" type="date" name="tahun_lulus" id="tahun_lulus" class="form-control" required>
                    <small id="error-tahun_lulus" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="aktif" id="aktif" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="1" {{ $riwayat->aktif == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $riwayat->aktif == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    <small id="error-aktif" class="error-text form-text text-danger"></small>
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
        $("#form-edit-riwayat-pendidikan").validate({
            rules: {
                nip: { required: true },
                nama_sekolah: { required: true },
                tingkat: { required: true },
                prodi_jurusan: { required: true },
                tahun_lulus: { required: true, date: true },
                aktif: { required: true }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#modal-riwayat-pendidikan').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataRiwayatPendidikan.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
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
    });
</script>
@endempty --}}


@empty($riwayat)
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
                    Data yang Anda cari tidak ditemukan
                </div>
                <a href="{{ url('/riwayat_pendidikan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
<form action="{{ url('/riwayat_pendidikan/' . $riwayat->id_pendidikan . '/update') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Riwayat Pendidikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">



                <div class="form-group">
                    <label>Nama Sekolah</label>
                    <input value="{{ $riwayat->nama_sekolah }}" type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" required>
                    <small id="error-nama_sekolah" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jenjang</label>
                    <select name="tingkat" id="tingkat" class="form-control" required>
                        <option value="">-- Pilih Jenjang --</option>
                        @foreach(['SD','SMP','SMA','D1','D2','D3','D4','S1','S2','S3'] as $jenjang)
                            <option value="{{ $jenjang }}" {{ strtoupper($riwayat->tingkat) == $jenjang ? 'selected' : '' }}>{{ $jenjang }}</option>
                        @endforeach
                    </select>
                    <small id="error-tingkat" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Prodi/Jurusan</label>
                    <input value="{{ $riwayat->prodi_jurusan }}" type="text" name="prodi_jurusan" id="prodi_jurusan" class="form-control">
                    <small id="error-prodi_jurusan" class="error-text form-text text-danger"></small>
                </div>

                {{-- <div class="form-group">
                    <label>Tahun Lulus</label>
                        <input type="text" name="tahun_lulus" id="tahun_lulus" class="form-control datepicker-year" value="{{ \Carbon\Carbon::parse($riwayat->tahun_lulus)->format('Y') }}">
                    <small id="error-tahun_lulus" class="error-text form-text text-danger"></small>
                </div> --}}

                <div class="form-group">
                    <label>Tahun Lulus</label>
                    <input type="date" name="tahun_lulus" id="tahun_lulus" class="form-control" value="{{ $riwayat->tahun_lulus }}" required>
                    <small id="error-tahun_lulus" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="aktif" id="aktif" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                                <option value="ya" {{ $riwayat->aktif == 'ya' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak" {{ $riwayat->aktif == 'tidak' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    <small id="error-aktif" class="error-text form-text text-danger"></small>
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
        $("#form-edit").validate({
            rules: {
                nip: { required: true },
                nama_sekolah: { required: true },
                tingkat: { required: true },
                prodi_jurusan: { required: false },
                tahun_lulus: { required: true, date: true },
                aktif: { required: true }
            },
            submitHandler: function(form) {
                // Check if prodi_jurusan is empty and set it to "-"
                if ($('#prodi_jurusan').val() === "") {
                    $('#prodi_jurusan').val('-');
                }
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
                            dataRiwayatPendidikan.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
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
    });

    //     $(document).ready(function () {
        
    //     $('#tahun_lulus').datepicker({
    //         format: "yyyy",
    //         viewMode: "years",
    //         minViewMode: "years",
    //         autoclose: true
    //     });
    // });
</script>
@endempty




{{-- @empty($riwayat)
    <div id="modal-riwayat-pendidikan" class="modal-dialog modal-lg" role="document">
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
                    Data yang Anda cari tidak ditemukan
                </div>
                <a href="{{ url('/riwayat_pendidikan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
<form action="{{ url('/riwayat_pendidikan/' . $riwayat->id_pendidikan . '/update') }}" method="POST" id="form-edit-riwayat-pendidikan">
    @csrf
    @method('PUT')
    <div id="modal-riwayat-pendidikan" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Riwayat Pendidikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Nama Sekolah</label>
                    <input value="{{ $riwayat->nama_sekolah }}" type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" required>
                    <small id="error-nama_sekolah" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jenjang</label>
                    <select name="tingkat" id="tingkat" class="form-control" required>
                        <option value="">-- Pilih Jenjang --</option>
                        @foreach(['SD','SMP','SMA','D1','D2','D3','D4','S1','S2','S3'] as $jenjang)
                            <option value="{{ $jenjang }}" {{ strtoupper($riwayat->tingkat) == $jenjang ? 'selected' : '' }}>{{ $jenjang }}</option>
                        @endforeach
                    </select>
                    <small id="error-tingkat" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Prodi/Jurusan</label>
                    <input value="{{ $riwayat->prodi_jurusan }}" type="text" name="prodi_jurusan" id="prodi_jurusan" class="form-control">
                    <small id="error-prodi_jurusan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tahun Lulus</label>
                    <input type="text" name="tahun_lulus" id="tahun_lulus" class="form-control datepicker-year" value="{{ \Carbon\Carbon::parse($riwayat->tahun_lulus)->format('Y') }}">
                    <small id="error-tahun_lulus" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="aktif" id="aktif" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="ya" {{ $riwayat->aktif == 'ya' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak" {{ $riwayat->aktif == 'tidak' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    <small id="error-aktif" class="error-text form-text text-danger"></small>
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
        $("#form-edit-riwayat-pendidikan").validate({
            rules: {
                nama_sekolah: { required: true },
                tingkat: { required: true },
                prodi_jurusan: { required: true },
                tahun_lulus: { required: true },
                aktif: { required: true }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            // SUCCESS: Data updated successfully
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataRiwayatPendidikan.ajax.reload();
                        } else {
                            // FAILED: Handle different types of errors
                            $('.error-text').text(''); // Clear previous errors
                            
                            if (response.type === 'no_changes') {
                                // Handle "no changes" specifically
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Informasi',
                                    text: response.message
                                });
                            } else if (response.type === 'not_found') {
                                // Handle "data not found"
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data Tidak Ditemukan',
                                    text: response.message
                                }).then(() => {
                                    $('#myModal').modal('hide');
                                    dataRiwayatPendidikan.ajax.reload();
                                });
                            } else if (response.msgField) {
                                // Handle validation errors
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            } else {
                                // Handle other errors
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Terjadi kesalahan dalam koneksi. Silakan coba lagi.'
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

        $('#tahun_lulus').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });
    });
</script>
@endempty --}}