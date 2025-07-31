@empty($pegawai)
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
                    Data pegawai tidak ditemukan.
                </div>
                <a href="{{ url('/pegawai') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/pegawai/' . $pegawai->nip . '/delete') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Hapus Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus data pegawai berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-4">NIP:</th>
                            <td class="col-9">{{ $pegawai->nip }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Nama:</th>
                            <td class="col-9">
                                @if($pegawai->gelar_depan)
                                    {{ $pegawai->gelar_depan }} 
                                @endif
                                {{ $pegawai->nama }}
                                @if($pegawai->gelar_belakang)
                                    , {{ $pegawai->gelar_belakang }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">NIK:</th>
                            <td class="col-9">{{ $pegawai->nik }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Tempat, Tanggal Lahir:</th>
                            <td class="col-9">{{ $pegawai->tempat_lahir }}, {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Jenis Kelamin:</th>
                            <td class="col-9">{{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Email:</th>
                            <td class="col-9">{{ $pegawai->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">No. HP:</th>
                            <td class="col-9">{{ $pegawai->hp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Status Kepegawaian:</th>
                            <td class="col-9">{{ $pegawai->status_kepegawaian }}</td>
                        </tr>
                        @if($pegawai->foto)
                        <tr>
                            <th class="text-right col-4">Foto:</th>
                            <td class="col-9">
                                <div class="avatar avatar-lg">
                                    <img alt="Foto Pegawai" src="/storage/{{ $pegawai->foto }}" class="rounded-circle" 
                                         style="width: 60px; height: 60px; object-fit: cover;"
                                         onerror="this.src='/img/avatar/avatar-1.png';">
                                </div>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th class="text-right col-4">Tanggal Dibuat:</th>
                            <td class="col-9">{{ $pegawai->created_at }}</td>
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
        $(document).ready(function() {
            $("#form-delete").validate({
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
                                dataPegawai.ajax.reload(); // reload instance DataTables pegawai
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
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
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty