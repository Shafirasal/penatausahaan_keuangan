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
            <table id="table_tree" class="table table-bordered table-hover table-striped dt-responsive nowrap" style="width:100%">
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

<style>
.ssh-child-container {
  background-color: #f8f9fa;
  border-left: 4px solid #007bff;
  margin: 10px 0;
  padding: 15px;
  border-radius: 5px;
}

.ssh-item {
  background: white;
  border: 1px solid #dee2e6;
  border-radius: 4px;
  margin-bottom: 8px;
  padding: 12px;
  transition: all 0.2s;
}

.ssh-item:hover {
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  border-color: #007bff;
}

.ssh-item:last-child {
  margin-bottom: 0;
}

.ssh-header {
  font-weight: 600;
  color: #495057;
  margin-bottom: 8px;
  font-size: 14px;
  display: flex;
  align-items: center;
}

.ssh-header .badge {
  margin-right: 8px;
  font-size: 10px;
}

.ssh-details {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  gap: 15px;
  font-size: 13px;
}

.ssh-detail-item {
  display: flex;
  flex-direction: column;
  text-align: center;
}

.ssh-detail-label {
  color: #6c757d;
  font-size: 11px;
  text-transform: uppercase;
  font-weight: 500;
  margin-bottom: 3px;
  letter-spacing: 0.5px;
}

.ssh-detail-value {
  font-weight: 600;
  color: #495057;
  font-size: 14px;
}

.ssh-empty-state {
  text-align: center;
  padding: 20px;
  color: #6c757d;
}

.ssh-empty-state i {
  font-size: 24px;
  margin-bottom: 8px;
  display: block;
}

.ssh-loading {
  text-align: center;
  padding: 15px;
  color: #007bff;
}

.ssh-loading i {
  margin-right: 8px;
}

@media (max-width: 768px) {
  .ssh-details {
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }
}

@media (max-width: 576px) {
  .ssh-details {
    grid-template-columns: 1fr;
    gap: 8px;
  }
  
  .ssh-child-container {
    padding: 10px;
  }
  
  .ssh-item {
    padding: 8px;
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
      { data: 'kode',   className:'align-middle' },
      { data: 'uraian', className:'align-middle' },
      { data: 'p1',     className:'text-right align-middle' },
      { data: 'p2',     className:'text-right align-middle' },
      { data: 'real',   className:'text-right align-middle' },
      { data: 'sisa',   className:'text-right align-middle' },
    ],
    order: [[1,'asc']],
  });

  // === Child rows: SSH per rekening (Card Layout) ===
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

      // Show loading state
      row.child('<div class="ssh-child-container"><div class="ssh-loading"><i class="fas fa-spinner fa-spin"></i>Loading SSH data...</div></div>').show();
      btn.html('<i class="fas fa-chevron-down"></i>');
      tr.addClass('shown');

      // Fetch SSH data
      $.get(`{{ url('/tree_view') }}/${id}/ssh?${params}`, function(data){
        let html = '<div class="ssh-child-container">';
        
        if (data && data.length > 0) {
          data.forEach(function(ssh) {
            html += `
              <div class="ssh-item">
                <div class="ssh-header">
                  <span class="badge badge-secondary">${ssh.kode_ssh || ''}</span>
                  ${ssh.nama_ssh || ''}
                </div>
                <div class="ssh-details">
                  <div class="ssh-detail-item">
                    <span class="ssh-detail-label">Periode 1</span>
                    <span class="ssh-detail-value">${ssh.p1 || '0'}</span>
                  </div>
                  <div class="ssh-detail-item">
                    <span class="ssh-detail-label">Periode 2</span>
                    <span class="ssh-detail-value">${ssh.p2 || '0'}</span>
                  </div>
                  <div class="ssh-detail-item">
                    <span class="ssh-detail-label">Realisasi</span>
                    <span class="ssh-detail-value">${ssh.real || '0'}</span>
                  </div>
                  <div class="ssh-detail-item">
                    <span class="ssh-detail-label">Sisa</span>
                    <span class="ssh-detail-value">${ssh.sisa || '0'}</span>
                  </div>
                </div>
              </div>
            `;
          });
        } else {
          html += `
            <div class="ssh-empty-state">
              <i class="fas fa-info-circle"></i>
              <div>Tidak ada data SSH untuk rekening ini</div>
            </div>
          `;
        }
        
        html += '</div>';
        
        row.child(html);
        
      }).fail(function(){
        row.child('<div class="ssh-child-container"><div class="text-danger text-center p-3"><i class="fas fa-exclamation-circle"></i> Gagal memuat data SSH.</div></div>');
      });
    }
  });

});
</script>
@endpush