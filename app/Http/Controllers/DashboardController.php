<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Reservasi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $inputStartDate = $request->start_date ?? '';
        $inputEndDate = $request->end_date ?? '';

        if ($inputStartDate === '' || $inputEndDate === '') {
            $startDate = Carbon::now()->subDays(6)->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
            $inputStartDate = '';
            $inputEndDate = '';
        } else {
            $startDate = $inputStartDate;
            $endDate = $inputEndDate;
            if ($startDate > $endDate) {
                [$startDate, $endDate] = [$endDate, $startDate];
            }
        }

        $totalMenu = Menu::count();
        $totalOrder = Order::count();
        $totalReservasi = Reservasi::count();
        $recentOrders = Order::with('user')->latest()->limit(5)->get();

        $period = new \DatePeriod(
            new \DateTime($startDate),
            new \DateInterval('P1D'),
            (new \DateTime($endDate))->modify('+1 day')
        );

        $dates = [];
        $totals = [];
        $reservasiTotals = [];
        $pendapatanTotals = [];

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $dates[] = $formattedDate;

            $totals[] = Order::whereDate('tgl', $formattedDate)->count();
            $reservasiTotals[] = Reservasi::whereDate('tanggal_dibuat', $formattedDate)->count();
            $pendapatanTotals[] = Order::whereDate('tgl', $formattedDate)
                ->with('detailOrders')
                ->get()
                ->sum(function ($order) {
                    return $order->detailOrders->sum('subtotal');
                });
        }

        // Bulan ini & bulan lalu untuk transaksi dan reservasi
        $thisMonthStart = Carbon::now()->startOfMonth();
        $thisMonthEnd = Carbon::now()->endOfMonth();

        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $orderThisMonth = Order::whereBetween('tgl', [$thisMonthStart, $thisMonthEnd])->count();
        $orderLastMonth = Order::whereBetween('tgl', [$lastMonthStart, $lastMonthEnd])->count();

        $reservasiThisMonth = Reservasi::where('created_at', '>=', $thisMonthStart)->count();
        $reservasiLastMonth = Reservasi::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();

        // Pendapatan hari ini
        $pendapatanHariIni = Order::whereDate('tgl', Carbon::today())
            ->with('detailOrders')
            ->get()
            ->sum(fn($order) => $order->detailOrders->sum('subtotal'));

        // Pendapatan bulanan
        $pendapatanThisMonth = Order::whereBetween('tgl', [$thisMonthStart, $thisMonthEnd])
            ->with('detailOrders')
            ->get()
            ->sum(fn($order) => $order->detailOrders->sum('subtotal'));

        $pendapatanLastMonth = Order::whereBetween('tgl', [$lastMonthStart, $lastMonthEnd])
            ->with('detailOrders')
            ->get()
            ->sum(fn($order) => $order->detailOrders->sum('subtotal'));

        $orderChange = $this->calculatePercentageChange($orderLastMonth, $orderThisMonth);
        $reservasiChange = $this->calculatePercentageChange($reservasiLastMonth, $reservasiThisMonth);
        $pendapatanChange = $this->calculatePercentageChange($pendapatanLastMonth, $pendapatanThisMonth);

        return view('dashboard.dashboard', compact(
            'totalMenu',
            'totalOrder',
            'totalReservasi',
            'recentOrders',
            'dates',
            'totals',
            'reservasiTotals',
            'pendapatanTotals',
            'startDate',
            'endDate',
            'inputStartDate',
            'inputEndDate',
            'orderChange',
            'reservasiChange',
            'pendapatanHariIni',
            'pendapatanThisMonth',
            'pendapatanChange'
        ));
    }

    public function getStockNotifications()
    {
        $notifications = [];

        $menus = Menu::orderBy('updated_at', 'desc')->get();

        foreach ($menus as $menu) {
            if ($menu->stok == 0) {
                $notifications[] = [
                    'type' => 'warning',
                    'title' => 'Stok Habis',
                    'message' => "Menu <strong>{$menu->nama_menu}</strong> kehabisan stok.",
                    'icon' => 'ni-box-2',
                    'time' => $menu->updated_at,
                ];
            } elseif ($menu->stok > 0 && Carbon::parse($menu->updated_at)->gt(now()->subMinutes(10))) {
                $notifications[] = [
                    'type' => 'success',
                    'title' => 'Stok Ditambahkan',
                    'message' => "Menu <strong>{$menu->nama_menu}</strong> telah ditambahkan kembali.",
                    'icon' => 'ni-fat-add',
                    'time' => $menu->updated_at,
                ];
            }
        }

        return response()->json([
            'notifications' => $notifications,
            'count' => count($notifications)
        ]);
    }


    private function calculatePercentageChange($last, $current)
    {
        if ($last == 0) {
            return $current > 0 ? 100 : 0;
        }
        return round((($current - $last) / $last) * 100, 2);
    }
}
