<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserLoginSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('t_user')->insert([
            'nip' => '678901234567890123',
            'level' => 'admin',
            'password' => Hash::make('67890'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
