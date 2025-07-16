<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'tb_orders'; // Nama tabel
    protected $fillable = [
        'id_user',
        'id_reservasi',
        'id_member',
        'id_metode_pembayaran',
        'tgl',
        'total_harga',
        'jml_bayar',
        'kembalian',
    ];



    // Relasi dengan UserCafe
    public function user()
    {
        return $this->belongsTo(UserCafe::class, 'id_user');
    }

    // Relasi dengan Reservasi
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi');
    }

    // Relasi dengan DetailOrder
    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'id_order');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'id_metode_pembayaran');
    }

}
