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
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
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
            <table class="table table-bordered table-hover table-striped dt-responsive nowrap" id="table_riwayat" style="width:100%">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Nama Pegawai</th>
                  <th>Golongan</th>
                  <th>Jenis Kenaikan Pangkat</th>
                  <th>TMT Pangkat</th>
                  <th>Masa Kerja</t   h>
                  <th>Keterangan</th>
                  <th>File</th>
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

  var dataRiwayatKepegawaian;

  $(document).ready(function () {
    dataRiwayatKepegawaian = $('#table_riwayat').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/riwayat_kepegawaian/list') }}",
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
          data: 'nama_golongan',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'nama_jenis_kp',
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
          render: function (data, type, row) {
            const masuk = new Date(row.tmt_pangkat);
            const sekarang = new Date();

            let tahun = sekarang.getFullYear() - masuk.getFullYear();
            let bulan = sekarang.getMonth() - masuk.getMonth();

            if (bulan < 0) {
              tahun--;
              bulan += 12;
            }

            return tahun + ' th ' + bulan + ' bln';
          },
          className: 'text-center'
        },
        {
          data: 'keterangan',
          className: '',
          orderable: true,
          searchable: true
        },
        // {
        //     data: 'file',
        //     className: '',
        //     render: function (data, type, row) {
        //       if (!data) return '-';

        //       // Ambil nama file asli dari path
        //       const fileName = data.split('/').pop().replace(/^\d{10}_/, '');

        //       return `
        //         <a href="/storage/${data}" target="_blank" title="Preview PDF">${fileName}</a><br>

        //       `;
        //     }
        // },

        {
            data: 'file',
            className: '',
            render: function (data, type, row) {
              if (!data) return '-';

              // Ambil nama file dari path
              const fileName = data.split('/').pop().replace(/^\d{10}_/, '');

              return `
                <a href="/storage/${data}" download="${fileName}" title="Klik untuk download">
                  ${fileName}
                </a>
              `;
            }
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