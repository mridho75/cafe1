@extends('layouts.app')

@section('title', 'Reservasi - Edit')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Reservasi</h4>
            <a href="{{ route('reservasi.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <div class="card-body">
            <form action="{{ route('reservasi.update', $reservasi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="id_user" class="form-label">Kasir</label>
                        <input type="text" class="form-control" value="{{ session('username') }}" readonly>
                        <input type="hidden" name="id_user" value="{{ session('user_id') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="id_member" class="form-label">Member</label>
                        <select name="id_member" id="id_member" class="form-select">
                            <option value="" {{ $reservasi->id_member ? '' : 'selected' }}>-- Pilih Member (Opsional) --</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}" {{ $reservasi->id_member == $member->id ? 'selected' : '' }}>
                                    {{ $member->nama_members }} ({{ $member->kode_member }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control" value="{{ $reservasi->nama_pelanggan }}" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tanggal_dibuat" class="form-label">Tanggal Dibuat</label>
                        <input type="date" name="tanggal_dibuat" class="form-control" value="{{ $reservasi->tanggal_dibuat->format('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_reservasi" class="form-label">Tanggal Reservasi</label>
                        <input type="date" name="tanggal_reservasi" class="form-control" value="{{ $reservasi->tanggal_reservasi->format('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="nomor_meja" class="form-label">Nomor Meja</label>
                        <input type="text" name="nomor_meja" class="form-control" value="{{ $reservasi->nomor_meja }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="jumlah_kursi" class="form-label">Jumlah Kursi</label>
                        <input type="number" name="jumlah_kursi" class="form-control" value="{{ $reservasi->jumlah_kursi }}" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="dp" class="form-label">DP (Down Payment)</label>
                        <input type="number" name="dp" class="form-control" value="{{ $reservasi->dp }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Perbarui Reservasi</button>
            </form>
        </div>
    </div>
</div>
@endsection
