<?php

namespace App\Traits;

trait FormatoFechaTrait
{
    public $FORMATO_NORMAL = 'Y-m-d g:i a';
    public $FORMATO_NORMAL_CORTO = 'Y-m-d';
    public $FORMATO_ISO = 'D MMM Y, h:mm a';
    public $FORMATO_ISO_CORTO = 'D MMM Y';

    /**
     * Formato fecha tipo normal
     * @param string $keyFecha
     * @param bool $short
     * @return string|null
     */
    public function formatoNormal(string $keyFecha, ?bool $short = false): string|null
    {
        if (is_null($this->{$keyFecha})) {
            return null;
        } else {
            return $this->{$keyFecha}->format($short ? $this->FORMATO_NORMAL_CORTO : $this->FORMATO_NORMAL);
        }
    }

    /**
     * Formato fecha tipo ISO
     * @param string $keyFecha
     * @param bool $short
     * @return string|null
     */
    public function formatoISO(string $keyFecha, ?bool $short = false): string|null
    {
        if (is_null($this->{$keyFecha})) {
            return null;
        } else {
            return $this->{$keyFecha}->isoFormat($short ? $this->FORMATO_ISO_CORTO : $this->FORMATO_ISO);
        }
    }

    /**
     * Muestra fecha amigable para humanos
     * @param string $campo
     * @return string|null
     */
    public function fechaHumanos(string $campo): string|null
    {
        if (is_null($this->{$campo})) {
            return null;
        }
        return $this->{$campo}->fechaHumanos();
    }
}
