@extends('layouts.app')

@section('title', 'Transaksi - Detail')
@section('judul', 'Transaksi Detail Page')

@section('content')
    <div class="container mt-6">

        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Informasi Order #{{ $order->id }}</h4>
                <div>
                    <a href="{{ route('order.show.receipt', $order->id) }}" target="_blank" class="btn btn-success btn-sm">Print</a>
                    <a href="{{ route('order.index') }}" class="btn btn-secondary btn-sm me-2">Kembali</a>
                </div>
            </div>


            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Nama Kasir:</strong> {{ $order->user->user_name ?? '-' }}</p>
                        <p><strong>Nama Pelanggan Reservasi:</strong> {{ $order->reservasi->nama_pelanggan ?? '-' }}</p>
                        <p><strong>Nama Member:</strong> {{ $order->reservasi->member->nama_members ?? 'Tidak ada' }}</p>
                        <!-- Menampilkan nama member -->
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tanggal:</strong> {{ $order->tgl }}</p>
                        <p><strong>Total Harga:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        <p><strong>Jumlah Bayar:</strong> Rp{{ number_format($order->jml_bayar, 0, ',', '.') }}</p>
                        <p><strong>Kembalian:</strong> Rp{{ number_format($order->kembalian, 0, ',', '.') }}</p>
                    </div>
                </div>

                <h5 class="mt-4 mb-3">Detail Item Dipesan</h5>

                @if ($order->detailOrders && $order->detailOrders->count())
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Menu</th>
                                    <th>Qty</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->detailOrders as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->menu->nama_menu ?? 'Menu tidak ditemukan' }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Tidak ada detail item dalam transaksi ini.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
