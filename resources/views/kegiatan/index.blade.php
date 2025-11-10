@extends('layouts.template')

@section('title')
    | Master Kegiatan
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $breadcrumb->title ?? 'Master Kegiatan' }}</h1>
            @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Master Kegiatan</h4>
                        <div class="card-header-action ml-auto">
                            <button onclick="modalAction(`{{ url('/master_kegiatan/create') }}`)" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="program_nama" class="mb-0 mr-2" style="width: 160px;"><strong>Nama Program:</strong></label>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select id="program_nama" class="form-control select2-compact">
                                        <option value="">-- Pilih Program --</option>
                                        @foreach ($listProgram as $program)
                                            <option value="{{ $program->nama_program }}">{{$program->kode_program}} - {{ $program->nama_program }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped dt-responsive nowrap"
                                id="table_master_kegiatan" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Kegiatan</th>
                                        {{-- <th>Nama Program</th> --}}
                                        <th>Nama Kegiatan</th>
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
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }


        var dataMasterKegiatan;
        $(document).ready(function() {
            // Aktifkan Select2 pada filter program
            $('#program_nama').select2({
                placeholder: "-- Pilih Program --",
                allowClear: true,
                width: 'resolve',
                minimumResultsForSearch: 0
            });

            dataMasterKegiatan = $('#table_master_kegiatan').DataTable({
                processing: false,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ url('/master_kegiatan/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.program_nama = $('#program_nama').val(); // kirim filter ke server
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_kegiatan',
                        orderable: true,
                        searchable: true
                    },
                    // {
                    //     data: 'program_nama',
                    //     orderable: true,
                    //     searchable: true
                    // },
                    {
                        data: 'nama_kegiatan',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'aksi',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Reload DataTables saat dropdown berubah
            $('#program_nama').on('change', function() {
                dataMasterKegiatan.ajax.reload();
            });
        });
    </script>
@endpush
