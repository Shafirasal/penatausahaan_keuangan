<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; Biro PBJ</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('stisla1/node_modules/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('stisla1/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla1/assets/css/components.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex flex-wrap align-items-stretch">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="p-4 m-3">
                        <img src="{{ asset('assets/logo.png') }}" alt="logo" width="100">
                        <h4 class="text-dark font-weight-normal">Selamat Datang di <span
                                class="font-weight-bold">Penatausahaan Keuangan Biro PBJ</span></h4>
                        <p class="text-muted">Login</p>

                        <form id="loginForm" method="POST" action="#" class="needs-validation" novalidate="">
                            @csrf
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input id="nip" type="text" class="form-control" name="nip" required
                                    autofocus>
                                <div class="invalid-feedback">
                                    Masukkan NIP
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                                <div class="invalid-feedback">
                                    Masukkan Password
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right">
                                    Login
                                </button>
                            </div>
                        </form>

                        {{-- Footer dan lainnya --}}
                    </div>
                </div>

                {{-- Background Kanan --}}
                <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100"
                    style="background-image: url('{{ asset('assets/poto_pbj.png') }}'); background-size: cover; background-position: center;">
                </div>

            </div>
        </section>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="{{ asset('stisla1/assets/js/stisla.js') }}"></script>
    <script src="{{ asset('stisla1/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('stisla1/assets/js/custom.js') }}"></script>

    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            const nip = $('#nip').val();
            const password = $('#password').val();

            $.ajax({
                url: '/api/login',
                method: 'POST',
                data: {
                    nip: nip,
                    password: password
                },
                success: function(response) {
                    const token = response.authorisation.token;
                    localStorage.setItem('token', token);

                    // 🔁 Sync session
                    $.ajax({
                        url: '/sync-session',
                        method: 'GET',
                        headers: {
                            Authorization: 'Bearer ' + token
                        },
                        success: function() {
                            // ✅ Selesai, redirect ke dashboard
                            window.location.href = '/home';
                        },
                        error: function() {
                            alert('Gagal menyimpan session');
                        }
                    });
                },
                error: function(xhr) {
                    alert('Login gagal: ' + xhr.responseJSON.message);
                }
            });

        });
    </script>

</body>

</html>
