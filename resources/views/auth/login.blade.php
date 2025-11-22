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
    @keyframes shake {
      0% { transform: translateX(0); }
      20% { transform: translateX(-10px); }
      40% { transform: translateX(10px); }
      60% { transform: translateX(-10px); }
      80% { transform: translateX(10px); }
      100% { transform: translateX(0); }
    }

    .shake {
      animation: shake 0.4s ease-in-out;
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

    .hero .left { order: 1; }
    .hero .right { order: 2; }

    @media (max-width: 992px) {
        .hero {
            flex-direction: column;
            text-align: center;
        }
        .hero-title { font-size: 32px; }
        .glass-card { max-width: 100%; }
        .hero .left { order: 2; }
        .hero .right { order: 1; }
    }

    .content-section {
        padding: 80px 0;
        background: #fff; /* Memberi background putih pada section */
    }

    .content-section.dark {
        background: #4f443e;
        color: #fff;
    }
    .content-section.dark h5 {
        color: #fff;
    }

/* Custom Card Styles */
.custom-card {
  background: #fff;
  border-radius: 20px;
  padding: 30px 25px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
  border: 1px solid rgba(0, 0, 0, 0.05);
  position: relative;
  overflow: hidden;
}

.custom-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
  transform: scaleX(0);
  transition: transform 0.4s ease;
}

.custom-card:hover {
  transform: translateY(-12px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.custom-card:hover::before {
  transform: scaleX(1);
}

.card-title {
  font-weight: 700;
  color: #2c3e50;
  font-size: 1.25rem;
  margin-bottom: 12px;
}

.card-description {
  font-size: 14px;
  line-height: 1.7;
  min-height: 65px;
  color: #6c757d;
}

/* Realisasi Info Box */
.realisasi-info {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  padding: 18px;
  border-radius: 12px;
  font-size: 14px;
  border: 1px solid #dee2e6;
}

.realisasi-info strong {
  font-size: 15px;
  font-weight: 600;
}

/* Progress Bar Styles */
.progress {
  background-color: #e9ecef;
  overflow: visible;
  border-radius: 10px;
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

.progress-bar {
  transition: width 0.1s linear;
  font-size: 11px;
  line-height: 12px;
  border-radius: 10px;
  position: relative;
}

.progress-bar-animated {
  animation: progress-bar-stripes 1s linear infinite;
}

/* Total Card Styles */
.total-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 20px;
  position: relative;
  overflow: hidden;
}

.total-card::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
  animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); opacity: 0.5; }
  50% { transform: scale(1.1); opacity: 0.8; }
}

.stat-box {
  padding: 15px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: all 0.3s ease;
}

.stat-box:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: translateY(-3px);
}

