<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid position-relative">

        {{-- Brand --}}
        <a class="pt-0" href="{{ route('dashboard') }}">
            <h1 class="mt-2 logo-text">Last Coffee</h1>
        </a>



        {{-- Collapse --}}
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">

            {{-- Navigation --}}
            <ul class="navbar-nav">
                {{-- Semua role bisa akses Dashboard --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="ni ni-tv-2 text-blue"></i> Dashboard
                    </a>
                </li>

                {{-- Hanya untuk ADMIN --}}
                @if (session('role') === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.index') }}">
                            <i class="ni ni-single-02 text-pink"></i> User
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('metode.index') }}">
                            <i class="ni ni-money-coins text-success"></i> Metode Pembayaran
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('category.index') }}">
                            <i class="ni ni-tag text-success"></i> Kategori
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('menu.index') }}">
                            <i class="ni ni-bullet-list-67 text-orange"></i> Menu
                        </a>
                    </li>
                @endif

                {{-- Hanya untuk KASIR --}}
                @if (in_array(session('role'), ['admin', 'kasir']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kasir.home') }}">
                            <i class="ni ni-shop text-info"></i> Home - Kasir
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('member.index') }}">
                            <i class="ni ni-badge text-primary"></i> Member
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reservasi.index') }}">
                            <i class="ni ni-calendar-grid-58 text-info"></i> Reservasi
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kasir.create_order') }}">
                            <i class="ni ni-cart text-success"></i> Transaksi - Kasir
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order.index') }}">
                            <i class="ni ni-credit-card  text-warning"></i> Daftar Transaksi
                        </a>
                    </li>
                @endif

                {{-- Hanya untuk OWNER --}}
                @if (in_array(session('role'), ['admin', 'pemilik']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('owner.laporan') }}">
                            <i class="ni ni-archive-2 text-danger"></i> Laporan
                        </a>
                    </li>
                @endif
            </ul>


        </div>
    </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const btnToggleSidebar = document.getElementById('btn-toggle-sidebar');
    const sidebar = document.getElementById('sidenav-main');
    const mainContent = document.querySelector('.main-content');
    const topbar = document.getElementById('navbar-main');
    const footer = document.querySelector('footer.footer');

    btnToggleSidebar.addEventListener('click', () => {
      sidebar.classList.toggle('closed');
      mainContent.classList.toggle('sidebar-closed');
      topbar.classList.toggle('sidebar-closed');
      footer.classList.toggle('sidebar-closed');

      // Ubah icon tombol saat toggle: silang (×) atau panah (⮜)
      if (sidebar.classList.contains('closed')) {
        btnToggleSidebar.innerHTML = '&#9776;'; // icon hamburger
        // Atau pakai icon panah misal '&#x25B6;' (▶)
      } else {
        btnToggleSidebar.innerHTML = '&#x2715;'; // icon silang
      }
    });
  });
</script>
