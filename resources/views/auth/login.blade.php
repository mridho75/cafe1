<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Cafe POS</title>
    <!-- Favicon -->
    <link href="{{ asset('assets/img/brand/favicon.png') }}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('assets/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/argon-dashboard.css?v=1.1.2') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-default">
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-6">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6 mt-4">
                            <h1 class="text-white">Selamat Datang!</h1>
                            <p class="text-lead text-light">Silakan login untuk melanjutkan ke sistem kasir.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>

        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary shadow border-0">

                        <div class="card bg-white border-0 shadow-lg rounded-3 px-5 py-4">
                            <div class="text-center mb-4">
                                <div class="mb-2 pt-2">
                                    <i class="fas fa-coffee fa-2x text-default"></i>
                                </div>
                                <h4 class="text-dark fw-bold">Login ke Cafe POS</h4>
                                <p class="text-muted small">Akses sistem kasir dengan akun Anda</p>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->has('login'))
                                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                                    {{ $errors->first('login') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login.process') }}" class="needs-validation"
                                novalidate>
                                @csrf

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingUsername" name="username"
                                        placeholder="Username" value="{{ old('username') }}" required>
                                    <label for="floatingUsername"><i class="fas fa-user me-2"></i>Username</label>
                                    @error('username')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3 position-relative">
                                    <input type="password" class="form-control" id="floatingPassword" name="password"
                                        placeholder="Password" required>
                                    <label for="floatingPassword"><i class="fas fa-lock me-2"></i>Password</label>

                                    <button type="button"
                                        class="btn btn-sm btn-link text-muted position-absolute top-50 end-0 translate-middle-y me-3"
                                        onclick="togglePassword()" style="z-index: 2;">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>

                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success py-2 fw-semibold">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login
                                    </button>
                                </div>
                            </form>

                            <div class="mt-4 text-center">
                                <small class="text-muted">© {{ date('Y') }} Cafe POS • All rights reserved</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="py-5">
            <div class="container">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-2">
                        <div class="copyright text-center text-xl-left text-secondary">
                            © {{ date('Y') }} <a href="https://www.creative-tim.com"
                                class="font-weight-bold ml-1 link-offset-2 link-underline link-underline-opacity-0"
                                target="_blank">Creative Tim</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.remove(); // Hapus elemen alert dari DOM, bukan cuma sembunyi
                }, 2000); // 3 detik
            }
        });

        function togglePassword() {
            const passwordField = document.getElementById("floatingPassword");
            const toggleIcon = document.getElementById("toggleIcon");
            const isPassword = passwordField.type === "password";

            passwordField.type = isPassword ? "text" : "password";
            toggleIcon.classList.toggle("fa-eye");
            toggleIcon.classList.toggle("fa-eye-slash");
        }
    </script>

    <script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/argon-dashboard.min.js?v=1.1.2') }}"></script>
</body>

</html>
