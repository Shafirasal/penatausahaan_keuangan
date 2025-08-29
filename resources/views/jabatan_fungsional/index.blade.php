@extends('layouts.template')

@section('title')
| Jabatan Fungsional
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
    <h1>{{ $breadcrumb->title ?? 'Jabatan Fungsional' }}</h1>
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
  </div>

  <div class="section-body">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Data Jabatan Fungsional</h4>
          <div class="card-header-action ml-auto">
            <button onclick="modalAction(`{{ url('/jabatan_fungsional/create') }}`)" class="btn btn-primary">
              <i class="fas fa-plus"></i> Tambah
            </button>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dt-responsive nowrap" id="table_jabatan_fungsional" style="width:100%">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Nama Jabatan</th>
                  <th>Instansi</th>
                  <th>tmt_jabatan</th>
                  <th>PAK</th>
                  <th>Status Fungsional</th>
                  <th>Status Diklat</th>
                  <th>Aktif</th>
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
  var dataJabatanFungsional;

  // Inisialisasi saat dokumen siap
  $(document).ready(function () {
    dataJabatanFungsional = $('#table_jabatan_fungsional').DataTable({
      processing: false,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/jabatan_fungsional/list') }}",
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
          data: 'nama_jabatan',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'instansi',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'tmt_jabatan',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'PAK',
          className: 'text-center',
          orderable: true,
          searchable: true
        },
        {
          data: 'status_fungsional',
          className: 'text-center',
          orderable: false,
          searchable: false
        },
        {
          data: 'status_diklat',
          className: 'text-center',
          orderable: false,
          searchable: false
        },
        {
          data: 'aktif',
          className: 'text-center',
          orderable: true,
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

