<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     */
    public function before(User $userAuth, string $ability): bool|null
    {
        if ($userAuth->isAdmin() && !in_array($ability, ['banunban', 'delete'])) {
            return true;
        }
        // Continual al metodo a validar
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $userAuth): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $userAuth, User $model): bool
    {
        if ($model->isAdmin()) {
            return false;
        }
        return $userAuth->fk_oficina_ivss == $model->fk_oficina_ivss;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $userAuth): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $userAuth, User $model): bool
    {
        if ($model->isAdmin()) {
            return false;
        }
        // userAuth DIRECTOR
        if ($userAuth->isDirector()) {
            return !$model->isDirector();
        }
        // userAuth FUNCIONARIO
        return $model->isPatrono() && $userAuth->fk_oficina_ivss == $model->fk_oficina_ivss;
    }

    /**
     * Determine whether the user can ban/unban the model.
     */
    public function banunban(User $userAuth, User $model)
    {
        if ($userAuth->id == $model->id) {
            return false;
        }
        if ($userAuth->isAdmin()) {
            return true;
        }
        if ($model->isAdmin()) {
            return false;
        }
        if ($userAuth->isDirector()) {
            return !$model->isDirector();
        }
        return $model->isPatrono() && $userAuth->fk_oficina_ivss == $model->fk_oficina_ivss;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $userAuth, User $model): bool
    {
        if ($userAuth->id == $model->id) {
            return false;
        }
        if ($userAuth->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $userAuth, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $userAuth, User $model): bool
    {
        return false;
    }
}
