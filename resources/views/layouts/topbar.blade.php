<style>
    #notif-container {
        position: relative;
        z-index: 1081;
    }

    #notif-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        z-index: 1081;
    }
</style>

<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">

        <!-- Tombol Toggle Sidebar -->
        <button id="btn-toggle-sidebar" class="btn btn-sm btn-outline-light mr-3"
            style="min-width: 38px; height: 38px; padding: 0; border-radius: 6px; font-size: 1.25rem;">
            &#x2715; <!-- icon silang -->
        </button>

        <!-- Brand -->
        <a class="h4 mb-0 text-white d-none d-lg-inline-block" href="{{ route('kasir.home') }}">@yield('judul', 'Last Coffee')</a>

        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">

            <li class="nav-item dropdown" id="notif-container">
                <a class="nav-link" href="#" role="button" id="notif-toggle" data-toggle="dropdown">
                    <i class="ni ni-bell-55 text-white"></i>
                    <span id="notif-count" class="badge badge-danger badge-counter"
                        style="position:absolute; top:8px; right:5px; font-size:0.6rem;">0</span>
                </a>
                <div id="notif-dropdown"
                    class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0 overflow-hidden">
                    <div class="px-3 py-3">
                        <h6 class="text-sm text-muted m-0">Memuat notifikasi...</h6>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('assets') }}/img/theme/gangsta.jpeg" />
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm font-weight-bold">{{ session('username') }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>

                    {{-- <a href="/" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>Edit</span>
                        </a> --}}

                    <div class="dropdown-divider"></div>
                    <a href="#" id="btn-logout" class="dropdown-item text-danger">
                        <i class="ni ni-user-run"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </li>
        </ul>
    </div>
</nav>

<script>
    document.getElementById('btn-logout').addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah link langsung ke route logout

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
                // Redirect ke route logout
                window.location.href = "{{ route('logout') }}";
            }
        });
    });

    // Event: Klik icon lonceng = anggap notif sudah dibaca
    document.getElementById('notif-toggle').addEventListener('click', function() {
        localStorage.setItem('notif_seen', 'true');
        document.getElementById('notif-count').style.display = 'none';
    });

    // Fungsi load notifikasi
    function loadNotifications() {
        fetch("{{ route('notif.stock') }}")
            .then(response => response.json())
            .then(data => {
                const notifCount = document.getElementById('notif-count');
                const notifDropdown = document.getElementById('notif-dropdown');

                // Ambil waktu terakhir notif dilihat, default 0
                let lastSeen = parseInt(localStorage.getItem('notif_last_seen') || '0');

                // Cari notif terbaru berdasarkan waktu, atau 0 kalau tidak ada notif
                let latestNotifTime = 0;
                if (data.notifications && data.notifications.length > 0) {
                    latestNotifTime = new Date(data.notifications[0].time).getTime();
                }

                console.log('Notif count:', data.count);
                console.log('Last seen:', lastSeen);
                console.log('Latest notif time:', latestNotifTime);

                // Apakah ada notif baru?
                const hasNewNotif = latestNotifTime > lastSeen;

                // Tampilkan atau sembunyikan badge
                if (data.count > 0 && hasNewNotif) {
                    notifCount.style.display = 'inline-block';
                    notifCount.textContent = data.count > 99 ? '99+' : data.count;
                } else {
                    notifCount.style.display = 'none';
                }

                // Render isi dropdown
                if (data.count === 0) {
                    notifDropdown.innerHTML = `
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Tidak ada notifikasi saat ini.</h6>
                    </div>`;
                    return;
                }

                let html = `
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">
                        Kamu memiliki <strong class="text-primary">${data.count}</strong> notifikasi
                    </h6>
                </div>
                <div class="list-group list-group-flush">`;

                data.notifications.forEach(n => {
                    html += `
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="ni ${n.icon} text-${n.type}"></i>
                        </div>
                        <div class="col ml--2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 text-sm">${n.title}</h4>
                                <div class="text-right text-muted">
                                    <small>${new Date(n.time).toLocaleTimeString('id-ID', {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })}</small>
                                </div>
                            </div>
                            <p class="text-sm mb-0">${n.message}</p>
                        </div>
                    </div>
                </a>`;
                });

                html += `</div>`;
                notifDropdown.innerHTML = html;
            })
            .catch(err => console.error('Error loading notifications:', err));
    }

    document.getElementById('notif-toggle').addEventListener('click', function() {
        localStorage.setItem('notif_last_seen', Date.now());
        document.getElementById('notif-count').style.display = 'none';
    });

    window.addEventListener('DOMContentLoaded', () => {
        loadNotifications();
        setInterval(loadNotifications, 30000); // refresh tiap 30 detik
    });
</script>
