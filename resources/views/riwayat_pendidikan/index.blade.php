{{-- @extends('layouts.template')

@section('title')
    | Riwayat Pendidikan
@endsection

@section('content')

@endsection --}}
{{--
@extends('layouts.template')

@section('title')
    | Riwayat Pendidikan
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $page->title ?? 'Riwayat Pendidikan' }}</h1>
            <div class="section-header-button ml-auto">
                <button onclick="modalAction({{ url('/riwayat-pendidikan/create') }})" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah
                </button>
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
                    <h4>Data Riwayat Pendidikan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table_pendidikan">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Sekolah</th>
                                    <th>Jenjang</th>
                                    <th>Prodi/Jurusan</th>
                                    <th>Tahun Lulus</th>
                                    <th>Aktif</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function () {
            $('#table_pendidikan').DataTable({
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ url('riwayat-pendidikan/list') }}",
                    type: "POST",
                    dataType: "json",
                },
                columns: [
                    { data: "DT_RowIndex", orderable: false, searchable: false },
                    { data: "nama_sekolah" },
                    { data: "jenjang" },
                    { data: "prodi_jurusan" },
                    { data: "tahun_lulus" },
                    { data: "aktif" },
                    { data: "aksi", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush --}}

{{--

@extends('layouts.template')

@section('title')
| Riwayat Pendidikan
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{ $breadcrumb->title ?? 'Riwayat Pendidikan' }}</h1>
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Data Riwayat Pendidikan</h4>
        <div class="card-header-action ml-auto">
          <button onclick="modalAction({{ url('/riwayat_pendidikan/create') }})" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped table-md" id="table_pendidikan" style="width: 100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Sekolah</th>
                <th>Tingkat</th>
                <th>Prodi/Jurusan</th>
                <th>Tahun Lulus</th>
                <th>Aktif</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('js')
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function loadRiwayatPendidikanTable() {
    if ($.fn.DataTable.isDataTable('#table_pendidikan')) {
      $('#table_pendidikan').DataTable().destroy();
    }

    $('#table_pendidikan').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/riwayat_pendidikan/list') }}",
        type: "POST"
      },
      columns: [
        { data: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'nama_sekolah' },
        { data: 'tingkat' },
        { data: 'prodi_jurusan' },
        { data: 'tahun_lulus' },
        { data: 'aktif' },
        { data: 'aksi', orderable: false, searchable: false }
      ]
    });
  }

  $(document).ready(function () {
    loadRiwayatPendidikanTable();
  });

  function modalAction(url = '') {
    $('#myModal').load(url, function () {
      $('#myModal').modal('show');
    });
  }
</script>
@endpush --}}

{{--
@extends('layouts.template')

@section('title')
| Riwayat Pendidikan
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{ $breadcrumb->title ?? 'Riwayat Pendidikan' }}</h1>
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Data Riwayat Pendidikan</h4>
        <div class="card-header-action ml-auto">
          <button onclick="modalAction({{ url('/riwayat_pendidikan/create') }})" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped table-md mb-0" id="table_pendidikan" style="width: 100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Sekolah</th>
                <th>Tingkat</th>
                <th>Prodi/Jurusan</th>
                <th>Tahun Lulus</th>
                <th>Aktif</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <div class="card-footer text-right">
        <nav class="d-inline-block">
          <ul class="pagination mb-0">

          </ul>
        </nav>
      </div>
    </div>
  </div>
</section>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('js')
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function loadRiwayatPendidikanTable() {
    if ($.fn.DataTable.isDataTable('#table_pendidikan')) {
      $('#table_pendidikan').DataTable().clear().destroy();
    }

    $('#table_pendidikan').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/riwayat_pendidikan/list') }}",
        type: "POST"
      },
      columns: [
        { data: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'nama_sekolah' },
        { data: 'tingkat' },
        { data: 'prodi_jurusan' },
        { data: 'tahun_lulus' },
        { data: 'aktif' },
        { data: 'aksi', orderable: false, searchable: false }
      ],
      drawCallback: function () {
        feather.replace();
      }
    });
  }

  $(document).ready(function () {
    loadRiwayatPendidikanTable();
  });

  function modalAction(url = '') {
    $('#myModal').load(url, function () {
      $('#myModal').modal('show');
    });
  }
</script>
@endpush --}}





@extends('layouts.template')

@section('title')
| Riwayat Pendidikan
@endsection

@push('css')
<!-- DataTables Bootstrap 4 CSS -->
{{--
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
--}}
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{ $breadcrumb->title ?? 'Riwayat Pendidikan' }}</h1>
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
  </div>

  <div class="section-body">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Data Riwayat Pendidikan</h4>
          <div class="card-header-action ml-auto">
            <button onclick="modalAction('{{ url('/riwayat_pendidikan/create') }}')" class="btn btn-primary">
              <i class="fas fa-plus"></i> Tambah
            </button>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dt-responsive nowrap" id="table_pendidikan" style="width:100%">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Nama Sekolah</th>
                  <th>Tingkat</th>
                  <th>Prodi/Jurusan</th>
                  <th>Tahun Lulus</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                {{-- Data dimuat dinamis via DataTables --}}
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer text-right">
          {{-- Pagination otomatis oleh DataTables --}}
        </div>
      </div>
    </div>
  </div>
</section>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection
@push('js')
<script>
  // Konfigurasi CSRF token untuk Ajax
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Fungsi untuk menampilkan modal dinamis
  function modalAction(url = '') {
    $('#myModal').load(url, function () {
      $('#myModal').modal('show');
    });
  }

  // Deklarasi variabel global datatable
  var dataRiwayatPendidikan;

  // Inisialisasi saat dokumen siap
  $(document).ready(function () {
    dataRiwayatPendidikan = $('#table_pendidikan').DataTable({
      processing: false,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/riwayat_pendidikan/list') }}",
        type: "POST"
      },
      columns: [
        {
          data: 'DT_RowIndex',
          className: 'text-center',
          orderable: false,
          searchable: false
        },
        {
          data: 'nama_sekolah',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'tingkat',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'prodi_jurusan',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'tahun_lulus',
          className: 'text-center',
          orderable: true,
          searchable: true
        },
        {
          data: 'aktif',
          className: 'text-center',
          orderable: false,
          searchable: false
        },
        {
          data: 'aksi',
          className: 'text-center',
          orderable: false,
          searchable: false
        }
      ]
    });
  });
</script>
@endpush
