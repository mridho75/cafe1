@extends('layouts.app')

@section('title', 'Laporan')
@section('judul', 'Laporan Page')

@section('content')
    <div class="container mt-5">
        {{-- Filter Tanggal --}}
        <form method="GET" action="{{ route('owner.laporan') }}" class="row g-3 mb-4" id="filter-form">
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
        <div class="d-flex justify-content-between mb-4">
            <div>
                <button type="submit" form="filter-form" class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i> Tampilkan
                </button>
                <a href="{{ route('owner.laporan') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                </a>
            </div>
            <div>
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
                <div class="card bg-default shadow">
                    <div class="card-header bg-transparent border-0">
                        <h3 class="text-white mb-0">Daftar Laporan</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-dark table-flush">
                            <thead class="thead-dark">
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
        <div class="mt-3 text-end">
            <h5>Total Pendapatan:
                <strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong>
            </h5>
        </div>
    </div>
@endsection
