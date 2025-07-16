@extends('layouts.app')

@section('title', 'Reservasi - Create')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Tambah Reservasi</h4>
            <a href="{{ route('reservasi.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <div class="card-body">
            <form action="{{ route('reservasi.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <label for="tanggal_dibuat" class="form-label">Tanggal Dibuat</label>
                        <input type="date" name="tanggal_dibuat" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_reservasi" class="form-label">Tanggal Reservasi</label>
                        <input type="date" name="tanggal_reservasi" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
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
