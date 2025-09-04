<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comunero;
use App\Models\Sector;
use Faker\Factory as Faker;

class ComunerosTestSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $faker = Faker::create('es_PE'); // Faker en español peruano
        
        // Obtener los sectores existentes
        $sectores = Sector::all();
        
        if ($sectores->isEmpty()) {
            $this->command->error('No hay sectores disponibles. Por favor, ejecuta primero el seeder de sectores.');
            return;
        }

        $this->command->info('Creando 50 comuneros de prueba...');

        // Arrays para datos realistas peruanos
        $nombresHombres = [
            'Carlos', 'José', 'Miguel', 'Juan', 'Luis', 'Jorge', 'Ricardo', 'Fernando', 'Roberto', 'Alberto',
            'Eduardo', 'Manuel', 'Francisco', 'Raúl', 'Sergio', 'Andrés', 'Diego', 'Alejandro', 'Víctor', 'Daniel',
            'Pablo', 'Antonio', 'Javier', 'Mario', 'César', 'Óscar', 'Martín', 'Emilio', 'Rodolfo', 'Arturo'
        ];
        
        $nombresMujeres = [
            'María', 'Ana', 'Carmen', 'Rosa', 'Teresa', 'Elena', 'Patricia', 'Julia', 'Susana', 'Gloria',
            'Isabel', 'Lucía', 'Esperanza', 'Silvia', 'Mónica', 'Sandra', 'Liliana', 'Maritza', 'Nancy', 'Betty',
            'Gladys', 'Delia', 'Norma', 'Yolanda', 'Victoria', 'Amanda', 'Roxana', 'Miriam', 'Angela', 'Cecilia'
        ];
        
        $apellidos = [
            'García', 'González', 'Rodríguez', 'Fernández', 'López', 'Martínez', 'Sánchez', 'Pérez', 'Gómez', 'Martín',
            'Jiménez', 'Ruiz', 'Hernández', 'Díaz', 'Moreno', 'Álvarez', 'Muñoz', 'Romero', 'Alonso', 'Gutiérrez',
            'Navarro', 'Torres', 'Domínguez', 'Vázquez', 'Ramos', 'Gil', 'Ramírez', 'Serrano', 'Blanco', 'Suárez',
            'Molina', 'Morales', 'Ortega', 'Delgado', 'Castro', 'Ortiz', 'Rubio', 'Marín', 'Sanz', 'Iglesias',
            'Medina', 'Garrido', 'Cortés', 'Castillo', 'Santos', 'Lozano', 'Guerrero', 'Cano', 'Prieto', 'Méndez'
        ];

        for ($i = 1; $i <= 50; $i++) {
            // Determinar género aleatoriamente
            $genero = $faker->randomElement(['masculino', 'femenino']);
            $nombres = $genero === 'masculino' ? $nombresHombres : $nombresMujeres;
            
            // Seleccionar nombres y apellidos
            $primerNombre = $faker->randomElement($nombres);
            $segundoNombre = $faker->boolean(30) ? $faker->randomElement($nombres) : ''; // 30% posibilidad de segundo nombre
            $nombreCompleto = $segundoNombre ? "$primerNombre $segundoNombre" : $primerNombre;
            
            $primerApellido = $faker->randomElement($apellidos);
            $segundoApellido = $faker->randomElement($apellidos);
            
            // Generar DNI único
            do {
                $dni = $faker->numerify('########');
            } while (Comunero::where('dni', $dni)->exists());
            
            // Determinar condición basada en probabilidades realistas
            // 60% calificados, 40% no calificados
            $condicion = $faker->randomFloat(2, 0, 100) <= 60 ? 'calificado' : 'no_calificado';
            
            // Porcentaje de asistencia coherente con la condición
            if ($condicion === 'calificado') {
                $porcentajeAsistencia = $faker->randomFloat(2, 50, 95); // Entre 50% y 95%
            } else {
                $porcentajeAsistencia = $faker->randomFloat(2, 0, 49); // Entre 0% y 49%
            }
            
            // Calcular puntos basados en el porcentaje
            $puntsPosibles = $faker->numberBetween(10, 20); // Simular 10-20 reuniones
            $puntosObtenidos = round(($porcentajeAsistencia / 100) * $puntsPosibles, 2);
            
            $comunero = Comunero::create([
                'dni' => $dni,
                'nombres' => $nombreCompleto,
                'apellidos' => "$primerApellido $segundoApellido",
                'genero' => $genero,
                'fecha_nacimiento' => $faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
                'telefono' => $faker->boolean(80) ? $faker->numerify('9########') : null, // 80% tienen teléfono
                'direccion' => $faker->boolean(70) ? $faker->address : null, // 70% tienen dirección
                'estado_civil' => $faker->randomElement(['soltero', 'casado', 'conviviente', 'divorciado', 'viudo']),
                'condicion' => $condicion,
                'sector_id' => $sectores->random()->id,
                'fecha_ingreso' => $faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
                'observaciones' => $faker->boolean(20) ? $faker->sentence() : null, // 20% tienen observaciones
                'activo' => $faker->boolean(90), // 90% están activos
                'puntos_obtenidos' => $puntosObtenidos,
                'puntos_posibles' => $puntsPosibles,
                'porcentaje_asistencia' => $porcentajeAsistencia
            ]);
            
            if ($i % 10 == 0) {
                $this->command->info("Creados $i comuneros...");
            }
        }
        
        $this->command->info('✅ Se han creado 50 comuneros de prueba exitosamente!');
        
        // Mostrar estadísticas finales
        $totalComuneros = Comunero::count();
        $totalCalificados = Comunero::where('condicion', 'calificado')->count();
        $totalNoCalificados = Comunero::where('condicion', 'no_calificado')->count();
        $totalActivos = Comunero::where('activo', true)->count();
        
        $this->command->info("📊 Estadísticas finales:");
        $this->command->info("   Total comuneros: $totalComuneros");
        $this->command->info("   Calificados: $totalCalificados");
        $this->command->info("   No calificados: $totalNoCalificados");
        $this->command->info("   Activos: $totalActivos");
        
        // Estadísticas por sector
        $this->command->info("📍 Distribución por sectores:");
        foreach ($sectores as $sector) {
            $count = Comunero::where('sector_id', $sector->id)->count();
            $this->command->info("   {$sector->nombre}: $count comuneros");
        }
    }
}
