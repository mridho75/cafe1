@extends('layouts.app')

@section('title', 'Menu - Edit')
@section('judul', 'Menu Edit Page')

@section('content')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header">
                <h3>Edit Menu</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="id_category">Kategori</label>
                        <select name="id_category" id="id_category" class="form-control select2" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $menu->id_category == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama_menu">Nama Menu</label>
                        <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="{{ $menu->nama_menu }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" value="{{ $menu->harga }}" required>
                    </div>

                    @if ($menu->image)
                        <div class="form-group mb-3">
                            <label>Gambar Saat Ini</label><br>
                            <div style="width: 100px; height: 100px; overflow: hidden; border-radius: 8px;">
                                <img src="{{ asset($menu->image) }}" alt="{{ $menu->nama_menu }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            </div>

                        </div>
                    @endif

                    <div class="form-group mb-3">
                        <label for="image">Ganti Gambar (Opsional)</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Perbarui</button>
                        <a href="{{ route('menu.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
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
