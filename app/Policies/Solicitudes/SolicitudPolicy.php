<?php

namespace App\Policies\Solicitudes;

use App\Models\Solicitudes\Solicitud;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SolicitudPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     */
    public function before(User $userAuth, string $ability): bool|null
    {
        if ($userAuth->isAdmin()) {
            return true;
        }
        // Continual al metodo a validar
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Solicitud $solicitud): bool
    {
        return $user->fk_oficina_ivss == $solicitud->fk_oficina_ivss;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Solicitud $solicitud): bool
    {
        return $user->fk_oficina_ivss == $solicitud->fk_oficina_ivss;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Solicitud $solicitud): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Solicitud $solicitud): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Solicitud $solicitud): bool
    {
        return false;
    }
}
