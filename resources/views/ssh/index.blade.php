@extends('layouts.template')

@section('title')
    | SSH
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $breadcrumb->title ?? 'SSH' }}</h1>
            @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data SSH</h4>
                        <div class="card-header-action ml-auto">
                            <button onclick="modalAction(`{{ url('/ssh/create') }}`)" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group d-flex align-items-center mb-0">
                            <label for="id_program" class="mb-0 mr-2" style="width: 160px;"><strong>Nama
                                    Program:</strong></label>
                            <select id="id_program" class="form-control form-control-sm">
                                <option value="">-- Pilih Program --</option>
                                @foreach ($listProgram as $program)
                                    <option value="{{ $program->id_program }}">
                                        {{ $program->kode_program }} - {{ $program->nama_program }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-flex align-items-center mb-0">
                            <label for="id_kegiatan" class="mb-0 mr-2" style="width: 160px;"><strong>Nama
                                    Kegiatan:</strong></label>
                            <select id="id_kegiatan" class="form-control form-control-sm" disabled>
                                <option value="">-- Pilih Kegiatan --</option>
                            </select>
                        </div>
                        <div class="form-group d-flex align-items-center mb-0">
                            <label for="id_sub_kegiatan" class="mb-0 mr-2" style="width: 160px;"><strong>Nama Sub
                                    Kegiatan:</strong></label>
                            <select id="id_sub_kegiatan" class="form-control form-control-sm" disabled>
                                <option value="">-- Pilih Sub Kegiatan --</option>
                            </select>
                        </div>
                        <div class="form-group d-flex align-items-center mb-0">
                            <label for="id_rekening" class="mb-0 mr-2" style="width: 160px;"><strong>Nama
                                    Rekening:</strong></label>
                            <select id="id_rekening" class="form-control form-control-sm" disabled>
                                <option value="">-- Pilih Rekening --</option>
                            </select>
                        </div>




                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped dt-responsive nowrap"
                                id="table_ssh" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode SSH</th>
                                        {{-- <th>Nama Program</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Nama Sub Kegiatan</th>
                                        <th>Nama Rekening</th> --}}
                                        <th>Nama SSH</th>
                                        <th>Pagu</th>
                                        <th>Periode</th>
                                        <th>Tahun</th>
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

        var dataSSH;
        $(document).ready(function() {
            $('#id_program, #id_kegiatan, #id_sub_kegiatan, #id_rekening').select2({
                placeholder: "-- Pilih --",
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 0
            });

            // Awal disable dropdown selain program
            // $('#kegiatan_nama, #nama_sub_kegiatan, #rekening').prop('disabled', true);

            // Program -> Kegiatan
            $('#id_program').on('change', function() {
                let programId = $(this).val();
                $('#id_kegiatan').prop('disabled', true).html(
                    '<option value="">-- Pilih Kegiatan --</option>');
                $('#id_sub_kegiatan').prop('disabled', true).html(
                    '<option value="">-- Pilih Sub Kegiatan --</option>');
                $('#id_rekening').prop('disabled', true).html(
                    '<option value="">-- Pilih Rekening --</option>');

                if (programId) {
                    $.get(`/ssh/program/${programId}/kegiatan`, function(data) {
                        data.forEach(function(item) {
                            $('#id_kegiatan').append(
                                `<option value="${item.id_kegiatan}">${item.kode_kegiatan} - ${item.nama_kegiatan}</option>`
                            );
                        });
                        $('#id_kegiatan').prop('disabled', false);
                        dataSSH.ajax.reload();
                    });
                }
            });

            // Kegiatan -> Sub Kegiatan
            $('#id_kegiatan').on('change', function() {
                let kegiatanId = $(this).val();
                $('#id_sub_kegiatan').prop('disabled', true).html(
                    '<option value="">-- Pilih Sub Kegiatan --</option>');
                $('#id_rekening').prop('disabled', true).html(
                    '<option value="">-- Pilih Rekening --</option>');

                if (kegiatanId) {
                    $.get(`/ssh/kegiatan/${kegiatanId}/sub_kegiatan`, function(data) {
                        data.forEach(function(item) {
                            $('#id_sub_kegiatan').append(
                                `<option value="${item.id_sub_kegiatan}">${item.kode_sub_kegiatan} - ${item.nama_sub_kegiatan}</option>`
                            );
                        });
                        $('#id_sub_kegiatan').prop('disabled', false);
                        dataSSH.ajax.reload();
                    });
                }
            });

            // Sub Kegiatan -> Rekening
            $('#id_sub_kegiatan').on('change', function() {
                let subKegiatanId = $(this).val();
                $('#id_rekening').prop('disabled', true).html(
                    '<option value="">-- Pilih Rekening --</option>');

                if (subKegiatanId) {
                    $.get(`/ssh/sub_kegiatan/${subKegiatanId}/rekening`, function(data) {
                        data.forEach(function(item) {
                            $('#id_rekening').append(
                                `<option value="${item.id_rekening}">${item.kode_rekening} - ${item.nama_rekening}</option>`
                            );
                        });
                        $('#id_rekening').prop('disabled', false);
                        dataSSH.ajax.reload();
                    });
                }
            });

        });

        // REKENING → reload tabel
        $('#id_rekening').change(function() {
            dataSSH.ajax.reload();
        });

        // Datatables
        dataSSH = $('#table_ssh').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ url('/ssh/list') }}",
                type: "POST",
                data: function(d) {
                    d.id_program = $('#id_program').val();
                    d.id_kegiatan = $('#id_kegiatan').val();
                    d.id_sub_kegiatan = $('#id_sub_kegiatan').val();
                    d.id_rekening = $('#id_rekening').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode_ssh'
                },
                // {
                //     data: 'program_nama'
                // },
                // {
                //     data: 'kegiatan_nama'
                // },
                // {
                //     data: 'nama_sub_kegiatan'
                // },
                // {
                //     data: 'nama_rekening'
                // },
                {
                    data: 'nama_ssh'
                },
                {
                    data: 'pagu'
                },
                {
                    data: 'periode'
                },
                {
                    data: 'tahun'
                },
                {
                    data: 'aksi',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ]
        });
        // Reload tabel ketika filter berubah
        $('#id_program, #id_kegiatan, #id_sub_kegiatan, #id_rekening').on('change', function() {
            dataSSH.ajax.reload();
        });
    </script>
@endpush
