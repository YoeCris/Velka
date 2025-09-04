<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reunion;

class ReunionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Ambos roles pueden ver reuniones
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reunion $reunion): bool
    {
        return true; // Ambos roles pueden ver detalles de reuniones
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperadmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reunion $reunion): bool
    {
        return $user->isSuperadmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reunion $reunion): bool
    {
        return $user->isSuperadmin();
    }

    /**
     * Determine whether the user can close the reunion.
     */
    public function close(User $user, Reunion $reunion): bool
    {
        return $user->isSuperadmin() && $reunion->estado === 'programada';
    }

    /**
     * Determine whether the user can register asistencias.
     */
    public function registerAsistencia(User $user, Reunion $reunion): bool
    {
        return $user->isSuperadmin() && $reunion->estado === 'programada';
    }

    /**
     * Determine whether the user can view asistencias.
     */
    public function viewAsistencias(User $user, Reunion $reunion): bool
    {
        return true; // Ambos roles pueden ver asistencias
    }
}
