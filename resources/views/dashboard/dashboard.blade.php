@extends('layouts.app')

@section('title', 'Dashboard')
@section('judul', 'Dashboard Page')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Total Menu -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card card-stats shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Menu</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $totalMenu ?? 0 }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                <i class="fas fa-utensils"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-danger mr-2"></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card card-stats shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Transaksi</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $totalOrder ?? 0 }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        @if ($orderChange >= 0)
                            <i class="fas fa-arrow-up"></i> {{ $orderChange }}%
                        @else
                            <span class="text-danger mr-2">
                                <i class="fas fa-arrow-down"></i> {{ abs($orderChange) }}%
                            </span>
                        @endif
                        <span class="text-nowrap">dibanding bulan lalu</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Reservasi -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card card-stats shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Reservasi</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $totalReservasi ?? 0 }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        @if ($reservasiChange >= 0)
                            <span class="text-success mr-2">
                                <i class="fas fa-arrow-up"></i> {{ $reservasiChange }}%
                            </span>
                        @else
                            <span class="text-danger mr-2">
                                <i class="fas fa-arrow-down"></i> {{ abs($reservasiChange) }}%
                            </span>
                        @endif
                        <span class="text-nowrap">dibanding bulan lalu</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendapatan Hari Ini dan Pendapatan Bulanan dalam 1 baris -->
    <div class="row">
        <!-- Pendapatan Hari Ini -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card card-stats shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Pendapatan Hari Ini</h5>
                            <span class="h2 font-weight-bold mb-0">Rp{{ number_format($pendapatanHariIni, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-danger mr-2"></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Pendapatan Bulanan -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card card-stats shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Pendapatan Bulanan</h5>
                            <span class="h2 font-weight-bold mb-0">Rp{{ number_format($pendapatanThisMonth, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        @if ($pendapatanChange >= 0)
                            <span class="text-success mr-2">
                                <i class="fas fa-arrow-up"></i> {{ $pendapatanChange }}%
                            </span>
                        @else
                            <span class="text-danger mr-2">
                                <i class="fas fa-arrow-down"></i> {{ abs($pendapatanChange) }}%
                            </span>
                        @endif
                        <span class="text-nowrap">dibanding bulan lalu</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Statistik Harian -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white border-bottom">
            <form method="GET" action="{{ route('dashboard') }}" class="mb-4 d-flex align-items-center gap-3 flex-wrap">
                <div>
                    <label for="start_date" class="form-label mb-1">Dari Tanggal</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $inputStartDate }}">
                </div>
                <div class="mx-2">
                    <label for="end_date" class="form-label mb-1">Sampai Tanggal</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $inputEndDate }}">
                </div>
                <div class="align-self-end d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div id="combinedChart"></div>
        </div>
    </div>

    <!-- Ringkasan Aktivitas -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Aktivitas Terakhir</h5>
        </div>
        <div class="card-body">
            @if (!empty($recentOrders) && count($recentOrders) > 0)
                <div class="list-group">
                    @foreach ($recentOrders as $order)
                        <a href="{{ route('order.show', $order->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-receipt text-primary me-2"></i>
                                <strong>Order #{{ $order->id }}</strong> oleh
                                <span class="text-muted">{{ $order->user->user_name ?? 'Tidak diketahui' }}</span>
                                <div class="small text-muted">{{ $order->tgl }}</div>
                            </div>
                            <span class="badge bg-primary rounded-pill text-secondary">
                                Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Belum ada aktivitas terbaru.</p>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const dates = {!! json_encode($dates) !!};
    const transaksiData = {!! json_encode($totals) !!};
    const reservasiData = {!! json_encode($reservasiTotals) !!};
    const pendapatanData = {!! json_encode($pendapatanTotals) !!};

    const options = {
        chart: {
            type: 'area',
            height: 400,
            toolbar: {
                show: true
            }
        },
        series: [{
                name: 'Transaksi',
                data: transaksiData
            },
            {
                name: 'Reservasi',
                data: reservasiData
            },
            {
                name: 'Pendapatan',
                data: pendapatanData
            }
        ],
        xaxis: {
            categories: dates,
            labels: {
                rotate: -45
            }
        },
        yaxis: [{
            title: {
                text: 'Jumlah'
            },
            labels: {
                formatter: val => val.toLocaleString()
            }
        }],
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: (val, { seriesIndex }) => {
                    if (seriesIndex === 2) return 'Rp ' + val.toLocaleString();
                    return val.toLocaleString();
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        colors: ['#1E90FF', '#FF4560', '#28a745']
    };

    const chart = new ApexCharts(document.querySelector("#combinedChart"), options);
    chart.render();
</script>
@endsection
