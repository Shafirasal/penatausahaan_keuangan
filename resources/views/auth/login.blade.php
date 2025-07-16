<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login — Biro PBJ</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- AOS (Animate On Scroll) -->
  <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet"/>

  <!-- Gilroy font -->
  <style>
    @font-face {
      font-family: 'Gilroy';
      src: url('{{ asset('fonts/Gilroy-Regular.woff2') }}') format('woff2');
      font-weight: normal;
      font-style: normal;
    }

    html {
      scroll-behavior: smooth;
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
      align-items: center;
      justify-content: space-between;
      gap: 50px;
      flex-wrap: wrap;
      padding: 60px 0;
    }

    .hero-title {
      font-size: 42px;
      font-weight: 600;
    }

    #lottie {
      max-width: 500px;
      width: 100%;
      height: auto;
    }

    .glass-card {
      flex: 1;
      max-width: 400px;
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .icon-input {
      position: absolute;
      top: 42px;
      left: 15px;
      color: #999;
    }

    .input-icon {
      padding-left: 40px;
    }

    .btn-hover {
      transition: all 0.3s ease;
    }

    .btn-hover:hover {
      background: #a7283d;
      box-shadow: 0 6px 18px rgba(0,0,0,0.2);
    }

    /* Flex order setting */
    .hero .left {
      order: 1;
    }

    .hero .right {
      order: 2;
    }

    @media (max-width: 768px) {
      .hero {
        flex-direction: column;
        text-align: center;
      }

      .hero-title {
        font-size: 32px;
      }

      .glass-card {
        max-width: 100%;
      }

      .hero .left {
        order: 2;
      }

      .hero .right {
        order: 1;
      }
    }

    .content {
      background: #4f443e;
      color: #fff;
      padding: 100px 0;
    }

    .content i {
      color: #fff;
    }

    .content h5 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .content p {
      font-size: 16px;
      line-height: 1.6;
    }

    footer {
      position: sticky;
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
            <li class="nav-item"><a href="#" class="nav-link" data-scroll-to="#pelayanan">pelayanan</a></li>
            <li class="nav-item"><a href="#" class="nav-link" data-scroll-to="#kontak">Kontak</a></li>
            <li class="nav-item"><a href="#" class="nav-link" data-scroll-to="#tentang">Tentang</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <!-- HERO -->
    <div class="hero container">
      <div class="left">
        <h1 class="hero-title">Selamat Datang di <span class="text-danger">Biro PBJ</span></h1>
        <div id="lottie"></div>
      </div>

      <div class="right glass-card" id="loginSection">
        <p class="text-muted mb-4">Gunakan akun Anda untuk mengakses sistem.</p>
        <form id="loginForm" method="POST" action="#">
          @csrf
          <div id="loginError" class="alert alert-danger d-none"></div>

          <div class="mb-3 position-relative">
            <label for="nip" class="form-label">NIP</label>
            <i class="fas fa-user icon-input"></i>
            <input type="text" id="nip" name="nip" class="form-control input-icon" required>
          </div>

          <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password</label>
            <i class="fas fa-lock icon-input"></i>
            <input type="password" id="password" name="password" class="form-control input-icon" required>
          </div>

          <button type="submit" class="btn btn-danger w-100 btn-hover">Login</button>
        </form>
      </div>
    </div>

    <!-- SECTION PELAYANAN -->
    <section id="pelayanan" class="content">
      <div class="container py-5">
        <div class="row mb-4">
          <div class="col-md-8 text-start" data-aos="fade-up">
            <div class="d-flex align-items-start">
              <i class="fas fa-briefcase fa-2x me-3"></i>
              <div>
                <h5>Bagian PBJ</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla,
                mattis ligula consectetur, ultrices mauris.
                Maecenas vitae mattis tellus. Nullam quis imperdiet augue.
                Vestibulum auctor ornare leo, non suscipit magna interdum eu.
                Curabitur pellentesque nibh nibh, at maximus ante fermentum sit amet.
                Pellentesque commodo lacus at sodales sodales. Quisque sagittis orci ut diam condimentum,
                vel euismod erat placerat. In iaculis arcu eros, eget tempus orci facilisis id.Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit
                amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus.
                Nullam quis imperdiet augue. Vestibulum auctor ornare leo, non suscipit magna interdum eu.
                Curabitur pellentesque nibh nibh, at maximus ante fermentum sit amet.
                Pellentesque commodo lacus at sodales sodales.
                Quisque sagittis orci ut diam condimentum, vel euismod erat placerat.
                In iaculis arcu eros, eget tempus orci facilisis id.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-4 justify-content-md-end">
          <div class="col-md-8 text-end" data-aos="fade-up">
            <div class="d-flex align-items-start justify-content-end">
              <div>
                <h5>Bagian LPSE</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla,
                mattis ligula consectetur, ultrices mauris.
                Maecenas vitae mattis tellus. Nullam quis imperdiet augue.
                Vestibulum auctor ornare leo, non suscipit magna interdum eu.
                Curabitur pellentesque nibh nibh, at maximus ante fermentum sit amet.
                Pellentesque commodo lacus at sodales sodales. Quisque sagittis orci ut diam condimentum,
                vel euismod erat placerat. In iaculis arcu eros, eget tempus orci facilisis id.Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit
                amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus.
                Nullam quis imperdiet augue. Vestibulum auctor ornare leo, non suscipit magna interdum eu.
                Curabitur pellentesque nibh nibh, at maximus ante fermentum sit amet.
                Pellentesque commodo lacus at sodales sodales.
                Quisque sagittis orci ut diam condimentum, vel euismod erat placerat.
                In iaculis arcu eros, eget tempus orci facilisis id.</p>
              </div>
              <i class="fas fa-network-wired fa-2x ms-3"></i>
            </div>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-8 text-start" data-aos="fade-up">
            <div class="d-flex align-items-start">
              <i class="fas fa-users fa-2x me-3"></i>
              <div>
                <h5>Bagian Pembinaan</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla,
                mattis ligula consectetur, ultrices mauris.
                Maecenas vitae mattis tellus. Nullam quis imperdiet augue.
                Vestibulum auctor ornare leo, non suscipit magna interdum eu.
                Curabitur pellentesque nibh nibh, at maximus ante fermentum sit amet.
                Pellentesque commodo lacus at sodales sodales. Quisque sagittis orci ut diam condimentum,
                vel euismod erat placerat. In iaculis arcu eros, eget tempus orci facilisis id.Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit
                amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus.
                Nullam quis imperdiet augue. Vestibulum auctor ornare leo, non suscipit magna interdum eu.
                Curabitur pellentesque nibh nibh, at maximus ante fermentum sit amet.
                Pellentesque commodo lacus at sodales sodales.
                Quisque sagittis orci ut diam condimentum, vel euismod erat placerat.
                In iaculis arcu eros, eget tempus orci facilisis id.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

<!-- SECTION KONTAK -->
    <section id="kontak" class="content">
      <div class="container py-5">
        <div class="row text-center">
          <div class="col-md-4 mb-4" data-aos="fade-up">
            <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
            <h5>Alamat</h5>
            <p>Jl. Pahlawan No.110 Lt. 3 dan Lt. 6, Krembangan Sel., Kec. Krembangan, Surabaya, Jawa Timur 60175, Indonesia</p>
          </div>
          <div class="col-md-4 mb-4" data-aos="fade-up">
            <i class="fas fa-phone fa-3x mb-3"></i>
            <h5>Telepon</h5>
            <p>+62 341 123456<br>+62 812 3456 7890</p>
          </div>
          <div class="col-md-4 mb-4" data-aos="fade-up">
            <i class="fas fa-envelope fa-3x mb-3"></i>
            <h5>Email</h5>
            <p>biro@pbj.go.id<br>support@pbj.go.id</p>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12" data-aos="fade-up">
            <div class="maps-embed overflow-hidden rounded shadow">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31662.49511434134!2d112.73061938126749!3d-7.262237535640607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f93e2c857c81%3A0xa60e788025c37814!2sBiro%20Pengadaan%20Barang%2FJasa%20Provinsi%20Jawa%20Timur!5e0!3m2!1sen!2sid!4v1752501272443!5m2!1sen!2sid"
                width="600"
                height="450"
                style="border:0; width: 100%; height: 300px;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION TENTANG -->
    <section id="tentang" class="tentang-section">
      <div class="container-fluid">
        <div class="row align-items-start">
          <div class="col-md-6">
            <div class="tentang-text sticky-tentang">
              <h2 class="mb-4">Tentang Kami</h2>

              <div data-aos="fade-up">
                <h5>01. Visi</h5>
                <p>Mewujudkan biro pengadaan barang/jasa yang profesional, transparan, dan akuntabel.</p>
              </div>

              <div data-aos="fade-up">
                <h5>02. Misi</h5>
                <p>Meningkatkan efisiensi, efektivitas, dan kualitas layanan pengadaan melalui sistem digital.</p>
              </div>

              <div data-aos="fade-up">
                <h5>03. Nilai</h5>
                <p>Integritas, kolaborasi, dan inovasi menjadi nilai dasar kerja kami.</p>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="tentang-image-wrapper">
              <img src="{{ asset('assets/tentang.jpg') }}" alt="Tentang Biro PBJ" class="img-fluid">
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
  </div>

  <!-- LIBS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

  <script>
    // Lottie animasi
    var animation = lottie.loadAnimation({
      container: document.getElementById('lottie'),
      renderer: 'svg',
      loop: true,
      autoplay: true,
      path: "{{ asset('animations/animation.json') }}"
    });

    // AOS
    AOS.init();

    $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            const nip = $('#nip').val();
            const password = $('#password').val();

            $.ajax({
                url: '/login',
                method: 'POST',
                data: {
                    nip: nip,
                    password: password,
                    _token: $('meta[name="csrf-token"]').attr('content') // penting!
                },
                success: function() {
                    window.location.href = '/home';
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.errors?.nip?.[0] || xhr.responseJSON?.message ||
                        'Login gagal.';
                    $('#loginError').removeClass('d-none').text(message);
                }
            });
        });

        // Reset error saat input
        $('#nip, #password').on('input', function() {
            $('#loginError').addClass('d-none').text('');
        });


    // Smooth scroll nav
    document.querySelectorAll('[data-scroll-to]').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const target = this.getAttribute('data-scroll-to');
        const el = document.querySelector(target);
        if (el) {
          el.scrollIntoView({ behavior: 'smooth' });
        }
      });
    });
  </script>
</body>
</html>
