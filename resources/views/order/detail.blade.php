<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f8f9fa;
        }

        .receipt {
            max-width: 400px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border: 1px dashed #000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .receipt img {
            display: block;
            max-width: 200px;
            margin: 0 auto 10px;
        }

        .receipt h5 {
            text-align: center;
            margin-bottom: 10px;
        }

        .receipt hr {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .receipt table {
            width: 100%;
            font-size: 14px;
        }

        .receipt th,
        .receipt td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .receipt th:nth-child(3),
        .receipt td:nth-child(3),
        .receipt th:nth-child(4),
        .receipt td:nth-child(4),
        .receipt th:nth-child(5),
        .receipt td:nth-child(5) {
            text-align: right;
            width: 20%;
            white-space: nowrap;
        }

        .receipt th:nth-child(2),
        .receipt td:nth-child(2) {
            width: 40%;
        }

        .totals td {
            font-weight: bold;
            padding: 4px 6px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <img src="{{ asset('assets') }}/img/brand/logo.png" alt="Logo">

        <h5>Order #{{ $order->id }}</h5>
        <hr>

        <p><strong>Tanggal:</strong> {{ $order->tgl }}</p>
        <p><strong>Kasir:</strong> {{ $order->user->user_name ?? '-' }}</p>
        <p><strong>Reservasi:</strong> {{ $order->reservasi->nama_pelanggan ?? '-' }}</p>
        <p><strong>Member:</strong> {{ $order->member->nama_members ?? '-' }}</p>

        <hr>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->detailOrders as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->menu->nama_menu ?? 'Tidak ditemukan' }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp.{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp.{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
        <table class="totals" width="100%">
            <tr>
                <td>Total:</td>
                <td class="text-end">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Bayar:</td>
                <td class="text-end">Rp{{ number_format($order->jml_bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembalian:</td>
                <td class="text-end">Rp{{ number_format($order->kembalian, 0, ',', '.') }}</td>
            </tr>
        </table>

        <hr>
        <p class="text-center">~~ Terima Kasih ~~</p>
    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>

</html>
