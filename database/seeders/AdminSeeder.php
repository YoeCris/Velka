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
        // Crear administrador principal de Jatucani
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@jatucani.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Crear usuario de prueba
        User::create([
            'name' => 'Comunero',
            'email' => 'comunero@jatucani.com', 
            'password' => Hash::make('comunero123'),
            'email_verified_at' => now(),
        ]);
    }
}