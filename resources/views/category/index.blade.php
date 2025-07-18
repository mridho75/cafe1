@extends('layouts.app')

@section('title', 'Category')
@section('judul', 'Category Page')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg" style="border-radius:1.25rem; border:1.5px solid #CBB799; background:#fff;">
            <div class="card-header d-flex justify-content-between align-items-center" style="background:#F5F5DC; border-radius:1.25rem 1.25rem 0 0; border-bottom:1.5px solid #CBB799;">
                <h4 class="mb-0 fw-bold" style="color:#3D211A; letter-spacing:0.5px;">Daftar Kategori</h4>
                <a href="{{ route('category.create') }}" class="btn" style="background:#A07856; color:#fff; font-weight:600; border-radius:0.75rem; box-shadow:0 2px 8px #A0785611;">+ Tambah Kategori</a>
            </div>
            <div class="card-body" style="padding:1.5rem;">
            <style>
                .category-table th, .category-table td {
                    vertical-align: middle !important;
                    text-align: center;
                }
                .category-table thead th {
                    background: #f5f1e6;
                    color: #3D211A;
                    font-weight: 700;
                    border-bottom: 2px solid #CBB799;
                    letter-spacing: 0.5px;
                    font-size: 1.07rem;
                }
                .category-table tbody tr {
                    transition: background 0.18s;
                }
                .category-table tbody tr:hover {
                    background: #faf7e3;
                }
                .category-table .btn, .category-table .btn-sm {
                    border-radius: 0.7rem !important;
                    font-weight: 500;
                    font-size: 0.97rem;
                    padding: 0.35rem 0.9rem;
                    transition: background 0.18s, color 0.18s;
                }
                .category-table .btn-warning {
                    background: #ffe6a0;
                    color: #7a5a3a;
                    border: none;
                }
                .category-table .btn-warning:hover {
                    background: #ffe6a0cc;
                    color: #3D211A;
                }
                .category-table .btn-danger {
                    background: #e74c3c;
                    color: #fff;
                    border: none;
                }
                .category-table .btn-danger:hover {
                    background: #c0392b;
                }
                .category-table .btn-outline-primary {
                    border: 1.5px solid #A07856;
                    color: #A07856;
                    background: #fff;
                }
                .category-table .btn-outline-primary:hover {
                    background: #A07856;
                    color: #fff;
                }
            </style>
            <div class="table-responsive">
                <table class="table category-table align-middle mb-0" style="background:#fff;border-radius:1.1rem;overflow:hidden;">
                    <thead style="background:#f5f1e6;">
                        <tr>
                            <th style="min-width:180px;">Nama Kategori</th>
                            <th style="min-width:140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr style="border-bottom:1px solid #e5e5e5;">
                                <td style="color:#3D211A;font-weight:600;font-size:1.08rem;vertical-align:middle;">{{ $category->nama_category }}</td>
                                <td style="vertical-align:middle;">
                                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning btn-sm fw-bold">Edit</a>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-delete fw-bold">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center" style="color:#A07856;font-weight:500;">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin hapus?',
                    text: "Data yang sudah dihapus tidak bisa dikembalikan!",
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
    </script>
@endsection
