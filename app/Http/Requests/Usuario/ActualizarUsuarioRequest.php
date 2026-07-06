<?php

namespace App\Http\Requests\Usuario;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class ActualizarUsuarioRequest extends FormRequest
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
            'nombre'  => Str::upper(Str::squish($this->nombre)),
            'email'   => Str::squish($this->email),
            'rol'     => Str::squish($this->rol),
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
            'nombre' => 'required|string|min:3|max:255|regex:/^[\pLáéíóúÁÉÍÓÚÑñ\s]+$/i',
            'email' => [
                'required',
                'email:rfc',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($this->usuario->id)
            ],
            'rol' => [
                'required',
                Rule::exists(Role::class, 'name')->where(function ($query) {
                    $roles = ['patrono'];
                    if (!$this->user()->isAdmin()) {
                        $roles[] = 'admin';
                    }
                    $query->whereNotIn('name', $roles);
                })
            ],
            'observacion' => 'nullable|string|max:10000',
        ];
    }
}
