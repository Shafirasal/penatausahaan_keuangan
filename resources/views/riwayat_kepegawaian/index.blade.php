@extends('layouts.template')

@section('title')
| Riwayat Kepegawaian
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
    <h1>{{ $breadcrumb->title ?? 'Riwayat Kepegawaian' }}</h1>
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list ?? []])
  </div>

  <div class="section-body">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Data Riwayat Kepegawaian</h4>
          <div class="card-header-action ml-auto">
            <button onclick="modalAction(`{{ url('/riwayat_kepegawaian/create') }}`)" class="btn btn-primary">
              <i class="fas fa-plus"></i> Tambah
            </button>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dt-responsive nowrap" id="table-riwayat" style="width:100%">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>NIP</th>
                  <th>Nama Pegawai</th>
                  <th>Golongan</th>
                  <th>Jenis KP</th>
                  <th>TMT Pangkat</th>
                  <th>Masa Kerja</th>
                  <th>File</th>
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
  function modalAction(url = '') {
    $('#myModal').load(url, function () {
      $('#myModal').modal('show');
    });
  }

  var dataRiwayatKepegawaian;

  $(document).ready(function () {
    dataRiwayatKepegawaian = $('#table-riwayat').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/riwayat_kepegawaian/list') }}",
        type: "POST",
        data: {
          _token: "{{ csrf_token() }}"
        }
      },
      columns: [
        {
          data: 'DT_RowIndex',
          className: 'text-center',
          orderable: false,
          searchable: false
        },
        {
          data: 'nip',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'pegawai_nama',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'golongan_nama',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'jenis_kp_nama',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'tmt_pangkat',
          className: 'text-center',
          orderable: true,
          searchable: true
        },
        {
          data: null,
          render: function(data) {
            return data.masa_kerja_tahun + ' Tahun ' + data.masa_kerja_bulan + ' Bulan';
          },
          className: 'text-center',
          orderable: false,
          searchable: false
        },
        {
          data: 'file',
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
