<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\UserCafe;
use App\Models\Menu;
use App\Models\Reservasi;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Menampilkan daftar transaksi
    public function index(Request $request)
    {
        if (!allowedRoles(['admin', 'kasir'])) {
            return redirect('/')->with('error', 'Akses hanya untuk Admin!');
        }

        if ($request->ajax()) {
            $orders = Order::with(['metodePembayaran', 'user'])
                ->orderBy('tgl', 'desc')
                ->paginate(10);

            return view('order._table', compact('orders'))->render();
        }

        // Halaman utama (tanpa AJAX)
        $orders = Order::with(['metodePembayaran', 'user'])
            ->orderBy('tgl', 'desc')
            ->paginate(10);

        return view('order.index', compact('orders'));
    }


    public function show($id)
    {
        $order = Order::with(['detailOrders.menu', 'user'])->findOrFail($id);
        return view('order.show', compact('order'));
    }


    // Menyimpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:tb_users_cafe,id',
            'id_reservasi' => 'nullable|exists:tb_reservasis,id',
            'id_member' => 'nullable|exists:tb_members,id',
            'id_metode_pembayaran' => 'required|exists:tb_metode_pembayaran,id',
            'tgl' => 'required|date',
            'menu_id' => 'required|array',
            'qty' => 'required|array',
            'harga_satuan' => 'required|array',
            'jumlah_bayar' => 'required|numeric',
            'kembalian' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            // Cek stok terlebih dahulu semua menu yang dipesan
            foreach ($request->menu_id as $i => $id_menu) {
                $menu = Menu::find($id_menu);
                if (!$menu) {
                    DB::rollBack();
                    return back()->withErrors(['error' => "Menu dengan ID {$id_menu} tidak ditemukan"]);
                }
                if ($menu->stok < $request->qty[$i]) {
                    DB::rollBack();
                    return back()->withErrors(['error' => "Stok menu '{$menu->nama_menu}' tidak cukup. Stok tersedia: {$menu->stok}"]);
                }
            }

            // Hitung total harga
            $total = 0;
            foreach ($request->menu_id as $i => $id_menu) {
                $total += $request->qty[$i] * $request->harga_satuan[$i];
            }

            // Simpan order utama
            $order = Order::create([
                'id_user' => $request->id_user,
                'id_reservasi' => $request->id_reservasi ?: null,
                'id_member' => $request->id_member ?: null,
                'id_metode_pembayaran' => $request->id_metode_pembayaran,
                'tgl' => $request->tgl,
                'total_harga' => $total,
                'jml_bayar' => $request->jumlah_bayar,
                'kembalian' => $request->kembalian,
            ]);

            // Simpan detail order dan update stok menu
            foreach ($request->menu_id as $i => $id_menu) {
                DetailOrder::create([
                    'id_order' => $order->id,
                    'id_menu' => $id_menu,
                    'qty' => $request->qty[$i],
                    'harga_satuan' => $request->harga_satuan[$i],
                    'subtotal' => $request->qty[$i] * $request->harga_satuan[$i],
                ]);

                // Kurangi stok menu
                $menu = Menu::find($id_menu);
                $menu->stok -= $request->qty[$i];
                $menu->save();
            }

            DB::commit();
            return redirect()->route('order.index')->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan transaksi: ' . $e->getMessage()]);
        }
    }

    public function showReceipt($id)
    {
        $order = Order::with([
            'user',
            'detailOrders.menu'
        ])->findOrFail($id);

        return view('order.detail', compact('order'));
    }
}
