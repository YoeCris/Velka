<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function comuneroCargos()
    {
        return $this->hasMany(ComuneroCargo::class);
    }

    public function comuneros()
    {
        return $this->belongsToMany(Comunero::class, 'comunero_cargos')
            ->withPivot(['fecha_inicio', 'fecha_fin', 'observaciones'])
            ->withTimestamps();
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
