<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'tb_reservasis';

    protected $fillable = [
        'id_user',
        'id_member',
        'nama_pelanggan',
        'tanggal_dibuat',
        'tanggal_reservasi',
        'nomor_meja',
        'jumlah_kursi',
        'dp',
        'sudah_dipakai',
    ];

    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'tanggal_reservasi' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(UserCafe::class, 'id_user');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    // Di app/Models/Reservasi.php
    public function getIsUsedAttribute()
    {
        // Cek ada order yang pakai reservasi ini atau enggak
        return \App\Models\Order::where('id_reservasi', $this->id)->exists();
    }


}
