<?php

namespace App\Http\Requests\Trabajador;

use App\Enums\TipoDocumentoEnum;
use App\Enums\TipoSexoEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class IngresoTrabajadorRequest extends FormRequest
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
            'tipo_documento' => Str::upper(Str::squish($this->tipo_documento)),
            'cedula' => Str::squish($this->cedula),
            'primer_nombre' => Str::upper(Str::squish($this->primer_nombre)),
            'segundo_nombre' => $this->segundo_nombre ? Str::upper(Str::squish($this->segundo_nombre)) : null,
            'primer_apellido' => Str::upper(Str::squish($this->primer_apellido)),
            'segundo_apellido' => $this->segundo_apellido ? Str::upper(Str::squish($this->segundo_apellido)) : null,
            'sexo' => Str::upper(Str::squish($this->sexo)),
            'rif' => $this->rif ? Str::upper(Str::squish(Str::replace('-', '', $this->rif))) : null,
            'ocupacion' => $this->ocupacion ? Str::upper(Str::squish($this->ocupacion)) : null,
            'estado_civil' => $this->estado_civil ? Str::upper(Str::squish($this->estado_civil)) : null,
            'direccion' => $this->direccion ? Str::upper(Str::squish(Str::transliterate($this->direccion))) : null,
            'telefono_habitacion' => $this->telefono_habitacion ? Str::squish($this->telefono_habitacion) : null,
            'telefono_movil' => $this->telefono_movil ? Str::squish($this->telefono_movil) : null,
            'email_principal' => $this->email_principal ? Str::squish($this->email_principal) : null,
            'email_alterno' => $this->email_alterno ? Str::squish($this->email_alterno) : null,
            'cedula_extranjero' => $this->cedula_extranjero ? Str::upper(Str::squish($this->cedula_extranjero)) : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(
            $this->datosPersonalesRules(),
            $this->contactoRules(),
            $this->laboralesRules(),
        );
    }

    /**
     * Reglas para datos personales
     */
    protected function datosPersonalesRules(): array
    {
        return [
            'tipo_documento' => ['required', 'string', Rule::enum(TipoDocumentoEnum::class)],
            'cedula' => [
                'required',
                'string',
                'min:7',
                'max:12',
                'regex:/^[1-9][0-9]+$/i',
            ],
            'primer_nombre' => 'required|string|min:2|max:100|regex:/^[\pLáéíóúÁÉÍÓÚÑñ\s]+$/i',
            'segundo_nombre' => 'nullable|string|min:2|max:100|regex:/^[\pLáéíóúÁÉÍÓÚÑñ\s]+$/i',
            'primer_apellido' => 'required|string|min:2|max:100|regex:/^[\pLáéíóúÁÉÍÓÚÑñ\s]+$/i',
            'segundo_apellido' => 'nullable|string|min:2|max:100|regex:/^[\pLáéíóúÁÉÍÓÚÑñ\s]+$/i',
            'sexo' => ['required', 'string', Rule::in(['F', 'M'])],
            'fecha_nacimiento' => [
                'required',
                'string',
                Rule::date()->after(now()->subYears(100))->before(now()->subYears(18))
            ],
            'cedula_extranjero' => 'nullable|string|min:5|max:50',
        ];
    }

    /**
     * Reglas para contacto y ubicación
     */
    protected function contactoRules(): array
    {
        return [
            'estado' => 'nullable|string',
            'municipio' => 'nullable|string',
            'parroquia' => 'nullable|string',
            'direccion' => 'nullable|string|min:10|max:500',
            'telefono_habitacion' => 'nullable|string|digits:11|regex:/^[0-9]+$/i',
            'telefono_movil' => 'nullable|string|digits:11|regex:/^[0-9]+$/i',
            'email_principal' => 'nullable|email:rfc|max:255',
            'email_alterno' => 'nullable|email:rfc|max:255',
        ];
    }

    /**
     * Reglas para datos laborales
     */
    protected function laboralesRules(): array
    {
        return [
            'rif' => 'nullable|string|min:10|max:20',
            'ocupacion' => 'nullable|string',
            'estado_civil' => 'nullable|string',
        ];
    }

    /**
     * Campos personalizados
     * @return array
     */
    public function attributes(): array
    {
        return [
            'tipo_documento' => 'tipo documento',
            'cedula_extranjero' => 'cédula de extranjero',
            'email_principal' => 'correo electrónico principal',
            'email_alterno' => 'correo electrónico alterno',
            'telefono_habitacion' => 'teléfono de habitación',
            'telefono_movil' => 'teléfono móvil',
        ];
    }
}
