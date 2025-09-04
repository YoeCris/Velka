<?php

namespace Database\Factories;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comunero>
 */
class ComuneroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dni' => $this->faker->unique()->numerify('########'),
            'nombres' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName() . ' ' . $this->faker->lastName(),
            'genero' => $this->faker->randomElement(['masculino', 'femenino']),
            'fecha_nacimiento' => $this->faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'telefono' => $this->faker->optional()->numerify('9########'),
            'direccion' => $this->faker->optional()->address(),
            'estado_civil' => $this->faker->randomElement(['soltero', 'casado', 'conviviente', 'divorciado', 'viudo']),
            'condicion' => $this->faker->randomElement(['calificado', 'no_calificado']),
            'sector_id' => Sector::factory(),
            'fecha_ingreso' => $this->faker->dateTimeBetween('-15 years', 'now')->format('Y-m-d'),
            'observaciones' => $this->faker->optional()->sentence(),
            'activo' => true,
            'puntos_obtenidos' => $this->faker->randomFloat(2, 0, 10),
            'puntos_posibles' => 10.0,
            'porcentaje_asistencia' => $this->faker->randomFloat(2, 0, 100),
        ];
    }

    /**
     * Indicate that the comunero is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'activo' => false,
        ]);
    }

    /**
     * Indicate that the comunero is qualified.
     */
    public function calificado(): static
    {
        return $this->state(fn (array $attributes) => [
            'condicion' => 'calificado',
            'porcentaje_asistencia' => $this->faker->randomFloat(2, 50, 100),
        ]);
    }

    /**
     * Indicate that the comunero is not qualified.
     */
    public function noCalificado(): static
    {
        return $this->state(fn (array $attributes) => [
            'condicion' => 'no_calificado',
            'porcentaje_asistencia' => $this->faker->randomFloat(2, 0, 49.99),
        ]);
    }
}
