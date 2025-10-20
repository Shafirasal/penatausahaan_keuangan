@extends('layouts.template')

@section('title')
    | Form Realisasi Pembinaan
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
                            {{-- Program Locked (TAMPILAN SAJA) --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><strong>Program</strong></label>
                                    <input id="program_display" type="text" class="form-control"
                                        value="{{ $program->kode_program_formatted }} - {{ $program->nama_program }}"
                                        data-label="{{ $program->kode_program_formatted }} - {{ $program->nama_program }}"
                                        readonly>
                                </div>
                            </div>

                            {{-- Kegiatan Locked (TAMPILAN SAJA) --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><strong>Kegiatan</strong></label>
                                    <input id="kegiatan_display" type="text" class="form-control"
                                        value="{{ $kegiatan->kode_kegiatan_formatted }} - {{ $kegiatan->nama_kegiatan }}"
                                        data-label="{{ $kegiatan->kode_kegiatan_formatted }} - {{ $kegiatan->nama_kegiatan }}"
                                        readonly>
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

                            {{-- Row 4: Pagu & Sisa --}}
                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label><strong>Pagu</strong></label>
                                    <div class="border rounded p-2 bg-light">
                                        <p class="mb-0 font-weight-bold text-dark" id="s_pagu_final">Rp -</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label><strong>Sisa</strong></label>
                                    <div class="border rounded p-2 bg-light">
                                        <p class="mb-0 font-weight-bold text-dark" id="s_sisa">Rp -</p>
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
        <form action="{{ url('/realisasipembinaan/store') }}" method="POST" enctype="multipart/form-data"
            id="form-tambah">
            @csrf
            {{-- hidden IDs (HANYA DI DALAM FORM) --}}
            <input type="hidden" name="id_program" id="h_program" value="{{ $program->id_program }}">
            <input type="hidden" name="id_kegiatan" id="h_kegiatan" value="{{ $kegiatan->id_kegiatan }}">
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
                                <label>Nomor Dokumen <span class="text-danger">*</span></label>
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
                                <small id="error_realisasi" class="text-danger d-none"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Realisasi <span class="text-danger">*</span></label>
                                <input type="date" id="tanggal_realisasi" name="tanggal_realisasi"
                                    class="form-control" value="{{ now()->toDateString() }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>File Upload</label>
                                <input type="file" id="file" name="file" class="form-control">
                            </div>
                        </div>

                        {{-- Jika butuh keterangan, buka ini
          <div class="col-12">
            <div class="form-group mb-0">
              <label>Keterangan</label>
              <textarea name="keterangan" rows="3" class="form-control">{{ old('keterangan') }}</textarea>
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
        {{-- ===================== HISTORI REALISASI ===================== --}}
        <div class="card mt-4">
            <div class="card-header">
                <h4>Histori Realisasi</h4>
            </div>
            <div class="card-body p-3">
                <div class="card-body p-0">
                    <table class="table table-striped mb-0" id="tbl-histori">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>No Dokumen</th>
                                <th>Nilai Realisasi</th>
                                <th>Tanggal</th>
                                <th>File</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let sisaGlobal = 0;

        $(document).ready(function() {

            function modalParent() {
                return ($('#myModal').length ? $('#myModal') : $(document.body));
            }
            const dp = {
                dropdownParent: modalParent(),
                allowClear: true,
                width: '100%'
            };
            // ========== INIT Select2 untuk filter ==========
            $('#f_sub').select2({
                placeholder: "-- Pilih Sub Kegiatan --",
                allowClear: true,
                width: '100%'
            }).prop('disabled', false);
            $('#f_rekening').select2({
                placeholder: "-- Pilih Rekening --",
                allowClear: true,
                width: '100%'
            }).prop('disabled', true);
            $('#f_ssh').select2({
                placeholder: "-- Pilih SSH --",
                allowClear: true,
                width: '100%'
            }).prop('disabled', true);

            // ========== Helper ringkasan + hidden ==========
            function setSel(idSel, idShow, idHidden) {
                const $opt = $(idSel).find('option:selected');
                $(idShow).text($opt.data('label') || $opt.text() || '-');
                $(idHidden).val($(idSel).val() || '');
            }

            // Set ringkasan awal dari display (program/kegiatan locked)
            // Set ringkasan awal dari display (program/kegiatan locked)
            $('#s_program').text($('#program_display').data('label'));
            $('#s_kegiatan').text($('#kegiatan_display').data('label'));

            // Ambil summary kegiatan (pagu & sisa saja)
            const kegiatanId = $('#h_kegiatan').val();
            if (kegiatanId) {
                $.get(`/realisasipembinaan/kegiatan/${kegiatanId}/summary`)
                    .done(function(resp) {
                        if (resp?.success) {
                            const {
                                total_pagu,
                                sisa
                            } = resp.data; // <-- total_realisasi diabaikan
                            $('#s_pagu_final').text(formatRupiah(total_pagu));
                            $('#s_sisa').text(formatRupiah(sisa));
                        }
                    });

                // Load sub kegiatan awal
                $.get(`/realisasipembinaan/kegiatan/${kegiatanId}/sub_kegiatan`)
                    .done(function(resp) {
                        if (resp?.success) {
                            populateSelect('#f_sub', resp.data, 'id_sub_kegiatan', 'kode_sub_kegiatan',
                                'nama_sub_kegiatan', '-- Pilih Sub Kegiatan --');
                        } else {
                            alert('Gagal memuat data sub kegiatan: ' + (resp?.message || ''));
                            resetSelect('#f_sub', '-- Pilih Sub Kegiatan --');
                        }
                    })
                    .fail(function() {
                        alert('Gagal memuat data sub kegiatan.');
                        resetSelect('#f_sub', '-- Pilih Sub Kegiatan --');
                    });
            }

            // Sub -> Rekening
            $('#f_sub').on('select2:select select2:clear', function(e) {
                const $opt = $(this).find('option:selected');
                setSel('#f_sub', '#s_sub', '#h_sub');
                resetDropdowns(['rekening', 'ssh']);

                if (e.type === 'select2:select' && $opt.length) {
                    const pagu_final = $opt.data('total_pagu') || 0;
                    const sisa = $opt.data('sisa') || 0;

                    $('#s_pagu_final').text(formatRupiah(pagu_final));
                    $('#s_sisa').text(formatRupiah(sisa));

                    const subId = $opt.val();
                    setLoadingState('#f_rekening', 'Loading...');
                    $.get(`/realisasipembinaan/sub_kegiatan/${subId}/rekening`)
                        .done(function(resp) {
                            if (resp?.success) {
                                populateSelect('#f_rekening', resp.data, 'id_rekening', 'kode_rekening',
                                    'nama_rekening', '-- Pilih Rekening --');
                            } else {
                                alert('Gagal memuat data rekening: ' + (resp?.message || ''));
                                resetSelect('#f_rekening', '-- Pilih Rekening --');
                            }
                        })
                        .fail(function() {
                            alert('Gagal memuat data rekening.');
                            resetSelect('#f_rekening', '-- Pilih Rekening --');
                        });
                }
            });

            // Rekening -> SSH
            $('#f_rekening').on('select2:select select2:clear', function(e) {
                const $opt = $(this).find('option:selected');
                setSel('#f_rekening', '#s_rekening', '#h_rekening');
                resetDropdowns(['ssh']);

                if (e.type === 'select2:select' && $opt.length) {
                    const pagu_final = $opt.data('total_pagu') || 0;
                    const sisa = $opt.data('sisa') || 0;

                    $('#s_pagu_final').text(formatRupiah(pagu_final));
                    $('#s_sisa').text(formatRupiah(sisa));

                    const rekeningId = $opt.val();
                    setLoadingState('#f_ssh', 'Loading...');
                    $.get(`/realisasipembinaan/rekening/${rekeningId}/ssh`)
                        .done(function(resp) {
                            if (resp?.success) {
                                $('#f_ssh').empty().append(`<option value="">-- Pilih SSH --</option>`);
                                resp.data.forEach(function(item) {
                                    const label = `${item.kode_ssh} - ${item.nama_ssh}`;
                                    const opt = new Option(label, item.id_ssh);
                                    $(opt).attr('data-label', label)
                                        .attr('data-pagu_final', item.pagu_final)
                                        .attr('data-sisa', item.sisa);
                                    $('#f_ssh').append(opt);
                                });
                                $('#f_ssh').select2('destroy').select2({
                                    placeholder: '-- Pilih SSH --',
                                    allowClear: true,
                                    width: '100%'
                                }).prop('disabled', false);
                            } else {
                                alert('Error: ' + (resp?.error || ''));
                                resetSelect('#f_ssh', '-- Pilih SSH --');
                            }
                        })
                        .fail(function() {
                            alert('Gagal memuat data SSH.');
                            resetSelect('#f_ssh', '-- Pilih SSH --');
                        });
                }
            });

            // SSH -> Ringkasan (tanpa realisasi)
            $('#f_ssh').on('select2:select select2:clear', function() {
                setSel('#f_ssh', '#s_ssh', '#h_ssh');
                const $opt = $(this).find('option:selected');
                const pagu_final = $opt.data('pagu_final') || 0;
                const sisa = $opt.data('sisa') || 0;

                sisaGlobal = sisa;
                $('#s_pagu_final').text(formatRupiah(pagu_final));
                $('#s_sisa').text(formatRupiah(sisa));

                // 🔹 panggil histori realisasi SSH yg dipilih
                const sshId = $opt.val();
                if (sshId) {
                    initHistoriTable(sshId);
                } else {
                    if (historiTable) {
                        historiTable.clear().draw();
                    }
                }

                //reset error setiap ganti ssh
                $('#error_realisasi').text('').addClass('d-none');
            });

            // validasi di input realisasi (pakai event delegation)
            $(document).on('input', '#i_nilai', function() {
                let val = $(this).val().replace(/\./g, '').replace(',', '.');
                let nilai = parseFloat(val) || 0;

                if (nilai > sisaGlobal) {
                    $('#error_realisasi')
                        .text("Nilai realisasi melebihi sisa anggaran (Rp " + sisaGlobal.toLocaleString(
                            "id-ID") + ")")
                        .removeClass('d-none');

                    // disable input tanggal & file
                    $('#tanggal_realisasi').prop('disabled', true);
                    $('#file').prop('disabled', true);
                } else {
                    $('#error_realisasi').text('').addClass('d-none');

                    // aktifkan kembali input tanggal & file
                    $('#tanggal_realisasi').prop('disabled', false);
                    $('#file').prop('disabled', false);
                }
            });

            // resetDropdowns: hapus reset #s_realisasi
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
                dropdowns.forEach(function(d) {
                    const c = config[d];
                    if (!c) return;
                    resetSelect(c.selector, c.placeholder);
                    $(c.summary).text('-');
                    $(c.hidden).val('');
                });
                if (dropdowns.includes('ssh')) {
                    $('#s_pagu_final').text('Rp -');
                    $('#s_sisa').text('Rp -');
                }
            }


            function resetSelect(selector, placeholder) {
                $(selector).empty().append(`<option value="">${placeholder}</option>`);
                $(selector).select2('destroy').select2({
                    placeholder,
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
                    const text = item[codeField] ? `${item[codeField]} - ${item[nameField]}` : item[
                        nameField];
                    $(selector).append(new Option(text, item[idField]));
                    $(selector).find('option:last').attr('data-label', text);
                    if (item.total_pagu !== undefined) {
                        $(selector).find('option:last')
                            .attr('data-total_pagu', item.total_pagu)
                            .attr('data-total_realisasi', item.total_realisasi || 0)
                            .attr('data-sisa', item.sisa || 0);
                    }
                });
                $(selector).select2('destroy').select2({
                    placeholder,
                    allowClear: true,
                    width: '100%'
                }).prop('disabled', false);
            }

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(angka || 0);
            }

            // ========== Tambahan SIMPAN: masker, validate, AJAX ==========
            // Masker angka (nyaman diketik)
            $('#i_nilai').on('input', function() {
                let v = this.value.replace(/[^\d]/g, '');
                this.value = v ? parseInt(v, 10).toLocaleString('id-ID') : '';
            });

            // Rule filesize untuk validate
            $.validator.addMethod("filesize", function(value, element, param) {
                if (this.optional(element) || !element.files || !element.files[0]) return true;
                return element.files[0].size <= param;
            }, "Ukuran file terlalu besar.");

            // VALIDATE + AJAX submit
            $("#form-tambah").validate({
                ignore: [],
                rules: {
                    id_program: {
                        required: true
                    },
                    id_kegiatan: {
                        required: true
                    },
                    id_sub_kegiatan: {
                        required: true
                    },
                    id_rekening: {
                        required: true
                    },
                    id_ssh: {
                        required: true
                    },
                    jenis_realisasi: {
                        required: true
                    },
                    no_dokumen: {
                        maxlength: 50,
                        required: true
                    },
                    nilai_realisasi: {
                        required: true,
                        number: true,
                        min: 1,
                        normalizer: function(value) {
                            const v = (value || '').replace(/[^\d]/g, '');
                            return v ? String(parseInt(v, 10)) : '';
                        }
                    },
                    tanggal_realisasi: {
                        required: true
                    },
                    file: {
                        extension: "pdf,jpg,jpeg,png,doc,docx",
                        filesize: 5 * 1024 * 1024
                    }
                },
                messages: {
                    id_program: {
                        required: "Program wajib dipilih."
                    },
                    id_kegiatan: {
                        required: "Kegiatan wajib dipilih."
                    },
                    id_sub_kegiatan: {
                        required: "Sub kegiatan wajib dipilih."
                    },
                    id_rekening: {
                        required: "Rekening wajib dipilih."
                    },
                    id_ssh: {
                        required: "SSH wajib dipilih."
                    },
                    jenis_realisasi: {
                        required: "Jenis realisasi wajib dipilih."
                    },
                    no_dokumen: {
                        maxlength: "Maksimal 50 karakter."
                    },
                    nilai_realisasi: {
                        required: "Nilai realisasi wajib diisi.",
                        number: "Masukkan angka yang valid.",
                        min: "Nilai realisasi harus lebih dari 0."
                    },
                    tanggal_realisasi: {
                        required: "Tanggal realisasi wajib diisi."
                    },
                    file: {
                        extension: "Format file harus pdf, jpg, jpeg, png, doc, atau docx.",
                        filesize: "Ukuran file maksimum 5 MB."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    if (element.hasClass('select2-hidden-accessible')) {
                        element.next('.select2').closest('.form-group').append(error);
                    } else {
                        element.closest('.form-group').append(error);
                    }
                },
                highlight: function(element) {
                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2').find('.select2-selection').addClass('is-invalid');
                    } else {
                        $(element).addClass('is-invalid');
                    }
                },
                unhighlight: function(element) {
                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2').find('.select2-selection').removeClass(
                            'is-invalid');
                    } else {
                        $(element).removeClass('is-invalid');
                    }
                },
                submitHandler: function(form) {
                    // Ambil nilai realisasi & normalisasi
                    const nilaiRaw = $('#i_nilai').val() || '';
                    const nilaiClean = nilaiRaw.replace(/\./g, '').replace(',',
                        '.'); // ganti ribuan & desimal
                    const nilai = parseFloat(nilaiClean) || 0;

                    // Cek terhadap sisaGlobal
                    if (nilai > sisaGlobal) {
                        // tampilkan error di bawah input
                        $('#error_realisasi')
                            .text("Nilai realisasi melebihi sisa anggaran (Rp " + sisaGlobal
                                .toLocaleString("id-ID") + ")")
                            .removeClass('d-none');

                        // stop submit
                        return false;
                    } else {
                        // clear error jika valid
                        $('#error_realisasi').text('').addClass('d-none');
                    }
                    let $hidden = $(form).find('input[name="nilai_realisasi_clean"]');
                    if ($hidden.length === 0) {
                        $('<input>', {
                            type: 'hidden',
                            name: 'nilai_realisasi_clean',
                            value: nilaiClean
                        }).appendTo(form);
                    } else {
                        $hidden.val(nilaiClean);
                    }

                    const fd = new FormData(form);

                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            if (res?.status) {
                                Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: res.message || 'Data tersimpan.'
                                    })
                                    .then(() => {
                                        // ── 1) kosongkan hanya form tambah
                                        $('#form-tambah')[0].reset();
                                        $('#i_nilai').val('');
                                        $('input[name="file"]').val('');

                                        // ── 2) jangan reset dropdown filter (sub/rekening/ssh)
                                        // biarkan pilihan user tetap

                                        // ── 3) update ulang pagu & sisa berdasarkan SSH yg aktif
                                        const sshId = $('#h_ssh').val();
                                        if (sshId) {
                                            $.get(`/realisasipembinaan/ssh/${sshId}/summary`, {
                                                    _: Date.now()
                                                })
                                                .done(function(resp) {
                                                    if (resp?.success) {
                                                        $('#s_pagu_final').text(
                                                            formatRupiah(resp
                                                                .data.pagu_final
                                                            ));
                                                        $('#s_sisa').text(
                                                            formatRupiah(resp
                                                                .data.sisa));
                                                        const $opt = $(
                                                            `#f_ssh option[value="${sshId}"]`
                                                        );
                                                        if ($opt.length) {
                                                            $opt.attr(
                                                                    'data-pagu_final',
                                                                    resp.data
                                                                    .pagu_final)
                                                                .attr('data-sisa',
                                                                    resp.data.sisa);
                                                        }
                                                        // update variabel global sisa
                                                        sisaGlobal = resp.data.sisa;
                                                        // refresh histori
                                                        initHistoriTable(sshId);
                                                    }
                                                });
                                        }
                                    });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: res?.message || 'Terjadi kesalahan.'
                                });
                            }
                        },


                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                                const errors = xhr.responseJSON.errors;
                                $.each(errors, function(field, messages) {
                                    const $field = $(`[name="${field}"]`);
                                    if ($field.length) {
                                        const $group = $field.hasClass(
                                                'select2-hidden-accessible') ?
                                            $field.next('.select2').closest(
                                                '.form-group') : $field.closest(
                                                '.form-group');
                                        const $err = $(
                                            '<span class="invalid-feedback"></span>'
                                        ).text(messages[0]);
                                        $group.append($err);
                                        if ($field.hasClass(
                                                'select2-hidden-accessible')) {
                                            $field.next('.select2').find(
                                                '.select2-selection').addClass(
                                                'is-invalid');
                                        } else {
                                            $field.addClass('is-invalid');
                                        }
                                    }
                                    $('#error-' + field).text(messages[
                                        0]); // kalau ada span manual
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validasi Gagal',
                                    text: 'Silakan periksa inputan Anda.'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Server Error',
                                    text: 'Terjadi kesalahan di server.'
                                });
                            }
                        }
                    });
                    return false; // cegah submit normal
                }
            });

            let historiTable;

            function initHistoriTable(sshId) {
                if (historiTable) {
                    historiTable.destroy(); // hapus instance lama
                    $('#tbl-histori').empty(); // kosongkan isi tabel
                    $('#tbl-histori').html(`
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>No Dokumen</th>
                    <th>Nilai (Rp)</th>
                    <th>Tanggal</th>
                    <th>File</th>
                </tr>
            </thead>
        `);
                }

                historiTable = $('#tbl-histori').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: `/realisasilpse/ssh/${sshId}/histori`,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'jenis_realisasi',
                            name: 'jenis_realisasi'
                        },
                        {
                            data: 'no_dokumen',
                            name: 'no_dokumen'
                        },
                        {
                            data: 'nilai_realisasi',
                            name: 'nilai_realisasi',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'tanggal_realisasi',
                            name: 'tanggal_realisasi'
                        },

                        {
                            data: 'file',
                            className: '',
                            render: function(data, type, row) {
                                if (!data) return '-';

                                // Ambil nama file dari path
                                const fileName = data.split('/').pop().replace(/^\d{10}_/, '');

                                return `
                        <a href="/storage/${data}" download="${fileName}" title="Klik untuk download">
                        ${fileName}
                        </a>
                    `;
                            }
                        }
                    ]
                });
            }

            // Bersihkan error UI saat user memilih ulang select2
            $('#f_sub,#f_rekening,#f_ssh').on('select2:select select2:clear', function() {
                $(this).next('.select2').find('.select2-selection').removeClass('is-invalid');
                $(this).next('.select2').closest('.form-group').find('.invalid-feedback').remove();
            });
        });
    </script>
@endpush
