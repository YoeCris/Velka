<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Sector;
use App\Models\Cargo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Deshabilitar verificación de claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Limpiar tablas existentes
        User::truncate();
        Sector::truncate();
        Cargo::truncate();

        // Crear sectores primero
        echo "Creando sectores...\n";
        $sectores = [
            [
                'nombre' => 'Central',
                'descripcion' => 'Sector Central de la Comunidad Jatucachi',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Catahui',
                'descripcion' => 'Sector Catahui de la Comunidad Jatucachi',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Jayuyapu',
                'descripcion' => 'Sector Jayuyapu de la Comunidad Jatucachi',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Titire',
                'descripcion' => 'Sector Titire de la Comunidad Jatucachi',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($sectores as $sector) {
            Sector::create($sector);
        }

        // Crear cargos
        echo "Creando cargos...\n";
        $cargos = [
            ['nombre' => 'Presidente', 'descripcion' => 'Presidente de la Comunidad', 'activo' => true],
            ['nombre' => 'Vice Presidente', 'descripcion' => 'Vice Presidente de la Comunidad', 'activo' => true],
            ['nombre' => 'Secretario', 'descripcion' => 'Secretario de la Comunidad', 'activo' => true],
            ['nombre' => 'Tesorero', 'descripcion' => 'Tesorero de la Comunidad', 'activo' => true],
            ['nombre' => 'Fiscal', 'descripcion' => 'Fiscal de la Comunidad', 'activo' => true],
            ['nombre' => 'Vocal', 'descripcion' => 'Vocal de la Comunidad', 'activo' => true],
            ['nombre' => 'Coordinador de Sector', 'descripcion' => 'Coordinador de Sector', 'activo' => true],
            ['nombre' => 'Delegado', 'descripcion' => 'Delegado de la Comunidad', 'activo' => true]
        ];

        foreach ($cargos as $cargo) {
            Cargo::create($cargo);
        }

        // Crear superadministrador
        echo "Creando superadministrador...\n";
        User::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@jatucachi.com',
            'password' => Hash::make('admin123'),
            'role' => 'superadmin',
            'sector_id' => null,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Crear administradores de sector
        echo "Creando administradores de sector...\n";
        $sectoresCreados = Sector::all();
        
        foreach ($sectoresCreados as $sector) {
            User::create([
                'name' => "Administrador {$sector->nombre}",
                'email' => "admin." . strtolower($sector->nombre) . "@jatucachi.com",
                'password' => Hash::make('admin123'),
                'role' => 'admin_sector',
                'sector_id' => $sector->id,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Rehabilitar verificación de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "✅ Usuarios creados correctamente!\n";
        echo "📧 Superadmin: admin@jatucachi.com / admin123\n";
        echo "📧 Admin sectores: admin.[sector]@jatucachi.com / admin123\n";

        // Llamar al seeder de comuneros si existe
        $this->call([
            ComuneroSeeder::class,
        ]);
    }
}
