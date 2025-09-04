<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comunero extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dni',
        'nombres',
        'apellidos',
        'genero',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'estado_civil',
        'condicion',
        'sector_id',
        'fecha_ingreso',
        'observaciones',
        'activo',
        'puntos_obtenidos',
        'puntos_posibles',
        'porcentaje_asistencia'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'activo' => 'boolean',
        'puntos_obtenidos' => 'decimal:2',
        'puntos_posibles' => 'decimal:2',
        'porcentaje_asistencia' => 'decimal:2'
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function cargos()
    {
        return $this->belongsToMany(Cargo::class, 'comunero_cargos')
            ->withPivot(['fecha_inicio', 'fecha_fin', 'observaciones'])
            ->withTimestamps();
    }

    public function comuneroCargos()
    {
        return $this->hasMany(ComuneroCargo::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeCalificados($query)
    {
        return $query->where('condicion', 'calificado');
    }

    public function scopeNoCalificados($query)
    {
        return $query->where('condicion', 'no_calificado');
    }

    public function scopePorSector($query, $sectorId)
    {
        return $query->where('sector_id', $sectorId);
    }

    public function scopeBuscarPorDniONombre($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('dni', 'LIKE', "%{$termino}%")
              ->orWhereRaw("CONCAT(nombres, ' ', apellidos) LIKE ?", ["%{$termino}%"]);
        });
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento->age;
    }

    // Métodos para estadísticas
    public function actualizarEstadisticas()
    {
        $reunionesCerradas = Reunion::where('estado', 'cerrada')->count();
        
        if ($reunionesCerradas > 0) {
            $this->puntos_posibles = $reunionesCerradas * 1.0;
            $this->puntos_obtenidos = $this->asistencias()
                ->whereHas('reunion', function($q) {
                    $q->where('estado', 'cerrada');
                })
                ->sum('puntos_total');
            
            $this->porcentaje_asistencia = round(($this->puntos_obtenidos / $this->puntos_posibles) * 100, 2);
        } else {
            $this->puntos_posibles = 0;
            $this->puntos_obtenidos = 0;
            $this->porcentaje_asistencia = 0;
        }
        
        $this->save();
    }

    public function puedeSerCalificado()
    {
        return $this->porcentaje_asistencia >= 50;
    }

    public function debeSerNoCalificado()
    {
        return $this->porcentaje_asistencia < 40;
    }
}
