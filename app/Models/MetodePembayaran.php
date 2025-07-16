<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    // Nama tabel, kalau pakai nama standar (plural + snake_case) bisa dihapus ini
    protected $table = 'tb_metode_pembayaran';

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'nama_metode',
        'ikon',
    ];

    /**
     * Relasi ke orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_metode_pembayaran');
    }
}
