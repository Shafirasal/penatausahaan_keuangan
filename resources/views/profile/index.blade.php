@extends('layouts.template')

@section('title')
    | Profile
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Profil Saya</h1>
    </div>

    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-header">
                            <h4>Update Profil</h4>
                        </div>

                        <div class="card-body">
                            {{-- Foto Profil --}}
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

                            {{-- Nama --}}
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" value="{{ old('nama', Auth::user()->pegawai->nama) }}"
                                    class="form-control" required>
                            </div>

                            {{-- No HP --}}
                            <div class="form-group">
                                <label for="hp">No Telepon</label>
                                <input type="text" name="hp" value="{{ old('hp', Auth::user()->pegawai->hp) }}"
                                    class="form-control">
                            </div>

                            {{-- Email --}}
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email"
                                    value="{{ old('email', Auth::user()->pegawai->email) }}" class="form-control"
                                    required>
                            </div>

                            {{-- Password Baru --}}
                            <div class="form-group">
                                <label for="password">Password Baru <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    // Update label input file setelah pilih file
    document.addEventListener("DOMContentLoaded", function () {
        const input = document.querySelector('.custom-file-input');
        if (input) {
            input.addEventListener('change', function (e) {
                const fileName = e.target.files[0]?.name;
                const label = e.target.nextElementSibling;
                if (label && fileName) {
                    label.innerText = fileName;
                }
            });
        }
    });
</script>
@endpush
