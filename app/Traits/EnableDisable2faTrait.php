<?php

namespace App\Traits;

use App\Models\User;

trait EnableDisable2faTrait
{
    /**
     * Habilita método 2fa al usuario
     */
    public static function activar(User $usuario, string|int $secret)
    {
        $usuario->{self::secretColumn()} = $secret;
        $usuario->{self::secretConfirmedAt()} = now();
        self::saveChanges($usuario);
    }

    /**
     * Deshabilita método 2fa al usuario
     */
    public static function desactivar(User $usuario, int|null $idUserAuth = null)
    {
        $usuario->{self::secretColumn()} = null;
        $usuario->{self::secretConfirmedAt()} = null;
        self::saveChanges($usuario, $idUserAuth);
    }

    /**
     * Guarda los cambios al usuario
     */
    public static function saveChanges(User $usuario, int|null $idUserAuth = null)
    {
        $usuario->updated_by = $idUserAuth ?: $usuario->id;
        $usuario->save();
    }
}
