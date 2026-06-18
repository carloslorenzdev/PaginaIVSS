<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

trait DatosPersonalesTrait
{
    /**
     * Primer nombre
     * @return Attribute
     */
    public function primerNombre(): Attribute
    {
        return Attribute::make(fn () => explode(' ', $this->nombres)[0]);
    }

    /**
     * Primer apellido
     * @return Attribute
     */
    public function primerApellido(): Attribute
    {
        return Attribute::make(fn () => explode(' ', $this->apellidos)[0]);
    }

    /**
     * Primer nombre y primer apellido
     * @return Attribute
     */
    public function nombreApellido(): Attribute
    {
        return Attribute::make(fn () => $this->primerNombre . ' ' . $this->primerApellido);
    }

    /**
     * Devuelve nombres y apellidos juntos
     * @return Attribute
     */
    public function nombreCompleto(): Attribute
    {
        return Attribute::make(fn () => $this->nombres . ' ' . $this->apellidos);
    }

    /**
     * Primera letra del nombre y el apellido
     * @return Attribute
     */
    public function iniciales(): Attribute
    {
        return Attribute::make(fn () => $this->nombres[0] . $this->apellidos[0]);
    }

    /**
     * Tipo de documento
     * @return string|null
     */
    public function tipoDocumento()
    {
        return $this->cedula[0];
    }

    /**
     * Numero de cedula
     * @return string|null
     */
    public function numeroCedula()
    {
        return intval(Str::substr(Str::replace('-', '', $this->cedula), 1));
    }

    /**
     * Formato de cédula
     * @return string|null
     */
    public function formatoCedula()
    {
        return $this->tipoDocumento() . '-' . number_format($this->numeroCedula(), 0, ',', '.');
    }
}
