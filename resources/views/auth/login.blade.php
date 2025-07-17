<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Minano Cafe</title>
    <!-- Favicon -->
    <link href="{{ asset('assets/img/brand/favicon.png') }}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('assets/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-cafe-beige" style="min-height:100vh; background:linear-gradient(135deg, #F5F5DC 0%, #CBB799 50%, #6F4D38 100%);">
    <div class="main-content">
        <!-- Header -->
        <div class="header" style="background:var(--cafe-coffee);padding:3rem 0 2rem 0;">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6 mt-4">
                            <h1 class="text-cafe-beige" style="font-weight:700;letter-spacing:2px;">☕ Selamat Datang!</h1>
                            <p class="text-cafe-khaki" style="font-size:1.1rem;">Silakan login untuk melanjutkan ke sistem kasir.</p>
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
        <div class="container d-flex align-items-center justify-content-center" style="min-height:70vh;">
            <div class="card-cafe shadow-lg p-4" style="max-width:410px;width:100%;border-radius:1.5rem;box-shadow:0 8px 32px 0 rgba(61,33,26,0.18);animation:fadeInUp 0.7s cubic-bezier(.4,2,.6,1);backdrop-filter:blur(2px);">
                <div class="text-center mb-4">
                    <div class="mb-2 pt-2">
                        <i class="fas fa-coffee fa-2x" style="color:var(--cafe-coffee);filter:drop-shadow(0 2px 6px #CBB79988);"></i>
                    </div>
                    <h4 class="mb-1" style="color:var(--cafe-coffee);font-weight:800;letter-spacing:1px;">Login ke Minano Cafe</h4>
                    <p class="text-cafe-chamoisee small" style="font-size:1.05rem;">Akses sistem kasir dengan akun Anda</p>
                </div>
                @if (session('success'))
                    <div class="alert card-cafe" style="background:var(--cafe-khaki);color:var(--cafe-bistre);border-left:6px solid var(--cafe-coffee);margin-bottom:1rem;">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->has('login'))
                    <div class="alert card-cafe" style="background:var(--cafe-chamoisee);color:var(--cafe-beige);border-left:6px solid var(--cafe-bistre);margin-bottom:1rem;">
                        {{ $errors->first('login') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login.process') }}" class="needs-validation" novalidate autocomplete="off">
                    @csrf
                    <div class="form-group mb-3 position-relative">
                        <label for="floatingUsername" style="color:var(--cafe-bistre);font-weight:600;">Username</label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--cafe-chamoisee);font-size:1.1rem;"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="floatingUsername" name="username" placeholder="Username" value="{{ old('username') }}" required autofocus style="padding-left:2.2rem;transition:box-shadow .2s;box-shadow:0 1px 4px #CBB79922;">
                        </div>
                        @error('username')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3 position-relative">
                        <label for="floatingPassword" style="color:var(--cafe-bistre);font-weight:600;">Password</label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--cafe-chamoisee);font-size:1.1rem;"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required style="padding-left:2.2rem;transition:box-shadow .2s;box-shadow:0 1px 4px #CBB79922;">
                            <button type="button" class="btn btn-sm btn-link text-cafe-coffee position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePassword()" style="z-index:2;">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn-cafe" style="font-size:1.15rem;border-radius:2rem;box-shadow:0 2px 8px #A0785633;transition:background .2s,box-shadow .2s;">Login</button>
                    </div>
                </form>
                <div class="mt-4 text-center">
                    <small class="text-cafe-chamoisee">© {{ date('Y') }} Minano Cafe • All rights reserved</small>
                </div>
            </div>
        </div>
        <style>
        @keyframes fadeInUp {
            from { opacity:0; transform:translateY(40px); }
            to { opacity:1; transform:translateY(0); }
        }
        .btn-cafe:hover, .btn-cafe:focus {
            background: var(--cafe-coffee) !important;
            color: var(--cafe-beige) !important;
            box-shadow: 0 4px 16px #6F4D3844;
        }
        .card-cafe {
            transition: box-shadow .2s, transform .2s;
        }
        .card-cafe:hover {
            box-shadow: 0 12px 32px 0 rgba(61,33,26,0.22);
            transform: translateY(-2px) scale(1.01);
        }
        input.form-control:focus {
            box-shadow: 0 0 0 2px var(--cafe-chamoisee) !important;
            border-color: var(--cafe-chamoisee) !important;
        }
        </style>

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
