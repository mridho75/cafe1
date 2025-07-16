<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('tb_categories')->insert([
            ['nama_category' => 'Kopi'],
            ['nama_category' => 'Non-Kopi & Latte'],
            ['nama_category' => 'Signature Drinks'],
            ['nama_category' => 'Minuman Dingin'],
            ['nama_category' => 'Makanan Berat'],
            ['nama_category' => 'Snack & Light Bites'],
            ['nama_category' => 'Dessert'],
            ['nama_category' => 'Add-ons'],
        ]);

    }
}

