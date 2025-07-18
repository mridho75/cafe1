@extends('layouts.app')

@section('title', 'Member - Edit')
@section('judul', 'Member Edit Page')


@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            <div class="card shadow-lg" style="border-radius:1.25rem; border:1.5px solid #CBB799; background:#fff; padding:2rem 1.5rem;">
                <h3 class="mb-4 fw-bold" style="color:#3D211A;">Edit Member</h3>
                <form action="{{ route('member.update', $member->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama_members" class="form-label fw-bold" style="color:#3D211A;">Nama</label>
                        <input type="text" name="nama_members" id="nama_members" class="form-control" value="{{ $member->nama_members }}" required style="border-radius:0.75rem;">
                    </div>
                    <div class="mb-3">
                        <label for="hp" class="form-label fw-bold" style="color:#3D211A;">No HP</label>
                        <input type="text" name="hp" id="hp" class="form-control" value="{{ $member->hp }}" required style="border-radius:0.75rem;">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-bold" style="color:#3D211A;">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" required style="border-radius:0.75rem;">{{ $member->alamat }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="form-label fw-bold" style="color:#3D211A;">Status</label>
                        <select name="status" id="status" class="form-select" required style="border-radius:0.75rem;">
                            <option value="aktif" {{ $member->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="non-aktif" {{ $member->status == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            <option value="blacklist" {{ $member->status == 'blacklist' ? 'selected' : '' }}>Blacklist</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn" style="background:#A07856;color:#fff;font-weight:600;border-radius:0.75rem;">Perbarui</button>
                        <a href="{{ route('member.index') }}" class="btn" style="background:#3D211A;color:#fff;font-weight:600;border-radius:0.75rem;">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