.stat-box h4 {
  font-size: 1.3rem;
  text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

/* Responsive Styles */
@media (max-width: 768px) {
  .custom-card {
    padding: 25px 20px;
  }
  
  .card-description {
    min-height: auto;
    font-size: 13px;
  }
  
  .realisasi-info {
    font-size: 13px;
    padding: 15px;
  }
  
  .stat-box h4 {
    font-size: 1.1rem;
  }
  
  .total-card .card-body {
    padding: 25px 20px !important;
  }
}

@media (max-width: 576px) {
  .stat-box {
    padding: 12px;
  }
  
  .stat-box h4 {
    font-size: 1rem;
  }
}

/* Icon Animations */
.custom-card i {
  transition: all 0.3s ease;
}

.custom-card:hover i {
  transform: scale(1.1) rotate(5deg);
}

/* Text Colors */
.text-success { color: #28a745 !important; }
.text-info { color: #17a2b8 !important; }
.text-warning { color: #ffc107 !important; }
.text-danger { color: #dc3545 !important; }

.text-orange {
  color: #ff6600; /* atau kode warna oranye lain yang kamu suka */
}
/* Text Colors - Tambahan untuk Violet */
.text-violet { color: #7c3aed !important; }
.bg-violet { background-color: #7c3aed !important; }

    footer {
      background: #111;
      color: #aaa;
      padding: 20px 0;
      font-size: 14px;
    }

    /* === STYLE SECTION TENTANG BARU === */
    .tentang-section {
        padding: 80px 0;
        background: #f5f6f8;
    }
    .tentang-text-card {
        background: #fff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    .tentang-text-card h2 { font-weight: 600; }
    .tentang-text-card h5 { font-size: 20px; font-weight: 600; color: #a7283d; }

    .tentang-image-wrapper {
        height: 100%;
    }
    .tentang-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 16px;
    }

    .footer-section {
      background-color: #101535; /* Warna dasar biru gelap */
      color: #EAEAEA;           /* Warna teks putih keabuan, lebih nyaman di mata */
      padding: 80px 0;
    }

    .footer-section h5 {
      color: #FFFFFF;           /* Warna judul dibuat sedikit lebih terang */
      margin-bottom: 20px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-size: 16px;
    }

    .footer-section p,
    .footer-section li {
      font-size: 14px;
      line-height: 1.8;
      margin-bottom: 10px;
    }

    /* Mengatur agar ikon sejajar dan memiliki warna yang konsisten */
    .footer-section .contact-list i {
      color: #00A9FF; /* Warna aksen untuk ikon */
      margin-right: 12px;
      width: 20px; /* Memberi lebar tetap agar teks rata */
      text-align: center;
    }

    /* Membuat peta (iframe) menjadi responsif */
    .footer-section .map-wrapper {
      width: 100px;
      height: 100px;
      border-radius: 8px;
      overflow: hidden;
      flex-shrink: 0; /* Mencegah gambar menyusut */
    }

    .footer-section .map-wrapper iframe {
      width: 100%;
      height: 100%;
      border: 0;
    }

    /* Style untuk list agar lebih rapi */
    .footer-section ul {
      list-style: none;
      padding: 0;
    }

  </style>
</head>

<body>
  <div class="main-container">
    <header>
      <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
          <a href="#"><img src="{{ asset('assets/logo-pbj.png') }}" alt="Logo"></a>
          <a href="https://jti.polinema.ac.id/" target="_blank"><img src="{{ asset('assets/Jti_polinema.png') }}" alt="Logo"></a>
          <a href="#"><img src="{{ asset('assets/logo_monitrack.png') }}" width="80" height="100"alt="Logo"></a>
        </div>
        <nav>
          <ul class="nav">
            <li class="nav-item"><a href="#" class="nav-link" data-scroll-to="#pelayanan">Realisasi</a></li>
            <li class="nav-item"><a href="#" class="nav-link" data-scroll-to="#kontak">Kontak</a></li>
            <li class="nav-item"><a href="#" class="nav-link" data-scroll-to="#tentang">Tentang</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <div class="hero container">
      <div class="left">
        <h1 class="hero-title">
          Selamat Datang di 
          <span class="text-danger">M</span><span class="text-orange">on</span><span class="text-danger">T</span><span class="text-orange">rac</span><span class="text-danger">K</span><span class="text-orange">eu</span>
        </h1>
        <div id="lottie"></div>
      </div>
      <div class="right glass-card" id="loginSection">
        <p class="text-muted mb-4">Gunakan akun Anda untuk mengakses sistem.</p>
        <form id="loginForm" method="POST" action="{{ route('login') }}">
          @csrf
          <div id="loginError" class="alert alert-danger d-none"></div>
          <div class="mb-3 position-relative">
            <label for="nip" class="form-label">NIP</label>
            <i class="fas fa-user icon-input"></i>
            <input type="text" id="nip" name="nip" class="form-control input-icon" required>
          </div>
          {{-- <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password</label>
            <i class="fas fa-lock icon-input"></i>
            <input type="password" id="password" name="password" class="form-control input-icon" required>
          </div> --}}
          <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password</label>
            <i class="fas fa-lock icon-input"></i>
            <input type="password" id="password" name="password" class="form-control input-icon pe-5" required>
            <i class="fas fa-eye position-absolute" id="togglePassword"
                style="top: 42px; right: 15px; cursor: pointer; color: #999;"></i>
        </div>

          <button id="loginButton" type="submit" class="btn btn-danger w-100 btn-hover">Login</button>
        </form>
      </div>
    </div>

{{-- Section Pelayanan dengan Data Realisasi Anggaran --}}
<section id="pelayanan" class="content-section py-5">
  <div class="container">
    {{-- Header Section --}}
    <div class="row text-center mb-5" data-aos="fade-up">
      <div class="col">
        <h2 style="font-weight: 600; color: #2c3e50;">Data Realisasi Tahun {{$tahun}}</h2>
        {{-- <p class="text-muted">Data Tahun <small>{{$tahun}}</small></p> --}}
      </div>
    </div>
    
    {{-- Cards untuk 3 Bagian --}}
    <div class="row">
      {{-- PBJ Card --}}
      <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up">
        <div class="custom-card h-100">
          <div class="text-center">
            <i class="fas fa-briefcase fa-3x text-success mb-3"></i>
            <h5 class="card-title">Bagian PBJ</h5>
            <p class="text-muted card-description">Membantu proses pengadaan barang dan jasa secara efisien, transparan, dan akuntabel.</p>
          </div>
          
          <div class="realisasi-info mt-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted small">Total Pagu:</span>
              <strong class="text-dark">Rp {{ number_format($dataBagian['pbj']['pagu'], 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted small">Realisasi:</span>
              <strong class="text-success">Rp {{ number_format($dataBagian['pbj']['realisasi'], 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted small">Selisih:</span>
              <strong class="text-danger">Rp {{ number_format($dataBagian['pbj']['selisih'], 0, ',', '.') }}</strong>
            </div>
          </div>
          
          <div class="progress mt-3" style="height: 12px; border-radius: 10px;">
            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                 role="progressbar" 
                 style="width: 0%"
                 data-target="{{ $dataBagian['pbj']['persentase'] }}"
                 aria-valuenow="0" 
                 aria-valuemin="0" 
                 aria-valuemax="100">
            </div>
          </div>
          <div class="text-center mt-2">
            <small class="text-muted">
              <strong class="text-success persentase-text">0%</strong> terealisasi
            </small>
          </div>
        </div>
      </div>

      {{-- LPSE Card --}}
      <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="custom-card h-100">
          <div class="text-center">
            <i class="fas fa-network-wired fa-3x text-info mb-3"></i>
            <h5 class="card-title">Bagian LPSE</h5>
            <p class="text-muted card-description">Menyediakan layanan pengadaan secara elektronik untuk kemudahan dan jangkauan yang lebih luas.</p>
          </div>
          
          <div class="realisasi-info mt-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted small">Total Pagu:</span>
              <strong class="text-dark">Rp {{ number_format($dataBagian['lpse']['pagu'], 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted small">Realisasi:</span>
              <strong class="text-info">Rp {{ number_format($dataBagian['lpse']['realisasi'], 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted small">Selisih:</span>
              <strong class="text-danger">Rp {{ number_format($dataBagian['lpse']['selisih'], 0, ',', '.') }}</strong>
            </div>
          </div>
          
          <div class="progress mt-3" style="height: 12px; border-radius: 10px;">
            <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" 
                 role="progressbar" 
                 style="width: 0%"
                 data-target="{{ $dataBagian['lpse']['persentase'] }}"
                 aria-valuenow="0" 
                 aria-valuemin="0" 
                 aria-valuemax="100">
            </div>
          </div>
          <div class="text-center mt-2">
            <small class="text-muted">
              <strong class="text-info persentase-text">0%</strong> terealisasi
            </small>
          </div>
        </div>
      </div>

      {{-- Pembinaan Card --}}
      <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
        <div class="custom-card h-100">
          <div class="text-center">
            <i class="fas fa-users fa-3x text-warning mb-3"></i>
            <h5 class="card-title">Bagian Pembinaan</h5>
            <p class="text-muted card-description">Memberikan pembinaan dan advokasi untuk meningkatkan kompetensi sumber daya manusia.</p>
          </div>
          
          <div class="realisasi-info mt-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted small">Total Pagu:</span>
              <strong class="text-dark">Rp {{ number_format($dataBagian['pembinaan']['pagu'], 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted small">Realisasi:</span>
              <strong class="text-warning">Rp {{ number_format($dataBagian['pembinaan']['realisasi'], 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted small">Selisih:</span>
              <strong class="text-danger">Rp {{ number_format($dataBagian['pembinaan']['selisih'], 0, ',', '.') }}</strong>
            </div>
          </div>
          
          <div class="progress mt-3" style="height: 12px; border-radius: 10px;">
            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" 
                 role="progressbar" 
                 style="width: 0%"
                 data-target="{{ $dataBagian['pembinaan']['persentase'] }}"
                 aria-valuenow="0" 
                 aria-valuemin="0" 
                 aria-valuemax="100">
            </div>
          </div>
          <div class="text-center mt-2">
            <small class="text-muted">
              <strong class="text-warning persentase-text">0%</strong> terealisasi
            </small>
          </div>
        </div>
      </div>

    {{-- Tata Kelola Card --}}
      <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
        <div class="custom-card h-100">
          <div class="text-center">
            <i class="fas fa-clipboard-check fa-3x text-violet mb-3"></i>
            <h5 class="card-title">Bagian Tata Kelola</h5>
            <p class="text-muted card-description">Mengelola tata kelola pemerintahan daerah dengan baik dan akuntabel.</p>
          </div>
          
          <div class="realisasi-info mt-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted small">Total Pagu:</span>
              <strong class="text-dark">Rp {{ number_format($dataBagian['tatakelola']['pagu'], 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted small">Realisasi:</span>
              <strong class="text-violet">Rp {{ number_format($dataBagian['tatakelola']['realisasi'], 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted small">Selisih:</span>
              <strong class="text-danger">Rp {{ number_format($dataBagian['tatakelola']['selisih'], 0, ',', '.') }}</strong>
            </div>
          </div>
          
          <div class="progress mt-3" style="height: 12px; border-radius: 10px;">
            <div class="progress-bar bg-violet progress-bar-striped progress-bar-animated" 
                 role="progressbar" 
                 style="width: 0%"
                 data-target="{{ $dataBagian['tatakelola']['persentase'] }}"
                 aria-valuenow="0" 
                 aria-valuemin="0" 
                 aria-valuemax="100">
            </div>
          </div>
          <div class="text-center mt-2">
            <small class="text-muted">
              <strong class="text-violet persentase-text">0%</strong> terealisasi
            </small>
          </div>
        </div>
      </div>
    </div>
    
    {{-- Total Keseluruhan Card --}}
    {{-- <div class="row mt-5" data-aos="fade-up" data-aos-delay="300">
      <div class="col-12">
        <div class="card shadow-lg border-0 total-card">
          <div class="card-body text-white p-4">
            <div class="d-flex align-items-center mb-4">
              <i class="fas fa-chart-pie fa-2x me-3"></i>
              <h5 class="card-title mb-0 fw-bold">Total Keseluruhan Realisasi Anggaran</h5>
            </div>
            
            <div class="row g-4">
              <div class="col-md-3 col-6">
                <div class="stat-box">
                  <div class="text-white-50 small mb-1">Total Pagu</div>
                  <h4 class="mb-0 fw-bold">Rp {{ number_format($totalKeseluruhan['pagu'], 0, ',', '.') }}</h4>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="stat-box">
                  <div class="text-white-50 small mb-1">Total Realisasi</div>
                  <h4 class="mb-0 fw-bold">Rp {{ number_format($totalKeseluruhan['realisasi'], 0, ',', '.') }}</h4>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="stat-box">
                  <div class="text-white-50 small mb-1">Sisa Anggaran</div>
                  <h4 class="mb-0 fw-bold">Rp {{ number_format($totalKeseluruhan['selisih'], 0, ',', '.') }}</h4>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="stat-box">
                  <div class="text-white-50 small mb-1">Persentase</div>
                  <h4 class="mb-0 fw-bold">{{ number_format($totalKeseluruhan['persentase'], 2, ',', '.') }}%</h4>
                </div>
              </div>
            </div>
            
            <div class="progress mt-4" style="height: 15px; background-color: rgba(255,255,255,0.2); border-radius: 10px;">
              <div class="progress-bar bg-light progress-bar-striped progress-bar-animated" 
                   role="progressbar" 
                   style="width: 0%"
                   data-target="{{ $totalKeseluruhan['persentase'] }}"
                   aria-valuenow="0" 
                   aria-valuemin="0" 
                   aria-valuemax="100">
                <strong class="text-dark total-persentase-text">0%</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
  </div>
</section>


    {{-- <section id="kontak" class="content-section dark">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col">
                    <h2 style="font-weight: 600;">Hubungi Kami</h2>
                    <p>Kami siap membantu Anda. Hubungi kami melalui detail di bawah ini.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
                    <div class="custom-card">
                        <i class="fas fa-map-marker-alt fa-3x"></i>
                        <h5>Alamat</h5>
                        <p>Jl. Pahlawan No.110 Lt. 3 & 6, Krembangan Sel., Surabaya, Jawa Timur.</p>
                        <div class="maps-embed overflow-hidden rounded shadow mt-3">
                            <iframe
                                src="https://maps.google.com/maps?q=Jalan%20Pahlawan%20No.110%2C%20Surabaya&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                style="border:0; width: 100%; height: 200px;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="custom-card">
                        <i class="fas fa-phone fa-3x"></i>
                        <h5>Telepon</h5>
                        <p>+62 341 123456<br>+62 812 3456 7890</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="custom-card">
                        <i class="fas fa-envelope fa-3x"></i>
                        <h5>Email</h5>
                        <p>biro@pbj.go.id<br>support@pbj.go.id</p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}


    <section id="tentang" class="tentang-section">
      <div class="container">
        <div class="row align-items-stretch">
          <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right">
            <div class="tentang-text-card">
              <h2 class="mb-4">Tentang Kami</h2>
              <div class="mb-4">
                <h5>01. Visi</h5>
                <p>Mewujudkan biro pengadaan barang/jasa yang profesional, transparan, dan akuntabel.</p>
              </div>
              <div class="mb-4" style="max-width: 700px; margin: 0 auto; line-height: 1.6; font-size: 16px; text-align: justify;">
                <h5>02. Misi</h5>
                <p>
                  Melaksanakan proses pengadaan barang/jasa pemerintah yang efisien, efektif, transparan, keterbukaan, bersaing, adil/tidak diskriminatif, dan akuntabel untuk mewujudkan tata kelola pemerintahan yang baik dan bersih serta meningkatkan persaingan usaha yang sehat dalam layanan pengadaan barang/jasa pemerintah bagi masyarakat.
                </p>
              </div>
              <div>
                <h5>03. Nilai</h5>
                <p>Integritas, kolaborasi, dan inovasi menjadi nilai dasar kerja kami.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6" data-aos="fade-left">
            <div class="tentang-image-wrapper">
              <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=2832&auto=format&fit=crop" alt="Tentang Biro PBJ" class="img-fluid">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="kontak" class="footer-section">
      <div class="container">
        <div class="row gy-5 gx-5">

          <div class="col-lg-3 col-md-6">
            <h5>Informasi Aplikasi</h5>
            <ul>
              <li><a href="#" class="text-decoration-none text-white-50">Dasar Hukum</a></li>
              <li><a href="#" class="text-decoration-none text-white-50">Dokumentasi</a></li>
              <li><a href="#" class="text-decoration-none text-white-50">FAQ</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6">
            <h5>Hubungi Kami</h5>
            <ul class="contact-list">
              <li><i class="fas fa-phone-alt"></i><span>031 - 3545235</span></li>
              {{-- <li><i class="fab fa-whatsapp"></i><span>+62 813 1763 3727</span></li> --}}
              <li><i class="fas fa-envelope"></i><span>ropbj@jatimprov.go.id</span></li>
            </ul>

          </div>

          <div class="col-lg-3 col-md-6">
            <h5>Alamat Kantor</h5>
            <div class="d-flex">
              <div class="map-wrapper me-3">
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.955805132482!2d112.73773547460928!3d-7.245870092760547!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f93e2c857c81%3A0xa60e788025c37814!2sBiro%20Pengadaan%20Barang%2FJasa%20Provinsi%20Jawa%20Timur!5e0!3m2!1sen!2sid!4v1752639383735!5m2!1sen!2sid"
                  allowfullscreen=""
                  loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade">
                </iframe>
              </div>
              <p>
                Jl. Pahlawan No.110 Lt. 3 dan Lt. 6, Krembangan Sel., Kec. Krembangan, Surabaya, Jawa Timur 60175
              </p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <h5>Media Sosial</h5>
            <ul class="contact-list">
              <li><a href="https://www.instagram.com/biro.pbjatim?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank"><i class="fab fa-instagram"></i><span>@biro.pbjatim</span></a></li>
              <li><a href="https://youtube.com/@biropengadaanbarangjasa7751?si=eSjwp0fgX2kgKxpO" target="_blank"><i class="fab fa-youtube"></i><span>biro pengadaan barang dan jasa</span></a></li>
              <li><a href="https://ropbj.jatimprov.go.id/web/" target="_blank"><i class="fas fa-globe"></i><span>Biro PBJ Jatim</span></a></li>
            </ul>
          </div>

        </div>
      </div>
    </section>


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
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk animasi progress bar
        function animateProgressBars() {
            const progressBars = document.querySelectorAll('.progress-bar');
            
            progressBars.forEach(function(bar) {
                const target = parseFloat(bar.getAttribute('data-target'));
                const parentCard = bar.closest('.custom-card, .total-card');
                const persentaseText = parentCard ? parentCard.querySelector('.persentase-text, .total-persentase-text') : null;
                
                // Animasi dengan interval untuk smooth transition
                let current = 0;
                const increment = target / 60; // 60 steps untuk animasi lebih smooth
                const duration = 2000; // 2 detik
                const stepTime = duration / 60;
                
                const animation = setInterval(function() {
                    current += increment;
                    
                    if (current >= target) {
                        current = target;
                        clearInterval(animation);
                    }
                    
                    bar.style.width = current + '%';
                    bar.setAttribute('aria-valuenow', current);
                    
                    // Update text persentase
                    if (persentaseText) {
                        persentaseText.textContent = current.toFixed(2) + '%';
                    }
                }, stepTime);
            });
        }
        
        // Trigger animasi setelah halaman load dengan delay
        setTimeout(animateProgressBars, 500);
        
        // Optional: Re-trigger animasi saat scroll ke section
        const section = document.getElementById('pelayanan');
        if (section && 'IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        // Reset progress bars
                        const progressBars = section.querySelectorAll('.progress-bar');
                        progressBars.forEach(bar => {
                            bar.style.width = '0%';
                            const text = bar.closest('.custom-card, .total-card').querySelector('.persentase-text, .total-persentase-text');
                            if (text) text.textContent = '0%';
                        });
                        
                        // Re-animate
                        setTimeout(animateProgressBars, 300);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });
            
            observer.observe(section);
        }
    });
    
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
            const $button = $('#loginButton');

            // simpan text asli
            const originalText = $button.html();

              // Ganti dengan spinner + disable tombol
            $button
              .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
              .prop('disabled', true);

            $.ajax({
                url: '/login',
                method: 'POST',
                data: {
                    nip: nip,
                    password: password,
                    _token: $('meta[name="csrf-token"]').attr('content') // penting!
                },
                success: function(response) {
                    console.log(response.redirect);  // Cek URL yang diterima

                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                  const message = xhr.responseJSON?.errors?.nip?.[0] || xhr.responseJSON?.message || 'Login gagal.';
                  $('#loginError').removeClass('d-none').text("NIP atau password salah, coba lagi.");

                  // Kembalikan tombol seperti semula
                  $button.html(originalText).prop('disabled', false);

                  // Tambahkan animasi shake ke #loginSection
                  const $section = $('#loginSection');
                  $section.addClass('shake');
                  void $section[0].offsetWidth;  // trik force reflow
                  $section.addClass('shake');

                  // Hapus class shake setelah animasi selesai
                  $section.on('animationend', function () {
                    $section.removeClass('shake');
                  });
                }
            });
        });

        // Reset error saat input
        $('#nip, #password').on('input', function() {
            $('#loginError').addClass('d-none').text('');
            $('#loginSection').removeClass('shake');
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

    // Toggle show/hide password
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

  </script>
</body>
</html>