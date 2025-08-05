@extends('layouts.template')

@section('title')
| Master Rekening
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{ $breadcrumb->title ?? 'Master Rekening' }}</h1>
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
  </div>

  <div class="section-body">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Data Master Rekening</h4>
          <div class="card-header-action ml-auto">
            <button onclick="modalAction(`{{ url('/master_rekening/create') }}`)" class="btn btn-primary">
              <i class="fas fa-plus"></i> Tambah
            </button>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dt-responsive nowrap" id="table_master_rekening" style="width:100%">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Kode Rekening</th>
                  <th>Nama Rekening</th>
                  <th>Program</th>
                  <th>Kegiatan</th>
                  <th>Sub Kegiatan</th>
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

  var dataMasterRekening;
  $(document).ready(function () {
    dataMasterRekening = $('#table_master_rekening').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/master_rekening/list') }}",
        type: "POST"
      },
      columns: [
        { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
        { data: 'kode_rekening', className: '', orderable: true, searchable: true },
        { data: 'nama_rekening', className: '', orderable: true, searchable: true },
        { data: 'program.nama_program', className: '', orderable: true, searchable: true },
        { data: 'kegiatan.nama_kegiatan', className: '', orderable: true, searchable: true },
        { data: 'sub_kegiatan.nama_sub_kegiatan', className: '', orderable: true, searchable: true },
        { data: 'aksi', className: 'text-center', orderable: false, searchable: false }
      ]
    });
  });
</script>
@endpush
