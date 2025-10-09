@extends('layouts.template')

@section('title')
    | Tree View SSH
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $breadcrumb->title ?? 'Tree View SSH' }}</h1>
            @include('layouts.breadcrumb', ['list' => $breadcrumb->list ?? []])
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $page->title ?? 'Data Rekening ➜ SSH (Tree)' }}</h4>
                        <div class="card-header-action ml-auto">
                            <a href="{{ url('/tree_view/export_excel') }}?tahun={{ request('tahun', $tahunSekarang) }}" class="btn btn-info" style="background-color: #EF5428; border-color: #EF5428;">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </a> 
                        </div>

                    </div>

                    <div class="card-body">
                        {{-- FILTER --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Nama Program</strong></label>
                                    <select id="program_filter" class="form-control">
                                        <option value="">-- Pilih Program --</option>
                                        @foreach ($listProgram as $program)
                                            <option value="{{ $program->id_program }}">
                                                {{ $program->kode_program }} - {{ $program->nama_program }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Nama Kegiatan</strong></label>
                                    <select id="kegiatan_filter" class="form-control" disabled>
                                        <option value="">-- Pilih Kegiatan --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Nama Sub Kegiatan</strong></label>
                                    <select id="sub_kegiatan_filter" class="form-control" disabled>
                                        <option value="">-- Pilih Sub Kegiatan --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- TABEL TREE: Level-1 = Rekening, child = SSH --}}
                        <div class="table-responsive">
                            <table id="table_tree"
                                class="table table-bordered table-hover table-striped dt-responsive nowrap"
                                style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width:48px"></th> {{-- expand/collapse --}}
                                        <th>Kode</th>
                                        <th>Uraian</th>
                                        <th class="text-right">Periode 1</th>
                                        <th class="text-right">Periode 2</th>
                                        <th class="text-right">Realisasi</th>
                                        <th class="text-right">Sisa</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        {{-- Pagination oleh DataTables --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>

        let isSearching = false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            // (opsional) select2
            if ($.fn.select2) {
                $('#program_filter, #kegiatan_filter, #sub_kegiatan_filter').select2({
                    width: '100%',
                    allowClear: true
                });
            }

            // === Dropdown berantai ===
            $('#program_filter').on('change', function() {
                const pid = $(this).val();

                $('#kegiatan_filter').empty().append('<option value="">-- Pilih Kegiatan --</option>').prop(
                    'disabled', true).trigger('change');
                $('#sub_kegiatan_filter').empty().append(
                        '<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true)
                    .trigger('change');

                if (pid) {
                    $.get(`{{ url('/tree_view/program') }}/${pid}/kegiatan`, function(rows) {
                        $('#kegiatan_filter').prop('disabled', false);
                        rows.forEach(r => {
                            $('#kegiatan_filter').append(
                                `<option value="${r.id_kegiatan}">${r.kode_kegiatan} - ${r.nama_kegiatan}</option>`
                            );
                        });
                    });
                }
                table.ajax.reload();
            });

            $('#kegiatan_filter').on('change', function() {
                const kid = $(this).val();

                $('#sub_kegiatan_filter').empty().append(
                        '<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true)
                    .trigger('change');

                if (kid) {
                    $.get(`{{ url('/tree_view/kegiatan') }}/${kid}/sub_kegiatan`, function(rows) {
                        $('#sub_kegiatan_filter').prop('disabled', false);
                        rows.forEach(r => {
                            $('#sub_kegiatan_filter').append(
                                `<option value="${r.id_sub_kegiatan}">${r.kode_sub_kegiatan} - ${r.nama_sub_kegiatan}</option>`
                            );
                        });
                    });
                }
                table.ajax.reload();
            });

            $('#sub_kegiatan_filter').on('change', function() {
                table.ajax.reload();
            });

            // === DataTables level-1: Rekening ===
            const table = $('#table_tree').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,  
                ajax: {
                    url: `{{ url('/tree_view/list-sub_kegiatan') }}`,
                    type: 'POST',
                    data: function(d) {
                        d.id_program = $('#program_filter').val();
                        d.id_kegiatan = $('#kegiatan_filter').val();
                        d.id_sub_kegiatan = $('#sub_kegiatan_filter').val();
                        d.tahun = $('#tahun').val();
                        // tambahan: kalau input search ≥3 huruf, kirim sebagai ssh_search
                        if (d.search && d.search.value && d.search.value.length >= 3) {
                            d.ssh_search = d.search.value;
                            isSearching = true;
                        } else {
                            isSearching = false;
                        }
                    }
                },
                columns: [{
                        data: 'expand',
                        orderable: false,
                        searchable: false,
                        className: 'text-center align-middle'
                    },
                    {
                        data: 'kode',
                        className: 'align-middle'
                    },
                    {
                        data: 'uraian',
                        className: 'align-middle'
                    },
                    {
                        data: 'p1',
                        className: 'text-right align-middle'
                    },
                    {
                        data: 'p2',
                        className: 'text-right align-middle'
                    },
                    {
                        data: 'real',
                        className: 'text-right align-middle'
                    },
                    {
                        data: 'sisa',
                        className: 'text-right align-middle'
                    },
                ],
                order: [
                    [1, 'asc']
                ],
            });

            table.on('draw', function() {
            if (isSearching) {
                // expand semua sub_kegiatan
                $('.btn-expand-sub').each(function() { $(this).click(); });

                // rekening akan expand otomatis setelah event rekening:loaded dipicu untuk search

                
                // $(document).one('rekening:loaded', function() {
                //     $('.btn-expand-rek').each(function() { $(this).click(); });
                // });
                
            }
        });
            // === Child rows: rekening per sub_kegiatan ===
            $('#table_tree tbody').on('click', '.btn-expand-sub', function(e) {
                e.preventDefault();

                const tr = $(this).closest('tr');
                const btn = $(this);
                const id = btn.data('id');
                const key = 'sub-' + id; // prefix biar tidak tabrakan id di level lain

                if (tr.hasClass('shown')) {
                    // Hapus SEMUA turunan sub ini (anak, cucu, dst)
                    $('.desc-of-' + key).remove();
                    btn.html('<i class="fas fa-chevron-right"></i>');
                    tr.removeClass('shown');
                } else {
                    const params = $.param({
                        id_program: $('#program_filter').val() || '',
                        id_kegiatan: $('#kegiatan_filter').val() || '',
                        id_sub_kegiatan: $('#sub_kegiatan_filter').val() || '',
                        tahun: $('#tahun').val() || '',
                        ssh_search: $('.dataTables_filter input').val() || '' // ambil dari input search DataTables
                    });

                    $.get(`{{ url('/tree_view') }}/${id}/rekening?${params}`, function(rowsHtml) {
                        // Sisipkan
                        const $ins = $(rowsHtml).insertAfter(tr);
                        // Tandai sebagai anak LANGSUNG + semua turunan dari sub ini
                        $ins.filter('tr').addClass('child-of-' + key + ' desc-of-' + key);

                        btn.html('<i class="fas fa-chevron-down"></i>');
                        tr.addClass('shown');

                        // ✅ beri sinyal kalau rekening sudah selesai dimuat untuk search
                        $(document).trigger('rekening:loaded');
                    }).fail(function() {
                        alert('Gagal memuat data rekening');
                    });
                }
            });


            // === Child rows: SSH per rekening ===
            $('#table_tree tbody').on('click', '.btn-expand-rek', function(e) {
                e.preventDefault();

                const tr = $(this).closest('tr');
                const btn = $(this);
                const id = btn.data('id');
                const key = 'rek-' + id;

                if (tr.hasClass('shown')) {
                    // Hapus SEMUA turunan rekening ini (anak, cucu, dst)
                    $('.desc-of-' + key).remove();
                    btn.html('<i class="fas fa-chevron-right"></i>');
                    tr.removeClass('shown');
                } else {
                    const params = $.param({
                        id_program: $('#program_filter').val() || '',
                        id_kegiatan: $('#kegiatan_filter').val() || '',
                        id_sub_kegiatan: $('#sub_kegiatan_filter').val() || '',
                        tahun: $('#tahun').val() || '',
                        ssh_search: $('.dataTables_filter input').val() || '' // ✅ ambil dari input search DataTables
                    });

                    $.get(`{{ url('/tree_view') }}/${id}/ssh?${params}`, function(rowsHtml) {
                        const $ins = $(rowsHtml).insertAfter(tr);

                        // Warisi semua "desc-of-..." dari parent, supaya collapse di atas ikut bersih
                        const parentMarks = (tr.attr('class') || '')
                            .split(/\s+/)
                            .filter(c => c.startsWith('desc-of-'));

                        // Tandai sebagai anak langsung rekening + descendant rekening,
                        // sekaligus wariskan semua penanda desc-of- parent (sub) agar collapse parent ikut menghapusnya
                        $ins.filter('tr').addClass(
                            ['child-of-' + key, 'desc-of-' + key].concat(parentMarks).join(' ')
                        );

                        btn.html('<i class="fas fa-chevron-down"></i>');
                        tr.addClass('shown');
                    }).fail(function() {
                        alert('Gagal memuat data SSH');
                    });
                }
            });

            $(document).on('tahun:changed', function(e, tahun) {
                table.ajax.reload(); // reload rekening utama
            });

        });

        //untuk memunculkan semua data yang di search dengan keyword tertentu
        $(document).ajaxStop(function() {
            if (isSearching) {
                $('.btn-expand-sub').each(function() { 
                    if (!$(this).closest('tr').hasClass('shown')) {
                            $(this).click();
                    }
                });
                $('.btn-expand-rek').each(function() { 
                    if (!$(this).closest('tr').hasClass('shown')) {
                        $(this).click();
                    }
                });
            }
        });

    </script>
@endpush
