<style>
    /* Sidebar responsive & collapsible */
    #sidenav-main {
        width: 260px;
        max-width: 90vw;
        transition: left 0.3s cubic-bezier(.4,0,.2,1), width 0.3s, margin-left 0.3s;
        left: 0;
        z-index: 1200;
    }
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.25);
        z-index: 1199;
        transition: opacity 0.2s;
    }
    /* Desktop: hide sidebar when .sidebar-closed */
    @media (min-width: 901px) {
        #sidenav-main.sidebar-closed {
            margin-left: -260px !important;
        }
        .main-content.sidebar-closed {
            margin-left: 0 !important;
        }
    }
    @media (max-width: 900px) {
        #sidenav-main {
            position: fixed;
            left: -100vw;
            top: 0;
            height: 100vh;
            width: 80vw;
            max-width: 340px;
            min-width: 0;
            box-shadow: 2px 0 16px 0 #0002;
        }
        #sidenav-main.sidebar-open {
            left: 0;
        }
        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }
        .sidebar-close-btn {
            display: block;
        }
    }
    .sidebar-close-btn {
        display: none;
        position: absolute;
        top: 1.1rem;
        right: 1.1rem;
        background: none;
        border: none;
        color: #fff;
        font-size: 2rem;
        z-index: 1300;
        cursor: pointer;
    }
</style>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<nav class="sidebar-cafe navbar-vertical fixed-left navbar-expand-md" id="sidenav-main" style="min-height:100vh;background:#3D211A;">
    <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup Sidebar">&times;</button>
    <div class="container-fluid position-relative d-flex flex-column p-0" style="height:100vh;">
        {{-- Brand --}}
        <div class="d-flex align-items-center justify-content-center" style="height:5rem;border-bottom:1px solid #6F4D38;background:#3D211A;">
            <h1 class="logo-text mb-0" style="font-family:'Inter',sans-serif;font-size:2rem;font-weight:700;color:#fff;">Minano Cafe</h1>
        </div>
        {{-- Navigation --}}
        <div class="flex-grow-1 overflow-auto" style="padding:2rem 1rem 1rem 1rem;">
            <ul class="navbar-nav nav flex-column gap-2" id="nav-container" style="font-family:'Inter',sans-serif;">
                {{-- Semua role bisa akses Dashboard --}}
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center gap-2 @if(request()->routeIs('dashboard')) active-sidebar @endif" href="{{ route('dashboard') }}" style="font-weight:600;color:#fff;padding:0.75rem 1rem;border-radius:0.75rem;transition:background 0.2s, color 0.2s;" onmouseover="this.style.background='#6F4D38';this.style.color='#fff'" onmouseout="if(!this.classList.contains('active-sidebar')){this.style.background='transparent';this.style.color='#fff'}" @if(request()->routeIs('dashboard')) style="background:#A07856;color:#fff;" @endif>
                        <i class="ni ni-tv-2" style="color:#fff;"></i> <span>Dashboard</span>
                    </a>
                </li>

                {{-- Hanya untuk ADMIN --}}
                @if (session('role') === 'admin')


                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 @if(request()->routeIs('metode.*')) active-sidebar @endif" href="{{ route('metode.index') }}" style="color:#fff;padding:0.75rem 1rem;border-radius:0.75rem;transition:background 0.2s, color 0.2s;" onmouseover="this.style.background='#6F4D38';this.style.color='#fff'" onmouseout="if(!this.classList.contains('active-sidebar')){this.style.background='transparent';this.style.color='#fff'}" @if(request()->routeIs('metode.*')) style="background:#A07856;color:#fff;" @endif>
                            <i class="ni ni-money-coins" style="color:#fff;"></i> <span>Metode Pembayaran</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 @if(request()->routeIs('category.*')) active-sidebar @endif" href="{{ route('category.index') }}" style="color:#fff;padding:0.75rem 1rem;border-radius:0.75rem;transition:background 0.2s, color 0.2s;" onmouseover="this.style.background='#6F4D38';this.style.color='#fff'" onmouseout="if(!this.classList.contains('active-sidebar')){this.style.background='transparent';this.style.color='#fff'}" @if(request()->routeIs('category.*')) style="background:#A07856;color:#fff;" @endif>
                            <i class="ni ni-tag" style="color:#fff;"></i> <span>Kategori</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 @if(request()->routeIs('menu.*')) active-sidebar @endif" href="{{ route('menu.index') }}" style="color:#fff;padding:0.75rem 1rem;border-radius:0.75rem;transition:background 0.2s, color 0.2s;" onmouseover="this.style.background='#6F4D38';this.style.color='#fff'" onmouseout="if(!this.classList.contains('active-sidebar')){this.style.background='transparent';this.style.color='#fff'}" @if(request()->routeIs('menu.*')) style="background:#A07856;color:#fff;" @endif>
                            <i class="ni ni-bullet-list-67" style="color:#fff;"></i> <span>Menu</span>
                        </a>
                    </li>
                @endif

                {{-- Hanya untuk KASIR --}}
                @if (in_array(session('role'), ['admin', 'kasir']))
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 @if(request()->routeIs('kasir.home')) active-sidebar @endif" href="{{ route('kasir.home') }}" style="color:#fff;padding:0.75rem 1rem;border-radius:0.75rem;transition:background 0.2s, color 0.2s;" onmouseover="this.style.background='#6F4D38';this.style.color='#fff'" onmouseout="if(!this.classList.contains('active-sidebar')){this.style.background='transparent';this.style.color='#fff'}" @if(request()->routeIs('kasir.home')) style="background:#A07856;color:#fff;" @endif>
                            <i class="ni ni-shop" style="color:#fff;"></i> <span>Home - Kasir</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 @if(request()->routeIs('member.*')) active-sidebar @endif" href="{{ route('member.index') }}" style="color:#fff;padding:0.75rem 1rem;border-radius:0.75rem;transition:background 0.2s, color 0.2s;" onmouseover="this.style.background='#6F4D38';this.style.color='#fff'" onmouseout="if(!this.classList.contains('active-sidebar')){this.style.background='transparent';this.style.color='#fff'}" @if(request()->routeIs('member.*')) style="background:#A07856;color:#fff;" @endif>
                            <i class="ni ni-badge" style="color:#fff;"></i> <span>Member</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 @if(request()->routeIs('reservasi.*')) active-sidebar @endif" href="{{ route('reservasi.index') }}" style="color:#fff;padding:0.75rem 1rem;border-radius:0.75rem;transition:background 0.2s, color 0.2s;" onmouseover="this.style.background='#6F4D38';this.style.color='#fff'" onmouseout="if(!this.classList.contains('active-sidebar')){this.style.background='transparent';this.style.color='#fff'}" @if(request()->routeIs('reservasi.*')) style="background:#A07856;color:#fff;" @endif>
                            <i class="ni ni-calendar-grid-58" style="color:#fff;"></i> <span>Reservasi</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 @if(request()->routeIs('kasir.create_order')) active-sidebar @endif" href="{{ route('kasir.create_order') }}" style="color:#fff;padding:0.75rem 1rem;border-radius:0.75rem;transition:background 0.2s, color 0.2s;" onmouseover="this.style.background='#6F4D38';this.style.color='#fff'" onmouseout="if(!this.classList.contains('active-sidebar')){this.style.background='transparent';this.style.color='#fff'}" @if(request()->routeIs('kasir.create_order')) style="background:#A07856;color:#fff;" @endif>
                            <i class="ni ni-cart" style="color:#fff;"></i> <span>Transaksi - Kasir</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 @if(request()->routeIs('order.*')) active-sidebar @endif" href="{{ route('order.index') }}" style="color:#fff;padding:0.75rem 1rem;border-radius:0.75rem;transition:background 0.2s, color 0.2s;" onmouseover="this.style.background='#6F4D38';this.style.color='#fff'" onmouseout="if(!this.classList.contains('active-sidebar')){this.style.background='transparent';this.style.color='#fff'}" @if(request()->routeIs('order.*')) style="background:#A07856;color:#fff;" @endif>
                            <i class="ni ni-credit-card" style="color:#fff;"></i> <span>Daftar Transaksi</span>
                        </a>
                    </li>
                @endif

                {{-- Hanya untuk OWNER --}}
                @if (in_array(session('role'), ['admin', 'pemilik']))
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 @if(request()->routeIs('owner.laporan')) active-sidebar @endif" href="{{ route('owner.laporan') }}" style="color:#fff;padding:0.75rem 1rem;border-radius:0.75rem;transition:background 0.2s, color 0.2s;" onmouseover="this.style.background='#6F4D38';this.style.color='#fff'" onmouseout="if(!this.classList.contains('active-sidebar')){this.style.background='transparent';this.style.color='#fff'}" @if(request()->routeIs('owner.laporan')) style="background:#A07856;color:#fff;" @endif>
                            <i class="ni ni-archive-2" style="color:#fff;"></i> <span>Laporan</span>
                        </a>
