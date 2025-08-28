<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Landing Page | Web Saya</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }

    .hero {
      background: linear-gradient(to right, #3b82f6, #60a5fa);
      color: white;
      padding: 100px 0;
      text-align: center;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
      animation: fadeInDown 1s ease-out;
    }

    .hero p {
      font-size: 1.25rem;
      animation: fadeInUp 1s ease-out;
    }

    .btn-primary {
      background-color: #2563eb;
      border: none;
    }

    .features {
      padding: 80px 0;
    }

    .feature-box {
      text-align: center;
      padding: 30px;
      border-radius: 12px;
      transition: 0.3s;
    }

    .feature-box:hover {
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    @keyframes fadeInDown {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    footer {
      background-color: #111827;
      color: white;
      text-align: center;
      padding: 30px 0;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand font-weight-bold" href="#">BrandSaya</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
        <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h1>Selamat Datang di Website Kami</h1>
    <p>Solusi digital modern untuk bisnis Anda</p>
    <a href="#layanan" class="btn btn-primary btn-lg mt-4">Mulai Sekarang</a>
  </div>
</section>

<!-- Features Section -->
<section class="features" id="layanan">
  <div class="container">
    <div class="row mb-5 text-center">
      <div class="col">
        <h2>Layanan Kami</h2>
        <p class="text-muted">Kami menyediakan solusi terbaik untuk kebutuhan digital Anda.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="feature-box bg-light">
          <h4>Website Profesional</h4>
          <p>Desain modern dan mobile-friendly untuk bisnis Anda.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box bg-light">
          <h4>SEO & Digital Marketing</h4>
          <p>Perkuat visibilitas brand Anda di mesin pencari.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box bg-light">
          <h4>Manajemen Produk</h4>
          <p>Dashboard efisien untuk kontrol penjualan dan inventori.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- About Section -->
<section id="tentang" class="py-5 bg-light">
  <div class="container text-center">
    <h2>Tentang Kami</h2>
    <p>Kami adalah tim pengembang kreatif yang berfokus pada solusi digital cerdas dan efisien.</p>
  </div>
</section>

<!-- Contact Section -->
<section id="kontak" class="py-5">
  <div class="container text-center">
    <h2>Hubungi Kami</h2>
    <p>Email: <a href="mailto:info@websaya.com">info@websaya.com</a> | WhatsApp: 08xxxxxxxxxx</p>
  </div>
</section>

<!-- Footer -->
<footer>
  <div class="container">
    <p>&copy; 2025 WebSaya. All rights reserved.</p>
  </div>
</footer>

<!-- JS Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
