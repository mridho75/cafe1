@extends('layouts.app')

@section('title', 'Member - Edit')
@section('judul', 'Member Edit Page')


@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h3>Edit Member</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('member.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- <div class="form-group mb-3">
                    <label for="kode_member">Kode Member</label>
                    <input type="text" name="kode_member" id="kode_member" class="form-control" value="{{ $member->kode_member }}" required>
                </div> --}}

                <div class="form-group mb-3">
                    <label for="nama_members">Nama</label>
                    <input type="text" name="nama_members" id="nama_members" class="form-control" value="{{ $member->nama_members }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="hp">No HP</label>
                    <input type="text" name="hp" id="hp" class="form-control" value="{{ $member->hp }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" required>{{ $member->alamat }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="aktif" {{ $member->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="non-aktif" {{ $member->status == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        <option value="blacklist" {{ $member->status == 'blacklist' ? 'selected' : '' }}>Blacklist</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Perbarui</button>
                    <a href="{{ route('member.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
