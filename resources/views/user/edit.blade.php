@extends('layouts.app')

@section('title', 'User - Edit')
@section('judul', 'User Edit Page')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="card shadow-lg" style="border-radius:1.25rem; border:1.5px solid #CBB799; background:#fff; padding:2rem 1.5rem;">
                    <h3 class="mb-4 fw-bold" style="color:#3D211A;">Edit User</h3>
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold" style="color:#3D211A;">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->user_name) }}" required style="border-radius:0.75rem;">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold" style="color:#3D211A;">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Isi jika ingin mengganti password" style="border-radius:0.75rem;">
                        </div>
                        <div class="mb-4">
                            <label for="role" class="form-label fw-bold" style="color:#3D211A;">Role</label>
                            <select class="form-select" id="role" name="role" required style="border-radius:0.75rem;">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                <option value="pemilik" {{ $user->role == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn" style="background:#A07856;color:#fff;font-weight:600;border-radius:0.75rem;">Perbarui</button>
                            <a href="{{ route('user.index') }}" class="btn" style="background:#3D211A;color:#fff;font-weight:600;border-radius:0.75rem;">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
