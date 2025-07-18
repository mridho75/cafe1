@extends('layouts.app')

@section('title', 'Laporan')
@section('judul', 'Laporan Page')

@section('content')
    <style>
      .laporan-filter-row {
        background: #fcfcf6;
        border-radius: 1.25rem;
        box-shadow: 0 2px 12px 0 rgba(61,33,26,0.07);
        padding: 1.5rem 1.2rem 0.7rem 1.2rem;
        margin-bottom: 1.7rem;
        align-items: end;
        gap: 1.2rem;
      }
      .laporan-filter-row label {
        font-weight: 600;
        color: #7a5a3a;
        margin-bottom: 0.3rem;
      }
      .laporan-filter-row input[type="date"] {
        border-radius: 0.7rem;
        font-size: 1rem;
        padding: 10px 14px;
        box-shadow: 0 1px 4px 0 rgba(0,0,0,0.03);
        border: 1.5px solid #CBB799;
        background: #fffbe9;
        transition: border 0.2s, background 0.2s;
      }
      .laporan-filter-row input[type="date"]:focus {
        border: 1.5px solid #A07856;
        background: #fff;
        outline: none;
      }
      .laporan-btn-row button,
      .laporan-btn-row a.btn {
        border-radius: 0.7rem !important;
        font-weight: 600;
        font-size: 1rem;
        min-width: 100px;
        box-shadow: 0 1px 6px 0 rgba(61,33,26,0.06);
        margin-right: 8px;
        margin-bottom: 8px;
        padding: 10px 18px;
        transition: background 0.2s, color 0.2s;
      }
      .laporan-btn-row .btn-primary {
        background: #A07856;
        border: none;
      }
      .laporan-btn-row .btn-primary:hover {
        background: #7a5a3a;
      }
      .laporan-btn-row .btn-secondary {
        background: #e0d3c2;
        color: #6d4c2c;
        border: none;
      }
      .laporan-btn-row .btn-secondary:hover {
        background: #cbb89e;
        color: #4d2e13;
      }
      .laporan-btn-row .btn-success {
        background: #1abc9c;
        border: none;
      }
      .laporan-btn-row .btn-success:hover {
        background: #159c85;
      }
      .laporan-btn-row .btn-danger {
        background: #e74c3c;
        border: none;
      }
      .laporan-btn-row .btn-danger:hover {
        background: #c0392b;
      }
      .laporan-table th, .laporan-table td {
        vertical-align: middle !important;
        text-align: center;
        font-size: 1.01rem;
      }
      .laporan-table thead th {
        background: #faf7e3;
        color: #3D211A;
        font-weight: 700;
        border-bottom: 2px solid #CBB799;
        letter-spacing: 0.5px;
        font-size: 1.07rem;
      }
      .laporan-table tbody tr {
        transition: background 0.18s;
      }
      .laporan-table tbody tr:hover {
        background: #fffbe9;
      }
      .laporan-table {
        border-radius: 1rem;
        overflow: hidden;
        background: #fff;
      }
      .laporan-card {
        border-radius: 1.25rem;
        box-shadow: 0 8px 32px 0 rgba(61,33,26,0.13);
        border: 1.5px solid #CBB799;
        background: #fff;
      }
      .laporan-card .card-header {
        background: #faf7e3;
        border-radius: 1.25rem 1.25rem 0 0;
        border-bottom: 1.5px solid #CBB799;
        font-weight: 600;
        font-size: 1.18rem;
        color: #3D211A;
      }
      .laporan-summary {
        background: #faf7e3;
        border-radius: 1rem;
        padding: 1.1rem 1.5rem;
        margin-top: 1.5rem;
        font-size: 1.15rem;
        color: #3D211A;
        font-weight: 600;
        box-shadow: 0 2px 8px 0 rgba(61,33,26,0.07);
        text-align: right;
      }
      @media (max-width: 991.98px) {
        .laporan-filter-row {
          flex-direction: column !important;
          gap: 1rem;
        }
        .laporan-filter-row > div {
          width: 100% !important;
        }
        .laporan-btn-row {
          flex-direction: column !important;
          gap: 10px;
        }
        .laporan-btn-row button,
        .laporan-btn-row a.btn {
          width: 100% !important;
          margin-right: 0 !important;
        }
      }
    </style>
    <div class="container mt-5">
        {{-- Filter Tanggal --}}
        <form method="GET" action="{{ route('owner.laporan') }}" class="row g-3 mb-4 laporan-filter-row" id="filter-form">
            <div class="col-md-4">
                <label for="from" class="form-label">Dari Tanggal</label>
                <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-4">
                <label for="to" class="form-label">Sampai Tanggal</label>
                <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}">
            </div>
        </form>

        {{-- Tombol --}}
        <div class="d-flex justify-content-between mb-4 laporan-btn-row flex-wrap">
            <div class="d-flex flex-wrap gap-2">
                <button type="submit" form="filter-form" class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i> Tampilkan
                </button>
                <a href="{{ route('owner.laporan') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                </a>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('owner.laporan.export', ['from' => request('from'), 'to' => request('to')]) }}"
                   class="btn btn-success ms-2">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>
                <a href="{{ route('owner.laporan.pdf', ['from' => request('from'), 'to' => request('to')]) }}"
                   class="btn btn-danger ms-2">
                    <i class="fas fa-file-pdf me-1"></i> Export PDF
                </a>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="row mt-2">
            <div class="col">
                <div class="card laporan-card">
                    <div class="card-header">
                        Daftar Laporan
                    </div>
                    <div class="table-responsive">
                        <table class="table laporan-table align-items-center table-flush">
                            <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Nama Kasir</th>
                                <th scope="col">Reservasi</th>
                                <th scope="col">Member</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Harga Satuan</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Jumlah Bayar</th>
                                <th scope="col">DP</th>
                                <th scope="col">Kembalian</th>
                                <th scope="col">Pemasukan</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                @php
                                    $detailCount = $order->detailOrders->count();
                                    $pemasukan = $order->detailOrders->sum('subtotal');
                                    $dp = $order->reservasi->dp ?? 0; // Ambil DP jika ada reservasi
                                @endphp
                                @foreach ($order->detailOrders as $index => $detail)
                                    <tr>
                                        @if ($index == 0)
                                            <td rowspan="{{ $detailCount }}">
                                                {{ \Carbon\Carbon::parse($order->tgl)->translatedFormat('j F Y') }}
                                            </td>
                                            <td rowspan="{{ $detailCount }}">{{ $order->user->user_name }}</td>
                                            <td rowspan="{{ $detailCount }}">
                                                @if ($order->reservasi)
                                                    {{ $order->reservasi->nama_pelanggan ?? '-' }}<br>
                                                    Meja: {{ $order->reservasi->nomor_meja ?? '-' }}
                                                @else
                                                    Tidak Ada
                                                @endif
                                            </td>
                                            <td rowspan="{{ $detailCount }}">
                                                {{ $order->member->nama_members ?? 'Tidak Ada' }}
                                            </td>
                                        @endif

                                        <td>{{ $detail->menu->nama_menu }}</td>
                                        <td>{{ $detail->qty }}</td>
                                        <td>Rp {{ number_format($detail->harga_satuan, 2, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->subtotal, 2, ',', '.') }}</td>

                                        @if ($index == 0)
                                            <td rowspan="{{ $detailCount }}">Rp
                                                {{ number_format($order->jml_bayar, 2, ',', '.') }}
                                            </td>
                                            <td rowspan="{{ $detailCount }}">Rp
                                                {{ number_format($dp, 2, ',', '.') }}
                                            </td>
                                            <td rowspan="{{ $detailCount }}">Rp
                                                {{ number_format($order->kembalian, 2, ',', '.') }}
                                            </td>
                                            <td rowspan="{{ $detailCount }}">Rp
                                                {{ number_format($pemasukan, 2, ',', '.') }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="laporan-summary">
            Total Pendapatan:
            <strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong>
        </div>
    </div>
@endsection
