<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'sector_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relaciones
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Scopes
    public function scopeSuperadmin($query)
    {
        return $query->where('role', 'superadmin');
    }

    public function scopeAdminSector($query)
    {
        return $query->where('role', 'admin_sector');
    }

    public function scopeDelSector($query, $sectorId)
    {
        return $query->where('sector_id', $sectorId);
    }

    // Métodos de verificación de roles
    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdminSector(): bool
    {
        return $this->role === 'admin_sector';
    }

    public function canAccessSector($sectorId): bool
    {
        return $this->isSuperadmin() || $this->sector_id == $sectorId;
    }

    public function canModifyData(): bool
    {
        return $this->isSuperadmin();
    }

    public function canManageReuniones(): bool
    {
        return $this->isSuperadmin();
    }

    public function canRegisterAsistencias(): bool
    {
        return $this->isSuperadmin();
    }

    public function canUpdateCondiciones(): bool
    {
        return $this->isSuperadmin();
    }

    public function getNombreConRolAttribute()
    {
        $roles = [
            'superadmin' => 'Superadministrador',
            'admin_sector' => 'Administrador de Sector'
        ];

        $rolNombre = $roles[$this->role] ?? $this->role;
        $sectorNombre = $this->sector ? " - {$this->sector->nombre}" : '';
        
        return "{$this->name} ({$rolNombre}{$sectorNombre})";
    }
}
