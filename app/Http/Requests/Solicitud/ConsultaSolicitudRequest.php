<?php

namespace App\Http\Requests\Solicitud;

use App\Enums\TipoDocumentoEnum;
use App\Enums\TipoRifEnum;
use App\Models\Solicitudes\Solicitud;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ConsultaSolicitudRequest extends FormRequest
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
            'tipo_rif' => Str::upper(Str::squish($this->tipo_rif)),
            'rif' => Str::replace('-', '', Str::squish($this->rif)),
            'tipo' => Str::upper(Str::squish($this->tipo)),
            'cedula' => Str::squish($this->cedula),
            'solicitud' => Str::upper(Str::squish($this->solicitud)),
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
            'tipo' => ['required', 'string', Rule::enum(TipoDocumentoEnum::class)],
            'cedula' => 'required|string|min:7|max:12|regex:/^[1-9][0-9]+$/i',
            'tipo_rif' => ['required', 'string', Rule::enum(TipoRifEnum::class)],
            'rif' => 'required|string|digits_between:1,9|regex:/^[1-9][0-9]+$/i',
            'solicitud' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::exists(Solicitud::class, 'no_solicitud')->where(function (Builder $query) {
                    $query->where('rif', $this->tipo_rif . Str::padLeft($this->rif, 9, '0'))
                        ->where('cedula', $this->tipo . '-' . $this->cedula);
                })
            ]
        ];
    }
}
