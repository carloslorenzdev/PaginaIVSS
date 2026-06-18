<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class Desactivar2faRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'metodo' => 'required|array',
            'metodo.*' => 'required|string',
            'observacion' => 'required|string|min:10|max:10000',
        ];
    }

    /**
     * Campos personalizados
     * @return array
     */
    public function attributes(): array
    {
        return [
            'metodo' => 'método 2fa',
            'metodo.*' => 'método 2fa'
        ];
    }
}
