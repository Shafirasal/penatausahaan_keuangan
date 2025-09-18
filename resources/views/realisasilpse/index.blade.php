@extends('layouts.template')

@section('title')
    | Form Realisasi LPSE
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $breadcrumb->title }}</h1>
            @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ===================== INFORMASI PAKET ===================== --}}
        <div class="card">
            <div class="card-header">
                <h4>Informasi Paket</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- KIRI: filter bertingkat (2 atas, 2 bawah, SSH full) --}}
                    <div class="col-lg-7">
                        <div class="row">
                            {{-- Row 1 --}}
                            {{-- Program Locked --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><strong>Program</strong></label>
                                    <input type="text" class="form-control"
                                        value="{{ $program->kode_program_formatted }} - {{ $program->nama_program }}"
                                        readonly>
                                    <input type="hidden" id="h_program" name="id_program"
                                        value="{{ $program->id_program }}"
                                        data-label="{{ $program->kode_program_formatted }} - {{ $program->nama_program }}">
                                </div>
                            </div>

                            {{-- Kegiatan Locked --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><strong>Kegiatan</strong></label>
                                    <input type="text" class="form-control"
                                        value="{{ $kegiatan->kode_kegiatan_formatted }} - {{ $kegiatan->nama_kegiatan }}"
                                        readonly>
                                    <input type="hidden" id="h_kegiatan" name="id_kegiatan"
                                        value="{{ $kegiatan->id_kegiatan }}"
                                        data-label="{{ $kegiatan->kode_kegiatan_formatted }} - {{ $kegiatan->nama_kegiatan }}">
                                </div>
                            </div>


                            {{-- Row 2 --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><strong>Sub Kegiatan</strong></label>
                                    <select id="f_sub" class="form-control" disabled>
                                        <option value="">-- Pilih Sub Kegiatan --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><strong>Rekening</strong></label>
                                    <select id="f_rekening" class="form-control" disabled>
                                        <option value="">-- Pilih Rekening --</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Row 3: SSH full width --}}
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <label><strong>SSH</strong></label>
                                    <select id="f_ssh" class="form-control" disabled>
                                        <option value="">-- Pilih SSH --</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Row 4: pagu & sisa --}}
                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label><strong>Pagu</strong></label>
                                    <div class="border rounded p-2 bg-light">
                                        <p class="mb-0 font-weight-bold text-dark" id="s_pagu_final">
                                            Rp -
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label><strong>Sisa</strong></label>
                                    <div class="border rounded p-2 bg-light">
                                        <p class="mb-0 font-weight-bold text-dark" id="s_sisa">
                                            Rp -
                                        </p>
                                    </div>
                                </div>
                            </div>





                        </div>
                    </div>

                    {{-- KANAN: ringkasan pilihan --}}
                    <div class="col-lg-5">
                        <div class="card border">
                            <div class="card-header py-2"><strong>Ringkasan Pilihan</strong></div>
                            <div class="card-body p-0">
                                <table class="table mb-0">
                                    <tr>
                                        <th style="width:180px">Program</th>
                                        <td id="s_program">-</td>
                                    </tr>
                                    <tr>
                                        <th>Kegiatan</th>
                                        <td id="s_kegiatan">-</td>
                                    </tr>
                                    <tr>
                                        <th>Sub Kegiatan</th>
                                        <td id="s_sub">-</td>
                                    </tr>
                                    <tr>
                                        <th>Rekening</th>
                                        <td id="s_rekening">-</td>
                                    </tr>
                                    <tr>
                                        <th>SSH</th>
                                        <td id="s_ssh">-</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <small class="text-muted">Pastikan ringkasan sesuai sebelum menambah data realisasi.</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== FORM REALISASI ===================== --}}
        <form action="{{ url('/realisasilpse/store') }}" method="POST" enctype="multipart/form-data" id="form-realisasi">
            @csrf
            {{-- hidden IDs dari filter --}}
            <input type="hidden" name="id_program" id="h_program">
            <input type="hidden" name="id_kegiatan" id="h_kegiatan">
            <input type="hidden" name="id_sub_kegiatan" id="h_sub">
            <input type="hidden" name="id_rekening" id="h_rekening">
            <input type="hidden" name="id_ssh" id="h_ssh">

            <div class="card">
                <div class="card-header">
                    <h4>Realisasi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Realisasi <span class="text-danger">*</span></label>
                                <select name="jenis_realisasi" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Kwitansi">Kwitansi</option>
                                    <option value="Nota">Nota</option>
                                    <option value="Dokumen Lainnya">Dokumen Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Dokumen</label>
                                <input type="text" name="no_dokumen" class="form-control"
                                    value="{{ old('no_dokumen') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nilai Realisasi (Rp) <span class="text-danger">*</span></label>
                                <input type="text" name="nilai_realisasi" id="i_nilai" class="form-control"
                                    placeholder="1.000,00" required>
                                <small class="form-text text-muted">Gunakan koma untuk pemisah desimal.</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Realisasi <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_realisasi" class="form-control"
                                    value="{{ now()->toDateString() }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>File Upload</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                        </div>

                        {{-- <div class="col-12">
            <div class="form-group mb-0">
              <label>Keterangan</label>
              <textarea name="keterangan" rows="3" class="form-control">{{ old('keterangan') }}</textarea>
            </div>
          </div>

          <div class="col-12 mt-3">
            <div class="alert alert-secondary">
              Tambah Pelaksana Swakelola setelah selesai menyimpan realisasi.
            </div>
          </div> --}}
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </section>
@endsection


