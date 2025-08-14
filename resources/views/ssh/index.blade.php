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

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="program_filter"><strong>Nama Program:</strong></label>
                                    <select id="program_filter" class="form-control">
                                        <option value="">-- Pilih Program --</option>
                                        @foreach ($listProgram as $program)
                                            {{-- ✅ TAMBAHAN: Tampilkan kode_program yang sudah diformat --}}
                                            <option value="{{ $program->id_program }}">{{ $program->kode_program }} -
                                                {{ $program->nama_program }}</option>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sub_kegiatan_filter"><strong>Nama Sub Kegiatan:</strong></label>
                                    <select id="sub_kegiatan_filter" class="form-control" disabled>
                                        <option value="">-- Pilih Sub Kegiatan --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rekening_filter"><strong>Nama Rekening:</strong></label>
                                    <select id="rekening_filter" class="form-control" disabled>
                                        <option value="">-- Pilih Rekening --</option>
                                    </select>
                                </div>
                            </div>
                        </div>




                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped dt-responsive nowrap"
                                id="table_ssh" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode SSH</th>
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

            $('#rekening_filter').select2({
                placeholder: "-- Pilih Rekening --",
                allowClear: true,
                width: '100%'
            });

            // Event handler untuk filter Program

            // Datatables
            dataSSH = $('#table_ssh').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ url('/ssh/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.id_program = $('#program_filter').val();
                        d.id_kegiatan = $('#kegiatan_filter').val();
                        d.id_sub_kegiatan = $('#sub_kegiatan_filter').val();
                        d.id_rekening = $('#rekening_filter').val();
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
                    {
                        data: 'nama_ssh'
                    },
                    {
                        data: 'pagu',
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
            $('#program_filter').on('change', function() {
                var programId = $(this).val();

                // Reset dan disable kegiatan filter
                $('#kegiatan_filter').empty().append('<option value="">-- Pilih Kegiatan --</option>').prop(
                    'disabled', true).trigger('change');

                if (programId) {
                    // Load kegiatan berdasarkan program yang dipilih
                    $.ajax({
                        url: "{{ url('/ssh/program') }}/" + programId + "/kegiatan",
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kegiatan_filter').prop('disabled', false);
                            $.each(data, function(index, kegiatan) {
                                // ✅ TAMBAHAN: Tampilkan kode_kegiatan yang sudah diformat dari controller
                                $('#kegiatan_filter').append('<option value="' +
                                    kegiatan.id_kegiatan + '">' + kegiatan
                                    .kode_kegiatan + ' - ' + kegiatan
                                    .nama_kegiatan + '</option>');
                            });
                        },
                        error: function() {
                            alert('Gagal memuat data kegiatan');
                        }
                    });
                }

                // Reload DataTable
                dataSSH.ajax.reload();
            });

            // Reload tabel ketika filter berubah
            $('#kegiatan_filter').on('change', function() {
                var kegiatanId = $(this).val();

                // Reset dan disable kegiatan filter
                $('#sub_kegiatan_filter').empty().append(
                    '<option value="">-- Pilih Sub Kegiatan --</option>').prop(
                    'disabled', true).trigger('change');

                if (kegiatanId) {
                    // Load kegiatan berdasarkan program yang dipilih
                    $.ajax({
                        url: "{{ url('/ssh/kegiatan') }}/" + kegiatanId + "/sub_kegiatan",
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#sub_kegiatan_filter').prop('disabled', false);
                            $.each(data, function(index, sub_kegiatan) {
                                // ✅ TAMBAHAN: Tampilkan kode_kegiatan yang sudah diformat dari controller
                                $('#sub_kegiatan_filter').append('<option value="' +
                                    sub_kegiatan.id_sub_kegiatan + '">' +
                                    sub_kegiatan
                                    .kode_sub_kegiatan + ' - ' + sub_kegiatan
                                    .nama_sub_kegiatan + '</option>');
                            });
                        },
                        error: function() {
                            alert('Gagal memuat data sub kegiatan');
                        }
                    });
                }

                // Reload DataTable
                dataSSH.ajax.reload();
            });
            // Reload tabel ketika filter berubah
            $('#sub_kegiatan_filter').on('change', function() {
                var subKegiatanId = $(this).val();

                // Reset dan disable kegiatan filter
                $('#rekening_filter').empty().append('<option value="">-- Pilih Rekening --</option>').prop(
                    'disabled', true).trigger('change');

                if (subKegiatanId) {
                    // Load kegiatan berdasarkan program yang dipilih
                    $.ajax({
                        url: "{{ url('/ssh/sub_kegiatan') }}/" + subKegiatanId + "/rekening",
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#rekening_filter').prop('disabled', false);
                            $.each(data, function(index, rekening) {
                                // ✅ TAMBAHAN: Tampilkan kode_kegiatan yang sudah diformat dari controller
                                $('#rekening_filter').append('<option value="' +
                                    rekening.id_rekening + '">' + rekening
                                    .kode_rekening + ' - ' + rekening
                                    .nama_rekening + '</option>');
                            });
                        },
                        error: function() {
                            alert('Gagal memuat data rekening');
                        }
                    });
                }

                // Reload DataTable
                dataSSH.ajax.reload();
            });

            // Event handler untuk filter Kegiatan
            $('#rekening_filter').on('change', function() {
                dataSSH.ajax.reload();
            });
        });
    </script>
@endpush
