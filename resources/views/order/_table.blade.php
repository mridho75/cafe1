<table class="table align-items-center table-flush">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Kasir</th>
            <th>Reservasi</th>
            <th>Member</th>
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
                <td>{{ $order->reservasi->nama_pelanggan ?? 'Tidak ada' }}</td>
                <td>{{ $order->member->nama_members ?? 'Tidak ada' }}</td>
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

<div class="d-flex justify-content-between align-items-center mt-3">
    <div>
        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
    </div>
    <div>
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- <div class="d-flex justify-content-center mt-3">
    {{ $orders->links('pagination::bootstrap-5') }}
</div> --}}
