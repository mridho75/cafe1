<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title', 'Dashboard')</title>
    <link href="{{ asset('assets/img/brand/favicon.png') }}" rel="icon" type="image/png" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/argon-dashboard.css?v=1.1.2') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Custom Cafe Color Palette & UI -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        @media (max-width: 900px) {
            html, body {
                width: 100vw !important;
                min-width: 0 !important;
                max-width: 100vw !important;
                overflow-x: hidden !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .container, .container-fluid, .row, .card, .card-cafe, .shadow, nav.topbar-glass {
                width: 100vw !important;
                min-width: 0 !important;
                max-width: 100vw !important;
                margin: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
        }
        /* Responsive container & card */
        .container, .container-fluid {
            width: 100% !important;
            max-width: 100vw;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .card, .card-cafe, .shadow, .shadow-lg {
            max-width: 100%;
            overflow-x: auto;
        }
        /* Responsive table */
        table {
            width: 100% !important;
            min-width: 600px;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        /* Responsive form */
        .form-control, .form-select {
            min-width: 0;
            width: 100%;
            box-sizing: border-box;
        }
        /* Utility for gap and flex on mobile */
        @media (max-width: 900px) {
            .container, .container-fluid {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
            .card, .card-cafe, .shadow, .shadow-lg {
                padding: 1rem 0.7rem;
            }
            .row, .d-flex {
                flex-direction: column !important;
                gap: 0.7rem !important;
            }
            .col-lg-8, .col-lg-7, .col-md-10, .col-md-9 {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
            }
            .table-responsive, table {
                min-width: 0;
            }
            .form-control, .form-select {
                font-size: 1rem;
            }
        }
        @media (max-width: 600px) {
            .container, .container-fluid {
                padding-left: 0.2rem;
                padding-right: 0.2rem;
            }
            .card, .card-cafe, .shadow, .shadow-lg {
                padding: 0.7rem 0.3rem;
            }
            .fw-bold, h1, h2, h3, h4, h5 {
                font-size: 1rem !important;
            }
            .form-label, label {
                font-size: 0.97rem !important;
            }
        }
        /* Additional global responsive improvements */
        @media (max-width: 480px) {
            html, body {
                overflow-x: hidden !important;
                max-width: 100vw !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .container, .container-fluid, .row, .card, .card-cafe, .shadow, nav.topbar-glass {
                max-width: 100vw !important;
                width: 100vw !important;
                margin: 0 !important;
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
                overflow-x: hidden !important;
            }
            .btn-cafe {
                padding: 0.4rem 1rem;
                font-size: 0.9rem;
            }
            .card-cafe {
                padding: 1rem;
            }
            .table-responsive {
                font-size: 0.9rem;
            }
            .navbar-cafe {
                padding: 0.5rem 1rem;
                font-size: 1rem;
            }
            .sidebar-cafe {
                font-size: 0.9rem;
            }
            .footer-cafe {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>

<style>
    .ant-popover {
        display: none !important;
    }
</style>


<body>
    @include('layouts.sidebar')

    <div class="main-content" style="background:#F5F5DC;min-height:100vh;">
        <div class="header" style="background:#F5F5DC;padding-bottom:0.5rem;padding-top:2.5rem;">
            <div class="container-fluid">
                <div class="header-body">
                    {{-- Optional header card --}}
                    @include('layouts.topbar')
                </div>
            </div>
        </div>

        @if (session('debug'))
            <pre>{{ print_r(session('debug'), true) }}</pre>
        @endif

        <div class="container-fluid" style="margin-top:0;max-width:100vw;">
            <div style="background:#fff;min-height:calc(100vh - 80px);padding:2.5rem 2.5rem 2.5rem 2.5rem;border-radius:1.5rem;box-shadow:0 4px 24px 0 rgba(61,33,26,0.08);">
                @yield('content')
                @include('layouts.footer')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.remove(); // Ini akan hapus elemen dari DOM
                }, 3000); // 3 detik
            }
        });

    </script>



    <!-- Core JS -->
    <script src="{{ asset('assets/js/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chart.js/dist/Chart.extension.js') }}"></script>
    <script src="{{ asset('assets/js/argon-dashboard.min.js?v=1.1.2') }}"></script>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: "{{ session('error') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>


    @yield('scripts')

</body>

</html>
