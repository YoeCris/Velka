<?php

namespace Database\Seeders;

use App\Models\Comunero;
use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComuneroSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $this->command->info('Seeder base de comuneros - Saltando por ahora');
        $this->command->info('Usa ComunerosTestSeeder para crear datos de prueba');
    }
}
