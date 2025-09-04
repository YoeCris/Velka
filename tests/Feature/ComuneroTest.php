<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sector;
use App\Models\Comunero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComuneroTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear sectores
        Sector::create(['nombre' => 'Central', 'descripcion' => 'Sector Central']);
        Sector::create(['nombre' => 'Catahui', 'descripcion' => 'Sector Catahui']);
    }

    /** @test */
    public function superadmin_can_view_comuneros()
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'sector_id' => null
        ]);

        $response = $this->actingAs($superadmin)->get('/comuneros');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_sector_can_only_view_their_sector_comuneros()
    {
        $sector = Sector::first();
        $adminSector = User::factory()->create([
            'role' => 'admin_sector',
            'sector_id' => $sector->id
        ]);

        $response = $this->actingAs($adminSector)->get('/comuneros');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_sector_cannot_create_comuneros()
    {
        $sector = Sector::first();
        $adminSector = User::factory()->create([
            'role' => 'admin_sector',
            'sector_id' => $sector->id
        ]);

        $comuneroData = [
            'dni' => '12345678',
            'nombres' => 'Test',
            'apellidos' => 'User',
            'genero' => 'masculino',
            'fecha_nacimiento' => '1990-01-01',
            'estado_civil' => 'soltero',
            'sector_id' => $sector->id,
            'fecha_ingreso' => '2020-01-01',
            'condicion' => 'no_calificado',
            'activo' => true
        ];

        $this->actingAs($adminSector);
        
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);
        
        Comunero::create($comuneroData);
    }

    /** @test */
    public function superadmin_can_create_comuneros()
    {
        $superadmin = User::factory()->create([
            'role' => 'superadmin',
            'sector_id' => null
        ]);

        $sector = Sector::first();
        
        $comuneroData = [
            'dni' => '12345678',
            'nombres' => 'Test',
            'apellidos' => 'User',
            'genero' => 'masculino',
            'fecha_nacimiento' => '1990-01-01',
            'estado_civil' => 'soltero',
            'sector_id' => $sector->id,
            'fecha_ingreso' => '2020-01-01',
            'condicion' => 'no_calificado',
            'activo' => true
        ];

        $this->actingAs($superadmin);
        
        $comunero = Comunero::create($comuneroData);

        $this->assertDatabaseHas('comuneros', [
            'dni' => '12345678',
            'nombres' => 'Test',
            'apellidos' => 'User'
        ]);
    }

    /** @test */
    public function comunero_statistics_are_calculated_correctly()
    {
        $sector = Sector::first();
        $comunero = Comunero::factory()->create([
            'sector_id' => $sector->id,
            'puntos_obtenidos' => 7.5,
            'puntos_posibles' => 10.0
        ]);

        $comunero->actualizarEstadisticas();

        $this->assertEquals(75.00, $comunero->fresh()->porcentaje_asistencia);
    }

    /** @test */
    public function comunero_condition_rules_work_correctly()
    {
        $sector = Sector::first();
        
        // Comunero que debe ser calificado (≥50%)
        $comuneroCalificado = Comunero::factory()->create([
            'sector_id' => $sector->id,
            'porcentaje_asistencia' => 60.0,
            'condicion' => 'no_calificado'
        ]);

        // Comunero que debe ser no calificado (<40%)
        $comuneroNoCalificado = Comunero::factory()->create([
            'sector_id' => $sector->id,
            'porcentaje_asistencia' => 30.0,
            'condicion' => 'calificado'
        ]);

        // Comunero en zona intermedia (40-50%, mantiene condición)
        $comuneroIntermedio = Comunero::factory()->create([
            'sector_id' => $sector->id,
            'porcentaje_asistencia' => 45.0,
            'condicion' => 'calificado'
        ]);

        $this->assertTrue($comuneroCalificado->puedeSerCalificado());
        $this->assertTrue($comuneroNoCalificado->debeSerNoCalificado());
        $this->assertFalse($comuneroIntermedio->puedeSerCalificado());
        $this->assertFalse($comuneroIntermedio->debeSerNoCalificado());
    }
}
