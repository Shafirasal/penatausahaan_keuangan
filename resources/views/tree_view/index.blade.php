@extends('layouts.template')

@section('title') | Tree View SSH @endsection

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
            <table id="table_tree" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
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
              <tbody>
                    {{-- Data dimuat via DataTables --}}
              </tbody>
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

<style>
/* Child table styling - terlihat seperti bukan tabel tapi tetap aligned */
.ssh-child-row {
  background-color: transparent !important;
}

.ssh-child-table {
  width: 100%;
  margin: 0;
  background: transparent;
  border: none;
  border-collapse: collapse;
  table-layout: fixed; /* Penting untuk alignment yang tepat */
}

.ssh-child-table td {
  border: none !important;
  padding: 8px 12px;
  vertical-align: middle;
  background: transparent !important;
  border-bottom: 1px solid #dee2e6 !important; /* Hanya border bawah seperti parent */
}

/* Sesuaikan width kolom child dengan parent */
.ssh-child-table td:nth-child(1) { width: 48px; }      /* Expand column */
.ssh-child-table td:nth-child(2) { width: auto; }      /* Kode */
.ssh-child-table td:nth-child(3) { width: auto; }      /* Uraian */
.ssh-child-table td:nth-child(4) { width: 120px; }     /* Periode 1 */
.ssh-child-table td:nth-child(5) { width: 120px; }     /* Periode 2 */
.ssh-child-table td:nth-child(6) { width: 120px; }     /* Realisasi */
.ssh-child-table td:nth-child(7) { width: 120px; }     /* Sisa */

.ssh-item-row {
  transition: background-color 0.2s ease;
}

.ssh-item-row:hover {
  background-color: #f8f9fa !important; /* Hover effect seperti parent */
}

.ssh-item-row:last-child td {
  border-bottom: none !important; /* Hilangkan border di item terakhir */
}

/* Styling untuk placeholder expand button */
.ssh-expand-cell {
  text-align: center;
  background-color: transparent !important;
}

.ssh-expand-placeholder {
  width: 16px;
  height: 16px;
  background-color: transparent;
  border: 1px solid #dee2e6;
  border-radius: 2px;
  margin: 0 auto;
  opacity: 0.3;
}

/* Styling untuk kode SSH - minimal indent */
/* .ssh-kode {
  font-family: 'Courier New', monospace;
  font-weight: 500;
  color: #6c757d;
  font-size: 12px;
  padding-left: 10px; 
} */

/* Styling untuk uraian SSH - bersih tanpa garis */
.ssh-uraian {
  /* color: #6c757d;
  font-size: 13px;
  padding-left: 20px; Indent sedang untuk menunjukkan hierarchy */
  font-weight: 400;
  line-height: 1.4;
}

/* Styling untuk nilai-nilai numerik */
.ssh-nilai {
  text-align: right;
  /* font-weight: 400;
  font-family: 'Courier New', monospace; */
  /* font-size: 12px; */
  color: #6c757d;
}

/* State untuk loading, empty, dan error */
.ssh-loading,
.ssh-empty-state,
.ssh-error-state {
  text-align: center;
  padding: 15px;
  font-style: italic;
  font-size: 13px;
}

.ssh-loading {
  color: #007bff;
}

.ssh-empty-state {
  color: #6c757d;
}

.ssh-error-state {
  color: #dc3545;
}

.ssh-loading i,
.ssh-empty-state i,
.ssh-error-state i {
  margin-right: 6px;
}

/* Ensure parent table child row tidak ada padding */
#table_tree tbody tr.child td {
  padding: 0 !important;
  background-color: transparent !important;
  border: none !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .ssh-child-table td {
    padding: 6px 8px;
    font-size: 11px;
  }
  
  .ssh-uraian {
    font-size: 12px;
    padding-left: 15px;
  }
  
  .ssh-kode {
    font-size: 10px;
    padding-left: 8px;
  }
}
</style>
@endsection

@push('js')
<script>
$.ajaxSetup({
  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
});

