
<style>
    .order-table th, .order-table td {
        vertical-align: middle !important;
        text-align: center;
        font-size: 1.01rem;
    }
    .order-table thead th {
        background: #faf7e3;
        color: #3D211A;
        font-weight: 700;
        border-bottom: 2px solid #CBB799;
        letter-spacing: 0.5px;
        font-size: 1.07rem;
    }
    .order-table tbody tr {
        transition: background 0.18s;
    }
    .order-table tbody tr:hover {
        background: #fffbe9;
    }
    .order-table .btn, .order-table .btn-sm {
        border-radius: 0.7rem !important;
        font-weight: 500;
        font-size: 0.97rem;
        padding: 0.35rem 0.9rem;
        transition: background 0.18s, color 0.18s;
    }
    .order-table .btn-info {
        background: #6c63ff;
        color: #fff;
        border: none;
    }
    .order-table .btn-info:hover {
        background: #5548c8;
    }
    .order-table .btn-success {
        background: #1abc9c;
        color: #fff;
        border: none;
    }
    .order-table .btn-success:hover {
        background: #159c85;
    }
    .order-pagination {
        margin-top: 1.2rem;
    }
</style>
<table class="table order-table align-items-center table-flush">
    <thead>
        <tr>
            <th>No</th>
            <th>Kasir</th>
            <!-- ...existing code... -->
            <th>Tanggal</th>
            <th>Pembayaran</th>
            <th>Total Harga</th>
            <th>Jumlah Bayar</th>
            <th>Kembalian</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $index => $order)
            <tr>
                <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                <td>{{ $order->user->user_name }}</td>
                <!-- ...existing code... -->
                <td>{{ $order->tgl }}</td>
                <td>{{ $order->metodePembayaran->nama_metode ?? 'Tidak ada' }}</td>
                <td>Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($order->jml_bayar, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($order->kembalian, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('order.show', $order->id) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('order.show.receipt', $order->id) }}" target="_blank"
                        class="btn btn-success btn-sm">Print</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center order-pagination">
    <div>
        Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} data
    </div>
    <div>
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- <div class="d-flex justify-content-center mt-3">
    {{ $orders->links('pagination::bootstrap-5') }}
</div> --}}
