@extends('layouts.template')

@section('title') | Form Realisasi @endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>{{ $breadcrumb->title }}</h1>
    @include('layouts.breadcrumb', ['list' => $breadcrumb->list])
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  {{-- ===================== INFORMASI PAKET ===================== --}}
  <div class="card">
    <div class="card-header"><h4>Informasi Paket</h4></div>
    <div class="card-body">
      <div class="row">
        {{-- KIRI: filter bertingkat (2 atas, 2 bawah, SSH full) --}}
        <div class="col-lg-7">
          <div class="row">
            {{-- Row 1 --}}
            <div class="col-sm-6">
              <div class="form-group">
                <label><strong>Program</strong></label>
                <select id="f_program" class="form-control">
                  <option value="">-- Pilih Program --</option>
                  @foreach ($listProgram as $p)
                    <option value="{{ $p->id_program }}"
                            data-label="{{ $p->kode_program.' - '.$p->nama_program }}">
                      {{ $p->kode_program }} - {{ $p->nama_program }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label><strong>Kegiatan</strong></label>
                <select id="f_kegiatan" class="form-control" disabled>
                  <option value="">-- Pilih Kegiatan --</option>
                </select>
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
          </div>
        </div>

        {{-- KANAN: ringkasan pilihan --}}
        <div class="col-lg-5">
          <div class="card border">
            <div class="card-header py-2"><strong>Ringkasan Pilihan</strong></div>
            <div class="card-body p-0">
              <table class="table mb-0">
                <tr><th style="width:180px">Program</th>     <td id="s_program">-</td></tr>
                <tr><th>Kegiatan</th>                         <td id="s_kegiatan">-</td></tr>
                <tr><th>Sub Kegiatan</th>                     <td id="s_sub">-</td></tr>
                <tr><th>Rekening</th>                         <td id="s_rekening">-</td></tr>
                <tr><th>SSH</th>                              <td id="s_ssh">-</td></tr>
              </table>
            </div>
          </div>
          <small class="text-muted">Pastikan ringkasan sesuai sebelum menambah data realisasi.</small>
        </div>
      </div>
    </div>
  </div>

  {{-- ===================== FORM REALISASI ===================== --}}
  <form action="{{ url('/realisasipbj/store') }}" method="POST" enctype="multipart/form-data" id="form-realisasi">
    @csrf
    {{-- hidden IDs dari filter --}}
    <input type="hidden" name="id_program" id="h_program">
    <input type="hidden" name="id_kegiatan" id="h_kegiatan">
    <input type="hidden" name="id_sub_kegiatan" id="h_sub">
    <input type="hidden" name="id_rekening" id="h_rekening">
    <input type="hidden" name="id_ssh" id="h_ssh">

    <div class="card">
      <div class="card-header"><h4>Realisasi</h4></div>
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
              <input type="text" name="no_dokumen" class="form-control" value="{{ old('no_dokumen') }}">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Nilai Realisasi (Rp) <span class="text-danger">*</span></label>
              <input type="text" name="nilai_realisasi" id="i_nilai" class="form-control" placeholder="1.000,00" required>
              <small class="form-text text-muted">Gunakan koma untuk pemisah desimal.</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Tanggal Realisasi <span class="text-danger">*</span></label>
              <input type="date" name="tanggal_realisasi" class="form-control" value="{{ now()->toDateString() }}" required>
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
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function() {
    // Inisialisasi Select2 yang benar
    $('#f_program').select2({
        placeholder: "-- Pilih Program --",
        allowClear: true,
        width: '100%'
    });

    $('#f_kegiatan').select2({
        placeholder: "-- Pilih Kegiatan --",
        allowClear: true,
        width: '100%'
    }).prop('disabled', true);

    $('#f_sub').select2({
        placeholder: "-- Pilih Sub Kegiatan --",
        allowClear: true,
        width: '100%'
    }).prop('disabled', true);

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

    // Helper untuk ringkasan & hidden
    function setSel(idSel, idShow, idHidden){
        const $opt = $(idSel).find('option:selected');
        $(idShow).text($opt.data('label') || $opt.text() || '-');
        $(idHidden).val($(idSel).val() || '');
    }

    // Mask rupiah: titik ribuan, koma desimal
    $('#i_nilai').on('input', function(){
        let v = this.value.replace(/[^\d,]/g,'');
        let p = v.split(',');
        let i = p[0].replace(/\B(?=(\d{3})+(?!\d))/g,'.');
        this.value = (p[1]!==undefined) ? (i+','+p[1].slice(0,2)) : i;
    });

    // ===== Cascading dengan Select2 Events =====
    // 1) Program → Kegiatan
    $('#f_program').on('select2:select select2:clear', function(e) {
        const programId = $(this).val();
        setSel('#f_program','#s_program','#h_program');

        // Reset semua dropdown di bawahnya
        resetDropdowns(['kegiatan', 'sub', 'rekening', 'ssh']);

        if (e.type === 'select2:select' && programId) {
            // Set loading state
            setLoadingState('#f_kegiatan', 'Loading...');
            
            $.get(`/realisasipbj/program/${programId}/kegiatan`)
            .done(function(data) {
                populateSelect('#f_kegiatan', data, 'id_kegiatan', 'kode_kegiatan', 'nama_kegiatan', '-- Pilih Kegiatan --');
            })
            .fail(function(xhr) {
                console.error('Error loading kegiatan:', xhr);
                alert('Gagal memuat data kegiatan. Silakan coba lagi.');
                resetSelect('#f_kegiatan', '-- Pilih Kegiatan --');
            });
        }
    });

    // 2) Kegiatan → Sub Kegiatan
    $('#f_kegiatan').on('select2:select select2:clear', function(e) {
        const kegiatanId = $(this).val();
        setSel('#f_kegiatan','#s_kegiatan','#h_kegiatan');

        // Reset dropdown di bawahnya
        resetDropdowns(['sub', 'rekening', 'ssh']);

        if (e.type === 'select2:select' && kegiatanId) {
            setLoadingState('#f_sub', 'Loading...');
            
            $.get(`/realisasipbj/kegiatan/${kegiatanId}/sub_kegiatan`)
            .done(function(data) {
                populateSelect('#f_sub', data, 'id_sub_kegiatan', 'kode_sub_kegiatan', 'nama_sub_kegiatan', '-- Pilih Sub Kegiatan --');
            })
            .fail(function(xhr) {
                console.error('Error loading sub kegiatan:', xhr);
                alert('Gagal memuat data sub kegiatan. Silakan coba lagi.');
                resetSelect('#f_sub', '-- Pilih Sub Kegiatan --');
            });
        }
    });

    // 3) Sub Kegiatan → Rekening
    $('#f_sub').on('select2:select select2:clear', function(e) {
        const subId = $(this).val();
        setSel('#f_sub','#s_sub','#h_sub');

        // Reset dropdown di bawahnya
        resetDropdowns(['rekening', 'ssh']);

        if (e.type === 'select2:select' && subId) {
            setLoadingState('#f_rekening', 'Loading...');
            
            $.get(`/realisasipbj/sub_kegiatan/${subId}/rekening`)
            .done(function(data) {
                populateSelect('#f_rekening', data, 'id_rekening', 'kode_rekening', 'nama_rekening', '-- Pilih Rekening --');
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
        const rekeningId = $(this).val();
        setSel('#f_rekening','#s_rekening','#h_rekening');

        // Reset dropdown SSH
        resetDropdowns(['ssh']);

        if (e.type === 'select2:select' && rekeningId) {
            setLoadingState('#f_ssh', 'Loading...');
            
            $.get(`/realisasipbj/rekening/${rekeningId}/ssh`)
            .done(function(response) {
                console.log('SSH Response:', response);
                
                if (response.success) {
                    populateSelect('#f_ssh', response.data, 'id_ssh', 'kode_ssh', 'nama_ssh', '-- Pilih SSH --');
                    console.log(`SSH loaded: ${response.count} records found`);
                } else {
                    alert('Error: ' + response.error);
                    resetSelect('#f_ssh', '-- Pilih SSH --');
                }
            })
            .fail(function(xhr) {
                console.error('Error loading SSH:', xhr);
                console.error('Response:', xhr.responseText);
                alert('Gagal memuat data SSH. Silakan coba lagi.');
                resetSelect('#f_ssh', '-- Pilih SSH --');
            });
        }
    });

    // 5) SSH → ringkasan + hidden
    $('#f_ssh').on('select2:select select2:clear', function() {
        setSel('#f_ssh','#s_ssh','#h_ssh');
    });

    // ===== Helper Functions =====
    function resetDropdowns(dropdowns) {
        const config = {
            'kegiatan': { selector: '#f_kegiatan', placeholder: '-- Pilih Kegiatan --', summary: '#s_kegiatan', hidden: '#h_kegiatan' },
            'sub': { selector: '#f_sub', placeholder: '-- Pilih Sub Kegiatan --', summary: '#s_sub', hidden: '#h_sub' },
            'rekening': { selector: '#f_rekening', placeholder: '-- Pilih Rekening --', summary: '#s_rekening', hidden: '#h_rekening' },
            'ssh': { selector: '#f_ssh', placeholder: '-- Pilih SSH --', summary: '#s_ssh', hidden: '#h_ssh' }
        };

        dropdowns.forEach(function(dropdown) {
            const conf = config[dropdown];
            if (conf) {
                resetSelect(conf.selector, conf.placeholder);
                $(conf.summary).text('-');
                $(conf.hidden).val('');
            }
        });
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
            
            // Set data-label untuk summary
            $(selector).find('option:last').attr('data-label', optionText);
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
            alert('Lengkapi pilihan Program, Kegiatan, Sub Kegiatan, Rekening, dan SSH terlebih dahulu.');
            return false;
        }
    });
});
</script>
@endpush

{{-- @push('js')
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function() {
    // Inisialisasi Select2 yang benar
    $('#f_program').select2({
        placeholder: "-- Pilih Program --",
        allowClear: true,
        width: '100%'
    });

    $('#f_kegiatan').select2({
        placeholder: "-- Pilih Kegiatan --",
        allowClear: true,
        width: '100%'
    }).prop('disabled', true);

    $('#f_sub').select2({
        placeholder: "-- Pilih Sub Kegiatan --",
        allowClear: true,
        width: '100%'
    }).prop('disabled', true);

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

    // Helper untuk ringkasan & hidden
    function setSel(idSel, idShow, idHidden){
        const $opt = $(idSel).find('option:selected');
        $(idShow).text($opt.data('label') || $opt.text() || '-');
        $(idHidden).val($(idSel).val() || '');
    }

    // Mask rupiah: titik ribuan, koma desimal
    $('#i_nilai').on('input', function(){
        let v = this.value.replace(/[^\d,]/g,'');
        let p = v.split(',');
        let i = p[0].replace(/\B(?=(\d{3})+(?!\d))/g,'.');
        this.value = (p[1]!==undefined) ? (i+','+p[1].slice(0,2)) : i;
    });

    // ===== Cascading dengan Select2 Events =====
    // 1) Program → Kegiatan
    $('#f_program').on('select2:select select2:clear', function(e) {
        const programId = $(this).val();
        setSel('#f_program','#s_program','#h_program');

        // Reset semua dropdown di bawahnya
        resetDropdowns(['kegiatan', 'sub', 'rekening', 'ssh']);

        if (e.type === 'select2:select' && programId) {
            // Set loading state
            setLoadingState('#f_kegiatan', 'Loading...');
            
            $.get(`/ssh/program/${programId}/kegiatan`)
            .done(function(data) {
                populateSelect('#f_kegiatan', data, 'id_kegiatan', 'kode_kegiatan', 'nama_kegiatan', '-- Pilih Kegiatan --');
            })
            .fail(function(xhr) {
                console.error('Error loading kegiatan:', xhr);
                alert('Gagal memuat data kegiatan. Silakan coba lagi.');
                resetSelect('#f_kegiatan', '-- Pilih Kegiatan --');
            });
        }
    });

    // 2) Kegiatan → Sub Kegiatan
    $('#f_kegiatan').on('select2:select select2:clear', function(e) {
        const kegiatanId = $(this).val();
        setSel('#f_kegiatan','#s_kegiatan','#h_kegiatan');

        // Reset dropdown di bawahnya
        resetDropdowns(['sub', 'rekening', 'ssh']);

        if (e.type === 'select2:select' && kegiatanId) {
            setLoadingState('#f_sub', 'Loading...');
            
            $.get(`/ssh/kegiatan/${kegiatanId}/sub_kegiatan`)
            .done(function(data) {
                populateSelect('#f_sub', data, 'id_sub_kegiatan', 'kode_sub_kegiatan', 'nama_sub_kegiatan', '-- Pilih Sub Kegiatan --');
            })
            .fail(function(xhr) {
                console.error('Error loading sub kegiatan:', xhr);
                alert('Gagal memuat data sub kegiatan. Silakan coba lagi.');
                resetSelect('#f_sub', '-- Pilih Sub Kegiatan --');
            });
        }
    });

    // 3) Sub Kegiatan → Rekening
    $('#f_sub').on('select2:select select2:clear', function(e) {
        const subId = $(this).val();
        setSel('#f_sub','#s_sub','#h_sub');

        // Reset dropdown di bawahnya
        resetDropdowns(['rekening', 'ssh']);

        if (e.type === 'select2:select' && subId) {
            setLoadingState('#f_rekening', 'Loading...');
            
            $.get(`/ssh/sub_kegiatan/${subId}/rekening`)
            .done(function(data) {
                populateSelect('#f_rekening', data, 'id_rekening', 'kode_rekening', 'nama_rekening', '-- Pilih Rekening --');
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
        const rekeningId = $(this).val();
        setSel('#f_rekening','#s_rekening','#h_rekening');

        // Reset dropdown SSH
        resetDropdowns(['ssh']);

        if (e.type === 'select2:select' && rekeningId) {
            setLoadingState('#f_ssh', 'Loading...');
            
            $.get(`/ssh/rekening/${rekeningId}/ssh`)
            .done(function(data) {
                populateSelect('#f_ssh', data, 'id_ssh', 'kode_ssh', 'nama_ssh', '-- Pilih SSH --');
            })
            .fail(function(xhr) {
                console.error('Error loading SSH:', xhr);
                alert('Gagal memuat data SSH. Silakan coba lagi.');
                resetSelect('#f_ssh', '-- Pilih SSH --');
            });
        }
    });

    // 5) SSH → ringkasan + hidden
    $('#f_ssh').on('select2:select select2:clear', function() {
        setSel('#f_ssh','#s_ssh','#h_ssh');
    });

    // ===== Helper Functions =====
    function resetDropdowns(dropdowns) {
        const config = {
            'kegiatan': { selector: '#f_kegiatan', placeholder: '-- Pilih Kegiatan --', summary: '#s_kegiatan', hidden: '#h_kegiatan' },
            'sub': { selector: '#f_sub', placeholder: '-- Pilih Sub Kegiatan --', summary: '#s_sub', hidden: '#h_sub' },
            'rekening': { selector: '#f_rekening', placeholder: '-- Pilih Rekening --', summary: '#s_rekening', hidden: '#h_rekening' },
            'ssh': { selector: '#f_ssh', placeholder: '-- Pilih SSH --', summary: '#s_ssh', hidden: '#h_ssh' }
        };

        dropdowns.forEach(function(dropdown) {
            const conf = config[dropdown];
            if (conf) {
                resetSelect(conf.selector, conf.placeholder);
                $(conf.summary).text('-');
                $(conf.hidden).val('');
            }
        });
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
            
            // Set data-label untuk summary
            $(selector).find('option:last').attr('data-label', optionText);
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
            alert('Lengkapi pilihan Program, Kegiatan, Sub Kegiatan, Rekening, dan SSH terlebih dahulu.');
            return false;
        }
    });
});
</script>
@endpush --}}