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
      background: transparent;
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
      align-items: center;   /* Tengah sumbu Y */
      justify-content: space-between; /* Pisahkan kiri-kanan */
      gap: 50px; /* Jarak antara kiri & kanan */
    }

    .hero .left {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center; /* Tengah vertikal */
    }
    .hero .left h1 {
      text-align: left;  /* Sejajar kiri */
      margin-bottom: 2rem;
    }

    .lottie-wrapper {
      position: relative;
      width: 100%;
      height: auto;
    }

    #lottie {
      width: 100%;
      height: auto;
    }

    .lottie-overlap {
      position: relative;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: 8px; /* Opsional, sama kayak card */
    }


    .hero .right {
      flex: 1;
      background: rgba(255, 255, 255, 0.6); /* transparan putih */
      backdrop-filter: blur(10px); /* efek blur */
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

    .content {
      height:100vh;
      background: #222;
      color: #fff;
      padding: 80px 0;
    }

    .content h5 {
      color: #d23553;
      font-size: 22px;
      margin-bottom: 10px;
    }

    .content p {
      margin: 0;
      font-size: 16px;
      line-height: 1.6;
    }

    .tentang-section {
      position: relative;
      padding: 100px 0;
    }

    .tentang-text h2 {
      font-size: 36px;
    }

    .tentang-item {
      opacity: 0;
      transform: translateY(50px);
      transition: all 0.8s ease-out;
    }

    .tentang-item.is-inview {
      opacity: 1;
      transform: translateY(0);
    }

    .tentang-image-wrapper {
      position: sticky;
      top: 100px; /* jarak dari atas viewport */
      height: 80vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .tentang-image-wrapper img {
      width: 100%;
      height: auto;
      display: block;
    }

    .tentang-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.3); /* overlay gelap */
    }

    @media (max-width: 767px) {
      .tentang-image-wrapper {
        position: static;
        height: auto;
      }
    }


    footer {
      background: #111;
      color: #aaa;
      padding: 20px 0;
      font-size: 14px;
    }
  </style>
</head>

<body data-scroll-container>
<div class="main-container" >
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
  <div class="hero container">
      <div class="left">
    <h1>Selamat Datang di <span class="text-danger">Biro PBJ</span></h1>
    <div id="lottie"></div>
  </div>

    {{-- <!-- LEFT: ANIMASI + SLIDER -->
    <div class="center">
      <!-- Lottie -->
        <div id="lottie" class="position-absolute top-50 start-30 translate-middle" style="max-width: 400px; z-index: 1;">
          <div class="lottie-overlap"></div>
        </div>
    </div> --}}

    <!-- RIGHT: FORM LOGIN -->
    <div class="right">
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
</div>
<section class="content" data-scroll-section-speed="1">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-4" data-scroll data-scroll-speed="1" data-scroll-delay="0.05">
        <h5>Kontak</h5>
        <p><i class="fas fa-phone"></i> (0341) 123456</p>
        <p><i class="fas fa-envelope"></i> biro@pbj.go.id</p>
      </div>
    </div>
  </div>
</section>

<section class="tentang-section" data-scroll-section>
  <div class="container">
    <div class="row">
      <!-- Kiri: List Tentang -->
      <div class="col-md-6 tentang-text">
        <h2 class="mb-4">Tentang Kami</h2>

        <div class="tentang-item" data-scroll data-scroll-call="fade-item" data-scroll-repeat data-scroll data-scroll-speed="1">
          <h5>01. Visi</h5>
          <p>Mewujudkan biro pengadaan barang/jasa yang profesional, transparan, dan akuntabel.</p>
        </div>

        <div class="tentang-item" data-scroll data-scroll-call="fade-item" data-scroll-repeat data-scroll data-scroll-speed="1">
          <h5>02. Misi</h5>
          <p>Meningkatkan efisiensi, efektivitas, dan kualitas layanan pengadaan melalui sistem digital.</p>
        </div>

        <div class="tentang-item" data-scroll data-scroll-call="fade-item" data-scroll-repeat data-scroll data-scroll-speed="1">
          <h5>03. Nilai</h5>
          <p>Integritas, kolaborasi, dan inovasi menjadi nilai dasar kerja kami.</p>
        </div>
      </div>

      <!-- Kanan: Gambar Fixed -->
      <div class="col-md-6">
        <div class="tentang-image-wrapper">
          <img src="{{ asset('assets/tentang.jpg') }}" alt="Tentang Biro PBJ" class="img-fluid">
          <div class="tentang-overlay"></div>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- FOOTER -->
<footer>
  <div class="container d-flex justify-content-between">
    <span>© 2025 Biro PBJ</span>
    <span>Developed by Tim IT</span>
  </div>
</footer>

<!-- LIBS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.js"></script>

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

    const scroll = new LocomotiveScroll({
    el: document.querySelector('[data-scroll-container]'),
    smooth: true,
  });
  // Fade effect on masuk viewport
    scroll.on('call', (value, way, obj) => {
      if (value === 'fade-item' && way === 'enter') {
        obj.el.classList.add('is-inview');
      }
    });
</script>

</body>
</html>

{{-- dibuang sayang --}}
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