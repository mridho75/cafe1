@extends('layouts.app')

@section('title', 'Reservasi')
@section('judul', 'Reservasi Page')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0" style="background:#fff;box-shadow:0 8px 32px 0 rgba(61,33,26,0.13);border-radius:1.5rem;padding:2.2rem 1.5rem;">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                <h4 class="mb-0" style="color:#3D211A;font-weight:800;letter-spacing:0.5px;">Daftar Reservasi</h4>
                <a href="{{ route('reservasi.create') }}" class="btn" style="background:#A07856;color:#fff;font-weight:600;border-radius:0.8rem;padding:0.55rem 1.7rem;box-shadow:0 2px 8px 0 rgba(160,120,86,0.08);transition:background 0.2s;">+ Tambah Reservasi</a>
            </div>
            <style>
                .reservasi-table th, .reservasi-table td {
                    vertical-align: middle !important;
                    text-align: center;
                }
                .reservasi-table thead th {
                    background: #f5f1e6;
                    color: #3D211A;
                    font-weight: 700;
                    border-bottom: 2px solid #CBB799;
                    letter-spacing: 0.5px;
                    font-size: 1.07rem;
                }
                .reservasi-table tbody tr {
                    transition: background 0.18s;
                }
                .reservasi-table tbody tr:hover {
                    background: #faf7e3;
                }
            </style>
            <div class="table-responsive">
                <table class="table reservasi-table align-middle mb-0" style="background:#fff;border-radius:1.1rem;overflow:hidden;">
                    <thead>
                        <tr>
                            <th style="min-width:110px;">Kasir</th>
                            <th style="min-width:120px;">Member</th>
                            <th style="min-width:140px;">Nama Pelanggan</th>
                            <th style="min-width:110px;">Tanggal</th>
                            <th style="min-width:140px;">Tanggal Reservasi</th>
                            <th style="min-width:80px;">No Meja</th>
                            <th style="min-width:80px;">Jml Kursi</th>
                            <th style="min-width:90px;">DP</th>
                            <th style="min-width:160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservasis as $reservasi)
                            <tr>
                                <td style="color:#3D211A;font-weight:600;">{{ $reservasi->user->user_name }}</td>
                                <td style="color:#3D211A;">{{ $reservasi->member ? $reservasi->member->nama_members : 'Non-member' }}</td>
                                <td style="color:#3D211A;">
                                    {{ $reservasi->nama_pelanggan }}
                                    @if ($reservasi->is_used)
                                        <span class="badge bg-success text-light mx-2" style="font-size:0.92rem;">Sudah Dipakai</span>
                                    @endif
                                </td>
                                <td style="color:#3D211A;">{{ $reservasi->tanggal_dibuat }}</td>
                                <td style="color:#3D211A;">{{ $reservasi->tanggal_reservasi }}</td>
                                <td style="color:#3D211A;">{{ $reservasi->nomor_meja }}</td>
                                <td style="color:#3D211A;">{{ $reservasi->jumlah_kursi }}</td>
                                <td style="color:#3D211A;">Rp{{ number_format($reservasi->dp, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                                        <a href="{{ route('reservasi.edit', $reservasi->id) }}" class="btn" style="background:#A07856;color:#fff;font-weight:600;border-radius:0.6rem;padding:0.35rem 1.1rem;font-size:0.97rem;box-shadow:0 1px 4px 0 rgba(160,120,86,0.07);transition:background 0.2s;">Edit</a>
                                        <form action="{{ route('reservasi.destroy', $reservasi->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn" style="background:#3D211A;color:#fff;font-weight:600;border-radius:0.6rem;padding:0.35rem 1.1rem;font-size:0.97rem;box-shadow:0 1px 4px 0 rgba(61,33,26,0.07);transition:background 0.2s;">Hapus</button>
                                        </form>
                                        <form action="{{ route('reservasi.pakai', $reservasi->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn" style="background:#CBB799;color:#3D211A;font-weight:700;border-radius:0.6rem;padding:0.35rem 1.1rem;font-size:0.97rem;box-shadow:0 1px 4px 0 rgba(203,183,153,0.07);transition:background 0.2s;" onclick="return confirm('Yakin ingin pakai reservasi ini?')" {{ $reservasi->is_used ? 'disabled' : '' }}>
                                                {{ $reservasi->is_used ? 'Sudah Dipakai' : 'Pakai Reservasi' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center" style="color:#A07856;font-weight:500;">Belum ada reservasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
