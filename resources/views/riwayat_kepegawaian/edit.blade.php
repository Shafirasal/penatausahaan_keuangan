@empty($kepegawaian)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-danger">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Data Tidak Ditemukan</h5>
                Data Riwayat Kepegawaian tidak tersedia.
            </div>
        </div>
    </div>
</div>
@else
<form action="{{ url('/riwayat_kepegawaian/' . $kepegawaian->id_riwayat_kepegawaian . '/update') }}" method="POST" id="form-edit" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Edit Riwayat Kepegawaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" value="{{ $kepegawaian->nip }}" readonly>
                </div>

                <div class="form-group">
                    <label>Golongan</label>
                    <select name="id_golongan" class="form-control" required>
                        <option value="">-- Pilih Golongan --</option>
                        @foreach ($golongan as $row)
                            <option value="{{ $row->id_golongan }}" {{ $row->id_golongan == $kepegawaian->id_golongan ? 'selected' : '' }}>
                                {{ $row->nama_golongan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Jenis KP</label>
                    <select name="id_jenis_kp" class="form-control" required>
                        <option value="">-- Pilih Jenis KP --</option>
                        @foreach ($jenisKp as $row)
                            <option value="{{ $row->id_jenis_kp }}" {{ $row->id_jenis_kp == $kepegawaian->id_jenis_kp ? 'selected' : '' }}>
                                {{ $row->nama_jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>TMT Pangkat</label>
                    <input type="date" name="tmt_pangkat" class="form-control" value="{{ $kepegawaian->tmt_pangkat }}" required>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ $kepegawaian->keterangan }}</textarea>
                </div>

                <div class="form-group">
                    <label>Status Aktif</label>
                    <select name="aktif" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="ya" {{ $kepegawaian->aktif == 'ya' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak" {{ $kepegawaian->aktif == 'tidak' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    <small id="error-aktif" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>File (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="file" class="form-control">
                    @if ($kepegawaian->file)
                        <small><a href="{{ asset('storage/'.$kepegawaian->file) }}" target="_blank">Lihat File Lama</a></small>
                    @endif
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $('#form-edit').validate({
            rules: {
                id_golongan: { required: true },
                id_jenis_kp: { required: true },
                tmt_pangkat: { required: true, date: true },
                aktif: { required: true },
                file: { extension: "pdf|jpg|jpeg|png", filesize: 2 * 1024 * 1024 }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        if (typeof dataRiwayatKepegawaian !== 'undefined') {
                            dataRiwayatKepegawaian.ajax.reload();
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menyimpan data.'
                        });
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

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param);
        }, 'Ukuran file terlalu besar');
    });
</script>
@endempty