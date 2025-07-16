@extends('layouts.app')

@section('title', 'Home - Kasir')
@section('judul', 'Home Kasir Page')

@section('content')
<div class="container-fluid py-4">

    {{-- RINGKASAN --}}
    <div class="row mb-4">
        <div class="col-md-6 col-xl-3 mb-3 mt-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px; margin-right: 10px;">
                        <i class="bi bi-bag-check fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Transaksi Hari Ini</h6>
                        <h4 class="fw-bold mb-0">{{ $jumlahOrder }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-3 mt-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px; margin-right: 10px;">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Total Pemasukan</h6>
                        <h4 class="fw-bold mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER TANGGAL (opsional) --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('kasir.home') }}" class="d-flex mb-3">
                <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" class="form-control me-2" />
                <button type="submit" class="btn btn-primary mx-2">Cari</button>
                <a href="{{ route('kasir.home') }}" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    {{-- TABEL RIWAYAT TRANSAKSI --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h6 class="fw-bold mb-0">Riwayat Transaksi Terbaru</h6>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Total</th>
                        <th scope="col">Jumlah Bayar</th>
                        <th scope="col">Kembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayatOrder as $order)
                        <tr @if(\Carbon\Carbon::parse($order->tgl)->isToday()) class="table-success" @endif>
                            <td>{{ \Carbon\Carbon::parse($order->tgl)->translatedFormat('d F Y') }}</td>
                            <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($order->jml_bayar, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($order->kembalian, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada transaksi ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
