<?php

namespace App\Http\Requests\Usuario;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RegistrarUsuarioRequest extends FormRequest
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
            'usuario' => Str::lower(Str::squish($this->usuario)),
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
                Rule::unique(User::class, 'email')->whereNull('deleted_at')
            ],
            'usuario' => [
                'required',
                'min:5',
                'max:20',
                'regex:/^[a-z]+[a-z0-9.]*$/i',
                Rule::unique(User::class, 'usuario')->whereNull('deleted_at')
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
            'password' => [
                'required',
                'confirmed',
                \Illuminate\Validation\Rules\Password::defaults()
            ],
        ];
    }
}
