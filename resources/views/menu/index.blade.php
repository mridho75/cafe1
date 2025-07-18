@extends('layouts.app')

@section('title', 'Menu')
@section('judul', 'Menu Page')

@section('content')
    <style>
        .menu-filter-row {
            display: flex;
            gap: 1.2rem;
            align-items: flex-end;
            margin-bottom: 2.2rem;
            flex-wrap: wrap;
        }
        .menu-filter-row > div {
            flex: 1 1 320px;
            min-width: 220px;
        }
        .menu-filter-group {
            display: flex;
            gap: 0.5rem;
            width: 100%;
        }
        .menu-filter-group .input-group {
            flex: 2;
            min-width: 0;
        }
        .menu-filter-group .input-group,
        .menu-filter-group .input-group .form-control,
        .menu-filter-group .input-group .input-group-text {
            border-radius: 1rem !important;
            background: #faf7e3 !important;
            box-shadow: none !important;
            border: none !important;
        }
        .menu-filter-group .input-group-text {
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
        .menu-filter-group .form-control {
            font-size: 1.08rem;
            padding: 0.7rem 1.1rem;
            border-radius: 0 1rem 1rem 0 !important;
            height: 44px;
            background: #faf7e3 !important;
            transition: box-shadow 0.2s, background 0.2s;
        }
        .menu-filter-group .form-control:focus {
            background: #fffbe9 !important;
            box-shadow: 0 0 0 2px #A07856333 !important;
        }
        .menu-filter-group .form-select {
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
        .menu-filter-group .form-select:focus {
            background: #fffbe9 !important;
            box-shadow: 0 0 0 2px #A0785633 !important;
        }
        .menu-filter-group .form-select option {
            background: #fff;
        }
        @media (max-width: 900px) {
            .menu-filter-row {
                flex-direction: column !important;
                gap: 0.7rem !important;
                align-items: stretch !important;
            }
            .menu-filter-row > * {
                width: 100% !important;
                min-width: 0 !important;
                max-width: 100vw !important;
            }
            .menu-filter-group {
                flex-direction: column;
                gap: 0.7rem;
            }
            .menu-filter-group .input-group,
            .menu-filter-group .form-select {
                width: 100% !important;
                max-width: 100vw !important;
            }
        }
    </style>
    <div class="container mt-5">
        <div class="card" style="background:#fff;box-shadow:0 8px 32px 0 rgba(61,33,26,0.13);border-radius:1.25rem;padding:2rem 1.5rem;">
            <!-- Filter dan Pencarian AJAX -->
            <style>
            @media (max-width: 900px) {
                .menu-filter-row {
                    flex-direction: column !important;
                    gap: 0.7rem !important;
                    align-items: stretch !important;
                }
                .menu-filter-row > * {
                    width: 100% !important;
                    min-width: 0 !important;
                    max-width: 100vw !important;
                }
                .input-group {
                    width: 100% !important;
                    min-width: 0 !important;
                }
                .input-group > .form-control,
                .input-group > .form-select {
                    width: 100% !important;
                    min-width: 0 !important;
                }
                .input-group-text {
                    flex: 0 0 auto;
                }
            }
            </style>
            <div class="menu-filter-row">
                <div class="menu-filter-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="search-menu" class="form-control" placeholder="Cari nama menu...">
                    </div>
                    <select id="filter-category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama_category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Container untuk tabel menu yang bisa di-reload dengan AJAX -->
            <div id="menu-table">
                @include('menu.table', ['menus' => $menus])
            </div>
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
