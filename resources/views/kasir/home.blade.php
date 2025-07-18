@extends('layouts.app')

@section('title', 'Home - Kasir')
@section('judul', 'Home Kasir Page')

@section('content')

<style>
  body {
    background: #f7f6f3 !important;
  }
  .kasir-main-card {
    background: #fff;
    border-radius: 1.25rem;
    box-shadow: 0 8px 32px 0 rgba(61,33,26,0.10);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
  }
  .kasir-summary-row {
    display: flex;
    gap: 1.2rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
  }
  .kasir-summary-row > div {
    flex: 1 1 220px;
    min-width: 180px;
  }
  .kasir-summary-row .card {
    border-radius: 1rem;
    box-shadow: 0 2px 12px 0 rgba(61,33,26,0.07);
    border: none;
    transition: box-shadow 0.2s;
  }
  .kasir-summary-row .card:hover {
    box-shadow: 0 4px 24px 0 rgba(61,33,26,0.13);
  }
  .kasir-summary-row .rounded-circle {
    box-shadow: 0 2px 8px 0 rgba(160,120,86,0.10);
  }
  .kasir-filter-form {
    display: flex;
    gap: 0.7rem;
    align-items: center;
    background: #faf7e3;
    border-radius: 1rem;
    padding: 0.7rem 1rem;
    box-shadow: 0 1px 4px 0 rgba(61,33,26,0.04);
    margin-bottom: 0;
  }
  .kasir-filter-form input[type="date"] {
    border: none;
    background: #fffbe9;
    border-radius: 0.7rem;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    box-shadow: none;
    transition: box-shadow 0.2s;
  }
  .kasir-filter-form input[type="date"]:focus {
    box-shadow: 0 0 0 2px #A0785633;
    background: #fff;
  }
  .kasir-filter-form .btn {
    border-radius: 0.7rem !important;
    font-weight: 500;
    padding: 0.5rem 1.2rem;
    font-size: 1rem;
    box-shadow: none;
    transition: background 0.2s, color 0.2s;
  }
  .kasir-filter-form .btn-primary {
    background: #A07856;
    border: none;
  }
  .kasir-filter-form .btn-primary:hover {
    background: #7a5a3a;
  }
  .kasir-filter-form .btn-secondary {
    background: #e0d3c2;
    color: #6d4c2c;
    border: none;
  }
  .kasir-filter-form .btn-secondary:hover {
    background: #cbb89e;
    color: #4d2e13;
  }
  .kasir-table-card {
    border-radius: 1rem;
    box-shadow: 0 2px 12px 0 rgba(61,33,26,0.07);
    border: none;
    margin-top: 1.5rem;
  }
  .kasir-table-card .card-header {
    background: #faf7e3;
    border-radius: 1rem 1rem 0 0;
    border: none;
    font-weight: 600;
    font-size: 1.1rem;
  }
  .kasir-table-card .table {
    border-radius: 0 0 1rem 1rem;
    overflow: hidden;
    margin-bottom: 0;
  }
  .kasir-table-card .table thead {
    background: #fffbe9;
  }
  .kasir-table-card .table-hover tbody tr:hover {
    background: #f5f1e6;
  }
  @media (max-width: 900px) {
    .kasir-summary-row {
      flex-direction: column !important;
      gap: 0.7rem !important;
      align-items: stretch !important;
    }
    .kasir-summary-row > * {
      width: 100% !important;
      min-width: 0 !important;
      max-width: 100vw !important;
    }
    .kasir-filter-form {
      flex-direction: column !important;
      gap: 10px;
    }
    .kasir-filter-form input,
    .kasir-filter-form button,
    .kasir-filter-form a {
      width: 100% !important;
      margin: 0 !important;
    }
    .container-fluid {
      padding-left: 2px !important;
      padding-right: 2px !important;
    }
    .card {
      margin-bottom: 12px !important;
    }
  }
  @media (max-width: 480px) {
    .kasir-summary-row > div {
      margin-bottom: 1rem !important;
    }
    .card-body.d-flex.align-items-center > div h6 {
      font-size: 0.85rem !important;
    }
    .card-body.d-flex.align-items-center > div h4 {
      font-size: 1.25rem !important;
    }
    .kasir-filter-form input,
    .kasir-filter-form button,
    .kasir-filter-form a {
      font-size: 0.9rem !important;
    }
    .table-responsive {
      font-size: 0.9rem !important;
    }
    .table thead tr th,
    .table tbody tr td {
      padding: 0.4rem 0.5rem !important;
    }
  }
</style>
<div class="container-fluid py-4">
    <div class="kasir-main-card">
        {{-- RINGKASAN --}}
        <div class="kasir-summary-row">
            <div>
                <div class="card h-100">
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
            <div>
                <div class="card h-100">
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
            <div class="col-md-8 col-lg-6">
                <form method="GET" action="{{ route('kasir.home') }}" class="kasir-filter-form">
                    <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" />
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="{{ route('kasir.home') }}" class="btn btn-secondary">Reset</a>
                </form>
            </div>
        </div>
        {{-- TABEL RIWAYAT TRANSAKSI --}}
        <style>
        .kasir-table-modern th, .kasir-table-modern td {
            vertical-align: middle !important;
            text-align: center;
        }
        .kasir-table-modern thead th {
            background: #f5f1e6;
            color: #3D211A;
            font-weight: 700;
            border-bottom: 2px solid #CBB799;
            letter-spacing: 0.5px;
            font-size: 1.07rem;
        }
        .kasir-table-modern tbody tr {
            transition: background 0.18s;
        }
        .kasir-table-modern tbody tr:hover {
            background: #faf7e3;
        }
        </style>
        <div class="card shadow-lg" style="border-radius:1.25rem; border:1.5px solid #CBB799; background:#fff; margin-top:2rem;">
            <div class="card-header d-flex align-items-center gap-2" style="background:#F5F5DC; border-radius:1.25rem 1.25rem 0 0; border-bottom:1.5px solid #CBB799;">
                <h6 class="fw-bold mb-0" style="color:#3D211A; letter-spacing:0.5px;">Riwayat Transaksi Terbaru</h6>
            </div>
            <div class="card-body table-responsive p-0" style="border-radius:0 0 1.25rem 1.25rem;">
                <table class="table kasir-table-modern align-middle mb-0" style="border-radius:1rem; overflow:hidden; min-width:600px;">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Total</th>
                            <th scope="col">Jumlah Bayar</th>
                            <th scope="col">Kembalian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatOrder as $order)
                            <tr>
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
</div>
@endsection
