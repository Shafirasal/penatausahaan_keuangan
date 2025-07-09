
<div class="row justify-content-center mt-5">
    <div class="col-12">
        <div class="card mx-auto" style="max-width: 600px;">
            <form id="form-tambah-jabatan-struktural" method="POST" action="{{ route('jabatan_struktural.store') }}">
                @csrf
                <div class="card-header">
                    <h4>Tambah Jabatan Struktural</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" id="nip" class="form-control" required>
                        <small id="error-nip" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Nama Jabatan</label>
                        <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control" required>
                        <small id="error-nama_jabatan" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Jenis Pelantikan</label>
                        <input type="text" name="jenis_pelantikan" id="jenis_pelantikan" class="form-control" required>
                        <small id="error-jenis_pelantikan" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Unit Kerja</label>
                        <select name="id_unit_kerja" id="id_unit_kerja" class="form-control" required>
                            <option value="">-- Pilih Unit Kerja --</option>
                            @foreach($unitKerja as $unit)
                                <option value="{{ $unit->id_unit_kerja }}">{{ $unit->nama_unit_kerja }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_unit_kerja" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>TMT Jabatan</label>
                        <input type="date" name="tmt_jabatan" id="tmt_jabatan" class="form-control" required>
                        <small id="error-tmt_jabatan" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                      <label>Status Jabatan</label>
                      <select name="status_jabatan" id="status_jabatan" class="form-control" required>
                        <option value="">-- Pilih Status Jabatan --</option>
                        <option value="mutasi">Mutasi</option>
                        <option value="promosi">Promosi</option>
                      </select>
                      <small id="error-status_jabatan" class="error-text form-text text-danger"></small>
                    </div>


                    <div class="form-group">
                        <label>Status Aktif</label>
                        <select name="aktif" id="aktif" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                        <small id="error-aktif" class="text-danger"></small>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-light text-danger border-danger">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
$(document).ready(function () {
    $("#form-tambah-jabatan-struktural").validate({
        rules: {
            nip: { required: true },
            nama_jabatan: { required: true },
            jenis_pelantikan: { required: true },
            id_unit_kerja: { required: true, number: true },
            tmt_jabatan: { required: true, date: true },
            status_jabatan: { required: true },
            aktif: { required: true }
        },
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    }).then(() => {
                        window.location.href = "{{ route('jabatan_struktural.index') }}";
                    });
                },
                error: function (xhr) {
                    $('.text-danger').text(''); // Clear semua error dulu
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, val) {
                            $('#error-' + key).text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan server!'
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
});
</script>
@endpush
