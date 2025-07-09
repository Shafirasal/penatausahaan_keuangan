@extends('layouts.template')

@section('title')
| Jabatan Struktural
@endsection

@push('css')
{{-- 
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css"> 
--}}
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{ $breadcrumb->title ?? 'Jabatan Struktural' }}</h1>
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
  </div>

  <div class="section-body">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Data Jabatan Struktural</h4>
          <div class="card-header-action ml-auto">
            <button onclick="modalAction(`{{ url('/jabatan_struktural/create') }}`)" class="btn btn-primary">
              <i class="fas fa-plus"></i> Tambah
            </button>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dt-responsive nowrap" id="table_jabatan" style="width:100%">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Nama Pegawai</th>
                  <th>Nama Jabatan</th>
                  <th>Jenis Pelantikan</th>
                  <th>Unit Kerja</th>
                  <th>TMT Jabatan</th>
                  <th>Status Jabatan</th>
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
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function modalAction(url = '') {
    $('#myModal').load(url, function () {
      $('#myModal').modal('show');
    });
  }

  var dataJabatanStruktural;

  $(document).ready(function () {
    dataJabatanStruktural = $('#table_jabatan').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/jabatan_struktural/list') }}",
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
          data: 'nama_pegawai',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'nama_jabatan',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'jenis_pelantikan',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'nama_unit_kerja',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'tmt_jabatan',
          className: 'text-center',
          orderable: true,
          searchable: true
        },
        {
          data: 'status_jabatan',
          className: '',
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
