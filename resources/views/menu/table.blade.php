
<style>
    .menu-table th, .menu-table td {
        vertical-align: middle !important;
        text-align: center;
    }
    .menu-table thead th {
        background: #f5f1e6;
        color: #3D211A;
        font-weight: 700;
        border-bottom: 2px solid #CBB799;
        letter-spacing: 0.5px;
        font-size: 1.07rem;
    }
    .menu-table tbody tr {
        transition: background 0.18s;
    }
    .menu-table tbody tr:hover {
        background: #faf7e3;
    }
    .menu-table .btn, .menu-table .btn-sm {
        border-radius: 0.7rem !important;
        font-weight: 500;
        font-size: 0.97rem;
        padding: 0.35rem 0.9rem;
        transition: background 0.18s, color 0.18s;
    }
    .menu-table .btn-warning {
        background: #ffe6a0;
        color: #7a5a3a;
        border: none;
    }
    .menu-table .btn-warning:hover {
        background: #ffe6a0cc;
        color: #3D211A;
    }
    .menu-table .btn-danger {
        background: #e74c3c;
        color: #fff;
        border: none;
    }
    .menu-table .btn-danger:hover {
        background: #c0392b;
    }
    .menu-table .btn-outline-primary {
        border: 1.5px solid #A07856;
        color: #A07856;
        background: #fff;
    }
    .menu-table .btn-outline-primary:hover {
        background: #A07856;
        color: #fff;
    }
    .menu-table-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 1rem;
        box-shadow: 0 2px 8px #3D211A11;
        border: 1.5px solid #CBB799;
        background: #fff;
        margin: auto;
        display: block;
    }
    .menu-table-modal .modal-content {
        border-radius: 1rem;
    }
    .menu-table-modal .modal-header {
        background: #F5F5DC;
        border-radius: 1rem 1rem 0 0;
    }
    .menu-table-modal .modal-title {
        color: #3D211A;
    }
</style>
<div class="card shadow-lg" style="border-radius:1.25rem; border:1.5px solid #CBB799; background:#fff;">
    <div class="card-header d-flex justify-content-between align-items-center" style="background:#F5F5DC; border-radius:1.25rem 1.25rem 0 0; border-bottom:1.5px solid #CBB799;">
        <h4 class="mb-0 fw-bold" style="color:#3D211A; letter-spacing:0.5px;">Daftar Menu</h4>
        <a href="{{ route('menu.create') }}" class="btn" style="background:#A07856; color:#fff; font-weight:600; border-radius:0.75rem; box-shadow:0 2px 8px #A0785611;">Tambah Menu</a>
    </div>
    <div class="card-body" style="padding:1.5rem;">
        <div class="table-responsive">
            <table class="table menu-table align-items-center table-flush" style="border-radius:1rem; overflow:hidden;">
                <thead>
                    <tr>
                        <th style="min-width:90px;">Gambar</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stock</th>
                        <th>Tambah / Edit Stock</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr style="vertical-align:middle;">
                            <td>
                                @if ($menu->image)
                                    <img src="{{ asset($menu->image) }}" alt="{{ $menu->nama_menu }}" class="menu-table-img" />
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="fw-bold" style="color:#3D211A;">{{ $menu->nama_menu }}</td>
                            <td style="color:#6F4D38;">{{ $menu->category->nama_category }}</td>
                            <td style="color:#A07856; font-weight:600;">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                            <td style="color:#3D211A; font-weight:600;">{{ $menu->stok }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#stokModal{{ $menu->id }}">
                                    Tambah / Edit Stok
                                </button>
                            </td>
                            <td>
                                <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning btn-sm fw-bold">Edit</a>
                                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete fw-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Stok -->
                        <div class="modal fade menu-table-modal" id="stokModal{{ $menu->id }}" tabindex="-1" aria-labelledby="stokModalLabel{{ $menu->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('menu.updateStock', $menu->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold" id="stokModalLabel{{ $menu->id }}">Edit Stok - {{ $menu->nama_menu }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label class="fw-bold" style="color:#3D211A;">Stok Saat Ini:</label>
                                                <input type="number" name="stok" class="form-control" value="{{ $menu->stok }}" min="0" required style="border-radius:0.75rem;">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary fw-bold">Simpan</button>
                                            <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="color:#A07856;">Tidak ada data menu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
