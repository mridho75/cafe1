@extends('layouts.app')

@section('title', 'User - Create')
@section('judul', 'User Create Page')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            <div class="card shadow-lg" style="border-radius:1.25rem; border:1.5px solid #CBB799; background:#fff; padding:2rem 1.5rem;">
                <h3 class="mb-4 fw-bold" style="color:#3D211A;">Tambah User</h3>
                <form method="POST" action="{{ route('user.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold" style="color:#3D211A;">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required style="border-radius:0.75rem;">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold" style="color:#3D211A;">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required style="border-radius:0.75rem;">
                    </div>
                    <div class="mb-4">
                        <label for="role" class="form-label fw-bold" style="color:#3D211A;">Role</label>
                        <select class="form-select" id="role" name="role" required style="border-radius:0.75rem;">
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                            <option value="pemilik">Owner</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn" style="background:#A07856;color:#fff;font-weight:600;border-radius:0.75rem;">Simpan</button>
                        <a href="{{ route('user.index') }}" class="btn" style="background:#3D211A;color:#fff;font-weight:600;border-radius:0.75rem;">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
