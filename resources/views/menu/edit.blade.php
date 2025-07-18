@extends('layouts.app')

@section('title', 'Menu - Edit')
@section('judul', 'Menu Edit Page')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0" style="background:#fff;box-shadow:0 8px 32px 0 rgba(61,33,26,0.13);border-radius:1.5rem;padding:2.2rem 1.5rem;max-width:600px;margin:auto;">
            <div class="mb-4">
                <h3 class="mb-0" style="color:#3D211A;font-weight:800;letter-spacing:0.5px;">Edit Menu</h3>
            </div>
            <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_category" class="form-label">Kategori</label>
                    <select name="id_category" id="id_category" class="form-select select2" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $menu->id_category == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nama_menu" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="{{ $menu->nama_menu }}" required>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" value="{{ $menu->harga }}" required>
                </div>

                @if ($menu->image)
                    <div class="mb-3">
                        <label class="form-label">Gambar Saat Ini</label><br>
                        <div style="width: 110px; height: 110px; overflow: hidden; border-radius: 1rem;box-shadow:0 2px 8px 0 rgba(61,33,26,0.10);background:#F5F5DC;display:flex;align-items:center;justify-content:center;">
                            <img src="{{ asset($menu->image) }}" alt="{{ $menu->nama_menu }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="image" class="form-label">Ganti Gambar (Opsional)</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <div class="d-flex flex-wrap gap-2 justify-content-between">
                    <button type="submit" class="btn" style="background:#A07856;color:#fff;font-weight:600;border-radius:0.8rem;padding:0.5rem 1.7rem;box-shadow:0 2px 8px 0 rgba(160,120,86,0.08);transition:background 0.2s;">Perbarui</button>
                    <a href="{{ route('menu.index') }}" class="btn btn-secondary" style="border-radius:0.8rem;padding:0.5rem 1.7rem;">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endpush
