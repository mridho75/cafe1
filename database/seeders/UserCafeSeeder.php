<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserCafeSeeder extends Seeder
{
    public function run()
    {
        DB::table('tb_users_cafe')->insertOrIgnore([
            [
                'user_name' => 'admin',
                'user_password' => Hash::make('admin'),
                'role' => 'admin'
            ],
            [
                'user_name' => 'kasir1',
                'user_password' => Hash::make('kasir1'),
                'role' => 'kasir'
            ],
            [
                'user_name' => 'owner',
                'user_password' => Hash::make('owner'),
                'role' => 'pemilik'
            ]
        ]);
    }
}
