<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comunero;

class ComuneroPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user = null): bool
    {
        return $user !== null; // Ambos roles pueden ver comuneros
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user = null, ?Comunero $comunero = null): bool
    {
        if (!$user) return false;
        
        if ($user->isSuperadmin()) {
            return true;
        }

        // Admin sector solo puede ver comuneros de su sector
        return $user->isAdminSector() && $comunero && $user->sector_id === $comunero->sector_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user = null): bool
    {
        return $user && $user->isSuperadmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user = null, ?Comunero $comunero = null): bool
    {
        return $user && $user->isSuperadmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user = null, ?Comunero $comunero = null): bool
    {
        return $user && $user->isSuperadmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user = null, ?Comunero $comunero = null): bool
    {
        return $user && $user->isSuperadmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user = null, ?Comunero $comunero = null): bool
    {
        return $user && $user->isSuperadmin();
    }

    /**
     * Determine whether the user can assign cargos.
     */
    public function assignCargo(?User $user = null, ?Comunero $comunero = null): bool
    {
        return $user && $user->isSuperadmin();
    }

    /**
     * Determine whether the user can update condition.
     */
    public function updateCondition(?User $user = null): bool
    {
        return $user && $user->isSuperadmin();
    }

    /**
     * Determine whether the user can export padron for sector.
     */
    public function exportPadron(?User $user = null, ?int $sectorId = null): bool
    {
        if (!$user) return false;
        
        if ($user->isSuperadmin()) {
            return true;
        }

        if ($user->isAdminSector() && $sectorId) {
            return $user->sector_id === $sectorId;
        }

        return $user->isAdminSector(); // Puede exportar su propio sector
    }
}
