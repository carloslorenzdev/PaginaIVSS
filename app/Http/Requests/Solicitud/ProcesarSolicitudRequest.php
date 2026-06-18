<?php

namespace App\Http\Requests\Solicitud;

use App\Enums\EstatusSolicitudEnum;
use App\Enums\TipoDocumentoEnum;
use App\Rules\Ciudadano\ActivoCiudadanoRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProcesarSolicitudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepara datos antes de la validacion
     * @return void
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'estatus' => Str::squish($this->estatus),
            'observacion' => $this->observacion == '<p></p>' ? null : $this->observacion,
            // AUTORIZADO
            'tipo' => $this->tipo ? Str::upper(Str::squish($this->tipo)) : null,
            'cedula' => $this->cedula ? Str::squish($this->cedula) : null,
            'nombres' => $this->nombres ? Str::upper(Str::squish($this->nombres)) : null,
            'apellidos' => $this->apellidos ? Str::upper(Str::squish($this->apellidos)) : null,
            'telefono' => $this->telefono_principal ? Str::squish($this->telefono_principal) : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'estatus' => [
                'required',
                'string',
                Rule::enum(EstatusSolicitudEnum::class)
                    ->only([EstatusSolicitudEnum::APROBADA, EstatusSolicitudEnum::NEGADA])
            ],
            'autorizado' => 'nullable|string',
            'tipo' => [
                Rule::excludeIf(function () {
                    return $this->autorizado != 'on';
                }),
                'string',
                Rule::enum(TipoDocumentoEnum::class)
            ],
            'cedula' => [
                Rule::excludeIf(function () {
                    return $this->autorizado != 'on';
                }),
                'string',
                'min:7',
                'max:12',
                'regex:/^[1-9][0-9]+$/i',
                new ActivoCiudadanoRule($this->tipo)
            ],
            'nombres' => [
                Rule::excludeIf(function () {
                    return $this->autorizado != 'on';
                }),
                'string',
                'min:3',
                'max:255',
                'regex:/^[\pLáéíóúÁÉÍÓÚñÑ\s]+$/i'
            ],
            'apellidos' => [
                Rule::excludeIf(function () {
                    return $this->autorizado != 'on';
                }),
                'string',
                'min:3',
                'max:255',
                'regex:/^[\pLáéíóúÁÉÍÓÚñÑ\s]+$/i'
            ],
            'telefono' => [
                Rule::excludeIf(function () {
                    return $this->autorizado != 'on';
                }),
                'string',
                'digits:11',
                'regex:/^[0-9]+$/i'
            ],
            'observacion' => 'nullable|string|min:10|max:10000',
        ];
    }

    /**
     * Campos personalizados
     * @return array
     */
    public function attributes(): array
    {
        return [
            'tipo' => 'tipo documento',
            'telefono' => 'teléfono',
        ];
    }
}
