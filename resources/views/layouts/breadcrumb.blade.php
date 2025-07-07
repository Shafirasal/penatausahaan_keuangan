{{-- <section class="section">
          <div class="section-header">
            <h1>Blank Page</h1>
          </div>

          <div class="section-body">
          </div>
        </section> --}}

{{-- <section class="section">
  <div class="section-header">
    <h1>{{ $breadcrumb->title ?? 'Judul Halaman' }}</h1>
    <div class="section-header-breadcrumb">
      @foreach ($breadcrumb->list as $key => $value)
        @if ($key == count($breadcrumb->list) - 1)
          <div class="breadcrumb-item active">{{ $value }}</div>
        @else
          <div class="breadcrumb-item">{{ $value }}</div>
        @endif
      @endforeach
    </div>
  </div>

  <div class="section-body">

  </div>
</section> --}}

<div class="section-header-breadcrumb">
  @foreach ($list as $key => $value)
    @if ($key == count($list) - 1)
      <div class="breadcrumb-item active">{{ $value }}</div>
    @else
      <div class="breadcrumb-item">{{ $value }}</div>
    @endif
  @endforeach
</div>