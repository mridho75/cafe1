@extends('layouts.app')

@section('title', 'Pesanan - Kasir')
@section('judul', 'Halaman Pemesanan')


@section('content')
    <style>
        .kasir-transaksi-row {
            display: flex;
            gap: 2.5rem;
            align-items: flex-start;
        }
        .kasir-search-filter {
            display: flex;
            gap: 1rem;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
            align-items: flex-end;
            position: relative;
            z-index: 10;
        }
        .kasir-search-filter .filter-group {
            display: flex;
            gap: 0.5rem;
            width: 100%;
        }
        .kasir-search-filter .input-group {
            flex: 2;
            min-width: 0;
            border-radius: 1rem !important;
            background: #faf7e3 !important;
            box-shadow: 0 2px 12px 0 rgba(61,33,26,0.07);
            border: none !important;
        }
        .kasir-search-filter .input-group-text {
            background: #A07856 !important;
            color: #fff !important;
            border-radius: 1rem 0 0 1rem !important;
            font-size: 1.2rem;
            padding: 0.7rem 1.1rem;
            display: flex;
            align-items: center;
            height: 44px;
            transition: background 0.2s;
        }
        .kasir-search-filter .form-control {
            font-size: 1.08rem;
            padding: 0.7rem 1.1rem;
            border-radius: 0 1rem 1rem 0 !important;
            height: 44px;
            background: #faf7e3 !important;
            border: none !important;
            transition: box-shadow 0.2s, background 0.2s;
        }
        .kasir-search-filter .form-control:focus {
            background: #fffbe9 !important;
            box-shadow: 0 0 0 2px #A0785633 !important;
        }
        .kasir-search-filter .form-select {
            min-width: 170px;
            max-width: 220px;
            border-radius: 1rem !important;
            background: #faf7e3 !important;
            font-size: 1.08rem;
            padding: 0.7rem 1.1rem;
            height: 44px;
            border: none !important;
            box-shadow: none !important;
            transition: box-shadow 0.2s, background 0.2s;
        }
        .kasir-search-filter .form-select:focus {
            background: #fffbe9 !important;
            box-shadow: 0 0 0 2px #A0785633 !important;
        }
        .kasir-search-filter .form-select option {
            background: #fff;
        }
        .kasir-search-filter label {
            font-weight: 600;
            color: #7a5a3a;
            margin-bottom: 0.4rem;
        }
        @media (max-width: 1200px) {
            .keranjang-card {
                position: static;
                width: 100%;
                margin-top: 2rem;
            }
            .kasir-transaksi-row {
                flex-direction: column;
                gap: 2rem;
            }
            .kasir-search-filter {
                margin-bottom: 1.5rem;
            }
        }
        @media (max-width: 900px) {
            .kasir-search-filter {
                flex-direction: column;
                gap: 1.2rem;
            }
            .kasir-search-filter .filter-group {
                flex-direction: column;
                gap: 0.7rem;
            }
        }
        @media (max-width: 600px) {
            .keranjang-card {
                width: 100vw;
                border-radius: 0.7rem;
                right: 0;
                left: 0;
                margin: 0 -8px;
            }
        }
        .keranjang-card {
            position: fixed;
            top: 110px;
            right: 32px;
            width: 340px;
            z-index: 100;
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(61,33,26,0.13);
            overflow: hidden;
            transition: box-shadow 0.2s;
        }
        .keranjang-card .keranjang-header {
            background: #A07856;
            color: #fff;
            border-radius: 1.5rem 1.5rem 0 0;
        }
        .keranjang-card .keranjang-footer {
            background: #faf7e3;
            border-radius: 0 0 1.5rem 1.5rem;
        }
        .keranjang-card .btn-outline-danger {
            border: none;
            color: #fff;
            background: #e74c3c;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        .keranjang-card .btn-outline-danger:hover {
            background: #c0392b;
        }
        @media (max-width: 1200px) {
            .keranjang-card {
                position: static;
                width: 100%;
                margin-top: 2rem;
                right: 0;
                top: 0;
            }
            .kasir-transaksi-row {
                flex-direction: column;
                gap: 2rem;
            }
        }
        @media (max-width: 600px) {
            .kasir-search-filter {
                flex-direction: column;
                gap: 1.2rem;
            }
            .keranjang-card {
                width: 100vw;
                border-radius: 0.7rem;
                right: 0;
                left: 0;
                margin: 0 -8px;
            }
        }
    </style>
    <div class="container">
        <h2 class="mb-5 text-center font-weight-bold text-dark"></h2>

        <div class="kasir-transaksi-row">
            <!-- Bagian daftar menu berdasarkan kategori -->
            <div class="col-lg-8 mb-4">
                <!-- Search & Filter Bar (side by side, inside menu column) -->
                <div class="kasir-search-filter mb-4">
                    <div class="input-group" style="max-width: 60%; min-width: 200px;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari menu..." aria-label="Cari Menu">
                    </div>
                    <select id="categoryFilter" class="form-select" style="max-width: 40%; min-width: 140px;">
                        <option value="">🌐 Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->nama_category }}">🍽️ {{ $category->nama_category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    @foreach ($categories as $category)
                        @if ($category->menus->count() > 0)
                            <div class="col-12 mb-4">
                                <h4 class="text-primary border-bottom pb-2 mb-3">{{ $category->nama_category }}</h4>
                                <div class="row g-3">
                                    @foreach ($category->menus as $menu)
                                        <div class="col-md-4 mb-4 menu-item" data-nama="{{ strtolower($menu->nama_menu) }}"
                                            data-kategori="{{ strtolower($category->nama_category) }}">
                                            <div class="menu-card position-relative" style="background:#fff;border-radius:1.2rem;box-shadow:0 4px 18px 0 rgba(61,33,26,0.10);padding:1.1rem 1rem 1rem 1rem;min-height:270px;border:1.5px solid #CBB799;transition:box-shadow 0.18s,transform 0.18s;">
                                                <img src="{{ asset($menu->image) }}" alt="{{ $menu->nama_menu }}" style="width:100%;height:140px;object-fit:cover;border-radius:1rem;box-shadow:0 2px 8px #3D211A11;margin-bottom:0.7rem;@if ($menu->stok <= 0) filter: blur(3px) brightness(0.6); @endif" />
                                                @if ($menu->stok <= 0)
                                                    <div class="overlay-stock-habis" style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(255,255,255,0.7);color:#e74c3c;font-weight:700;font-size:1.1rem;display:flex;align-items:center;justify-content:center;border-radius:1rem;">Stock Habis</div>
                                                @endif
                                                <div class="menu-card-body">
                                                    <h5 class="menu-card-title" style="font-size:1.13rem;font-weight:700;color:#3D211A;margin-bottom:0.3rem;">{{ $menu->nama_menu }}</h5>
                                                    <p class="menu-card-price" style="color:#A07856;font-weight:600;font-size:1.07rem;margin-bottom:0.2rem;">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                                    <p class="menu-card-stock" style="color:#6F4D38;font-size:0.97rem;margin-bottom:0.5rem;">Stok: <strong>{{ $menu->stok }}</strong></p>
                                                    <div class="menu-card-controls" style="display:flex;align-items:center;gap:0.7rem;margin-top:0.5rem;">
                                                        <button class="btn btn-kurang btn-sm" style="border-radius:50%;width:36px;height:36px;font-size:1.2rem;display:flex;align-items:center;justify-content:center;font-weight:700;background:#ffe6e0;color:#e74c3c;border:none;transition:background 0.18s,color 0.18s;" data-id="{{ $menu->id }}">-</button>
                                                        <span id="qty-display-{{ $menu->id }}" style="font-size:1.1rem;font-weight:600;color:#3D211A;min-width:24px;text-align:center;">0</span>
                                                        <button class="btn btn-tambah btn-sm" style="border-radius:50%;width:36px;height:36px;font-size:1.2rem;display:flex;align-items:center;justify-content:center;font-weight:700;background:#e0d3c2;color:#A07856;border:none;transition:background 0.18s,color 0.18s;" data-id="{{ $menu->id }}" data-nama="{{ e($menu->nama_menu) }}" data-harga="{{ $menu->harga }}" data-image="{{ asset($menu->image) }}" data-stok="{{ $menu->stok }}" @if ($menu->stok <= 0) disabled @endif>+</button>
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
            <div id="keranjang-sidebar" class="keranjang-card" style="border:1.5px solid #CBB799;box-shadow:0 8px 32px 0 rgba(61,33,26,0.13);">
                <div class="keranjang-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom" style="background:#A07856;color:#fff;border-radius:1.5rem 1.5rem 0 0;font-weight:600;font-size:1.13rem;">
                    <h5 class="mb-0 fw-bold text-dark">🛒 Keranjang</h5>
                    <button type="button" class="btn btn-sm btn-outline-danger" id="btn-reset-keranjang" title="Reset Keranjang" style="border:none;color:#fff;background:#e74c3c;border-radius:50%;width:32px;height:32px;display:flex;align-items:center;justify-content:center;transition:background 0.2s;">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
                <div class="keranjang-list px-3 py-2" id="keranjang-list">
                    <!-- Konten keranjang via JS -->
                </div>
                <div class="keranjang-footer px-3 py-3 border-top bg-light" style="background:#faf7e3;border-radius:0 0 1.5rem 1.5rem;box-shadow:0 -2px 8px #A0785611;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-semibold" style="color:#3D211A;">Subtotal:</span>
                        <span>Rp <strong id="subtotal-display">0</strong></span>
                    </div>
                    <button type="button" class="btn btn-success w-100 rounded-pill fw-semibold" id="btn-simpan" style="background:#A07856;border:none;font-weight:600;font-size:1.08rem;border-radius:1.2rem;box-shadow:0 2px 8px #A0785611;transition:background 0.18s;">Simpan Transaksi</button>
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
