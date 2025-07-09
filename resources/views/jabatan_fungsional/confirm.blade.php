@empty($jabatan_fungsional)
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
                    Data jabatan fungsional tidak ditemukan.
                </div>
                <a href="{{ url('/jabatan_fungsional') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/jabatan_fungsional/' . $jabatan_fungsional->id_jabatan_fungsional . '/delete') }}" method="POST" id="form-delete-jabatan-fungsional">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Jabatan Fungsional</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus data jabatan fungsional berikut?
                    </div>

                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-4">Nama Jabatan:</th>
                            <td class="col-8">{{ $jabatan_fungsional->nama_jabatan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Instansi:</th>
                            <td>{{ $jabatan_fungsional->instansi }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">TMT Jabatan:</th>
                            <td>{{ $jabatan_fungsional->tmt_jabatan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">PAK:</th>
                            <td>{{ $jabatan_fungsional->PAK }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Status Fungsional:</th>
                            <td>{{ $jabatan_fungsional->status_fungsional }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Status Diklat:</th>
                            <td>{{ $jabatan_fungsional->status_diklat }}</td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal" style="color: #EF5428; background-color: white; border-color: #EF5428;">Batal</button>
                    <button type="submit" class="btn" style="color: white; background-color: #EF5428; border-color: #EF5428;">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-delete-jabatan-fungsional").validate({
                rules: {},
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
                                dataJabatanFungsional.ajax.reload(); // Pastikan ini sesuai dengan variabel DataTables kamu
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: 'Terjadi kesalahan di server. Silakan coba lagi.'
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
@endempty
