<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF token for AJAX -->

  <!-- Title -->
  <title>@yield('title') &mdash; Stisla</title>

  <!-- General CSS -->
  <link rel="stylesheet" href="{{ asset('stisla1/node_modules/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla1/node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('stisla1/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla1/assets/css/components.css') }}">

  @stack('css') <!-- For page-specific CSS -->
</head>

<body>
  <div id="app">
    <div class="main-wrapper">

      <!-- Navbar -->
      @include('layouts.navbar')

      <!-- Sidebar -->
      <div class="main-sidebar sidebar-style-2">
        @include('layouts.sidebar')
      </div>

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>

      <!-- Footer -->
      @include('layouts.footer')

    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('stisla1/node_modules/jquery/dist/jquery.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="{{ asset('stisla1/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('stisla1/node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('stisla1/node_modules/jquery-ui-dist/jquery-ui.min.js') }}"></script>




  <!-- jQuery Validate -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script> --}}

<script src="{{ asset('stisla1/assets/js/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('stisla1/assets/js/validate/additional-methods.min.js') }}"></script>


  <!-- DataTables -->
  <script src="{{ asset('stisla1/node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('stisla1/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('stisla1/node_modules/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('stisla1/node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

  <!-- Stisla Core JS -->
  <script src="{{ asset('stisla1/assets/js/stisla.js') }}"></script>
  <script src="{{ asset('stisla1/assets/js/scripts.js') }}"></script>
  <script src="{{ asset('stisla1/assets/js/custom.js') }}"></script>

  <!-- Page Specific JS -->
  <script src="{{ asset('stisla1/assets/js/page/bootstrap-modal.js') }}"></script>
  <script src="{{ asset('stisla1/assets/js/page/components-table.js') }}"></script>

    <!-- SweetAlert2 CDN -->
<script src="{{ asset('stisla1/assets/js/sweetalert2.all.min.js') }}"></script>

  <!-- AJAX CSRF Setup -->
  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>

  @stack('js') <!-- For page-specific JS -->
    @yield('scripts')
</body>
</html>
