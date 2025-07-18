@extends('layouts.app')

@section('title', 'Dashboard')
@section('judul', 'Dashboard Page')

@section('content')
<style>
  /* Modern Dashboard Style */
  .dashboard-bg {
    background: linear-gradient(120deg, #faf7e3 60%, #f7f6f2 100%);
    min-height: 100vh;
  }
  .card-cafe, .card.shadow, .card {
    border-radius: 1.2rem !important;
    box-shadow: 0 4px 24px 0 rgba(61,33,26,0.08) !important;
    border: none !important;
    margin-bottom: 1.5rem;
    transition: box-shadow 0.2s;
  }
  .card-cafe:hover, .card.shadow:hover, .card:hover {
    box-shadow: 0 8px 32px 0 rgba(61,33,26,0.13) !important;
  }
  .icon-circle, .icon.icon-shape {
    background: #A07856 !important;
    color: #fff !important;
    width: 54px;
    height: 54px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: 0 2px 8px 0 rgba(61,33,26,0.10);
    font-size: 1.7rem;
  }
  .dashboard-metric-title {
    font-size: 1rem;
    font-weight: 600;
    color: #A07856;
    letter-spacing: 0.5px;
    margin-bottom: 0.2rem;
  }
  .dashboard-metric-value {
    font-size: 2.3rem;
    font-weight: 800;
    color: #3D211A;
    line-height: 1.1;
  }
  .dashboard-metric-card {
    padding: 1.5rem 1.2rem 1.2rem 1.2rem;
  }
  .dashboard-filter-form {
    display: grid;
    grid-template-columns: 1fr 1fr auto auto;
    align-items: end;
    gap: 1.2rem;
    padding: 1.2rem 0 0.5rem 0;
    flex-wrap: wrap;
  }
  .dashboard-filter-form label {
    font-weight: 500;
    margin-bottom: 6px;
    color: #A07856;
    display: block;
  }
  .dashboard-filter-form input[type="date"] {
    border-radius: 10px;
    font-size: 1rem;
    padding: 10px 14px;
    box-shadow: 0 1px 4px 0 rgba(0,0,0,0.03);
    border: 1px solid #e0e0e0;
    background: #fff;
    transition: border 0.2s;
    height: 44px;
    min-width: 160px;
  }
  .dashboard-filter-form input[type="date"]:focus {
    border: 1.5px solid #6c63ff;
    outline: none;
  }
  .dashboard-filter-form .btn-cafe {
    border-radius: 10px !important;
    font-weight: 600;
    font-size: 1rem;
    min-width: 100px;
    box-shadow: 0 1px 6px 0 rgba(0,0,0,0.06);
    margin-right: 8px;
    margin-bottom: 0;
    padding: 10px 18px;
    transition: background 0.2s, color 0.2s;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .dashboard-filter-form .btn-cafe {
    background: #6c63ff;
    color: #fff;
    border: none;
  }
  .dashboard-filter-form .btn-cafe:hover {
    background: #5548c8;
    color: #fff;
  }
  .dashboard-filter-form .btn-cafe:last-child {
    background: #f3f3f3;
    color: #333;
  }
  .dashboard-filter-form .btn-cafe:last-child:hover {
    background: #e0e0e0;
    color: #333;
  }
  .list-group-item {
    border-radius: 0.7rem !important;
    margin-bottom: 0.7rem !important;
    border: none !important;
    box-shadow: 0 1px 6px 0 rgba(0,0,0,0.04);
    transition: box-shadow 0.2s;
  }
  .list-group-item:hover {
    box-shadow: 0 4px 16px 0 rgba(0,0,0,0.08);
  }
  @media (max-width: 900px) {
    .container, .container-fluid {
      padding-left: 0 !important;
      padding-right: 0 !important;
      margin: 0 !important;
      width: 100vw !important;
      max-width: 100vw !important;
    }
    .row {
      flex-direction: column !important;
      gap: 1.2rem !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
    }
    .card, .card-cafe, .shadow {
      width: 100% !important;
      min-width: 0 !important;
      max-width: 100vw !important;
      margin: 0 auto 1.2rem auto !important;
    }
    .col-xl-4, .col-lg-6, .mb-4 {
      width: 100% !important;
      max-width: 100vw !important;
      margin: 0 !important;
      padding: 0 !important;
    }
    .dashboard-filter-form {
      display: flex !important;
      flex-direction: column !important;
      gap: 1rem;
    }
    .dashboard-filter-form > div {
      width: 100% !important;
    }
    .dashboard-filter-form .btn-cafe {
      width: 100% !important;
      margin-right: 0 !important;
    }
  }
</style>
<div class="container py-4 dashboard-bg">
    <div class="row" style="margin-bottom:0.5rem;">
        <!-- Total Menu -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card card-cafe dashboard-metric-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="dashboard-metric-title">Total Menu</div>
                            <div class="dashboard-metric-value">{{ $totalMenu ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle">
                                <i class="fas fa-utensils"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card card-cafe dashboard-metric-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="dashboard-metric-title">Total Transaksi</div>
                            <div class="dashboard-metric-value">{{ $totalOrder ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Reservasi -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card card-cafe dashboard-metric-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="dashboard-metric-title">Total Reservasi</div>
                            <div class="dashboard-metric-value">{{ $totalReservasi ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle" style="background:#6F4D38;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pendapatan Hari Ini -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card card-cafe dashboard-metric-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="dashboard-metric-title">Pendapatan Hari Ini</div>
                            <div class="dashboard-metric-value">Rp{{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pendapatan Bulanan -->
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card card-cafe dashboard-metric-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="dashboard-metric-title">Pendapatan Bulanan</div>
                            <div class="dashboard-metric-value">Rp{{ number_format($pendapatanThisMonth, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Statistik Harian -->
    <div class="card shadow mb-4" style="background:#fff;border-radius:1rem;box-shadow:0 2px 8px #3D211A22;">
        <div class="card-header" style="background:#faf7e3;border-bottom:1px solid #e5e5e5;border-radius:1rem 1rem 0 0;">
            <form method="GET" action="{{ route('dashboard') }}" class="mb-4 d-flex dashboard-filter-form">
                <div>
                    <label for="start_date" class="form-label mb-1">Dari Tanggal</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $inputStartDate }}">
                </div>
                <div>
                    <label for="end_date" class="form-label mb-1">Sampai Tanggal</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $inputEndDate }}">
                </div>
                <div class="align-self-end d-flex gap-2">
                    <button type="submit" class="btn-cafe">Filter</button>
                    <a href="{{ route('dashboard') }}" class="btn-cafe">Reset</a>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div id="combinedChart"></div>
        </div>
    </div>

    <!-- Ringkasan Aktivitas -->
    <div class="card shadow mb-4" style="background:#fff;border-radius:1rem;box-shadow:0 2px 8px #3D211A22;">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#faf7e3;border-bottom:1px solid #e5e5e5;border-radius:1rem 1rem 0 0;">
            <h5 class="mb-0" style="color:#3D211A;">Aktivitas Terakhir</h5>
        </div>
        <div class="card-body">
            @if (!empty($recentOrders) && count($recentOrders) > 0)
                <div class="list-group">
                    @foreach ($recentOrders as $order)
                        <a href="{{ route('order.show', $order->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="border-radius:0.5rem;margin-bottom:0.5rem;">
                            <div>
                                <i class="fas fa-receipt" style="color:var(--cafe-bistre);margin-right:0.5rem;"></i>
                                <strong style="color:var(--cafe-bistre);">Order #{{ $order->id }}</strong> oleh
                                <span class="text-muted">{{ $order->user->user_name ?? 'Tidak diketahui' }}</span>
                                <div class="small text-muted">{{ $order->tgl }}</div>
                            </div>
                            <span class="badge" style="background:var(--cafe-bistre);color:var(--cafe-beige);border-radius:1rem;padding:0.5em 1em;">
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
