@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Data Pegawai</h1>
        
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Pegawai</a></div>
            <div class="breadcrumb-item active">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <form action="{{ route('pegawai.update', $pegawai->nip) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body row">
                    <div class="form-group col-md-6">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip', $pegawai->nip) }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $pegawai->nama) }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="Laki-laki" {{ $pegawai->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $pegawai->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $pegawai->email) }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nomor HP</label>
                        <input type="text" name="hp" class="form-control" value="{{ old('hp', $pegawai->hp) }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Status Kepegawaian</label>
                        <select name="status_kepegawaian" class="form-control">
                            <option value="PNS" {{ $pegawai->status_kepegawaian == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="Non-PNS" {{ $pegawai->status_kepegawaian == 'Non-PNS' ? 'selected' : '' }}>Non-PNS</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Foto (Opsional)</label><br>
                        @if ($pegawai->foto)
                            <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto Pegawai" width="150" class="mb-2 rounded">
                        @endif
                        <input type="file" name="foto" class="form-control-file">
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
