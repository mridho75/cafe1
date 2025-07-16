<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserCafe extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tb_users_cafe';

    protected $fillable = [
        'user_name',
        'user_password',
        'role',
    ];

    protected $hidden = [
        'user_password', // Sesuaikan dengan kolom user_password
    ];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_user');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'id_user');
    }

}
