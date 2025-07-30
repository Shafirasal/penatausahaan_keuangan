@extends('layouts.template')

@section('title')
| Daftar Pegawai
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
    <h1>{{ $breadcrumb->title ?? 'Daftar Pegawai' }}</h1>
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
  </div>

  <div class="section-body">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Data Pegawai</h4>
          <div class="card-header-action ml-auto">
            <button onclick="modalAction(`{{ url('/pegawai/create') }}`)" class="btn btn-primary">
              <i class="fas fa-plus"></i> Tambah
            </button>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dt-responsive nowrap" id="table_pegawai" style="width:100%">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Tempat Lahir</th>
                  <th>Tanggal Lahir</th>
                  <th>Jenis Kelamin</th>
                  <th>Email</th>
                  <th>No. HP</th>
                  <th>Status Kepegawaian</th>
                  <th>Foto</th>
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

  // Handle modal events untuk mengatasi aria-hidden issue
  $('#myModal').on('shown.bs.modal', function () {
    $(this).removeAttr('aria-hidden');
  });

  $('#myModal').on('hidden.bs.modal', function () {
    $(this).attr('aria-hidden', 'true');
  });

  var dataPegawai;

  $(document).ready(function () {
    dataPegawai = $('#table_pegawai').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: {
        url: "{{ url('/pegawai/list') }}",
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
          data: 'nip',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'nama',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'tempat_lahir',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'tanggal_lahir',
          className: 'text-center',
          orderable: true,
          searchable: true,
          render: function (data, type, row) {
            if (!data) return '-';
            const date = new Date(data);
            return date.toLocaleDateString('id-ID', {
              day: '2-digit',
              month: '2-digit',
              year: 'numeric'
            });
          }
        },
        {
          data: 'jenis_kelamin',
          className: 'text-center',
          orderable: true,
          searchable: true,
          render: function (data, type, row) {
            return data === 'L' ? 'Laki-laki' : 'Perempuan';
          }
        },
        {
          data: 'email',
          className: '',
          orderable: true,
          searchable: true,
          render: function (data, type, row) {
            return data || '-';
          }
        },
        {
          data: 'hp',
          className: '',
          orderable: true,
          searchable: true,
          render: function (data, type, row) {
            return data || '-';
          }
        },
        {
          data: 'status_kepegawaian',
          className: '',
          orderable: true,
          searchable: true
        },
        {
          data: 'foto',
          className: 'text-center',
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            // Definisikan default image path (sesuaikan dengan struktur project Anda)
            const defaultImage = '/storage/foto_profile'; // atau path yang sesuai
            
            if (!data || data === '' || data === null) {
              return `
                <div class="avatar avatar-lg">
                  <img alt="image" src="${defaultImage}" class="rounded-circle">
                </div>
              `;
            }

            // Pastikan path foto benar
            const imagePath = data.startsWith('/') ? data : `/storage/${data}`;
            
            return `
              <div class="avatar avatar-lg">
                <img alt="image" src="${imagePath}" class="rounded-circle" 
                    onerror="this.src='${defaultImage}'">
              </div>
            `;
          }
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