$(function(){
  // (opsional) select2
  if ($.fn.select2) {
    $('#program_filter, #kegiatan_filter, #sub_kegiatan_filter').select2({ width:'100%', allowClear:true });
  }

  // === Dropdown berantai ===
  $('#program_filter').on('change', function(){
    const pid = $(this).val();

    $('#kegiatan_filter').empty().append('<option value="">-- Pilih Kegiatan --</option>').prop('disabled', true).trigger('change');
    $('#sub_kegiatan_filter').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true).trigger('change');

    if (pid) {
      $.get(`{{ url('/tree_view/program') }}/${pid}/kegiatan`, function(rows){
        $('#kegiatan_filter').prop('disabled', false);
        rows.forEach(r => {
          $('#kegiatan_filter').append(`<option value="${r.id_kegiatan}">${r.kode_kegiatan} - ${r.nama_kegiatan}</option>`);
        });
      });
    }
    table.ajax.reload();
  });

  $('#kegiatan_filter').on('change', function(){
    const kid = $(this).val();

    $('#sub_kegiatan_filter').empty().append('<option value="">-- Pilih Sub Kegiatan --</option>').prop('disabled', true).trigger('change');

    if (kid) {
      $.get(`{{ url('/tree_view/kegiatan') }}/${kid}/sub_kegiatan`, function(rows){
        $('#sub_kegiatan_filter').prop('disabled', false);
        rows.forEach(r => {
          $('#sub_kegiatan_filter').append(`<option value="${r.id_sub_kegiatan}">${r.kode_sub_kegiatan} - ${r.nama_sub_kegiatan}</option>`);
        });
      });
    }
    table.ajax.reload();
  });

  $('#sub_kegiatan_filter').on('change', function(){
    table.ajax.reload();
  });

  // === DataTables level-1: Rekening ===
  const table = $('#table_tree').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
      url: `{{ url('/tree_view/list-rekening') }}`,
      type: 'POST',
      data: function(d){
        d.id_program      = $('#program_filter').val();
        d.id_kegiatan     = $('#kegiatan_filter').val();
        d.id_sub_kegiatan = $('#sub_kegiatan_filter').val();
      }
    },
    columns: [
      { data: 'expand', orderable:false, searchable:false, className:'text-center align-middle' },
      { data: 'kode',   className:'align-middle',  orderable: true, searchable: true },
      { data: 'uraian', className:'align-middle',  orderable: true, searchable: true  },
      { data: 'p1',     className:'text-right align-middle',  orderable: true, searchable: true  },
      { data: 'p2',     className:'text-right align-middle',  orderable: true, searchable: true  },
      { data: 'real',   className:'text-right align-middle' },
      { data: 'sisa',   className:'text-right align-middle' },
    ],
    order: [[1,'asc']],
  });

  // === Child rows: SSH per rekening (Table Layout - Aligned) ===
// Update bagian JavaScript untuk child rows
$('#table_tree tbody').on('click', '.btn-expand', function(e){
  e.preventDefault();

  const tr  = $(this).closest('tr');
  const row = table.row(tr);
  const btn = $(this);
  const id  = btn.data('id');

  if (row.child.isShown()) {
    row.child.hide();
    btn.html('<i class="fas fa-chevron-right"></i>');
    tr.removeClass('shown');
  } else {
    const params = $.param({
      id_program: $('#program_filter').val() || '',
      id_kegiatan: $('#kegiatan_filter').val() || '',
      id_sub_kegiatan: $('#sub_kegiatan_filter').val() || '',
    });

    // Show loading state - seamless dengan parent
    row.child(`
      <table class="ssh-child-table">
        <tr class="ssh-item-row">
          <td colspan="7" class="ssh-loading">
            <i class="fas fa-spinner fa-spin"></i>Memuat data SSH...
          </td>
        </tr>
      </table>
    `).show();
    
    btn.html('<i class="fas fa-chevron-down"></i>');
    tr.addClass('shown');

    // Fetch SSH data
    $.get(`{{ url('/tree_view') }}/${id}/ssh?${params}`, function(data){
      let html = '<table class="ssh-child-table">';
      
      if (data && data.length > 0) {
        data.forEach(function(ssh, index) {
          html += `
            <tr class="ssh-item-row">
              <td class="ssh-expand-cell">
                <div class="ssh-expand-placeholder"></div>
              </td>
              <td class="ssh-kode">${ssh.kode_ssh || ''}</td>
              <td class="ssh-uraian">${ssh.nama_ssh || ''}</td>
              <td class="ssh-nilai">${formatNumber(ssh.p1) || '0'}</td>
              <td class="ssh-nilai">${formatNumber(ssh.p2) || '0'}</td>
              <td class="ssh-nilai">${formatNumber(ssh.real) || '0'}</td>
              <td class="ssh-nilai">${formatNumber(ssh.sisa) || '0'}</td>
            </tr>
          `;
        });
      } else {
        html += `
          <tr class="ssh-item-row">
            <td colspan="7" class="ssh-empty-state">
              <i class="fas fa-info-circle"></i>
              Tidak ada data SSH untuk rekening ini
            </td>
          </tr>
        `;
      }
      
      html += '</table>';
      
      row.child(html);
      
    }).fail(function(){
      row.child(`
        <table class="ssh-child-table">
          <tr class="ssh-item-row">
            <td colspan="7" class="ssh-error-state">
              <i class="fas fa-exclamation-circle"></i> Gagal memuat data SSH
            </td>
          </tr>
        </table>
      `);
    });
  }
});

// Helper function untuk format angka (opsional)
function formatNumber(num) {
  if (!num || num == 0) return '0';
  return parseFloat(num).toLocaleString('id-ID');
}

});
</script>
@endpush