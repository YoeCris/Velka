<?php

namespace App\Livewire;

use App\Models\Comunero;
use App\Models\Sector;
use App\Models\Reunion;
use App\Models\Asistencia;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $selectedSector = null;
    public $selectedReunion = null; // Filtro para reuniones

    public function mount()
    {
        // Si es admin sector, establecer su sector por defecto
        if (auth()->user()->isAdminSector()) {
            $this->selectedSector = auth()->user()->sector_id;
        }
    }

    public function getEstadisticasGenerales()
    {
        // Base con filtro de sector según rol/selección (mutuamente excluyente)
        $base = Comunero::query()
            ->when(auth()->user()->isAdminSector(), fn($q) => $q->where('sector_id', auth()->user()->sector_id)
            )
            ->when(!auth()->user()->isAdminSector() && $this->selectedSector, fn($q) => $q->where('sector_id', $this->selectedSector)
            );

        if (app()->isLocal()) {
            \Log::info('=== DASHBOARD DEBUG ===');
            \Log::info('Total comuneros (global): ' . Comunero::count());
        }

        // Métricas (cada una con su clone)
        $totalComuneros = (clone $base)->count();
        $comunerosActivos = (clone $base)->where('activo', true)->count();
        $comunerosCalificados = (clone $base)->where('condicion', 'calificado')->count();
        $comunerosNoCalificados = (clone $base)->where('condicion', 'no_calificado')->count();

        // Promedios SOLO de activos
        $porcentajeTotal = (clone $base)->where('activo', true)->avg('porcentaje_asistencia') ?? 0;
        $porcentajeCalificados = (clone $base)->where('activo', true)->where('condicion','calificado')->avg('porcentaje_asistencia') ?? 0;
        $porcentajeNoCalificados = (clone $base)->where('activo', true)->where('condicion','no_calificado')->avg('porcentaje_asistencia') ?? 0;

        return [
            'total_comuneros' => $totalComuneros,
            'comuneros_activos' => $comunerosActivos,
            'comuneros_calificados' => $comunerosCalificados,
            'comuneros_no_calificados' => $comunerosNoCalificados,
            'porcentaje_asistencia_total' => round($porcentajeTotal, 1),
            'porcentaje_asistencia_calificados' => round($porcentajeCalificados, 1),
            'porcentaje_asistencia_no_calificados' => round($porcentajeNoCalificados, 1),
            // Si no la necesitas, puedes eliminar la siguiente línea:
            'porcentaje_asistencia_global' => round($porcentajeTotal, 1),
        ];
    }

    public function getEstadisticasPorSector()
    {
        $query = Sector::query();

        // Si es admin sector, solo su sector
        if (auth()->user()->isAdminSector()) {
            $query->where('id', auth()->user()->sector_id);
        }

        $sectores = $query->withCount([
            'comuneros as total',
            'comuneros as calificados' => fn($q) => $q->where('condicion', 'calificado'),
            'comuneros as no_calificados' => fn($q) => $q->where('condicion', 'no_calificado'),
        ])->get();

        return $sectores->map(fn($s) => [
            'sector' => $s->nombre,
            'total' => (int) $s->total,
            'calificados' => (int) $s->calificados,
            'no_calificados' => (int) $s->no_calificados,
        ])->all();
    }

    public function getTendenciaAsistenciaPorSector()
    {
        // Si hay una reunión específica seleccionada, calcular asistencia para esa reunión
        if ($this->selectedReunion) {
            return $this->getAsistenciaReunionEspecifica($this->selectedReunion);
        }

        // Si no hay reunión específica, mostrar promedios generales
        $query = Sector::query();
        
        if (auth()->user()->isAdminSector()) {
            $query->where('id', auth()->user()->sector_id);
        }

        $sectores = $query
            // conteos de activos por condición
            ->withCount([
                'comuneros as total_calificados' => fn($q) => $q->where('activo', true)->where('condicion', 'calificado'),
                'comuneros as total_no_calificados' => fn($q) => $q->where('activo', true)->where('condicion', 'no_calificado'),
            ])
            // promedios de asistencia (solo activos) por condición
            ->withAvg(['comuneros as avg_calificados' => fn($q) => $q->where('activo', true)->where('condicion', 'calificado')], 'porcentaje_asistencia')
            ->withAvg(['comuneros as avg_no_calificados' => fn($q) => $q->where('activo', true)->where('condicion', 'no_calificado')], 'porcentaje_asistencia')
            ->get();

        return $sectores->map(fn($s) => [
            'sector' => $s->nombre,
            'porcentaje_calificados' => round((float) $s->avg_calificados, 1),
            'porcentaje_no_calificados'=> round((float) $s->avg_no_calificados, 1),
            'total_calificados' => (int) $s->total_calificados,
            'total_no_calificados' => (int) $s->total_no_calificados,
        ])->all();
    }

    public function getAsistenciaReunionEspecifica($reunionId)
    {
        // Para datos demo, generar estadísticas simuladas según la reunión
        $reunionesDemo = [
            1 => [
                // Reunión Ordinaria - Enero (alta asistencia)
                'multiplicador_cal' => 0.85,
                'multiplicador_nocal' => 0.70
            ],
            2 => [
                // Reunión Extraordinaria - Presupuesto (asistencia media)
                'multiplicador_cal' => 0.75,
                'multiplicador_nocal' => 0.60
            ],
            3 => [
                // Asamblea General - Diciembre (baja asistencia)
                'multiplicador_cal' => 0.65,
                'multiplicador_nocal' => 0.45
            ]
        ];

        if (!isset($reunionesDemo[$reunionId])) {
            return [];
        }

        $config = $reunionesDemo[$reunionId];
        $query = Sector::query();
        
        if (auth()->user()->isAdminSector()) {
            $query->where('id', auth()->user()->sector_id);
        }

        $sectores = $query->get();

        return $sectores->map(function($sector) use ($config) {
            // Obtener comuneros del sector
            $comunerosCalificados = $sector->comuneros()
                ->where('activo', true)
                ->where('condicion', 'calificado')
                ->get();
            
            $comunerosNoCalificados = $sector->comuneros()
                ->where('activo', true)
                ->where('condicion', 'no_calificado')
                ->get();

            $totalCalificados = $comunerosCalificados->count();
            $totalNoCalificados = $comunerosNoCalificados->count();

            // Simular asistencia basada en los multiplicadores
            $porcentajeCalificados = round($config['multiplicador_cal'] * 100, 1);
            $porcentajeNoCalificados = round($config['multiplicador_nocal'] * 100, 1);

            return [
                'sector' => $sector->nombre,
                'porcentaje_calificados' => $porcentajeCalificados,
                'porcentaje_no_calificados' => $porcentajeNoCalificados,
                'total_calificados' => $totalCalificados,
                'total_no_calificados' => $totalNoCalificados,
            ];
        })->all();
    }

    public function getReunionesDisponibles()
    {
        // Por ahora, crear datos demo hasta que tengas reuniones reales
        return collect([
            (object)[
                'id' => 1,
                'titulo' => 'Reunión Ordinaria - Enero',
                'fecha' => now()->subDays(15),
                'tipo' => 'ordinaria'
            ],
            (object)[
                'id' => 2,
                'titulo' => 'Reunión Extraordinaria - Presupuesto',
                'fecha' => now()->subDays(30),
                'tipo' => 'extraordinaria'
            ],
            (object)[
                'id' => 3,
                'titulo' => 'Asamblea General - Diciembre',
                'fecha' => now()->subDays(45),
                'tipo' => 'ordinaria'
            ]
        ]);

        /* // Código real para cuando tengas reuniones en la BD:
        $query = Reunion::query()->orderBy('fecha', 'desc');
        
        if (auth()->user()->isAdminSector()) {
            $sectorId = auth()->user()->sector_id;
            $query->whereHas('asistencias.comunero', function($q) use ($sectorId) {
                $q->where('sector_id', $sectorId);
            });
        }
        
        return $query->get();
        */
    }

    public function updatedSelectedReunion()
    {
        // Método que se ejecuta cuando se cambia la reunión seleccionada
        // Livewire actualizará automáticamente la vista
    }

    public function getAsistenciaHistorica()
    {
        // Para demo, crear datos simulados ya que aún no hay reuniones
        return [
            ['fecha' => '01/01', 'titulo' => 'Reunión Demo 1', 'porcentaje' => 85.0],
            ['fecha' => '15/01', 'titulo' => 'Reunión Demo 2', 'porcentaje' => 92.5],
            ['fecha' => '01/02', 'titulo' => 'Reunión Demo 3', 'porcentaje' => 78.3],
        ];
    }

    public function getUltimasReuniones()
    {
        // Para demo, crear datos simulados
        return collect([
            [
                'id' => 1,
                'titulo' => 'Reunión Ordinaria Demo',
                'fecha' => now()->subDays(5),
                'tipo' => 'ordinaria',
                'estado' => 'cerrada',
                'porcentaje_asistencia' => 85.0
            ],
            [
                'id' => 2,
                'titulo' => 'Reunión Extraordinaria Demo',
                'fecha' => now()->subDays(10),
                'tipo' => 'extraordinaria',
                'estado' => 'cerrada',
                'porcentaje_asistencia' => 92.5
            ]
        ]);
    }

    private function getPorcentajeAsistenciaGlobal()
    {
        $query = Comunero::where('activo', true);

        // Filtrar por sector si es necesario
        if (auth()->user()->isAdminSector()) {
            $query->where('sector_id', auth()->user()->sector_id);
        } elseif ($this->selectedSector) {
            $query->where('sector_id', $this->selectedSector);
        }

        $promedio = $query->avg('porcentaje_asistencia');
        return $promedio ? round($promedio, 1) : 0;
    }

    public function render()
    {
        $estadisticasGenerales = $this->getEstadisticasGenerales();
        $estadisticasPorSector = $this->getEstadisticasPorSector();
        $tendenciaAsistenciaPorSector = $this->getTendenciaAsistenciaPorSector();
        $asistenciaHistorica = $this->getAsistenciaHistorica();
        $ultimasReuniones = $this->getUltimasReuniones();
        $reunionesDisponibles = $this->getReunionesDisponibles();

        // Sectores para el filtro (solo si es superadmin)
        $sectores = collect();
        if (auth()->user()->isSuperadmin()) {
            $sectores = Sector::activos()->get();
        }

        return view('livewire.dashboard', compact(
            'estadisticasGenerales',
            'estadisticasPorSector',
            'tendenciaAsistenciaPorSector',
            'asistenciaHistorica',
            'ultimasReuniones',
            'sectores',
            'reunionesDisponibles'
        ))->layout('components.layouts.app');
    }
}