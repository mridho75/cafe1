@extends('layouts.app')

@section('title', 'User - Edit')
@section('judul', 'User Edit Page')

@section('content')
    <div class="container mt-5">
        <div class="card-cafe">
            <h3 class="mb-3" style="font-weight:700;color:var(--cafe-coffee);">Edit User</h3>
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="username" style="color:var(--cafe-bistre);font-weight:600;">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->user_name) }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password" style="color:var(--cafe-bistre);font-weight:600;">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Isi jika ingin mengganti password">
                </div>
                <div class="form-group mb-4">
                    <label for="role" style="color:var(--cafe-bistre);font-weight:600;">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="pemilik" {{ $user->role == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn-cafe">Perbarui</button>
                    <a href="{{ route('user.index') }}" class="btn-cafe" style="background:var(--cafe-bistre);color:var(--cafe-beige);">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
