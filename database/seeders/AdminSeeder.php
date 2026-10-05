<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Buat akun admin perpustakaan.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@perpus.test'],
            [
                'name' => 'Admin Perpus',
                // Jangan pakai Hash::make di sini karena
                // User model sudah punya cast 'password' => 'hashed'
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
    }
}
