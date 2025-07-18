    <style>
        nav.topbar-glass {
            background: #fff !important;
            border-radius: 0 0 24px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 0.5rem 2rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            min-height: 56px;
            z-index: 1040;
        }
        .navbar-cafe .container-fluid {
            padding: 0.5rem 1.5rem 0.5rem 1.2rem !important;
            min-height: 60px;
        }
        #sidebarToggleTop {
            transition: background 0.18s, box-shadow 0.18s;
        }
        @media (max-width: 900px) {
            nav.topbar-glass {
                width: 100vw;
                left: 0;
                right: 0;
                border-radius: 0 0 14px 14px;
                padding: 0.4rem 0.3rem;
                margin-bottom: 0.7rem;
                min-width: 0;
                max-width: 100vw;
                overflow-x: hidden;
            }
            .navbar-cafe .container-fluid {
                padding: 0.4rem 0.2rem 0.4rem 0.2rem !important;
            }
            .topbar-admin-min { font-size: 0.95rem; }
            .topbar-divider { margin: 0 0.5rem; }
            #sidebarToggleTop {
                width: 32px;
                height: 32px;
                font-size: 1.1rem;
                margin-right: 0.5rem;
            }
            .fw-bold[style] {
                font-size: 1rem !important;
            }
        }
        @media (max-width: 600px) {
            nav.topbar-glass {
                flex-direction: column;
                align-items: stretch;
                padding: 0.3rem 0.3rem;
            }
            .navbar-cafe .container-fluid {
                flex-direction: column;
                align-items: stretch !important;
                gap: 0.5rem;
            }
            .d-flex.align-items-center {
                flex-direction: row;
                gap: 0.5rem !important;
            }
            #sidebarToggleTop {
                width: 30px;
                height: 30px;
                font-size: 1rem;
                margin-right: 0.3rem;
            }
            .fw-bold[style] {
                font-size: 0.95rem !important;
            }
            .topbar-admin-min {
                font-size: 0.9rem;
            }
        }
    .topbar-admin-wrap {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .topbar-admin-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        border-radius: 2rem;
        transition: background 0.15s;
    }
    .topbar-admin-btn:hover, .topbar-admin-btn:focus {
        background: #f5f5dc;
    }
    .topbar-avatar-min {
        width: 34px;
        height: 34px;
        background: #A07856;
        color: #fff;
        font-weight: 600;
        font-size: 1.1rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 4px #a0785633;
    }
    .topbar-admin-min {
        color: #6F4D38;
        font-size: 1rem;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        margin-left: 0.2rem;
    }
    .topbar-divider {
        width: 1px;
        height: 32px;
        background: #ece7db;
        margin: 0 1.1rem;
        border-radius: 2px;
    }
    .topbar-admin-dropdown {
        position: absolute;
        top: 120%;
        right: 0;
        min-width: 140px;
        background: #fffbe9;
        border-radius: 1rem;
        box-shadow: 0 8px 32px 0 rgba(61,33,26,0.13);
        border: 1px solid #f5f5dc;
        padding: 0.5rem 0.2rem;
        z-index: 100;
        display: none;
        animation: fadeInDown 0.3s cubic-bezier(.4,0,.2,1);
    }
    .topbar-admin-dropdown.show {
        display: block;
    }
    .topbar-admin-dropdown-btn {
        width: 100%;
        background: none;
        border: none;
        color: #A07856;
        font-weight: 500;
        font-size: 1rem;
        padding: 0.6rem 1.2rem;
        border-radius: 0.7rem;
        text-align: left;
        transition: background 0.18s, color 0.18s;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }
    .topbar-admin-dropdown-btn:hover {
        background: #f5f5dc;
        color: #3d211a;
    }
    @media (max-width: 900px) {
        .navbar-cafe .container-fluid { padding: 0.5rem 0.7rem !important; }
        .topbar-admin-min { font-size: 0.95rem; }
        .topbar-divider { margin: 0 0.5rem; }
    }
