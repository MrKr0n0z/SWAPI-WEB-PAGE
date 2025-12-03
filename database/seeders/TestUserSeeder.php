<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '+1234567890',
            'address' => 'Calle Principal 123, Ciudad',
        ]);

        // Usuario regular
        User::create([
            'name' => 'Usuario Regular',
            'email' => 'user@test.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '+9876543210',
            'address' => 'Avenida Secundaria 456, Ciudad',
        ]);
    }
}
