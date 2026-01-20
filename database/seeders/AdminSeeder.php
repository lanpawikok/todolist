<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@todolist.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]); 

        // Buat akun User biasa (optional)
        User::create([
            'name' => 'Regular User',
            'email' => 'user@todolist.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}