<style>
.active-sidebar {
    background: #A07856 !important;
    color: #fff !important;
    font-weight: 700;
}
.nav-link:hover {
    color: #fff !important;
    background: #6F4D38 !important;
    transition: background 0.2s, color 0.2s;
}
</style>
                    </li>
                @endif
            </ul>


        </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidenav-main');
        const overlay = document.getElementById('sidebarOverlay');
        const closeBtn = document.getElementById('sidebarCloseBtn');
        const sidebarToggleBtn = document.getElementById('sidebarToggleTop');
        const mainContent = document.querySelector('.main-content');

        function openSidebar() {
          if (window.innerWidth <= 900) {
            sidebar.classList.add('sidebar-open');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
          } else {
            sidebar.classList.remove('sidebar-closed');
            if (mainContent) mainContent.classList.remove('sidebar-closed');
          }
        }
        function closeSidebar() {
          if (window.innerWidth <= 900) {
            sidebar.classList.remove('sidebar-open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
          } else {
            sidebar.classList.add('sidebar-closed');
            if (mainContent) mainContent.classList.add('sidebar-closed');
          }
        }
        if (closeBtn) closeBtn.onclick = closeSidebar;
        if (overlay) overlay.onclick = closeSidebar;
        if (sidebarToggleBtn) {
          sidebarToggleBtn.onclick = function(e) {
            e.preventDefault();
            if (window.innerWidth <= 900) {
              // Mobile: toggle overlay sidebar
              if (sidebar.classList.contains('sidebar-open')) {
                closeSidebar();
              } else {
                openSidebar();
              }
            } else {
              // Desktop: toggle collapse
              if (sidebar.classList.contains('sidebar-closed')) {
                openSidebar();
              } else {
                closeSidebar();
              }
            }
          };
        }
        // Responsive: close overlay on resize to desktop, open on resize to mobile
        window.addEventListener('resize', function() {
          if (window.innerWidth > 900) {
            // Remove overlay mode
            sidebar.classList.remove('sidebar-open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
          } else {
            // Remove desktop collapse
            sidebar.classList.remove('sidebar-closed');
            if (mainContent) mainContent.classList.remove('sidebar-closed');
          }
        });
      });
    </script>
</nav>


