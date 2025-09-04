<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Reunion extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'reuniones';

    protected $fillable = [
        'tipo',
        'titulo',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'lugar',
        'notas',
        'estado',
        'umbral_tardanza',
        'cerrada_at'
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'cerrada_at' => 'datetime'
    ];

    // Configuración de ActivityLog
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['tipo', 'titulo', 'fecha', 'estado'])
            ->setDescriptionForEvent(fn(string $eventName) => "Reunión {$eventName}")
            ->useLogName('reunion');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function comunerosAsistentes()
    {
        return $this->belongsToMany(Comunero::class, 'asistencias')
            ->withPivot(['marca_entrada', 'marca_salida', 'puntos_total']);
    }

    // Scopes
    public function scopeProgramadas($query)
    {
        return $query->where('estado', 'programada');
    }

    public function scopeCerradas($query)
    {
        return $query->where('estado', 'cerrada');
    }

    public function scopeOrdinarias($query)
    {
        return $query->where('tipo', 'ordinaria');
    }

    public function scopeExtraordinarias($query)
    {
        return $query->where('tipo', 'extraordinaria');
    }

    // Métodos
    public function cerrarReunion()
    {
        if ($this->estado === 'cerrada') {
            return false;
        }

        // Completar asistencias faltantes
        $this->completarAsistenciasFaltantes();
        
        // Recalcular puntos
        $this->recalcularPuntos();
        
        // Marcar como cerrada
        $this->update([
            'estado' => 'cerrada',
            'cerrada_at' => now()
        ]);

        // Actualizar estadísticas de todos los comuneros
        Comunero::activos()->each(function($comunero) {
            $comunero->actualizarEstadisticas();
        });

        return true;
    }

    private function completarAsistenciasFaltantes()
    {
        $comunerosActivos = Comunero::activos()->get();
        
        foreach ($comunerosActivos as $comunero) {
            $asistencia = $this->asistencias()
                ->where('comunero_id', $comunero->id)
                ->first();
            
            if (!$asistencia) {
                // Crear asistencia con falta total
                $this->asistencias()->create([
                    'comunero_id' => $comunero->id,
                    'marca_entrada' => null,
                    'marca_salida' => null,
                    'puntos_entrada' => 0,
                    'puntos_salida' => 0,
                    'puntos_total' => 0
                ]);
            }
        }
    }

    private function recalcularPuntos()
    {
        foreach ($this->asistencias as $asistencia) {
            $asistencia->recalcularPuntos($this);
        }
    }

    public function getHoraInicioConUmbralAttribute()
    {
        return $this->fecha->setTimeFromTimeString($this->hora_inicio)
            ->addMinutes($this->umbral_tardanza);
    }

    public function esAsistenciaTarde($horaLlegada)
    {
        return $horaLlegada > $this->hora_inicio_con_umbral;
    }
}