@push('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#f_kegiatan').append({});
            // Sub Kegiatan
            $('#f_sub').select2({
                placeholder: "-- Pilih Sub Kegiatan --",
                allowClear: true,
                width: '100%'
            }).prop('disabled', false);

            // Rekening
            $('#f_rekening').select2({
                placeholder: "-- Pilih Rekening --",
                allowClear: true,
                width: '100%'
            }).prop('disabled', true);

            // SSH
            $('#f_ssh').select2({
                placeholder: "-- Pilih SSH --",
                allowClear: true,
                width: '100%'
            }).prop('disabled', true);

            // Helper ringkasan
            function setSel(idSel, idShow, idHidden) {
                const $opt = $(idSel).find('option:selected');
                $(idShow).text($opt.data('label') || $opt.text() || '-');
                $(idHidden).val($(idSel).val() || '');
            }

            // Kegiatan sudah lock → langsung set ringkasannya dari server
            $('#s_program').text($('#h_program').data('label'));


            $('#s_kegiatan').text($('#h_kegiatan').data('label'));

            const kegiatanId = $('#h_kegiatan').val();
            if (kegiatanId) {
                $.get(`/realisasilpse/kegiatan/${kegiatanId}/summary`)
                    .done(function(response) {
                        if (response.success) {
                            const {
                                total_pagu,
                                total_realisasi,
                                sisa
                            } = response.data;

                            $('#s_pagu_final').text(formatRupiah(total_pagu));
                            $('#s_realisasi').text(formatRupiah(total_realisasi));
                            $('#s_sisa').text(formatRupiah(sisa));
                        }
                    })
                    .fail(function(xhr) {
                        console.error('Error load summary:', xhr);
                    });
            }
            // 2) Kegiatan (locked) → load Sub Kegiatan langsung

            if (kegiatanId) {
                $.get(`/realisasilpse/kegiatan/${kegiatanId}/sub_kegiatan`)
                    .done(function(response) {
                        if (response.success) {
                            populateSelect('#f_sub', response.data, 'id_sub_kegiatan', 'kode_sub_kegiatan',
                                'nama_sub_kegiatan', '-- Pilih Sub Kegiatan --');
                        } else {
                            alert('Gagal memuat data sub kegiatan: ' + response.message);
                            resetSelect('#f_sub', '-- Pilih Sub Kegiatan --');
                        }
                    })
                    .fail(function(xhr) {
                        console.error('Error loading sub kegiatan:', xhr);
                        alert('Gagal memuat data sub kegiatan. Silakan coba lagi.');
                        resetSelect('#f_sub', '-- Pilih Sub Kegiatan --');
                    });
            }


            // 3) Sub Kegiatan → Rekening
            $('#f_sub').on('select2:select select2:clear', function(e) {
                const $opt = $(this).find('option:selected');
                setSel('#f_sub', '#s_sub', '#h_sub');
                resetDropdowns(['rekening', 'ssh']);

                if (e.type === 'select2:select' && $opt.length) {
                    // 🔹 Ambil langsung pagu/sisa dari atribut option
                    const pagu_final = $opt.data('total_pagu') || 0;
                    const realisasi = $opt.data('total_realisasi') || 0;
                    const sisa = $opt.data('sisa') || 0;

                    $('#s_pagu_final').text(formatRupiah(pagu_final));
                    $('#s_realisasi').text(formatRupiah(realisasi));
                    $('#s_sisa').text(formatRupiah(sisa));

                    // Lanjut load rekening
                    const subId = $opt.val();
                    setLoadingState('#f_rekening', 'Loading...');

                    $.get(`/realisasilpse/sub_kegiatan/${subId}/rekening`)
                        .done(function(response) {
                            if (response.success) {
                                populateSelect('#f_rekening', response.data, 'id_rekening',
                                    'kode_rekening', 'nama_rekening', '-- Pilih Rekening --');
                            } else {
                                alert('Gagal memuat data rekening: ' + response.message);
                                resetSelect('#f_rekening', '-- Pilih Rekening --');
                            }
                        })
                        .fail(function(xhr) {
                            console.error('Error loading rekening:', xhr);
                            alert('Gagal memuat data rekening. Silakan coba lagi.');
                            resetSelect('#f_rekening', '-- Pilih Rekening --');
                        });
                }
            });


            // 4) Rekening → SSH
            $('#f_rekening').on('select2:select select2:clear', function(e) {
                const $opt = $(this).find('option:selected');
                setSel('#f_rekening', '#s_rekening', '#h_rekening');
                resetDropdowns(['ssh']);

                if (e.type === 'select2:select' && $opt.length) {
                    // 🔹 Ambil langsung pagu/sisa rekening
                    const pagu_final = $opt.data('total_pagu') || 0;
                    const realisasi = $opt.data('total_realisasi') || 0;
                    const sisa = $opt.data('sisa') || 0;

                    $('#s_pagu_final').text(formatRupiah(pagu_final));
                    $('#s_realisasi').text(formatRupiah(realisasi));
                    $('#s_sisa').text(formatRupiah(sisa));

                    // Lanjut load SSH
                    const rekeningId = $opt.val();
                    setLoadingState('#f_ssh', 'Loading...');

                    $.get(`/realisasilpse/rekening/${rekeningId}/ssh`)
                        .done(function(response) {
                            if (response.success) {
                                $('#f_ssh').empty().append(`<option value="">-- Pilih SSH --</option>`);

                                response.data.forEach(function(item) {
                                    const optionText = item.kode_ssh + ' - ' + item.nama_ssh;

                                    const $opt = new Option(optionText, item.id_ssh);
                                    $($opt).attr('data-label', optionText);

                                    // simpan data pagu & sisa
                                    $($opt).attr('data-realisasi', item.realisasi);
                                    $($opt).attr('data-pagu_final', item.pagu_final);
                                    $($opt).attr('data-sisa', item.sisa);

                                    $('#f_ssh').append($opt);
                                });

                                $('#f_ssh').select2('destroy').select2({
                                    placeholder: '-- Pilih SSH --',
                                    allowClear: true,
                                    width: '100%'
                                }).prop('disabled', false);
                            } else {
                                alert('Error: ' + response.error);
                                resetSelect('#f_ssh', '-- Pilih SSH --');
                            }
                        })
                        .fail(function(xhr) {
                            console.error('Error loading SSH:', xhr);
                            alert('Gagal memuat data SSH. Silakan coba lagi.');
                            resetSelect('#f_ssh', '-- Pilih SSH --');
                        });
                }
            });



            // 5) SSH → Ringkasan + Pagu & Sisa
            $('#f_ssh').on('select2:select select2:clear', function() {
                setSel('#f_ssh', '#s_ssh', '#h_ssh');

                const $opt = $(this).find('option:selected');

                const realisasi = $opt.data('realisasi') || 0;
                const pagu_final = $opt.data('pagu_final') || 0;
                const sisa = $opt.data('sisa') || 0;

                $('#s_realisasi').text(formatRupiah(realisasi));
                $('#s_pagu_final').text(formatRupiah(pagu_final));
                $('#s_sisa').text(formatRupiah(sisa));
            });

            // helper format rupiah
            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(angka);
            }



            // ===== Helper Functions =====
            function resetDropdowns(dropdowns) {
                const config = {
                    'kegiatan': {
                        selector: '#f_kegiatan',
                        placeholder: '-- Pilih Kegiatan --',
                        summary: '#s_kegiatan',
                        hidden: '#h_kegiatan'
                    },
                    'sub': {
                        selector: '#f_sub',
                        placeholder: '-- Pilih Sub Kegiatan --',
                        summary: '#s_sub',
                        hidden: '#h_sub'
                    },
                    'rekening': {
                        selector: '#f_rekening',
                        placeholder: '-- Pilih Rekening --',
                        summary: '#s_rekening',
                        hidden: '#h_rekening'
                    },
                    'ssh': {
                        selector: '#f_ssh',
                        placeholder: '-- Pilih SSH --',
                        summary: '#s_ssh',
                        hidden: '#h_ssh'
                    }
                };



                dropdowns.forEach(function(dropdown) {
                    const conf = config[dropdown];
                    if (conf) {
                        resetSelect(conf.selector, conf.placeholder);
                        $(conf.summary).text('-');
                        $(conf.hidden).val('');
                    }
                });

                // 🔹 tambahan khusus: reset pagu & sisa setiap kali filter naik diubah
                if (dropdowns.includes('ssh')) {
                    $('#s_pagu_final').text('Rp -');
                    $('#s_sisa').text('Rp -');
                }
            }

            function resetSelect(selector, placeholder) {
                $(selector).empty().append(`<option value="">${placeholder}</option>`);
                $(selector).select2('destroy').select2({
                    placeholder: placeholder,
                    allowClear: true,
                    width: '100%'
                }).prop('disabled', true);
            }

            function setLoadingState(selector, loadingText) {
                $(selector).empty().append(`<option value="">${loadingText}</option>`);
                $(selector).select2('destroy').select2({
                    placeholder: loadingText,
                    allowClear: true,
                    width: '100%'
                }).prop('disabled', true);
            }

            function populateSelect(selector, data, idField, codeField, nameField, placeholder) {
                $(selector).empty().append(`<option value="">${placeholder}</option>`);

                data.forEach(function(item) {
                    const optionText = item[codeField] ?
                        `${item[codeField]} - ${item[nameField]}` :
                        item[nameField];

                    $(selector).append(new Option(optionText, item[idField]));

                    // Set data-label untuk ringkasan
                    $(selector).find('option:last').attr('data-label', optionText);

                    // 🔹 Tambahkan atribut pagu/sisa/realisasi bila ada
                    if (item.total_pagu !== undefined) {
                        $(selector).find('option:last')
                            .attr('data-total_pagu', item.total_pagu)
                            .attr('data-total_realisasi', item.total_realisasi || 0)
                            .attr('data-sisa', item.sisa || 0);
                    }
                });

                $(selector).select2('destroy').select2({
                    placeholder: placeholder,
                    allowClear: true,
                    width: '100%'
                }).prop('disabled', false);
            }


            // Validasi sebelum submit
            $('#form-realisasi').on('submit', function(e) {
                const requiredFields = ['#h_program', '#h_kegiatan', '#h_sub', '#h_rekening', '#h_ssh'];
                const emptyFields = requiredFields.filter(field => !$(field).val());

                if (emptyFields.length > 0) {
                    e.preventDefault();
                    alert(
                        'Lengkapi pilihan Program, Kegiatan, Sub Kegiatan, Rekening, dan SSH terlebih dahulu.'
                    );
                    return false;
                }
            });
        });
    </script>
@endpush
