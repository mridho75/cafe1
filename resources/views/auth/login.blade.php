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
    @vite(['resources/css/app.css'])
</head>

<body class="bg-cafe-beige" style="min-height:100vh;height:100vh;overflow:hidden;background:linear-gradient(135deg, #CBB799 0%, #A07856 100%);">
    <div class="main-content">
        <!-- Header -->

            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>

        <!-- Page content -->
        <div class="d-flex align-items-center justify-content-center w-100 h-100" style="min-height:100vh;height:100vh;">
            <div class="row w-100 justify-content-center align-items-center" style="max-width:1050px;min-height:0;">
                <div class="col-lg-8 col-md-10 p-0">
                    <div class="d-flex flex-lg-row flex-column shadow" style="border-radius:24px;overflow:hidden;background:#fff;min-height:520px;max-height:92vh;box-shadow:0 8px 40px 0 rgba(61,33,26,0.13);">
                        <!-- Left: Form -->
                        <div class="p-5 flex-fill d-flex flex-column justify-content-center" style="background:#fff;min-width:340px;min-height:420px;">
                            <div class="mb-4 text-center">
                                <h2 style="color:#6F4D38;font-family:serif;font-weight:700;font-size:2.3rem;">Minano Cafe</h2>
                                <h4 style="color:#3D211A;font-weight:700;font-size:1.45rem;">Admin Login</h4>
                                <div style="color:#6F4D38;opacity:.7;font-size:1.08rem;margin-bottom:10px;">Halaman ini memiliki akses terbatas.</div>
                            </div>
                            @if (session('success'))
                                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        let msg = "{{ session('success') }}";
                                        if (msg.toLowerCase().includes('login berhasil') || msg.toLowerCase().includes('berhasil login')) {
                                            Swal.fire({
                                                toast: true,
                                                position: 'top-end',
                                                icon: 'success',
                                                title: msg,
                                                showConfirmButton: false,
                                                timer: 2200,
                                                timerProgressBar: true,
                                                background: '#CBB799',
                                                color: '#3D211A',
                                                customClass: { popup: 'shadow-lg rounded-3' }
                                            });
                                        }
                                    });
                                </script>
                            @endif
                            @if ($errors->has('login'))
                                <div class="alert card-cafe" style="background:var(--cafe-chamoisee);color:var(--cafe-beige);border-left:6px solid var(--cafe-bistre);margin-bottom:1rem;">
                                    {{ $errors->first('login') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('login.process') }}" class="needs-validation" novalidate autocomplete="off">
                                @csrf
                                <div class="mb-3">
                                    <label for="floatingUsername" class="form-label" style="color:#3D211A;font-weight:600;">Username</label>
                                    <input type="text" class="form-control" id="floatingUsername" name="username" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus style="border-radius:10px;background:#f6f7fa;transition:box-shadow .2s;">
                                </div>
                                <div class="mb-4 position-relative">
                                    <label for="floatingPassword" class="form-label" style="color:#3D211A;font-weight:600;">Password</label>
                                    <input type="password" class="form-control pe-5" id="floatingPassword" name="password" placeholder="Masukkan password" required style="border-radius:10px;background:#f6f7fa;transition:box-shadow .2s;height:44px;min-height:44px;">
                                    <button type="button" class="btn-eye position-absolute" tabindex="-1" onclick="togglePassword()" aria-label="Show password" style="top:70%;right:12px;height:38px;width:38px;display:flex;align-items:center;justify-content:center;background:transparent;border:none;outline:none;box-shadow:none;padding:0;color:#6F4D38;z-index:2;cursor:pointer;transition:color .2s;transform:translateY(-50%);">
                                        <i class="fas fa-eye" id="toggleIcon" style="font-size:1.25rem;transition:color .2s;line-height:1;"></i>
                                    </button>
                                </div>
                                <button type="submit" class="btn w-100" style="background:#A07856;color:#fff;font-weight:700;font-size:1.13rem;border-radius:10px;padding:.8rem 0;box-shadow:0 2px 8px #A0785633;transition:background .2s,box-shadow .2s;letter-spacing:.5px;">Login</button>
                            </form>
                        </div>
                        <!-- Right: Branding -->
                        <div class="d-none d-lg-flex flex-column align-items-center justify-content-center flex-fill" style="background:#3D211A;width: 340px;">
                            <div class="w-100 text-center d-flex align-items-center justify-content-center" style="height:100%;min-height:100px;">
                                <span style="color:#CBB799;font-size:2.5rem;font-family:serif;font-weight:700;letter-spacing:1px;">Minano Cafe</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
        html, body {
            height: 100%;
            min-height: 100vh;
            overflow: hidden;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            height: 100vh;
            background: linear-gradient(135deg, #CBB799 0%, #A07856 100%);
        }
        .btn-cafe, .btn.w-100 {
            transition: background .2s, box-shadow .2s;
        }
        .btn-cafe:hover, .btn-cafe:focus, .btn.w-100:hover, .btn.w-100:focus {
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
        input.form-control {
            font-size:1.08rem;
            padding:.6rem 1rem;
        }
        label.form-label {
            font-size:1.04rem;
        }
        @media (max-width: 991px) {
            .d-none.d-lg-flex.flex-column.align-items-center.justify-content-center.flex-fill {
                display: none !important;
            }
            .col-lg-8.col-md-10.p-0 {
                max-width: 95vw;
            }
        }
        .btn-eye:hover i, .btn-eye:focus i {
            color: #A07856 !important;
        }
        .btn-eye:active i {
            color: #3D211A !important;
        }
        .btn-eye {
            border-radius: 50%;
            transition: background .2s;
        }
        .btn-eye:hover, .btn-eye:focus {
            background: #f0e7df;
        }
        /* Perbaikan spacing dan visual hierarchy */
        .form-label {
            margin-bottom: .35rem;
        }
        .form-control {
            box-shadow: none;
        }
        .mb-4.position-relative {
            margin-bottom: 2rem !important;
        }
        /* Responsive tweak for better mobile usability */
        @media (max-width: 575px) {
            .p-5 { padding: 1.5rem !important; }
        }
        </style>

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
