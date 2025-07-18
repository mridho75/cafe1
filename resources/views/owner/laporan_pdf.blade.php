<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 9px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 5px;
        }

        .table-wrapper {
            overflow-x: auto;
            margin-top: 20px;
            max-width: 100vw;
            /* maksimal lebar 100% viewport */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* agar kolom punya lebar tetap */
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
            text-align: left;
            white-space: normal;
            /* bisa wrap teks */
            word-wrap: break-word;
            /* pecah kata jika terlalu panjang */
            vertical-align: top;
        }

        th {
            background-color: #eee;
            font-size: 8px;
        }

        .harga,
        .menu,
        .subtotal,
        .bayar,
        .dp,
        .kembalian,
        .pemasukan {
            width: 80px;
            text-align: right;
        }

        .tgl {
            width: 90px;
        }

        .qty {
            width: 20px;
        }
    </style>
</head>

<body>

    <h2>Laporan Transaksi</h2>
    <p>
        Periode:
        @if ($from && $to)
            {{ \Carbon\Carbon::parse($from)->translatedFormat('d F Y') }} s/d
            {{ \Carbon\Carbon::parse($to)->translatedFormat('d F Y') }}
        @else
            -
        @endif
    </p>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Kasir</th>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th>Jumlah Bayar</th>
                    <th>Kembalian</th>
                    <th>Pemasukan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    @php
                        $detailCount = $order->detailOrders->count();
                        $pemasukan = $order->detailOrders->sum('subtotal');
                    @endphp
                    @foreach ($order->detailOrders as $index => $detail)
                        <tr>
                            @if ($index == 0)
                                <td rowspan="{{ $detailCount }}">{{ \Carbon\Carbon::parse($order->tgl)->translatedFormat('d F Y') }}</td>
                                <td rowspan="{{ $detailCount }}">{{ $order->user->user_name }}</td>
                            @endif
                            <td>{{ $detail->menu->nama_menu }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            @if ($index == 0)
                                <td rowspan="{{ $detailCount }}">Rp {{ number_format($order->jml_bayar, 0, ',', '.') }}</td>
                                <td rowspan="{{ $detailCount }}">Rp {{ number_format($order->kembalian, 0, ',', '.') }}</td>
                                <td rowspan="{{ $detailCount }}">Rp {{ number_format($pemasukan, 0, ',', '.') }}</td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="right" style="margin-top: 20px;">
        <strong>Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong>
    </p>

</body>

</html>
