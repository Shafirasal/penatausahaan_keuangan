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
          <!-- Filter Section -->
          <div class="row mb-3">
            <div class="col-md-4">
              <div class="form-group">
                <label for="program_filter"><strong>Nama Program:</strong></label>
                <select id="program_filter" class="form-control">
                  <option value="">-- Pilih Program --</option>
                  @foreach ($listProgram as $program)
                    @php
                      $kode = $program->kode_program;
                      $formatted_kode = '[' . substr($kode, 0, 1) . '.' . substr($kode, 1, 2) . '.' . substr($kode, 3, 2) . ']';
                    @endphp
                    <option value="{{ $program->id_program }}">{{ $formatted_kode }} {{ $program->nama_program }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="kegiatan_filter"><strong>Nama Kegiatan:</strong></label>
                <select id="kegiatan_filter" class="form-control" disabled>
                  <option value="">-- Pilih Kegiatan --</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="sub_kegiatan_filter"><strong>Nama Sub Kegiatan:</strong></label>
                <select id="sub_kegiatan_filter" class="form-control" disabled>
                  <option value="">-- Pilih Sub Kegiatan --</option>
                </select>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dt-responsive nowrap" id="table_master_rekening" style="width:100%">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Kode Rekening</th>
                  <th>Program</th>
                  <th>Kegiatan</th>
                  <th>Sub Kegiatan</th>
                  <th>Nama Rekening</th>
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

    $('#sub_kegiatan_filter').select2({
      placeholder: "-- Pilih Sub Kegiatan --",
      allowClear: true,
      width: '100%'
    });

    // Inisialisasi DataTable
    dataMasterRekening = $('#table_master_rekening').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/master_rekening/list') }}",
        type: "POST",
        data: function (d) {
          d.id_program = $('#program_filter').val();
          d.id_kegiatan = $('#kegiatan_filter').val();
          d.id_sub_kegiatan = $('#sub_kegiatan_filter').val();
        }
      },
      columns: [
        { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
        { data: 'kode_rekening', className: '', orderable: true, searchable: true },
        { data: 'program_nama', className: '', orderable: true, searchable: true },
        { data: 'kegiatan_nama', className: '', orderable: true, searchable: true },
        { data: 'sub_kegiatan_nama', className: '', orderable: true, searchable: true },
        { data: 'nama_rekening', className: '', orderable: true, searchable: true },
        { data: 'aksi', className: 'text-center', orderable: false, searchable: false }
      ]
    });

    // Event handler untuk filter Program
    $('#program_filter').on('change', function() {
      var programId = $(this).val();
      
      // Reset dan disable kegiatan dan sub kegiatan filter
      $('#kegiatan_filter').empty().append('<option value="">-- Pilih Kegiatan --</option>').prop('disabled', true).trigger('change');
      $('#sub_kegiatan_filter').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true).trigger('change');
      
      if (programId) {
        // Load kegiatan berdasarkan program yang dipilih
        $.ajax({
          url: "{{ url('/master_rekening/program') }}/" + programId + "/kegiatan",
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $('#kegiatan_filter').prop('disabled', false);
            $.each(data, function(index, kegiatan) {
              // Format kode kegiatan jika ada
              let displayText = kegiatan.nama_kegiatan;
              if (kegiatan.kode_kegiatan) {
                let kode = kegiatan.kode_kegiatan;
                let formattedKode = '[' + kode.substr(0, 1) + '.' + kode.substr(1, 2) + '.' + kode.substr(3, 2) + '.' + kode.substr(5, 1) + ']';
                displayText = formattedKode + ' ' + kegiatan.nama_kegiatan;
              }
              $('#kegiatan_filter').append('<option value="' + kegiatan.id_kegiatan + '">' + displayText + '</option>');
            });
          },
          error: function() {
            alert('Gagal memuat data kegiatan');
          }
        });
      }
      
      // Reload DataTable
      dataMasterRekening.ajax.reload();
    });

    // Event handler untuk filter Kegiatan
    $('#kegiatan_filter').on('change', function() {
      var kegiatanId = $(this).val();
      
      // Reset dan disable sub kegiatan filter
      $('#sub_kegiatan_filter').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true).trigger('change');
      
      if (kegiatanId) {
        // Load sub kegiatan berdasarkan kegiatan yang dipilih
        $.ajax({
          url: "{{ url('/master_rekening/kegiatan') }}/" + kegiatanId + "/sub_kegiatan",
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $('#sub_kegiatan_filter').prop('disabled', false);
            $.each(data, function(index, subKegiatan) {
              // Format kode sub kegiatan jika ada
              let displayText = subKegiatan.nama_sub_kegiatan;
              if (subKegiatan.kode_sub_kegiatan) {
                let kode = subKegiatan.kode_sub_kegiatan;
                let formattedKode = '[' + kode.substr(0, 1) + '.' + kode.substr(1, 2) + '.' + kode.substr(3, 2) + '.' + kode.substr(5, 1) + '.' + kode.substr(6, 2) + ']';
                displayText = formattedKode + ' ' + subKegiatan.nama_sub_kegiatan;
              }
              $('#sub_kegiatan_filter').append('<option value="' + subKegiatan.id_sub_kegiatan + '">' + displayText + '</option>');
            });
          },
          error: function() {
            alert('Gagal memuat data sub kegiatan');
          }
        });
      }
      
      // Reload DataTable
      dataMasterRekening.ajax.reload();
    });

    // Event handler untuk filter Sub Kegiatan
    $('#sub_kegiatan_filter').on('change', function() {
      dataMasterRekening.ajax.reload();
    });

  });
</script>
@endpush