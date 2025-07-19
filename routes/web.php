<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserCafeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\KasirHomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Middleware\AuthSession;

// ============================
// Auth Routes
// ============================
Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================
// Protected Routes (Harus Login)
// ============================
Route::middleware([AuthSession::class])->group(function () {

    // Home and Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications/stock', [DashboardController::class, 'getStockNotifications'])->name('notif.stock');

    // User Management
    Route::resource('user', UserCafeController::class);

    // Menu & Kategori
    Route::resource('menu', MenuController::class);
    Route::post('/menu/{id}/add-stock', [MenuController::class, 'addStock'])->name('menu.addStock');
    Route::put('/menu/{id}/update-stock', [MenuController::class, 'updateStock'])->name('menu.updateStock');


    Route::resource('category', CategoriesController::class);

    // Member
    // Reservasi
    // Fitur member & reservasi dihapus



    // Transaksi (Order)
    Route::resource('order', OrderController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('/order/receipt/{id}', [OrderController::class, 'showReceipt'])->name('order.show.receipt');
    Route::get('/order/detail/{id}', [OrderController::class, 'show'])->name('order.detail');


    // Kasir Home (Halaman Kasir)
    Route::get('/kasir/home', [KasirHomeController::class, 'index'])->name('kasir.home');
    // Halaman untuk membuat order
    Route::get('/kasir/order', [KasirHomeController::class, 'createOrder'])->name('kasir.create_order');
    // Menyimpan order yang dibuat
    Route::post('/kasir/order', [KasirHomeController::class, 'storeOrder'])->name('kasir.store_order');
    //stok refresh
    Route::get('/kasir/stok-terbaru', function () {
        return \App\Models\Menu::select('id', 'stok')->get();
    })->name('kasir.stok_terbaru');


    // Halaman Untuk Melihat Laporan dan export excel&pdf
    Route::get('/owner/laporan', [LaporanController::class, 'index'])->name('owner.laporan');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('owner.laporan.export');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPDF'])->name('owner.laporan.pdf');

    // Metode Pembayaran
    Route::resource('metode', MetodePembayaranController::class)->except(['show']);
});
