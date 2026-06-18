<?php

namespace App\Http\Requests\Trabajador;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EgresoTrabajadorRequest extends FormRequest
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
            'motivo' => $this->motivo ? Str::upper(Str::squish($this->motivo)) : null,
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
            'fecha_egreso' => [
                'required',
                'string',
                Rule::date()->after('2020-01-01')->beforeOrEqual(now())
            ],
            'motivo' => 'required|string|min:10|max:500',
        ];
    }

    /**
     * Campos personalizados
     * @return array
     */
    public function attributes(): array
    {
        return [
            'fecha_egreso' => 'fecha de egreso',
        ];
    }
}
