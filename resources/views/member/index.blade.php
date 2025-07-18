@extends('layouts.app')

@section('title', 'Member')
@section('judul', 'Member Page')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0" style="background:#fff;box-shadow:0 8px 32px 0 rgba(61,33,26,0.13);border-radius:1.5rem;padding:2.2rem 1.5rem;">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                <h4 class="mb-0" style="color:#3D211A;font-weight:800;letter-spacing:0.5px;">Daftar Member</h4>
                <a href="{{ route('member.create') }}" class="btn" style="background:#A07856;color:#fff;font-weight:600;border-radius:0.8rem;padding:0.55rem 1.7rem;box-shadow:0 2px 8px 0 rgba(160,120,86,0.08);transition:background 0.2s;">+ Tambah Member</a>
            </div>
            <style>
                .member-table th, .member-table td {
                    vertical-align: middle !important;
                    text-align: center;
                }
                .member-table thead th {
                    background: #f5f1e6;
                    color: #3D211A;
                    font-weight: 700;
                    border-bottom: 2px solid #CBB799;
                    letter-spacing: 0.5px;
                    font-size: 1.07rem;
                }
                .member-table tbody tr {
                    transition: background 0.18s;
                }
                .member-table tbody tr:hover {
                    background: #faf7e3;
                }
            </style>
            <div class="table-responsive">
                <table class="table member-table align-middle mb-0" style="background:#fff;border-radius:1.1rem;overflow:hidden;">
                    <thead>
                        <tr>
                            <th style="min-width:90px;">Kode</th>
                            <th style="min-width:120px;">Nama</th>
                            <th style="min-width:120px;">Tgl Dibuat</th>
                            <th style="min-width:100px;">HP</th>
                            <th style="min-width:160px;">Alamat</th>
                            <th style="min-width:80px;">Status</th>
                            <th style="min-width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $member)
                            <tr>
                                <td style="color:#3D211A;font-weight:600;font-size:1.08rem;">{{ $member->kode_member }}</td>
                                <td style="color:#3D211A;">{{ $member->nama_members }}</td>
                                <td style="color:#3D211A;">{{ $member->ttl }}</td>
                                <td style="color:#3D211A;">{{ $member->hp }}</td>
                                <td style="color:#3D211A;">{{ $member->alamat }}</td>
                                <td style="color:#3D211A;">{{ ucfirst($member->status) }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                                        <a href="{{ route('member.edit', $member->id) }}" class="btn" style="background:#A07856;color:#fff;font-weight:600;border-radius:0.6rem;padding:0.35rem 1.1rem;font-size:0.97rem;box-shadow:0 1px 4px 0 rgba(160,120,86,0.07);transition:background 0.2s;">Edit</a>
                                        <form action="{{ route('member.destroy', $member->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn" style="background:#3D211A;color:#fff;font-weight:600;border-radius:0.6rem;padding:0.35rem 1.1rem;font-size:0.97rem;box-shadow:0 1px 4px 0 rgba(61,33,26,0.07);transition:background 0.2s;">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center" style="color:#A07856;font-weight:500;">Belum ada member.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin hapus?',
                    text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
