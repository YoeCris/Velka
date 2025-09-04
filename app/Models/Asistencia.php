<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'reunion_id',
        'comunero_id',
        'marca_entrada',
        'marca_salida',
        'puntos_entrada',
        'puntos_salida',
        'puntos_total'
    ];

    protected $casts = [
        'marca_entrada' => 'datetime',
        'marca_salida' => 'datetime',
        'puntos_entrada' => 'decimal:2',
        'puntos_salida' => 'decimal:2',
        'puntos_total' => 'decimal:2'
    ];

    public function reunion()
    {
        return $this->belongsTo(Reunion::class);
    }

    public function comunero()
    {
        return $this->belongsTo(Comunero::class);
    }

    public function registrarEntrada($hora = null)
    {
        $hora = $hora ?? now();
        $this->marca_entrada = $hora;
        
        // Calcular puntos de entrada según reglas
        $this->puntos_entrada = $this->calcularPuntosEntrada($hora);
        $this->recalcularPuntosTotal();
        $this->save();
    }

    public function registrarSalida($hora = null)
    {
        $hora = $hora ?? now();
        $this->marca_salida = $hora;
        
        // Calcular puntos de salida
        $this->puntos_salida = $this->marca_entrada ? 0.50 : 0.00;
        $this->recalcularPuntosTotal();
        $this->save();
    }

    private function calcularPuntosEntrada($horaEntrada)
    {
        $reunion = $this->reunion;
        $horaInicioReunion = $reunion->fecha->setTimeFromTimeString($reunion->hora_inicio);
        $horaLimiteATiempo = $horaInicioReunion->copy()->addMinutes($reunion->umbral_tardanza);
        
        if ($horaEntrada <= $horaLimiteATiempo) {
            return 0.50; // A tiempo
        } else {
            return 0.25; // Tarde
        }
    }

    public function recalcularPuntos($reunion = null)
    {
        $reunion = $reunion ?? $this->reunion;
        
        // Recalcular puntos de entrada
        if ($this->marca_entrada) {
            $this->puntos_entrada = $this->calcularPuntosEntrada($this->marca_entrada);
        } else {
            $this->puntos_entrada = 0; // Falta
        }
        
        // Recalcular puntos de salida
        if ($this->marca_salida) {
            $this->puntos_salida = 0.50; // Asistió/salió
        } else {
            $this->puntos_salida = 0.00; // No salió
        }
        
        $this->recalcularPuntosTotal();
        $this->save();
    }

    private function recalcularPuntosTotal()
    {
        // Aplicar regla especial: si entró pero no salió, queda en 0.50
        if ($this->marca_entrada && !$this->marca_salida) {
            $this->puntos_total = 0.50;
        } else {
            $this->puntos_total = $this->puntos_entrada + $this->puntos_salida;
        }
    }

    // Accessors para estados legibles
    public function getEstadoEntradaAttribute()
    {
        if (!$this->marca_entrada) return 'F';
        
        $reunion = $this->reunion;
        $horaInicioReunion = $reunion->fecha->setTimeFromTimeString($reunion->hora_inicio);
        $horaLimiteATiempo = $horaInicioReunion->copy()->addMinutes($reunion->umbral_tardanza);
        
        return $this->marca_entrada <= $horaLimiteATiempo ? 'A' : 'T';
    }

    public function getEstadoSalidaAttribute()
    {
        return $this->marca_salida ? 'A' : 'F';
    }

    public function getEstadoCompletoAttribute()
    {
        return $this->estado_entrada . '/' . $this->estado_salida;
    }
}
