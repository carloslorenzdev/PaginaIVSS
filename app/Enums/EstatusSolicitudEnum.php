<?php

namespace App\Enums;

enum EstatusSolicitudEnum: string
{
    case PENDIENTE = 'PENDIENTE';
    case APROBADA = 'APROBADA';
    case NEGADA = 'NEGADA';

    /**
     * Color para el estatus
     */
    public function color(): string
    {
        return match ($this) {
            self::PENDIENTE => 'sky',
            self::APROBADA => 'teal',
            self::NEGADA => 'red',
            default => 'purple',
        };
    }

    /**
     * Verifica si esta pendiente
     */
    public function isPendiente(): bool
    {
        return $this === self::PENDIENTE;
    }

    /**
     * Verifica si esta aprobada
     */
    public function isAprobada(): bool
    {
        return $this === self::APROBADA;
    }

    /**
     * Verifica si esta negada
     */
    public function isNegada(): bool
    {
        return $this === self::NEGADA;
    }

    /**
     * Estatus pendiente y aprobada
     */
    public static function pendienteAprobada(): array
    {
        return [self::PENDIENTE, self::APROBADA];
    }
}
