<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cargo;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargos = [
            [
                'nombre' => 'Presidente',
                'descripcion' => 'Presidente de la Comunidad',
                'activo' => true
            ],
            [
                'nombre' => 'Vice Presidente',
                'descripcion' => 'Vice Presidente de la Comunidad',
                'activo' => true
            ],
            [
                'nombre' => 'Secretario',
                'descripcion' => 'Secretario de la Comunidad',
                'activo' => true
            ],
            [
                'nombre' => 'Tesorero',
                'descripcion' => 'Tesorero de la Comunidad',
                'activo' => true
            ],
            [
                'nombre' => 'Fiscal',
                'descripcion' => 'Fiscal de la Comunidad',
                'activo' => true
            ],
            [
                'nombre' => 'Vocal',
                'descripcion' => 'Vocal de la Comunidad',
                'activo' => true
            ],
            [
                'nombre' => 'Coordinador de Sector',
                'descripcion' => 'Coordinador de Sector',
                'activo' => true
            ],
            [
                'nombre' => 'Delegado',
                'descripcion' => 'Delegado de la Comunidad',
                'activo' => true
            ]
        ];

        foreach ($cargos as $cargo) {
            Cargo::create($cargo);
        }
    }
}
