@extends('layouts.template')

@section('title')
| Master Program
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{ $breadcrumb->title ?? 'Master Program' }}</h1>
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
  </div>

  <div class="section-body">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Data Master Program</h4>
          <div class="card-header-action ml-auto">
            <button onclick="modalAction(`{{ url('/master_program/create') }}`)" class="btn btn-primary">
              <i class="fas fa-plus"></i> Tambah
            </button>
          </div>
        </div>

        <div class="card-body">
          <!-- Filter Section -->
          <div class="row">
            <div class="col-sm-2">
              <label for="program_filter"><strong>Nama Program:</strong></label>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <select id="program_filter" class="form-control select2-compact">
                  <option value="">-- Pilih Program --</option>
                  @foreach ($listProgram as $program)
                    <option value="{{ $program->id_program }}">{{ formatKode($program->kode_program, 'program') }} - {{ $program->nama_program }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dt-responsive nowrap" id="table_master_program" style="width:100%">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Kode Program</th>
                  <th>Nama Program</th>
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

  var dataMasterProgram;
  $(document).ready(function () {
    
    // Inisialisasi Select2
    $('#program_filter').select2({
      placeholder: "-- Pilih Program --",
      allowClear: true,
      width: '100%'
    });

    // Inisialisasi DataTable
    dataMasterProgram = $('#table_master_program').DataTable({
      processing: false,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/master_program/list') }}",
        type: "POST",
        data: function(d) {
          d.id_program = $('#program_filter').val();
        }
      },
      columns: [
        { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
        { data: 'kode_program', className: '', orderable: true, searchable: true },
        { data: 'nama_program', className: '', orderable: true, searchable: true },
        { data: 'aksi', className: 'text-center', orderable: false, searchable: false }
      ]
    });

    // Event handler untuk filter Program
    $('#program_filter').on('change', function() {
      // Reload DataTable
      dataMasterProgram.ajax.reload();
    });

  });
</script>
@endpush