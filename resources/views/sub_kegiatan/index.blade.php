@extends('layouts.template')

@section('title')
| Master Sub Kegiatan
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{ $breadcrumb->title ?? 'Master Sub Kegiatan' }}</h1>
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
  </div>

  <div class="section-body">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Data Master Sub Kegiatan</h4>
          <div class="card-header-action ml-auto">
            <button onclick="modalAction(`{{ url('/master_sub_kegiatan/create') }}`)" class="btn btn-primary">
              <i class="fas fa-plus"></i> Tambah
            </button>
          </div>
        </div>

        <div class="card-body">
          <!-- Filter Section -->
          <div class="row mb-3">
            <div class="col-md-6">
              <div class="form-group">
                <label for="program_filter"><strong>Nama Program:</strong></label>
                <select id="program_filter" class="form-control">
                  <option value="">-- Pilih Program --</option>
                  @foreach ($listProgram as $program)
                    {{-- TAMBAHAN: Tampilkan kode_program yang sudah diformat --}}
                    <option value="{{ $program->id_program }}">{{ $program->kode_program }} - {{ $program->nama_program }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="kegiatan_filter"><strong>Nama Kegiatan:</strong></label>
                <select id="kegiatan_filter" class="form-control" disabled>
                  <option value="">-- Pilih Kegiatan --</option>
                </select>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dt-responsive nowrap" id="table_master_sub_kegiatan" style="width:100%">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Kode Sub Kegiatan</th>
                  <th>Nama Sub Kegiatan</th>
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

  var dataMasterSubKegiatan;
  $(document).ready(function () {
    
    // Inisialisasi Select2
    $('#program_filter').select2({
      placeholder: "-- Pilih Program --",
      allowClear: true,
      width: '100%'
    });

    $('#kegiatan_filter').select2({
      placeholder: "-- Pilih Kegiatan --",
      allowClear: true,
      width: '100%'
    });

    // Inisialisasi DataTable
    dataMasterSubKegiatan = $('#table_master_sub_kegiatan').DataTable({
      processing: false,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/master_sub_kegiatan/list') }}",
        type: "POST",
        data: function(d) {
          d.id_program = $('#program_filter').val();
          d.id_kegiatan = $('#kegiatan_filter').val();
        }
      },
      columns: [
        { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
        { data: 'kode_sub_kegiatan', orderable: true, searchable: true },
        { data: 'nama_sub_kegiatan', className: '', orderable: true, searchable: true },
        { data: 'aksi', className: 'text-center', orderable: false, searchable: false }
      ]
    });

    // Event handler untuk filter Program
    $('#program_filter').on('change', function() {
      var programId = $(this).val();
      
      // Reset dan disable kegiatan filter
      $('#kegiatan_filter').empty().append('<option value="">-- Pilih Kegiatan --</option>').prop('disabled', true).trigger('change');
      
      if (programId) {
        // Load kegiatan berdasarkan program yang dipilih
        $.ajax({
          url: "{{ url('/master_sub_kegiatan/program') }}/" + programId + "/kegiatan",
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $('#kegiatan_filter').prop('disabled', false);
            $.each(data, function(index, kegiatan) {
              // ✅ TAMBAHAN: Tampilkan kode_kegiatan yang sudah diformat dari controller
              $('#kegiatan_filter').append('<option value="' + kegiatan.id_kegiatan + '">' + kegiatan.kode_kegiatan + ' - ' + kegiatan.nama_kegiatan + '</option>');
            });
          },
          error: function() {
            alert('Gagal memuat data kegiatan');
          }
        });
      }
      
      // Reload DataTable
      dataMasterSubKegiatan.ajax.reload();
    });

    // Event handler untuk filter Kegiatan
    $('#kegiatan_filter').on('change', function() {
      dataMasterSubKegiatan.ajax.reload();
    });

  });
</script>
@endpush