<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'tb_categories';
    protected $fillable = ['nama_category'];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'id_category');
    }
}
