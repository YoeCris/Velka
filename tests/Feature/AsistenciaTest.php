<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sector;
use App\Models\Comunero;
use App\Models\Reunion;
use App\Models\Asistencia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Tests\TestCase;

class AsistenciaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear datos básicos
        $sector = Sector::create(['nombre' => 'Central', 'descripcion' => 'Sector Central']);
        
        $this->comunero = Comunero::factory()->create([
            'sector_id' => $sector->id
        ]);

        $this->reunion = Reunion::create([
            'tipo' => 'ordinaria',
            'titulo' => 'Reunión de Prueba',
            'fecha' => Carbon::today(),
            'hora_inicio' => '10:00',
            'hora_fin' => '12:00',
            'lugar' => 'Casa Comunal',
            'estado' => 'programada',
            'umbral_tardanza' => 40
        ]);
    }

    /** @test */
    public function attendance_points_are_calculated_correctly_for_on_time_arrival()
    {
        $horaEntrada = Carbon::today()->setTime(10, 30); // 30 min después del inicio
        $horaSalida = Carbon::today()->setTime(11, 30);

        $asistencia = Asistencia::create([
            'reunion_id' => $this->reunion->id,
            'comunero_id' => $this->comunero->id
        ]);

        $asistencia->registrarEntrada($horaEntrada);
        $asistencia->registrarSalida($horaSalida);

        // A tiempo (≤40 min) = 0.50 + salió = 0.50 = 1.00 total
        $this->assertEquals(0.50, $asistencia->puntos_entrada);
        $this->assertEquals(0.50, $asistencia->puntos_salida);
        $this->assertEquals(1.00, $asistencia->puntos_total);
        $this->assertEquals('A', $asistencia->estado_entrada);
        $this->assertEquals('A', $asistencia->estado_salida);
    }

    /** @test */
    public function attendance_points_are_calculated_correctly_for_late_arrival()
    {
        $horaEntrada = Carbon::today()->setTime(10, 45); // 45 min después (tarde)
        $horaSalida = Carbon::today()->setTime(11, 30);

        $asistencia = Asistencia::create([
            'reunion_id' => $this->reunion->id,
            'comunero_id' => $this->comunero->id
        ]);

        $asistencia->registrarEntrada($horaEntrada);
        $asistencia->registrarSalida($horaSalida);

        // Tarde (>40 min) = 0.25 + salió = 0.50 = 0.75 total
        $this->assertEquals(0.25, $asistencia->puntos_entrada);
        $this->assertEquals(0.50, $asistencia->puntos_salida);
        $this->assertEquals(0.75, $asistencia->puntos_total);
        $this->assertEquals('T', $asistencia->estado_entrada);
        $this->assertEquals('A', $asistencia->estado_salida);
    }

    /** @test */
    public function attendance_points_for_entry_without_exit()
    {
        $horaEntrada = Carbon::today()->setTime(10, 30);

        $asistencia = Asistencia::create([
            'reunion_id' => $this->reunion->id,
            'comunero_id' => $this->comunero->id
        ]);

        $asistencia->registrarEntrada($horaEntrada);
        
        // Regla especial: entró pero no salió = 0.50 total
        $this->assertEquals(0.50, $asistencia->puntos_entrada);
        $this->assertEquals(0.00, $asistencia->puntos_salida);
        $this->assertEquals(0.50, $asistencia->puntos_total);
        $this->assertEquals('A', $asistencia->estado_entrada);
        $this->assertEquals('F', $asistencia->estado_salida);
    }

    /** @test */
    public function attendance_points_for_no_attendance()
    {
        $asistencia = Asistencia::create([
            'reunion_id' => $this->reunion->id,
            'comunero_id' => $this->comunero->id
        ]);

        // Sin entrada ni salida = 0.00 total
        $this->assertEquals(0.00, $asistencia->puntos_entrada);
        $this->assertEquals(0.00, $asistencia->puntos_salida);
        $this->assertEquals(0.00, $asistencia->puntos_total);
        $this->assertEquals('F', $asistencia->estado_entrada);
        $this->assertEquals('F', $asistencia->estado_salida);
    }

    /** @test */
    public function reunion_can_be_closed_and_statistics_updated()
    {
        // Crear asistencia con puntos
        $asistencia = Asistencia::create([
            'reunion_id' => $this->reunion->id,
            'comunero_id' => $this->comunero->id
        ]);

        $horaEntrada = Carbon::today()->setTime(10, 30);
        $horaSalida = Carbon::today()->setTime(11, 30);
        
        $asistencia->registrarEntrada($horaEntrada);
        $asistencia->registrarSalida($horaSalida);

        // Cerrar reunión
        $resultado = $this->reunion->cerrarReunion();

        $this->assertTrue($resultado);
        $this->assertEquals('cerrada', $this->reunion->estado);
        $this->assertNotNull($this->reunion->cerrada_at);

        // Verificar que se actualizaron las estadísticas del comunero
        $this->comunero->refresh();
        $this->assertEquals(1.0, $this->comunero->puntos_posibles);
        $this->assertEquals(1.0, $this->comunero->puntos_obtenidos);
        $this->assertEquals(100.0, $this->comunero->porcentaje_asistencia);
    }

    /** @test */
    public function reunion_closure_completes_missing_attendances()
    {
        // Crear otro comunero sin asistencia registrada
        $sector = Sector::first();
        $comunero2 = Comunero::factory()->create([
            'sector_id' => $sector->id
        ]);

        // Solo registrar asistencia del primer comunero
        $asistencia1 = Asistencia::create([
            'reunion_id' => $this->reunion->id,
            'comunero_id' => $this->comunero->id
        ]);

        $asistencia1->registrarEntrada(Carbon::today()->setTime(10, 30));
        $asistencia1->registrarSalida(Carbon::today()->setTime(11, 30));

        // Cerrar reunión
        $this->reunion->cerrarReunion();

        // Verificar que se creó automáticamente la asistencia faltante
        $asistencia2 = Asistencia::where([
            'reunion_id' => $this->reunion->id,
            'comunero_id' => $comunero2->id
        ])->first();

        $this->assertNotNull($asistencia2);
        $this->assertEquals(0.00, $asistencia2->puntos_total);
        $this->assertEquals('F', $asistencia2->estado_entrada);
        $this->assertEquals('F', $asistencia2->estado_salida);
    }
}
