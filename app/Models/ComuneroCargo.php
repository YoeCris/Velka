<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComuneroCargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'comunero_id',
        'cargo_id',
        'fecha_inicio',
        'fecha_fin',
        'observaciones'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date'
    ];

    public function comunero()
    {
        return $this->belongsTo(Comunero::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function scopeActuales($query)
    {
        return $query->whereNull('fecha_fin')
            ->orWhere('fecha_fin', '>=', now()->toDateString());
    }

    public function scopeHistoricas($query)
    {
        return $query->whereNotNull('fecha_fin')
            ->where('fecha_fin', '<', now()->toDateString());
    }

    public function getEsActivoAttribute()
    {
        return is_null($this->fecha_fin) || $this->fecha_fin >= now()->toDate();
    }
}
