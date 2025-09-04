<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Sector;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear Superadministrador
        User::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@jatucachi.com',
            'password' => Hash::make('admin123'),
            'role' => 'superadmin',
            'sector_id' => null,
            'email_verified_at' => now()
        ]);

        // Crear administradores de sector
        $sectores = Sector::all();
        
        foreach ($sectores as $sector) {
            User::create([
                'name' => "Administrador {$sector->nombre}",
                'email' => "admin.{$sector->nombre}@jatucachi.com",
                'password' => Hash::make('admin123'),
                'role' => 'admin_sector',
                'sector_id' => $sector->id,
                'email_verified_at' => now()
            ]);
        }
    }
}
