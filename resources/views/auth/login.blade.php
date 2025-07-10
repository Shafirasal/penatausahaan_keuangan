<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login — Biro PBJ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- Gilroy font (pakai file lokal) -->
  <style>
    @font-face {
      font-family: 'Gilroy';
      src: url('{{ asset('fonts/Gilroy-Regular.woff2') }}') format('woff2');
      font-weight: normal;
      font-style: normal;
    }

    body {
      background: #f5f6f8;
      font-family: 'Gilroy', sans-serif;
    }

    .main-container {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      background: transparent; /* transparan */
      border-bottom: none;
      padding: 15px 0;
    }

    header .logo img {
      height: 50px;
    }

    nav .nav-link {
      color: #333;
    }

    .hero {
      flex: 1;
      display: flex;
      padding: 40px 0;
    }

    .hero .left {
      flex: 2;
      padding-right: 40px;
    }

    .hero .right {
      flex: 1;
      background: rgba(255, 255, 255, 0.6); /* transparan putih */
      backdrop-filter: blur(10px); /* efek blur modern */
      padding: 40px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      border-radius: 8px;
    }

    .hero .right input.form-control {
      background: #EAF0F7;
      border: none;
    }

    .hero .right input.form-control:focus {
      box-shadow: none;
      border: 1px solid #d23553;
    }

    .feature {
      background: #222;
      color: #fff;
      padding: 40px 0;
    }

    .feature h5 {
      color: #d23553;
    }

    footer {
      background: #111;
      color: #aaa;
      padding: 20px 0;
      font-size: 14px;
    }
  </style>
</head>

<body>

<div class="main-container">

  <!-- HEADER -->
  <header>
    <div class="container d-flex justify-content-between align-items-center">
      <div class="logo">
        <a href="#"><img src="{{ asset('assets/logo_biro.png') }}" alt="Logo"></a>
      </div>
      <nav>
        <ul class="nav">
          <li class="nav-item"><a href="#" class="nav-link">FAQ</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Tutorial</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Tentang</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- HERO -->
  <div class="container hero">
    <!-- LEFT: ANIMASI + SLIDER -->
    <div class="left">
      <!-- Lottie -->
      <div id="lottie" style="max-width: 600px; margin-bottom: 30px;"></div>

      <!-- Slider -->
      {{-- <div id="sliderPBJ" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{ asset('assets/slide1.jpg') }}" class="d-block w-100" alt="Slide 1">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('assets/slide2.jpg') }}" class="d-block w-100" alt="Slide 2">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('assets/slide3.jpg') }}" class="d-block w-100" alt="Slide 3">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#sliderPBJ" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#sliderPBJ" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div> --}}
    </div>

    <!-- RIGHT: FORM LOGIN -->
    <div class="right">
      <h4 class="mb-4">Selamat Datang di <span class="text-danger">Biro PBJ</span></h4>
      <p class="text-muted mb-4">Gunakan akun Anda untuk mengakses sistem.</p>

      <form id="loginForm" method="POST" action="#">
        @csrf
        <div id="loginError" class="alert alert-danger d-none"></div>

        <div class="mb-3">
          <label for="nip" class="form-label">NIP</label>
          <input type="text" id="nip" name="nip" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-danger w-100">Login</button>
      </form>
    </div>
  </div>

  <!-- FEATURE -->
  <div class="feature">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-4">
          <h5>Kontak</h5>
          <p><i class="fas fa-phone"></i> (0341) 123456</p>
          <p><i class="fas fa-envelope"></i> biro@pbj.go.id</p>
        </div>
        <div class="col-md-4">
          <h5>Informasi</h5>
          <p>Sistem Penatausahaan Keuangan berbasis web, efisien & transparan. Gunakan akun Anda untuk akses fitur lengkap.</p>
        </div>
        <div class="col-md-4">
          <h5>Visi</h5>
          <p>Mewujudkan tata kelola keuangan yang akuntabel, transparan & modern.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer>
    <div class="container d-flex justify-content-between">
      <span>© 2025 Biro PBJ</span>
      <span>Developed by Tim IT</span>
    </div>
  </footer>

</div>

<!-- LIBS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
  // Lottie animasi
  var animation = lottie.loadAnimation({
    container: document.getElementById('lottie'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: "{{ asset('animations/animation.json') }}"
  });

  // Login AJAX
  $('#loginForm').on('submit', function(e) {
    e.preventDefault();

    const nip = $('#nip').val();
    const password = $('#password').val();

    $.ajax({
      url: '/api/login',
      method: 'POST',
      data: { nip, password },
      success: function(response) {
        const token = response.authorisation.token;
        localStorage.setItem('token', token);

        $.ajax({
          url: '/sync-session',
          method: 'GET',
          headers: { Authorization: 'Bearer ' + token },
          success: function() {
            window.location.href = '/home';
          },
          error: function() {
            $('#loginError').removeClass('d-none').text('Gagal menyimpan session');
          }
        });
      },
      error: function(xhr) {
        const message = xhr.responseJSON?.message || 'Login gagal.';
        $('#loginError').removeClass('d-none').text(message);
      }
    });
  });

  $('#nip, #password').on('input', function() {
    $('#loginError').addClass('d-none').text('');
  });
</script>

</body>
</html>
