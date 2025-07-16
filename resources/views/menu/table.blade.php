<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Daftar Menu</h4>
        <a href="{{ route('menu.create') }}" class="btn btn-success">Tambah Menu</a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th>Gambar</th>
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
                        <tr>
                            <td>
                                @if ($menu->image)
                                    <div style="width: 100px; height: 100px; overflow: hidden; border-radius: 8px;">
                                        <img src="{{ asset($menu->image) }}" alt="{{ $menu->nama_menu }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $menu->nama_menu }}</td>
                            <td>{{ $menu->category->nama_category }}</td>
                            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                            <td>{{ $menu->stok }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#stokModal{{ $menu->id }}">
                                    Tambah / Edit Stok
                                </button>
                            </td>
                            <td>
                                <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST"
                                    class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Stok -->
                        <div class="modal fade" id="stokModal{{ $menu->id }}" tabindex="-1"
                            aria-labelledby="stokModalLabel{{ $menu->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('menu.updateStock', $menu->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="stokModalLabel{{ $menu->id }}">
                                                Edit Stok - {{ $menu->nama_menu }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Stok Saat Ini:</label>
                                                <input type="number" name="stok" class="form-control"
                                                    value="{{ $menu->stok }}" min="0" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data menu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