</style>

<nav class="navbar-cafe navbar navbar-top navbar-expand-md topbar-glass" id="navbar-main" style="background:linear-gradient(90deg,#fffbe9 60%,#fff 100%);box-shadow:0 4px 24px 0 rgba(61,33,26,0.07);border-radius:0 0 2rem 2rem;min-height:70px;">
    <div class="container-fluid d-flex align-items-center justify-content-between" style="padding:0.7rem 2.2rem 0.7rem 1.2rem;">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light rounded-4 shadow-sm d-flex align-items-center justify-content-center" id="sidebarToggleTop" style="background: #fffbe9; color: #3d211a; width: 38px; height: 38px; box-shadow: 0 2px 8px 0 #f5f5dc80; z-index: 2000; pointer-events: auto; position: relative; border:1.5px solid #ece7db;">
                <i class="fas fa-bars fa-lg"></i>
            </button>
            <div>
                <span class="fw-bold" style="color: #3d211a; font-size: 1.18rem; letter-spacing: 0.5px;">@yield('page-title', 'Dashboard Page')</span>
                <div style="color:#a07856; font-size:0.97rem; margin-top:0.13rem;">@yield('page-desc', 'Ringkasan aktivitas terkini')</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="topbar-divider" style="height:40px;width:1.5px;background:#f5f5dc;margin:0 1.2rem 0 0.5rem;"></div>
            <div class="topbar-admin-wrap" style="background:#fffbe9;border:1.5px solid #a0785633;border-radius:2rem;padding:0.18rem 1.1rem 0.18rem 0.5rem;box-shadow:0 2px 8px 0 #f5f5dc80;display:flex;align-items:center;gap:0.7rem;">
                <span class="topbar-avatar-min" style="background:#a07856;color:#fff;font-size:1.1rem;width:34px;height:34px;">A</span>
                <span class="topbar-admin-min" style="color:#6F4D38;font-size:1.08rem;font-weight:600;">Admin</span>
            </div>
            <button class="btn logout-outline-btn ms-2 d-none d-md-flex align-items-center" id="btn-logout-menu-direct">
                <i class="fas fa-sign-out-alt"></i> <span class="d-none d-lg-inline">Logout</span>
            </button>
        </div>
    </div>
</nav>
<style>
    .logout-outline-btn {
        border: 2px solid #e74c3c !important;
        color: #e74c3c !important;
        background: #fff !important;
        border-radius: 2rem !important;
        font-weight: 600;
        font-size: 1.08rem;
        padding: 0.4rem 1.5rem;
        gap: 0.5rem;
        box-shadow: none;
        transition: background 0.18s, color 0.18s, box-shadow 0.18s;
    }
    .logout-outline-btn i {
        color: #e74c3c !important;
        font-size: 1.2rem;
        margin-right: 0.4rem;
    }
    .logout-outline-btn:hover, .logout-outline-btn:focus {
        background: #e74c3c !important;
        color: #fff !important;
        box-shadow: 0 2px 8px 0 #e74c3c22;
    }
    .logout-outline-btn:hover i, .logout-outline-btn:focus i {
        color: #fff !important;
    }
</style>
<script>
     // Sidebar toggle logic is now handled in sidebar.blade.php only to avoid duplicate variable declarations and event listeners.
     // Logout logic
     function handleLogoutClick(e) {
         e.preventDefault();
         Swal.fire({
             title: 'Yakin ingin logout?',
             text: "Kamu akan keluar dari akunmu!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Ya, Logout!',
             cancelButtonText: 'Batal'
         }).then((result) => {
             if (result.isConfirmed) {
                 window.location.href = "{{ route('logout') }}";
             }
         });
     }
     // Only add event for direct logout button (dropdown removed)
     var btnLogoutDirect = document.getElementById('btn-logout-menu-direct');
     if (btnLogoutDirect) {
         btnLogoutDirect.addEventListener('click', handleLogoutClick);
     }
 </script>
