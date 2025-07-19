@extends('layouts.app')


@section('title', 'Metode Pembayaran')
@section('judul', 'Metode Pembayaran')
@section('page-title', 'Metode Pembayaran')
@section('page-desc', 'Kelola dan lihat daftar metode pembayaran yang tersedia')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0" style="background:#fff;box-shadow:0 8px 32px 0 rgba(61,33,26,0.13);border-radius:1.5rem;padding:2.2rem 1.5rem;">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                <h4 class="mb-0" style="color:#3D211A;font-weight:800;letter-spacing:0.5px;">Daftar Metode Pembayaran</h4>
                <a href="{{ route('metode.create') }}" class="btn" style="background:#A07856;color:#fff;font-weight:600;border-radius:0.8rem;padding:0.55rem 1.7rem;box-shadow:0 2px 8px 0 rgba(160,120,86,0.08);transition:background 0.2s;">+ Tambah Metode</a>
            </div>
            <style>
                .metode-table th, .metode-table td {
                    vertical-align: middle !important;
                    text-align: center;
                }
                .metode-table thead th {
                    background: #f5f1e6;
                    color: #3D211A;
                    font-weight: 700;
                    border-bottom: 2px solid #CBB799;
                    letter-spacing: 0.5px;
                    font-size: 1.07rem;
                }
                .metode-table tbody tr {
                    transition: background 0.18s;
                }
                .metode-table tbody tr:hover {
                    background: #faf7e3;
                }
                .metode-table .btn, .metode-table .btn-sm {
                    border-radius: 0.7rem !important;
                    font-weight: 500;
                    font-size: 0.97rem;
                    padding: 0.35rem 0.9rem;
                    transition: background 0.18s, color 0.18s;
                }
                .metode-table .btn-warning {
                    background: #ffe6a0;
                    color: #7a5a3a;
                    border: none;
                }
                .metode-table .btn-warning:hover {
                    background: #ffe6a0cc;
                    color: #3D211A;
                }
                .metode-table .btn-danger {
                    background: #e74c3c;
                    color: #fff;
                    border: none;
                }
                .metode-table .btn-danger:hover {
                    background: #c0392b;
                }
                .metode-table .btn-outline-primary {
                    border: 1.5px solid #A07856;
                    color: #A07856;
                    background: #fff;
                }
                .metode-table .btn-outline-primary:hover {
                    background: #A07856;
                    color: #fff;
                }
            </style>
            <div class="table-responsive">
                <table class="table metode-table align-middle mb-0" style="background:#fff;border-radius:1.1rem;overflow:hidden;">
                    <thead>
                        <tr>
                            <th style="min-width:180px;">Nama Metode</th>
                            <th style="min-width:120px;">Ikon</th>
                            <th style="min-width:140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($metodes as $metode)
                            <tr>
                                <td style="color:#3D211A;font-weight:600;font-size:1.08rem;">{{ $metode->nama_metode }}</td>
                                <td>
                                    @if ($metode->ikon)
                                        <div style="background:#fff;border-radius:0.7rem;padding:0.3rem;display:inline-block;box-shadow:0 2px 8px 0 rgba(61,33,26,0.07);">
                                            <img src="{{ asset($metode->ikon) }}" width="44" height="44" style="object-fit:contain;max-width:44px;max-height:44px;" alt="Ikon">
                                        </div>
                                    @else
                                        <span style="color:#A07856;font-size:0.97rem;">Tidak ada ikon</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                                        <a href="{{ route('metode.edit', $metode->id) }}" class="btn btn-warning btn-sm fw-bold">Edit</a>
                                        <form action="{{ route('metode.destroy', $metode->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm btn-delete fw-bold" onclick="return confirm('Yakin ingin menghapus metode ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center" style="color:#A07856;font-weight:500;">Belum ada metode pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
