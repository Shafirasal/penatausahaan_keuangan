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
                <button onclick="modalAction(`{{ url('/riwayat-pendidikan/create') }}`)" class="btn btn-primary">
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
      </div>
      <div class="card-body p-0"> {{-- hilangkan padding agar tabel full width --}}
        <div class="table-responsive"> {{-- tambahkan wrapper ini --}}
          <table class="table table-striped table-md" id="table_pendidikan">
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
@endsection

@push('js')
<script>
  $(document).ready(function () {
    $('#table_pendidikan').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ url('/riwayat-pendidikan/list') }}",
      columns: [
        { data: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'nama_sekolah' },
        { data: 'jenjang' },
        { data: 'prodi_jurusan' },
        { data: 'tahun_lulus' },
        { data: 'aktif' },
        { data: 'aksi', orderable: false, searchable: false }
      ]
    });
  });
</script>
@endpush
