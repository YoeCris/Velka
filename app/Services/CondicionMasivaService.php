<?php

namespace App\Services;

use App\Models\Comunero;
use Spatie\Activitylog\Models\Activity;

class CondicionMasivaService
{
    public function obtenerPreviewCambios($fechaInicio, $fechaFin)
    {
        // Obtener reuniones del período
        $reuniones = \App\Models\Reunion::where('estado', 'cerrada')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get();

        if ($reuniones->isEmpty()) {
            return [
                'cambios' => [],
                'mensaje' => 'No hay reuniones cerradas en el período seleccionado'
            ];
        }

        $cambios = [];
        $comuneros = Comunero::activos()->get();

        foreach ($comuneros as $comunero) {
            // Recalcular estadísticas para el período
            $puntosObtenidos = $comunero->asistencias()
                ->whereIn('reunion_id', $reuniones->pluck('id'))
                ->sum('puntos_total');
            
            $puntosPosibles = $reuniones->count() * 1.0;
            $porcentaje = $puntosPosibles > 0 ? ($puntosObtenidos / $puntosPosibles) * 100 : 0;
            
            $condicionActual = $comunero->condicion;
            $nuevaCondicion = $this->determinarNuevaCondicion($condicionActual, $porcentaje);
            
            if ($condicionActual !== $nuevaCondicion) {
                $cambios[] = [
                    'comunero_id' => $comunero->id,
                    'dni' => $comunero->dni,
                    'nombre_completo' => $comunero->nombre_completo,
                    'sector' => $comunero->sector->nombre,
                    'condicion_actual' => $condicionActual,
                    'nueva_condicion' => $nuevaCondicion,
                    'porcentaje_asistencia' => round($porcentaje, 2),
                    'puntos_obtenidos' => $puntosObtenidos,
                    'puntos_posibles' => $puntosPosibles,
                    'reuniones_evaluadas' => $reuniones->count()
                ];
            }
        }

        return [
            'cambios' => $cambios,
            'total_reuniones' => $reuniones->count(),
            'periodo' => [
                'inicio' => $fechaInicio,
                'fin' => $fechaFin
            ]
        ];
    }

    public function aplicarCambiosMasivos($cambios, $userId = null)
    {
        $aplicados = 0;
        $errores = [];

        foreach ($cambios as $cambio) {
            try {
                $comunero = Comunero::find($cambio['comunero_id']);
                
                if ($comunero) {
                    $condicionAnterior = $comunero->condicion;
                    $comunero->update(['condicion' => $cambio['nueva_condicion']]);
                    
                    // Registrar en activity log
                    activity('comunero')
                        ->causedBy($userId)
                        ->performedOn($comunero)
                        ->withProperties([
                            'condicion_anterior' => $condicionAnterior,
                            'condicion_nueva' => $cambio['nueva_condicion'],
                            'porcentaje_asistencia' => $cambio['porcentaje_asistencia'],
                            'tipo_actualizacion' => 'masiva'
                        ])
                        ->log('Actualización masiva de condición');
                    
                    $aplicados++;
                }
            } catch (\Exception $e) {
                $errores[] = [
                    'comunero_id' => $cambio['comunero_id'],
                    'error' => $e->getMessage()
                ];
            }
        }

        return [
            'aplicados' => $aplicados,
            'errores' => $errores,
            'total_procesados' => count($cambios)
        ];
    }

    private function determinarNuevaCondicion($condicionActual, $porcentaje)
    {
        // Regla comunal (estatuto 40/50):
        if ($porcentaje >= 50) {
            return 'calificado';
        } elseif ($porcentaje < 40) {
            return 'no_calificado';
        } else {
            // Entre 40% y 50%, mantiene la condición actual
            return $condicionActual;
        }
    }

    public function obtenerEstadisticasPeriodo($fechaInicio, $fechaFin)
    {
        $reuniones = \App\Models\Reunion::where('estado', 'cerrada')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get();

        $totalComuneros = Comunero::activos()->count();
        $porSector = [];
        
        foreach (\App\Models\Sector::all() as $sector) {
            $comunerosSector = Comunero::activos()
                ->where('sector_id', $sector->id)
                ->get();
                
            $porSector[$sector->nombre] = [
                'total' => $comunerosSector->count(),
                'calificados' => $comunerosSector->where('condicion', 'calificado')->count(),
                'no_calificados' => $comunerosSector->where('condicion', 'no_calificado')->count()
            ];
        }

        return [
            'total_comuneros' => $totalComuneros,
            'total_reuniones' => $reuniones->count(),
            'periodo' => [
                'inicio' => $fechaInicio,
                'fin' => $fechaFin
            ],
            'por_sector' => $porSector
        ];
    }
}
