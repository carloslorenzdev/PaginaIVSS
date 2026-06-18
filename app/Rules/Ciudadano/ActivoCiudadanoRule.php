<?php

namespace App\Rules\Ciudadano;

use App\Models\IVSS\SiraCiudadano;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class ActivoCiudadanoRule implements ValidationRule
{
    /**
     * Tipo de documento
     * @var string
     */
    protected $tipo = '';

    public function __construct(string $tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $ciudadano = SiraCiudadano::activo()
            ->where('id_ciudadano', Str::upper($this->tipo) . Str::padLeft($value, 9, '0'))->first();
        if ($ciudadano && $ciudadano->isFallecido()) {
            $fail('Ciudadano se encuentra fallecido');
        }
    }
}
