@extends('layouts.template')

@section('title')
| Tambah Jabatan Struktural
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Tambah Jabatan Struktural</h1>
  </div>

  <div class="section-body">
    <form action="{{ route('jabatan_struktural.store') }}" method="POST">
      @csrf
      <!-- Tambahkan input sesuai field -->
      <div class="form-group">
        <label>NIP</label>
        <input type="text" name="nip" class="form-control" required>
        <label>Nama Jabatan</label>
      </div>
      <!-- Tambahkan input lainnya -->
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</section>
@endsection
