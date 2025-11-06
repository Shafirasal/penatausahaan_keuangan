@extends('layouts.template')

@section('title') | Profile @endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Profil Saya</h1>
    </div>

    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form id="form-update-profile" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>Update Profil</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-group text-center">
                                <img src="{{ Auth::user()->pegawai && Auth::user()->pegawai->foto
                                    ? asset('storage/' . Auth::user()->pegawai->foto)
                                    : asset('storage/foto_profile/default_pp.jpg') }}"
                                    alt="Foto Profil" class="img-thumbnail rounded-circle mb-2" width="150">

                                <div class="custom-file d-block mx-auto mt-2" style="max-width: 300px;">
                                    <input type="file" name="foto" class="custom-file-input" id="foto">
                                    <label class="custom-file-label text-left" for="foto">Pilih Foto</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" value="{{ Auth::user()->pegawai->nama }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="hp">No Telepon</label>
                                <input type="text" name="hp" value="{{ Auth::user()->pegawai->hp }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->pegawai->email }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <button type="button" class="btn btn-warning" onclick="modalAction('{{ url('/profile/change-password') }}')">
                                <i class="fas fa-key"></i> Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('js')
<script>
    // Update label untuk file input
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.querySelector('.custom-file-input');
        if (input) {
            input.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name;
                const label = e.target.nextElementSibling;
                if (label && fileName) {
                    label.innerText = fileName;
                }
            });
        }
    });

    // Handle submit profil dengan AJAX
    $('#form-update-profile').on('submit', function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: this.action,
            method: this.method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message || 'Profil berhasil diperbarui'
                });
            },
            error: function(xhr){
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                });
            }
        });
    });

    // Fungsi untuk load modal
    function modalAction(url) {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }
    function reloadProfilePhoto(newUrl) {
    const img = document.querySelector('img[alt="Foto Profil"]');
    if (img) {
        img.src = newUrl + '?t=' + new Date().getTime(); // untuk hindari cache
    }
}

</script>
@endpush
