@extends('layouts.app')

@section('title', 'User - Create')
@section('judul', 'User Create Page')

@section('content')
<div class="container-fluid mt-6">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card-cafe">
                <h3 class="mb-3" style="font-weight:700;color:var(--cafe-coffee);">Create User</h3>
                <form method="POST" action="{{ route('user.store') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="username" style="color:var(--cafe-bistre);font-weight:600;">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" style="color:var(--cafe-bistre);font-weight:600;">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="role" style="color:var(--cafe-bistre);font-weight:600;">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                            <option value="pemilik">Owner</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-cafe">Save</button>
                    <a href="{{ route('user.index') }}" class="btn-cafe" style="background:var(--cafe-bistre);color:var(--cafe-beige);margin-left:0.5rem;">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
