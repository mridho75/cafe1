<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Menu;
use App\Models\UserCafe;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{

    public function index(Request $request)
    {
        if (!allowedRoles(['pemilik', 'admin'])) {
            return redirect('/')->with('error', 'Akses hanya untuk pemilik!');
        }

        $from = $request->input('from');
        $to = $request->input('to');

        $query = Order::with(['detailOrders.menu', 'user', 'reservasi', 'member'])
              ->orderBy('tgl', 'desc');

        if ($from && $to) {
            $query->whereBetween('tgl', [$from, $to]);
        }

        $orders = $query->get();

        // Total dari semua subtotal menu (uang yang seharusnya masuk)
        $totalPendapatan = $orders->sum(function ($order) {
            return $order->detailOrders->sum('subtotal');
        });

        return view('owner.laporan', compact('orders', 'totalPendapatan'));
    }



    public function export(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        return Excel::download(new LaporanExport($from, $to), 'laporan-transaksi.xlsx');
    }


    public function exportPDF(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $query = Order::with(['user', 'reservasi', 'member', 'detailOrders.menu'])
            ->when($from && $to, function ($q) use ($from, $to) {
                $q->whereBetween('tgl', [$from, $to]);
            });

        $orders = $query->get();

        $totalPendapatan = $orders->sum(function ($order) {
            return $order->detailOrders->sum('subtotal');
        });

        $pdf = Pdf::loadView('owner.laporan_pdf', compact('orders', 'totalPendapatan', 'from', 'to'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_transaksi.pdf');
    }



}
