<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $table = 'sectores';
    
    protected $fillable = [
        'nombre',
        'descripcion', 
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function comuneros()
    {
        return $this->hasMany(Comunero::class);
    }

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function getComunerosActivosCount()
    {
        return $this->comuneros()->where('activo', true)->count();
    }

    public function getComunerosCalificadosCount()
    {
        return $this->comuneros()
            ->where('activo', true)
            ->where('condicion', 'calificado')
            ->count();
    }
}
