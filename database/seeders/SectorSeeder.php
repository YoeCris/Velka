<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sector;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectores = [
            [
                'nombre' => 'Central',
                'descripcion' => 'Sector Central de la Comunidad Jatucachi',
                'activo' => true
            ],
            [
                'nombre' => 'Catahui',
                'descripcion' => 'Sector Catahui de la Comunidad Jatucachi',
                'activo' => true
            ],
            [
                'nombre' => 'Jayuyapu',
                'descripcion' => 'Sector Jayuyapu de la Comunidad Jatucachi',
                'activo' => true
            ],
            [
                'nombre' => 'Titire',
                'descripcion' => 'Sector Titire de la Comunidad Jatucachi',
                'activo' => true
            ]
        ];

        foreach ($sectores as $sector) {
            Sector::create($sector);
        }
    }
}
