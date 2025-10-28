       <aside id="sidebar-wrapper">
           <div class="sidebar-brand">
               {{-- <img src="assets/logo.png"> --}}
               <a href="index.html">BIRO PBJ</a>
           </div>
           <div class="sidebar-brand sidebar-brand-sm">
               <a href="index.html">BPBJ</a>
           </div>

           {{-- sidebar menu --}}
           <ul class="sidebar-menu">
               <li class="menu-header">Dashboard</li>
               <li class="nav-item dropdown">
                   <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                   <ul class="dropdown-menu">
                       <li><a class="nav-link" href="{{ url('/dashboard') }}">General Dashboard</a></li>
                   </ul>
               </li>
               <li class="menu-header">Master Data</li>
               <li class="nav-item dropdown">
                   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                       <span>Biodata</span></a>
                   <ul class="dropdown-menu">
                       @if (auth()->user()->level == 'admin')
                           <li><a class="nav-link" href="{{ url('/user') }}">Tambah User</a></li>
                           <li><a class="nav-link" href="{{ url('/pegawai') }}">Daftar Pegawai</a></li>
                        @endif

                       @if (in_array(auth()->user()->level, ['admin', 'operator', 'pimpinan', 'pegawai']))
                           <li><a class="nav-link" href="{{ url('/riwayat_pendidikan') }}">Riwayat Pendidikan</a></li>
                           <li><a class="nav-link" href="{{ url('/jabatan_fungsional') }}">Jabatan Fungsional</a></li>
                           <li><a class="nav-link" href="{{ url('/jabatan_struktural') }}">Jabatan Struktural</a></li>
                           <li><a class="nav-link" href="{{ url('/riwayat_kepegawaian') }}">Riwayat Pegawai</a></li>
                           <li><a class="nav-link" href="{{ url('/riwayat_pendidikan') }}">Riwayat Pendidikan</a></li>
                           <li><a class="nav-link" href="{{ url('/jabatan_fungsional') }}">Jabatan Fungsional</a></li>
                           <li><a class="nav-link" href="{{ url('/jabatan_struktural') }}">Jabatan Struktural</a></li>
                           <li><a class="nav-link" href="{{ url('/riwayat_kepegawaian') }}">Riwayat Pegawai</a></li>
                       @endif

                   </ul>
               </li>
               {{-- <li class="active"><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li> --}}
               @if (in_array(auth()->user()->level, ['admin', 'operator', 'pimpinan']))

                   <li class="nav-item dropdown">
                       <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>SIPD</span></a>
                       <ul class="dropdown-menu">
                             @if (in_array(auth()->user()->level, ['admin', 'operator']))
                               <li><a class="nav-link" href="{{ url('/master_program') }}">Master Program</a></li>
                               <li><a class="nav-link" href="{{ url('/master_kegiatan') }}">Master Kegiatan</a></li>
                               <li><a class="nav-link" href="{{ url('/master_sub_kegiatan') }}">Master Sub-Kegiatan</a></li>
                               <li><a class="nav-link" href="{{ url('/master_rekening') }}">Master Rekening</a></li>
                               <li><a class="nav-link" href="{{ url('/ssh') }}">Master SSH</a></li>
                          @elseif (in_array(auth()->user()->level, ['admin', 'pimpinan']))
                               <li><a class="nav-link" href="{{ url('tree_view') }}">List DPA</a></li>
                           @endif
                       </ul>
                   </li>
               @endif

              @if (in_array(auth()->user()->level, ['admin', 'operator']))
               <li class="menu-header">Transaksional</li>
               <li class="nav-item dropdown">
                   <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i> <span>Realisasi Anggaran</span></a>
                   <ul class="dropdown-menu">
                       <li><a class="nav-link" href="{{ url('/realisasipbj') }}">Bagian PBJ</a></li>
                       <li><a class="nav-link" href="{{ url('/realisasilpse') }}">Bagian LPSE</a></li>
                       <li><a class="nav-link" href={{ url('/realisasipembinaan') }}>Bagian Pembinaan</a></li>
                       <li><a class="nav-link" href={{ url('/realisasitatakelola') }}>Bagian TU</a></li>
                   </ul>
               </li>
               @endif
{{-- 
               <li class="nav-item dropdown">
                   <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Surat Perintah
                           Kerja</span></a>
                   <ul class="dropdown-menu">
                       <li><a class="nav-link" href="components-article.html">Bagian PBJ</a></li>
                       <li><a class="nav-link" href="components-article.html">Bagian LPSE</a></li>
                       <li><a class="nav-link" href="components-article.html">Bagian Pembinaan</a></li>
                   </ul>
               </li> --}}


               {{-- <li class="menu-header">Laporan</li>
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
           </ul> --}}

           {{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
               <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                   <i class="fas fa-rocket"></i> Documentation.
               </a>
           </div> --}}
       </aside>
