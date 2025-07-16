@extends('layouts.app')

@section('title', 'Menu')
@section('judul', 'Menu Page')

@section('content')
    <div class="container mt-5">

        <!-- Filter dan Pencarian AJAX -->
        <div class="row mb-4">

            <div class="col-md-6 mb-2">
                <div class="input-group shadow-sm rounded">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="search-menu" class="form-control border-start-0"
                        placeholder="Cari nama menu...">
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <div class="input-group rounded">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-list-ul"></i></span>
                    <select id="filter-category" class="form-select border-start-0">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama_category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Container untuk tabel menu yang bisa di-reload dengan AJAX -->
        <div id="menu-table">
            @include('menu.table', ['menus' => $menus])
        </div>
    </div>

    <!-- Script Konfirmasi Hapus -->
    <script>
        function initDeleteConfirmation() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Yakin ingin menghapus menu ini?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        }

        // AJAX Pencarian dan Filter
        const categoryFilter = document.getElementById('filter-category');
        const searchInput = document.getElementById('search-menu');
        const tableContainer = document.getElementById('menu-table');
        let debounceTimeout;

        function fetchMenus() {
            const category = categoryFilter.value;
            const search = searchInput.value;

            fetch(`{{ route('menu.index') }}?category=${category}&search=${search}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    tableContainer.innerHTML = html;
                    initDeleteConfirmation(); // Re-bind event setelah isi halaman diubah
                });
        }

        categoryFilter.addEventListener('change', fetchMenus);
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(fetchMenus, 400);
        });

        // Inisialisasi pertama
        initDeleteConfirmation();
    </script>
@endsection
