<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'tb_menus';
    protected $fillable = ['id_category', 'nama_menu', 'harga', 'image', 'stok'];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'id_category');
    }
}
