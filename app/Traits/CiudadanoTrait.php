<?php

namespace App\Traits;

use App\Enums\TipoSexoEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait CiudadanoTrait
{
    /**
     * Primer nombre
     * @return Attribute
     */
    public function nombres(): Attribute
    {
        return Attribute::make(fn () => $this->primer_nombre . ' ' . $this->segundo_nombre);
    }

    /**
     * Primer apellido
     * @return Attribute
     */
    public function apellidos(): Attribute
    {
        return Attribute::make(fn () => $this->primer_apellido . ' ' . $this->segundo_apellido);
    }

    /**
     * Primer nombre y primer apellido
     * @return Attribute
     */
    public function nombreApellido(): Attribute
    {
        return Attribute::make(fn () => $this->primer_nombre . ' ' . $this->primer_apellido);
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
        return $this->id_ciudadano[0];
    }

    /**
     * Numero de cedula
     * @return int|null
     */
    public function numeroCedula()
    {
        return intval(substr($this->id_ciudadano, 1));
    }

    /**
     * Formato de cédula
     * @return string|null
     */
    public function formatoCedula()
    {
        return $this->tipoDocumento() . '-' . number_format($this->numeroCedula(), 0, ',', '.');
    }

    /**
     * Sexo completo
     * @return Attribute
     */
    public function sexoCompleto(): Attribute
    {
        return Attribute::get(fn () => $this->sexo == 'M' ? TipoSexoEnum::MASCULINO->value : TipoSexoEnum::FEMENINO->value);
    }
}
