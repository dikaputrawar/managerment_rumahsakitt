<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // cek berdasarkan email
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'), // ganti password sesuai kebutuhan
                'is_admin' => true, // pastikan kolom 'is_admin' ada di tabel users
            ]
        );
    }
}
