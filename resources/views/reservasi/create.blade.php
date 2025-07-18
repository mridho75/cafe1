@extends('layouts.app')

@section('title', 'Reservasi - Create')

@section('content')
<style>
    .reservasi-card {
        border-radius: 1.25rem;
        box-shadow: 0 8px 32px 0 rgba(61,33,26,0.13);
        border: 1.5px solid #CBB799;
        background: #fff;
    }
    .reservasi-card .card-header {
        background: #faf7e3;
        border-radius: 1.25rem 1.25rem 0 0;
        border-bottom: 1.5px solid #CBB799;
        font-weight: 600;
        font-size: 1.18rem;
        color: #3D211A;
    }
    .reservasi-card .btn-secondary {
        border-radius: 0.7rem;
        font-weight: 500;
        background: #e0d3c2;
        color: #6d4c2c;
        border: none;
    }
    .reservasi-card .btn-secondary:hover {
        background: #cbb89e;
        color: #4d2e13;
    }
    .reservasi-card .form-label {
        font-weight: 600;
        color: #7a5a3a;
        margin-bottom: 0.3rem;
    }
    .reservasi-card .form-control, .reservasi-card .form-select {
        border-radius: 0.7rem;
        border: 1.5px solid #CBB799;
        background: #fffbe9;
        font-size: 1.05rem;
        transition: box-shadow 0.18s, background 0.18s;
    }
    .reservasi-card .form-control:focus, .reservasi-card .form-select:focus {
        background: #fff;
        box-shadow: 0 0 0 2px #A0785633;
    }
    .reservasi-card .btn-primary {
        background: #A07856;
        border: none;
        border-radius: 0.7rem;
        font-weight: 600;
        font-size: 1.08rem;
        box-shadow: 0 2px 8px #A0785611;
        transition: background 0.18s;
    }
    .reservasi-card .btn-primary:hover {
        background: #7a5a3a;
    }
    @media (max-width: 900px) {
        .reservasi-card { padding: 0.7rem 0.2rem; }
    }
</style>
<div class="container mt-5">
    <div class="card reservasi-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Tambah Reservasi</span>
            <a href="{{ route('reservasi.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('reservasi.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="id_user" class="form-label">Kasir</label>
                        <input type="text" class="form-control" value="{{ session('username') }}" readonly>
                        <input type="hidden" name="id_user" value="{{ session('user_id') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="id_member" class="form-label">Member</label>
                        <select name="id_member" id="id_member" class="form-select">
                            <option value="" selected>-- Pilih Member (Opsional) --</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->nama_members }} ({{ $member->kode_member }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="tanggal_dibuat" class="form-label">Tanggal Dibuat</label>
                        <input type="date" name="tanggal_dibuat" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_reservasi" class="form-label">Tanggal Reservasi</label>
                        <input type="date" name="tanggal_reservasi" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="nomor_meja" class="form-label">Nomor Meja</label>
                        <input type="text" name="nomor_meja" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jumlah_kursi" class="form-label">Jumlah Kursi</label>
                        <input type="number" name="jumlah_kursi" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="dp" class="form-label">DP (Down Payment)</label>
                        <input type="number" name="dp" class="form-control" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
