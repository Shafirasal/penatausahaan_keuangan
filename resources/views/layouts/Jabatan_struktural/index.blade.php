@extends('layouts.template')

@section('title')
| Jabatan Struktural
@endsection

@push('css')
{{-- Kalau butuh CSS tambahan untuk DataTables, bisa taruh di sini --}}
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Data Jabatan Struktural</h1>
    {{-- Kalau mau pakai breadcrumb, aktifkan ini --}}
    {{-- @include('layouts.breadcrumb', ['list' => $breadcrumb->list]) --}}
    <div class="section-header-button ml-auto">
      <a href="{{ route('jabatan_struktural.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Jabatan
      </a>
    </div>
  </div>

  <div class="section-body">
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    <div class="card">
      <div class="card-header">
        <h4>Daftar Jabatan Struktural</h4>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dt-responsive nowrap" id="table_jabatan" style="width: 100%">
            <thead class="thead-light">
              <tr>
                <th>#</th>
                <th>NIP</th>
                <th>Nama Jabatan</th>
                <th>Jenis Pelantikan</th>
                <th>Unit Kerja</th>
                <th>TMT Jabatan</th>
                <th>Status Jabatan</th>
                <th>Aktif</th>
                <th>Pegawai</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              {{-- Data dimuat via DataTables --}}
            </tbody>
          </table>
        </div>
      </div>

      <div class="card-footer text-right">
        {{-- Pagination DataTables --}}
      </div>
    </div>
  </div>
</section>

{{-- Modal (opsional kalau mau pakai modal form) --}}
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('js')
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function () {
    loadJabatanTable();
  });

  function loadJabatanTable() {
    if ($.fn.DataTable.isDataTable('#table_jabatan')) {
      $('#table_jabatan').DataTable().destroy();
    }

    $('#table_jabatan').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ route('jabatan_struktural.data') }}",
        type: "GET"
      },
      columns: [
        { data: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'nip' },
        { data: 'nama_jabatan' },
        { data: 'jenis_pelantikan' },
        { data: 'id_unit_kerja' },
        { data: 'tmt_jabatan' },
        { data: 'status_jabatan' },
        { data: 'aktif' },
        { data: 'pegawai_nama' },
        { data: 'action', orderable: false, searchable: false }
      ]
    });
  }

  function modalAction(url = '') {
    $('#myModal').load(url, function () {
      $('#myModal').modal('show');
    });
  }
</script>
@endpush
