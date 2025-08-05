@empty($ssh)
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
                    Data sub kegiatan tidak ditemukan.
                </div>
                <a href="{{ url('/ssh') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/ssh/' . $ssh->id_ssh . '/delete') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Hapus SSH</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus data SSH berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-4">Program:</th>
                            <td class="col-8">{{ $ssh->program ? $ssh->program->nama_program : '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Kegiatan:</th>
                            <td class="col-8">{{ $ssh->kegiatan ? $ssh->kegiatan->nama_kegiatan : '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Sub Kegiatan:</th>
                            <td class="col-8">{{ $ssh->sub_kegiatan ? $ssh->sub_kegiatan->nama_sub_kegiatan : '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Rekening:</th>
                            <td class="col-8">{{ $ssh->rekening ? $ssh->rekening->nama_rekening : '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Kode SSH:</th>
                            <td class="col-8">{{ $ssh->kode_ssh }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Nama SSH:</th>
                            <td class="col-8">{{ $ssh->nama_ssh }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Pagu:</th>
                            <td class="col-8">{{ number_format($ssh->pagu, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Periode:</th>
                            <td class="col-8">{{ $ssh->periode }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Tahun:</th>
                            <td class="col-8">{{ $ssh->tahun }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#form-delete").validate({
                rules: {},
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
                                dataSSH.ajax.reload(); // pastikan ini instance datatable-nya
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function () {
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
@endempty
