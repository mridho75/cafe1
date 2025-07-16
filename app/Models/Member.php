<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'tb_members';

    protected $fillable = [
        'kode_member',
        'nama_members',
        'ttl',
        'hp',
        'alamat',
        'status'
    ];

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'member_id');
    }

}
