@extends('layouts.app')

@section('title', 'Reservasi')
@section('judul', 'Reservasi Page')

@section('content')
    <div class="container mt-5">

        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Reservasi</h4>
                <a href="{{ route('reservasi.create') }}" class="btn btn-success">
                    Tambah Reservasi
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Kasir</th>
                                <th scope="col">Member</th>
                                <th scope="col">Nama Pelanggan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Tanggal Reservasi</th>
                                <th scope="col">No Meja</th>
                                <th scope="col">Jml Kursi</th>
                                <th scope="col">DP</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservasis as $reservasi)
                                <tr class="{{ $reservasi->is_used ? 'table-succes' : '' }}">
                                    <td>{{ $reservasi->user->user_name }}</td>
                                    <td>{{ $reservasi->member ? $reservasi->member->nama_members : 'Non-member' }}</td>
                                    <td>
                                        {{ $reservasi->nama_pelanggan }}
                                        @if ($reservasi->is_used)
                                            <span class="badge bg-success text-secondary mx-2">Sudah Dipakai</span>
                                        @endif
                                    </td>
                                    <td>{{ $reservasi->tanggal_dibuat }}</td>
                                    <td>{{ $reservasi->tanggal_reservasi }}</td>
                                    <td>{{ $reservasi->nomor_meja }}</td>
                                    <td>{{ $reservasi->jumlah_kursi }}</td>
                                    <td>Rp{{ number_format($reservasi->dp, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('reservasi.edit', $reservasi->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>

                                        <form action="{{ route('reservasi.destroy', $reservasi->id) }}" method="POST"
                                            style="display:inline-block;" class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>

                                        <form action="{{ route('reservasi.pakai', $reservasi->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                onclick="return confirm('Yakin ingin pakai reservasi ini?')"
                                                {{ $reservasi->is_used ? 'disabled' : '' }}>
                                                {{ $reservasi->is_used ? 'Sudah Dipakai' : 'Pakai Reservasi' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tangkap semua form dengan class 'delete-form'
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Cegah submit langsung

                Swal.fire({
                    title: 'Yakin ingin menghapus menu ini?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user konfirmasi, submit form secara manual
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
