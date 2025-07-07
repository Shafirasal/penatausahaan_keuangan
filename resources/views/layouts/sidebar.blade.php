        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            {{-- <img src="assets/logo.png"> --}}
            <a href="index.html">BIRO PBJ</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
          </div>

        {{--sidebar menu--}}
          <ul class="sidebar-menu"> 
            <li class="menu-header">Dashboard</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="">General Dashboard</a></li>
                  <li><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li>
                </ul>
              </li>
              <li class="menu-header">Master Data</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Biodata Pegawai</span></a>
                <ul class="dropdown-menu">

                  <li><a class="nav-link" href="{{ url('/riwayat_pendidikan') }}">Riwayat Pendidikan</a></li>
                  <li><a class="nav-link" href="layout-top-navigation.html">Jabatan Fungsional</a></li>
                  <li><a class="nav-link" href="layout-top-navigation.html">Jabatan Struktural</a></li>
                  <li><a class="nav-link" href="layout-top-navigation.html">Riwayat Pegawai</a></li>
                </ul>
              </li>
              {{-- <li class="active"><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li> --}}
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>SIPD</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="layout-transparent.html">Bagian PBJ</a></li>
                  <li><a class="nav-link" href="bootstrap-badge.html">Bagian LPSE</a></li>
                  <li><a class="nav-link" href="bootstrap-breadcrumb.html">Bagian Pembinaan</a></li>
    
                </ul>
              </li>
              <li class="menu-header">Transaksional</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i> <span>Realisasi Anggaran</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="components-article.html">Bagian PBJ</a></li>
                  <li><a class="nav-link" href="components-article.html">Bagian LPSE</a></li>
                  <li><a class="nav-link" href="components-article.html">Bagian Pembinaan</a></li>
                </ul>
              </li>

             <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Surat Perintah Kerja</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="components-article.html">Bagian PBJ</a></li>
                  <li><a class="nav-link" href="components-article.html">Bagian LPSE</a></li>
                  <li><a class="nav-link" href="components-article.html">Bagian Pembinaan</a></li>
                </ul>
              </li>
              
              
              <li class="menu-header">Laporan</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Auth</span></a>
                <ul class="dropdown-menu">
                  <li><a href="auth-forgot-password.html">Forgot Password</a></li>
                  <li><a href="auth-login.html">Login</a></li>
                  <li><a class="beep beep-sidebar" href="auth-login-2.html">Login 2</a></li>
                  <li><a href="auth-register.html">Register</a></li>
                  <li><a href="auth-reset-password.html">Reset Password</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-bicycle"></i> <span>Features</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="features-activities.html">Activities</a></li>
                  <li><a class="nav-link" href="features-post-create.html">Post Create</a></li>
                  <li><a class="nav-link" href="features-posts.html">Posts</a></li>
                  <li><a class="nav-link" href="features-profile.html">Profile</a></li>
                  <li><a class="nav-link" href="features-settings.html">Settings</a></li>
                  <li><a class="nav-link" href="features-setting-detail.html">Setting Detail</a></li>
                  <li><a class="nav-link" href="features-tickets.html">Tickets</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-ellipsis-h"></i> <span>Utilities</span></a>
                <ul class="dropdown-menu">
                  <li><a href="utilities-contact.html">Contact</a></li>
                  <li><a class="nav-link" href="utilities-invoice.html">Invoice</a></li>
                  <li><a href="utilities-subscribe.html">Subscribe</a></li>
                </ul>
              </li>
              <li><a class="nav-link" href="credits.html"><i class="fas fa-pencil-ruler"></i> <span>Credits</span></a></li>
          </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
              </a>
            </div>
        </aside>