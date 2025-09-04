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

    public function mount()
    {
        // Si es admin sector, establecer su sector por defecto
        if (auth()->user()->isAdminSector()) {
            $this->selectedSector = auth()->user()->sector_id;
        }
    }

    public function updatedSelectedSector()
    {
        // Refrescar datos cuando cambie el sector
    }

    public function getEstadisticasGenerales()
    {
        $query = Comunero::query();
        
        // Filtrar por sector si es necesario
        if (auth()->user()->isAdminSector()) {
            $query->where('sector_id', auth()->user()->sector_id);
        } elseif ($this->selectedSector) {
            $query->where('sector_id', $this->selectedSector);
        }

        // DEBUG: Agregar logs para revisar los datos
        \Log::info('=== DASHBOARD DEBUG ===');
        \Log::info('Total comuneros en DB: ' . Comunero::count());
        \Log::info('Comuneros activos: ' . Comunero::where('activo', true)->count());
        \Log::info('Calificados: ' . Comunero::where('condicion', 'calificado')->count());
        \Log::info('No calificados: ' . Comunero::where('condicion', 'no_calificado')->count());
        
        // Mostrar todos los comuneros y sus condiciones
        $todosComuneros = Comunero::select('id', 'nombres', 'apellidos', 'condicion', 'activo')->get();
        foreach($todosComuneros as $comunero) {
            \Log::info("ID: {$comunero->id}, Nombre: {$comunero->nombres} {$comunero->apellidos}, Condición: '{$comunero->condicion}', Activo: " . ($comunero->activo ? 'Sí' : 'No'));
        }

        $totalComuneros = $query->count();
        $comunerosActivos = $query->where('activo', true)->count();
        
        // Cambiar la lógica para incluir tanto activos como no activos en el conteo de condiciones
        $queryCalificados = clone $query;
        $queryNoCalificados = clone $query;
        
        $comunerosCalificados = $queryCalificados->where('condicion', 'calificado')->count();
        $comunerosNoCalificados = $queryNoCalificados->where('condicion', 'no_calificado')->count();

        // Para porcentajes de asistencia, solo considerar activos
        $queryActivosPorcentaje = clone $query;
        $queryActivosPorcentaje->where('activo', true);
        
        $porcentajeTotal = $comunerosActivos > 0 ? $queryActivosPorcentaje->avg('porcentaje_asistencia') : 0;
        
        $queryCalificadosActivos = clone $queryActivosPorcentaje;
        $porcentajeCalificados = $queryCalificadosActivos->where('condicion', 'calificado')->count() > 0 
            ? $queryCalificadosActivos->where('condicion', 'calificado')->avg('porcentaje_asistencia') : 0;
        
        $queryNoCalificadosActivos = clone $queryActivosPorcentaje;
        $porcentajeNoCalificados = $queryNoCalificadosActivos->where('condicion', 'no_calificado')->count() > 0 
            ? $queryNoCalificadosActivos->where('condicion', 'no_calificado')->avg('porcentaje_asistencia') : 0;

        \Log::info("RESULTADOS FINALES:");
        \Log::info("Total: {$totalComuneros}");
        \Log::info("Activos: {$comunerosActivos}");
        \Log::info("Calificados: {$comunerosCalificados}");
        \Log::info("No Calificados: {$comunerosNoCalificados}");

        return [
            'total_comuneros' => $totalComuneros,
            'comuneros_activos' => $comunerosActivos,
            'comuneros_calificados' => $comunerosCalificados,
            'comuneros_no_calificados' => $comunerosNoCalificados,
            'porcentaje_asistencia_total' => round($porcentajeTotal, 1),
            'porcentaje_asistencia_calificados' => round($porcentajeCalificados, 1),
            'porcentaje_asistencia_no_calificados' => round($porcentajeNoCalificados, 1),
            'porcentaje_asistencia_global' => round($porcentajeTotal, 1)
        ];
    }

    public function getEstadisticasPorSector()
    {
        $sectores = Sector::with(['comuneros'])->get(); // Quitar filtro de activo aquí también

        $data = [];
        
        foreach ($sectores as $sector) {
            // Si es admin sector, solo mostrar su sector
            if (auth()->user()->isAdminSector() && $sector->id !== auth()->user()->sector_id) {
                continue;
            }

            $data[] = [
                'sector' => $sector->nombre,
                'total' => $sector->comuneros->count(),
                'calificados' => $sector->comuneros->where('condicion', 'calificado')->count(),
                'no_calificados' => $sector->comuneros->where('condicion', 'no_calificado')->count(),
            ];
        }

        return $data;
    }

    public function getTendenciaAsistenciaPorSector()
    {
        $sectores = Sector::with(['comuneros' => function($query) {
            $query->where('activo', true);
        }])->get();

        $data = [];
        
        foreach ($sectores as $sector) {
            // Si es admin sector, solo mostrar su sector
            if (auth()->user()->isAdminSector() && $sector->id !== auth()->user()->sector_id) {
                continue;
            }

            $comunerosCalificados = $sector->comuneros->where('condicion', 'calificado');
            $comunerosNoCalificados = $sector->comuneros->where('condicion', 'no_calificado');

            $porcentajeCalificados = $comunerosCalificados->count() > 0 ? $comunerosCalificados->avg('porcentaje_asistencia') : 0;
            $porcentajeNoCalificados = $comunerosNoCalificados->count() > 0 ? $comunerosNoCalificados->avg('porcentaje_asistencia') : 0;

            $data[] = [
                'sector' => $sector->nombre,
                'porcentaje_calificados' => round($porcentajeCalificados, 1),
                'porcentaje_no_calificados' => round($porcentajeNoCalificados, 1),
                'total_calificados' => $comunerosCalificados->count(),
                'total_no_calificados' => $comunerosNoCalificados->count()
            ];
        }

        return $data;
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
            'sectores'
        ))->layout('components.layouts.app');
    }
}
