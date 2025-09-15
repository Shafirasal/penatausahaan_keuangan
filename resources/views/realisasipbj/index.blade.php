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

// Select2 (opsional—aktifkan jika dipakai global)
$('#f_program,#f_kegiatan,#f_sub,#f_rekening,#f_ssh').select2({ width:'100%' });

// helper untuk ringkasan & hidden
function setSel(idSel, idShow, idHidden){
  const $opt = $(idSel).find('option:selected');
  $(idShow).text($opt.data('label') || $opt.text() || '-');
  $(idHidden).val($(idSel).val() || '');
}

// mask rupiah: titik ribuan, koma desimal
$('#i_nilai').on('input', function(){
  let v = this.value.replace(/[^\d,]/g,'');
  let p = v.split(',');
  let i = p[0].replace(/\B(?=(\d{3})+(?!\d))/g,'.');
  this.value = (p[1]!==undefined) ? (i+','+p[1].slice(0,2)) : i;
});

// ===== Cascading =====
// 1) Program → Kegiatan
$('#f_program').on('change', function(){
  const id = $(this).val();
  setSel('#f_program','#s_program','#h_program');

  // reset bawahnya
  $('#f_kegiatan').html('<option value="">-- Pilih Kegiatan --</option>').prop('disabled', !id).trigger('change');
  $('#f_sub').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true).trigger('change');
  $('#f_rekening').html('<option value="">-- Pilih Rekening --</option>').prop('disabled', true).trigger('change');
  $('#f_ssh').html('<option value="">-- Pilih SSH --</option>').prop('disabled', true).trigger('change');
  $('#s_kegiatan,#s_sub,#s_rekening,#s_ssh').text('-'); $('#h_kegiatan,#h_sub,#h_rekening,#h_ssh').val('');

  if(!id) return;
  $.get(`/ssh/program/${id}/kegiatan`, function(data){
    data.forEach(it=>{
      $('#f_kegiatan').append(`<option value="${it.id_kegiatan}" data-label="${it.kode_kegiatan} - ${it.nama_kegiatan}">${it.kode_kegiatan} - ${it.nama_kegiatan}</option>`);
    });
    $('#f_kegiatan').prop('disabled', false);
  });
});

// 2) Kegiatan → Sub
$('#f_kegiatan').on('change', function(){
  const id = $(this).val();
  setSel('#f_kegiatan','#s_kegiatan','#h_kegiatan');

  $('#f_sub').html('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', !id).trigger('change');
  $('#f_rekening').html('<option value="">-- Pilih Rekening --</option>').prop('disabled', true).trigger('change');
  $('#f_ssh').html('<option value="">-- Pilih SSH --</option>').prop('disabled', true).trigger('change');
  $('#s_sub,#s_rekening,#s_ssh').text('-'); $('#h_sub,#h_rekening,#h_ssh').val('');

  if(!id) return;
  $.get(`/ssh/kegiatan/${id}/sub_kegiatan`, function(data){
    data.forEach(it=>{
      $('#f_sub').append(`<option value="${it.id_sub_kegiatan}" data-label="${it.kode_sub_kegiatan} - ${it.nama_sub_kegiatan}">${it.kode_sub_kegiatan} - ${it.nama_sub_kegiatan}</option>`);
    });
    $('#f_sub').prop('disabled', false);
  });
});

// 3) Sub → Rekening
$('#f_sub').on('change', function(){
  const id = $(this).val();
  setSel('#f_sub','#s_sub','#h_sub');

  $('#f_rekening').html('<option value="">-- Pilih Rekening --</option>').prop('disabled', !id).trigger('change');
  $('#f_ssh').html('<option value="">-- Pilih SSH --</option>').prop('disabled', true).trigger('change');
  $('#s_rekening,#s_ssh').text('-'); $('#h_rekening,#h_ssh').val('');

  if(!id) return;
  $.get(`/ssh/sub_kegiatan/${id}/rekening`, function(data){
    data.forEach(it=>{
      $('#f_rekening').append(`<option value="${it.id_rekening}" data-label="${it.kode_rekening} - ${it.nama_rekening}">${it.kode_rekening} - ${it.nama_rekening}</option>`);
    });
    $('#f_rekening').prop('disabled', false);
  });
});

// 4) Rekening → SSH
$('#f_rekening').on('change', function(){
  const id = $(this).val();
  setSel('#f_rekening','#s_rekening','#h_rekening');

  $('#f_ssh').html('<option value="">-- Pilih SSH --</option>').prop('disabled', !id).trigger('change');
  $('#s_ssh').text('-'); $('#h_ssh').val('');

  if(!id) return;
  $.get(`/ssh/rekening/${id}/ssh`, function(data){
    data.forEach(it=>{
      $('#f_ssh').append(`<option value="${it.id_ssh}" data-label="${it.kode_ssh} - ${it.nama_ssh}">${it.kode_ssh} - ${it.nama_ssh}</option>`);
    });
    $('#f_ssh').prop('disabled', false);
  });
});

// 5) SSH → ringkasan + hidden
$('#f_ssh').on('change', function(){
  setSel('#f_ssh','#s_ssh','#h_ssh');
});

// Cegah submit jika filter belum lengkap
$('#form-realisasi').on('submit', function(e){
  if(!$('#h_program').val() || !$('#h_kegiatan').val() || !$('#h_sub').val() || !$('#h_rekening').val() || !$('#h_ssh').val()){
    e.preventDefault();
    alert('Lengkapi pilihan Program, Kegiatan, Sub Kegiatan, Rekening, dan SSH terlebih dahulu.');
  }
});
</script>
@endpush
