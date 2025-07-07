<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- untuk mengirimkan token laravel csrf pada setiap request ajax --}}
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  {{-- <title>Blank Page &mdash; Stisla</title> --}}
  <title>@yield('title') &mdash; Stisla</title>

  <!-- General CSS Files -->
  {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
  {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> --}}
<link rel="stylesheet"href="{{ asset('stisla1/node_modules/bootstrap/dist/css/bootstrap.min.css') }}">
<link rel="stylesheet"href="{{ asset('stisla1/node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('stisla1') }}/assets/css/style.css">
  <link rel="stylesheet" href="{{ asset('stisla1') }}/assets/css/components.css">
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
    <!-- navbar -->
    @include('layouts.navbar')
    <!-- navbar -->
      
    <!-- Sidebar -->
      <div class="main-sidebar sidebar-style-2">
        @include('layouts.sidebar')
      </div>
    <!-- Sidebar -->


    <!-- Main Content -->
<!-- Main Content -->
<div class="main-content">
    @yield('content')
</div>

    
      {{-- <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Blank Page</h1>
          </div>

          <div class="section-body">
          </div>
        </section>
      </div> --}}

            <!-- footer -->
         @include('layouts.footer')

    </div>
  </div>

  <!-- General JS Scripts -->

<script src="{{ asset('stisla1/node_modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('stisla1/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('stisla1/node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('stisla1/node_modules/popper.js/dist/popper.min.js') }}"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('stisla1/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>


  {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> --}}
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> --}}
  {{-- <script src="{{ asset('stisla1') }}/assets/js/stisla.js"></script> --}}
  <script src="{{ asset('stisla1/assets/js/stisla.js') }}"></script>


  <!-- JS Libraies -->
  <!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>


  <!-- Template JS File -->
<script src="{{ asset('stisla1/assets/js/scripts.js') }}"></script>
<script src="{{ asset('stisla1/assets/js/custom.js') }}"></script>


  <!-- Page Specific JS File  -->
  @stack('js')
</body>
</html>