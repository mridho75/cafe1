@extends('layouts.app')

@section('title', 'Pesanan - Kasir')
@section('judul', 'Halaman Pemesanan')

@section('content')
    <div class="container">
        <h2 class="mb-5 text-center font-weight-bold text-dark">Transaksi</h2>

        <!-- Bagian pencarian dan filter kategori menu -->
        <div class="row g-3 align-items-end mb-4 respon">
            <!-- Input pencarian berdasarkan nama menu -->
            <div class="col-md-6">
                <label for="searchInput" class="form-label fw-semibold text-dark">
                    <i class="bi bi-search me-1"></i> Cari Nama Menu
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control"
                        placeholder="Contoh: Nasi Goreng, Ayam Bakar...">
                </div>
            </div>

            <!-- Dropdown filter kategori menu -->
            <div class="col-md-6">
                <label for="categoryFilter" class="form-label fw-semibold text-dark">
                    <i class="bi bi-funnel-fill me-1"></i> Filter Kategori Menu
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="bi bi-tags-fill"></i>
                    </span>
                    <select id="categoryFilter" class="form-select">
                        <option value="">🌐 Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->nama_category }}">🍽️ {{ $category->nama_category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- Bagian daftar menu berdasarkan kategori -->
            <div class="col-lg-8 mb-4">
                <div class="row">
                    @foreach ($categories as $category)
                        @if ($category->menus->count() > 0)
                            <div class="col-12 mb-4">
                                <h4 class="text-primary border-bottom pb-2 mb-3">{{ $category->nama_category }}</h4>
                                <div class="row g-3">
                                    @foreach ($category->menus as $menu)
                                        <div class="col-md-4 mb-4 menu-item" data-nama="{{ strtolower($menu->nama_menu) }}"
                                            data-kategori="{{ strtolower($category->nama_category) }}">
                                            <div class="menu-card position-relative">
                                                <div class="position-relative" style="overflow: hidden;">
                                                    <img src="{{ asset($menu->image) }}" alt="{{ $menu->nama_menu }}"
                                                        style="@if ($menu->stok <= 0) filter: blur(3px) brightness(0.6); @endif" />
                                                    @if ($menu->stok <= 0)
                                                        <div class="overlay-stock-habis">Stock Habis</div>
                                                    @endif
                                                </div>
                                                <div class="menu-card-body">
                                                    <h5 class="menu-card-title">{{ $menu->nama_menu }}</h5>
                                                    <p class="menu-card-price">Rp
                                                        {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                                    <p class="menu-card-stock">Stok: <strong>{{ $menu->stok }}</strong>
                                                    </p>
                                                    <div class="menu-card-controls">
                                                        <button class="btn btn-outline-danger btn-kurang btn-sm"
                                                            data-id="{{ $menu->id }}">-</button>
                                                        <span id="qty-display-{{ $menu->id }}">0</span>
                                                        <button class="btn btn-outline-primary btn-tambah btn-sm"
                                                            data-id="{{ $menu->id }}"
                                                            data-nama="{{ e($menu->nama_menu) }}"
                                                            data-harga="{{ $menu->harga }}"
                                                            data-image="{{ asset($menu->image) }}"
                                                            data-stok="{{ $menu->stok }}"
                                                            @if ($menu->stok <= 0) disabled @endif>+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>

            {{-- keranjang --}}
            <div id="keranjang-sidebar" class="keranjang-card shadow-lg rounded-4">
                <div class="keranjang-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">🛒 Keranjang</h5>
                    <button type="button" class="btn btn-sm btn-outline-danger" id="btn-reset-keranjang"
                        title="Reset Keranjang">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>

                <div class="keranjang-list px-3 py-2" id="keranjang-list">
                    <!-- Konten keranjang via JS -->
                </div>

                <div class="keranjang-footer px-3 py-3 border-top bg-light">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-semibold">Subtotal:</span>
                        <span>Rp <strong id="subtotal-display">0</strong></span>
                    </div>
                    <button type="button" class="btn btn-success w-100 rounded-pill fw-semibold" id="btn-simpan">
                        Simpan Transaksi
                    </button>
                </div>
            </div>



            <!-- Form tersembunyi untuk submit transaksi -->
            <form id="form-transaksi" action="{{ route('order.store') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <!-- Modal form pembayaran -->
            <div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form-modal">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Form Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <!-- Subtotal tersembunyi untuk kalkulasi -->
                                <input type="hidden" id="modal-subtotal-hidden" />

                                <!-- Info kasir (user yang login) -->
                                <div class="form-group mb-3">
                                    <label for="id_user">Kasir</label>
                                    <input type="text" class="form-control" value="{{ $loggedInUser->user_name }}"
                                        readonly>
                                    <input type="hidden" name="id_user" id="id_user"
                                        value="{{ $loggedInUser->id }}">
                                </div>

                                <!-- Pilih reservasi (jika ada) -->
                                <div class="mb-3">
                                    <label class="form-label">Reservasi</label>
                                    <select name="id_reservasi" id="id_reservasi" class="form-select">
                                        <option value="">-- Pilih Reservasi --</option>
                                        @foreach ($reservasis as $reservasi)
                                            <option value="{{ $reservasi->id }}" data-dp="{{ $reservasi->dp ?? 0 }}">
                                                • {{ $reservasi->nama_pelanggan }} - Meja {{ $reservasi->nomor_meja }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Pilih member (jika ada) -->
                                <div class="mb-3">
                                    <label class="form-label">Member</label>
                                    <select name="id_member" id="id_member" class="form-select">
                                        <option value="">-- Non-Member --</option>
                                        @foreach ($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->nama_members }}
                                                ({{ $member->kode }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tanggal transaksi default hari ini -->
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Transaksi</label>
                                    <input type="date" name="tgl" id="tgl" class="form-control"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>

                                <!-- Display DP reservasi -->
                                <div class="mb-3">
                                    <label class="form-label">DP Reservasi</label>
                                    <input type="text" id="dpDisplay" class="form-control" readonly value="Rp 0" />
                                </div>

                                <!-- Display total bayar setelah dikurangi DP -->
                                <div class="mb-3">
                                    <label class="form-label">Total Bayar Setelah DP</label>
                                    <input type="text" id="subtotalAfterDpDisplay" class="form-control" readonly
                                        value="Rp 0" />
                                </div>

                                <!-- Pilih metode pembayaran -->
                                <div class="mb-3">
                                    <label class="form-label">Metode Pembayaran</label>
                                    <select name="id_metode_pembayaran" id="id_metode_pembayaran" class="form-select"
                                        required>
                                        <option value="">-- Pilih Metode Pembayaran --</option>
                                        @foreach ($metodePembayarans as $metode)
                                            <option value="{{ $metode->id }}">
                                                @if ($metode->ikon)
                                                    <img src="{{ asset($metode->ikon) }}" width="50" alt="Ikon">
                                                @else
                                                    Tidak ada ikon
                                                @endif
                                                {{ $metode->nama_metode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Input jumlah bayar -->
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Bayar</label>
                                    <input type="number" class="form-control" id="jumlahBayar" required>
                                </div>

                                <!-- Tampil kembalian -->
                                <p>Kembalian: <strong>Rp <span id="kembalianDisplay">0</span></strong></p>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success w-100">Konfirmasi & Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Script khusus halaman transaksi -->
    <script src="{{ asset('js/transaksi.js') }}"></script>

    <script>
        const STOK_API_URL = "{{ route('kasir.stok_terbaru') }}";

        // Data DP reservasi untuk kalkulasi di JS (dipetakan dari server)
        const dpReservasi = {
            @foreach ($reservasis as $reservasi)
                "{{ $reservasi->id }}": {{ $reservasi->dp ?? 0 }},
            @endforeach
        };
    </script>
@endsection
