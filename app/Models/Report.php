<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'nombre_archivo',
        'ruta_archivo',
        'filtros',
        'total_registros',
        'user_id'
    ];

    protected $casts = [
        'filtros' => 'array'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeRecientes($query, $dias = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }

    public function getRutaCompletaAttribute()
    {
        return storage_path('app/public/' . $this->ruta_archivo);
    }

    public function existeArchivo()
    {
        return file_exists($this->ruta_completa);
    }
}
