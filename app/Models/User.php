<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dni',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'genero',
        'telefono',
        'condicion',
        'sector',
        'fecha_ingreso_comunidad',
        'observaciones',
        'rol',
        'activo',
        'direccion',
        'ocupacion',
        'estado_civil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_nacimiento' => 'date',
            'fecha_ingreso_comunidad' => 'date',
            'activo' => 'boolean',
        ];
    }

    /**
     * Scope para comuneros activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para comuneros calificados
     */
    public function scopeCalificados($query)
    {
        return $query->where('condicion', 'calificado');
    }

    /**
     * Scope para comuneros no calificados
     */
    public function scopeNoCalificados($query)
    {
        return $query->where('condicion', 'no_calificado');
    }

    /**
     * Scope para administradores
     */
    public function scopeAdministradores($query)
    {
        return $query->where('rol', 'administrador');
    }

    /**
     * Scope para comuneros por sector
     */
    public function scopeDelSector($query, $sector)
    {
        return $query->where('sector', $sector);
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function esAdministrador(): bool
    {
        return $this->rol === 'administrador';
    }

    /**
     * Verificar si el comunero está calificado
     */
    public function esCalificado(): bool
    {
        return $this->condicion === 'calificado';
    }

    /**
     * Obtener nombre completo
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim($this->name . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno);
    }

    /**
     * Obtener descripción del sector
     */
    public function getDescripcionSectorAttribute(): string
    {
        $sectores = [
            'sector_1' => 'Sector 1 - Centro',
            'sector_2' => 'Sector 2 - Norte',
            'sector_3' => 'Sector 3 - Sur',
            'sector_4' => 'Sector 4 - Este',
        ];

        return $sectores[$this->sector] ?? 'Sector no definido';
    }

    /**
     * Obtener descripción de la condición
     */
    public function getDescripcionCondicionAttribute(): string
    {
        return $this->condicion === 'calificado' ? 'Comunero Calificado' : 'Comunero No Calificado';
    }
}
