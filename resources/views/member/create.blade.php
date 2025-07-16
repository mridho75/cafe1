@extends('layouts.app')

@section('title', 'Member - Create')
@section('judul', 'Member Create Page')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h3>Tambah Member</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('member.store') }}" method="POST">
                @csrf

                {{-- <div class="form-group mb-3">
                    <label for="kode_member">Kode Member</label>
                    <input type="text" name="kode_member" id="kode_member" class="form-control" required>
                </div> --}}

                <div class="form-group mb-3">
                    <label for="nama_members">Nama</label>
                    <input type="text" name="nama_members" id="nama_members" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="ttl">Tgl Dibuat</label>
                    <input type="date" name="ttl" id="ttl" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="hp">No HP</label>
                    <input type="text" name="hp" id="hp" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" required></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="aktif">Aktif</option>
                        <option value="non-aktif">Non-Aktif</option>
                        <option value="blacklist">Blacklist</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('member.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
