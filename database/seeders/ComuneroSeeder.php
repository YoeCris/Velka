<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ComuneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear administrador principal
        User::create([
            'name' => 'Juan Carlos',
            'apellido_paterno' => 'Quispe',
            'apellido_materno' => 'Mamani',
            'email' => 'admin@jatucani.com',
            'password' => Hash::make('password'),
            'dni' => '12345678',
            'fecha_nacimiento' => '1970-05-15',
            'genero' => 'masculino',
            'telefono' => '987654321',
            'condicion' => 'calificado',
            'sector' => 'sector_1',
            'fecha_ingreso_comunidad' => '1995-01-01',
            'rol' => 'administrador',
            'activo' => true,
            'direccion' => 'Av. Principal 123, Jatucani',
            'ocupacion' => 'Presidente de la Comunidad',
            'estado_civil' => 'casado',
            'observaciones' => 'Administrador principal del sistema',
        ]);

        // Crear comuneros calificados de muestra
        $comunerosCalificados = [
            [
                'name' => 'María Elena',
                'apellido_paterno' => 'Condori',
                'apellido_materno' => 'Flores',
                'dni' => '23456789',
                'sector' => 'sector_1',
                'ocupacion' => 'Agricultora',
                'telefono' => '987654322',
            ],
            [
                'name' => 'Pedro Miguel',
                'apellido_paterno' => 'Huanca',
                'apellido_materno' => 'Ticona',
                'dni' => '34567890',
                'sector' => 'sector_2',
                'ocupacion' => 'Ganadero',
                'telefono' => '987654323',
            ],
            [
                'name' => 'Rosa María',
                'apellido_paterno' => 'Choque',
                'apellido_materno' => 'Apaza',
                'dni' => '45678901',
                'sector' => 'sector_3',
                'ocupacion' => 'Comerciante',
                'telefono' => '987654324',
            ],
            [
                'name' => 'Carlos Alberto',
                'apellido_paterno' => 'Vilca',
                'apellido_materno' => 'Soncco',
                'dni' => '56789012',
                'sector' => 'sector_4',
                'ocupacion' => 'Técnico',
                'telefono' => '987654325',
            ],
        ];

        foreach ($comunerosCalificados as $index => $comunero) {
            User::create(array_merge($comunero, [
                'email' => 'comunero' . ($index + 2) . '@jatucani.com',
                'password' => Hash::make('password'),
                'fecha_nacimiento' => '1980-0' . (($index % 9) + 1) . '-15',
                'genero' => $index % 2 == 0 ? 'femenino' : 'masculino',
                'condicion' => 'calificado',
                'fecha_ingreso_comunidad' => '200' . ($index + 5) . '-03-01',
                'rol' => 'comunero',
                'activo' => true,
                'direccion' => 'Calle ' . ($index + 1) . ' #' . (100 + $index * 50) . ', Jatucani',
                'estado_civil' => ['soltero', 'casado', 'viudo', 'divorciado'][$index],
            ]));
        }

        // Crear comuneros no calificados de muestra
        $comunerosNoCalificados = [
            [
                'name' => 'Ana Lucía',
                'apellido_paterno' => 'Mamani',
                'apellido_materno' => 'Cruz',
                'dni' => '67890123',
                'sector' => 'sector_1',
                'ocupacion' => 'Estudiante',
                'telefono' => '987654326',
            ],
            [
                'name' => 'José Luis',
                'apellido_paterno' => 'Ccapa',
                'apellido_materno' => 'Quispe',
                'dni' => '78901234',
                'sector' => 'sector_2',
                'ocupacion' => 'Trabajador independiente',
                'telefono' => '987654327',
            ],
            [
                'name' => 'Carmen Rosa',
                'apellido_paterno' => 'Puma',
                'apellido_materno' => 'Coaquira',
                'dni' => '89012345',
                'sector' => 'sector_3',
                'ocupacion' => 'Ama de casa',
                'telefono' => '987654328',
            ],
            [
                'name' => 'Miguel Ángel',
                'apellido_paterno' => 'Chuquimia',
                'apellido_materno' => 'Layme',
                'dni' => '90123456',
                'sector' => 'sector_4',
                'ocupacion' => 'Comerciante menor',
                'telefono' => '987654329',
            ],
            [
                'name' => 'Esperanza',
                'apellido_paterno' => 'Colque',
                'apellido_materno' => 'Nina',
                'dni' => '01234567',
                'sector' => 'sector_1',
                'ocupacion' => 'Artesana',
                'telefono' => '987654330',
            ],
        ];

        foreach ($comunerosNoCalificados as $index => $comunero) {
            User::create(array_merge($comunero, [
                'email' => 'nocal' . ($index + 1) . '@jatucani.com',
                'password' => Hash::make('password'),
                'fecha_nacimiento' => '199' . ($index % 2 + 1) . '-0' . (($index % 9) + 1) . '-20',
                'genero' => $index % 2 == 0 ? 'femenino' : 'masculino',
                'condicion' => 'no_calificado',
                'fecha_ingreso_comunidad' => '201' . ($index % 2 + 8) . '-06-15',
                'rol' => 'comunero',
                'activo' => true,
                'direccion' => 'Jr. Comunal ' . ($index + 10) . ' #' . (200 + $index * 25) . ', Jatucani',
                'estado_civil' => ['soltero', 'casado', 'conviviente', 'soltero', 'casado'][$index],
                'observaciones' => $index == 0 ? 'En proceso de calificación' : null,
            ]));
        }

        // Crear algunos comuneros inactivos para testing
        User::create([
            'name' => 'Roberto',
            'apellido_paterno' => 'Inquilla',
            'apellido_materno' => 'Ramos',
            'email' => 'inactivo@jatucani.com',
            'password' => Hash::make('password'),
            'dni' => '11223344',
            'fecha_nacimiento' => '1975-12-10',
            'genero' => 'masculino',
            'telefono' => '987654331',
            'condicion' => 'calificado',
            'sector' => 'sector_2',
            'fecha_ingreso_comunidad' => '2000-01-01',
            'rol' => 'comunero',
            'activo' => false,
            'direccion' => 'Ex comunero - Av. Lima 456',
            'ocupacion' => 'Ex comunero',
            'estado_civil' => 'casado',
            'observaciones' => 'Comunero inactivo por migración',
        ]);
    }
}
