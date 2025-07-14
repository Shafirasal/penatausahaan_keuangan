<form action="{{ url('/riwayat_kepegawaian/store') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Tambah Riwayat Kepegawaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control"
                        value="{{ session('nip') }}" readonly>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Golongan</label>
                    <select name="id_golongan" id="id_golongan" class="form-control" required>
                        <option value="">-- Pilih Golongan --</option>
                        @foreach ($golongan as $row)
                        <option value="{{ $row->id_golongan }}">{{ $row->nama_golongan }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_golongan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jenis Kenaikan Pangkat</label>
                    <select name="id_jenis_kp" id="id_jenis_kp" class="form-control" required>
                        <option value="">-- Pilih Jenis KP --</option>
                        @foreach ($jenisKp as $row)
                        <option value="{{ $row->id_jenis_kp }}">{{ $row->nama_jenis }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_jenis_kp" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>TMT Pangkat</label>
                    <input type="date" name="tmt_pangkat" id="tmt_pangkat" class="form-control" required>
                    <small id="error-tmt_pangkat" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                    <small id="error-keterangan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Upload File</label>
                    <input type="file" name="file" id="file" class="form-control-file">
                    <small id="error-file" class="error-text form-text text-danger"></small>
                </div>


                <div class="form-group">
                    <label>Status</label>
                    <select name="aktif" id="aktif" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="ya">Aktif</option>
                        <option value="tidak">Tidak Aktif</option>
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
    $("#form-tambah").validate({
        rules: {
            nip: { required: true },
            id_golongan: { required: true },
            id_jenis_kp: { required: true },
            tmt_pangkat: { required: true, date: true },
            aktif: {required: true},
            file:{required: true, extension: "pdf"}
        },
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
                        dataRiwayatKepegawaian.ajax.reload();
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
});
</script>
