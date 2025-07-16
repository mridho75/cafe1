<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Menu;
use App\Models\Member;
use App\Models\UserCafe;
use App\Models\Reservasi;
use App\Models\Categories;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KasirHomeController extends Controller
{
    // Menampilkan riwayat order dan ringkasan hari ini
    public function index(Request $request)
    {
        if (!allowedRoles(['kasir', 'admin'])) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $tanggal = $request->tanggal;

        if ($tanggal) {
            $riwayatOrder = Order::with(['reservasi', 'member'])
                ->whereDate('tgl', $tanggal)
                ->orderBy('tgl', 'desc')
                ->get();
        } else {
            $riwayatOrder = Order::with(['reservasi', 'member'])
                ->latest()
                ->take(10)
                ->get();
        }

        $today = Carbon::today();
        $jumlahOrder = Order::whereDate('tgl', $today)->count();
        $totalPemasukan = Order::whereDate('tgl', $today)->sum('total_harga');

        return view('kasir.home', compact('jumlahOrder', 'totalPemasukan', 'riwayatOrder', 'tanggal'));
    }

    // Menampilkan form untuk membuat pesanan baru
    public function createOrder()
    {
        $loggedInUserId = session('user_id');
        $loggedInUser = UserCafe::find($loggedInUserId);

        // Ambil semua kategori beserta menu-menu di dalamnya
        $categories = Categories::with('menus')->get();

        // Ambil reservasi yang belum dipakai di order manapun
        $usedReservasiIds = Order::whereNotNull('id_reservasi')->pluck('id_reservasi')->toArray();

        $reservasis = Reservasi::whereNotIn('id', $usedReservasiIds)->get();

        $members = Member::where('status', 'aktif')->get();

        $metodePembayarans = MetodePembayaran::all();

        return view('kasir.create_order', compact('categories', 'reservasis', 'members', 'loggedInUser', 'metodePembayarans'));
    }

    // Menyimpan pesanan baru
    public function storeOrder(Request $request)
{
    // Validasi dasar
    $request->validate([
        'id_user' => 'required|exists:tb_users_cafe,id',
        'tgl' => 'required|date',
        'jumlah_bayar' => 'required|numeric',
        'kembalian' => 'required|numeric',
        'menu_id' => 'required|array',
        'qty' => 'required|array',
        'harga_satuan' => 'required|array',
    ]);

    $menuIds = $request->menu_id;
    $qtys = $request->qty;
    $hargaSatuans = $request->harga_satuan;

    $subtotal = 0;
    $detailOrders = [];

    foreach ($menuIds as $i => $id_menu) {
        $qty = (int) $qtys[$i];
        $harga = (int) $hargaSatuans[$i];
        $menu = Menu::find($id_menu);

        if (!$menu || $menu->stok < $qty) {
            return response()->json([
                'error' => 'Stok tidak cukup untuk menu: ' . ($menu ? $menu->nama_menu : 'Tidak ditemukan')
            ], 422);
        }

        $subtotalItem = $qty * $harga;
        $subtotal += $subtotalItem;

        $detailOrders[] = [
            'id_menu' => $id_menu,
            'qty' => $qty,
            'harga_satuan' => $harga,
            'subtotal' => $subtotalItem,
        ];
    }

    // Simpan Order
    $order = Order::create([
        'id_user' => $request->id_user,
        'id_reservasi' => $request->id_reservasi ?: null,
        'id_member' => $request->id_member ?: null,
        'tgl' => $request->tgl,
        'total_harga' => $subtotal,
        'jml_bayar' => $request->jumlah_bayar,
        'kembalian' => $request->kembalian,
        'dp_reservasi' => $request->dp_reservasi ?? 0,
    ]);

    // Simpan Detail dan Kurangi Stok
    foreach ($detailOrders as $item) {
        DetailOrder::create([
            'id_order' => $order->id,
            ...$item
        ]);

        $menu = Menu::find($item['id_menu']);
        $menu->stok -= $item['qty'];
        $menu->save();
    }

    return response($order->id, 200);
}


    public function showReceipt($id)
    {
        $order = Order::with([
            'user',
            'reservasi.member',
            'reservasi',
            'detailOrders.menu'
        ])->findOrFail($id);

        return view('order.detail', compact('order'));
    }
}
