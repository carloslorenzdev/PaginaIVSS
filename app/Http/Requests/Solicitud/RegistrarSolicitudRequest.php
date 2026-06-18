<?php

namespace App\Http\Requests\Solicitud;

use App\Enums\TipoDocumentoEnum;
use App\Enums\TipoRifEnum;
use App\Models\IVSS\SiraActividadEconomica;
use App\Models\IVSS\SiraParroquia;
use App\Models\IVSS\SiraTipoEmpresa;
use App\Models\IVSS\SiraTipoSociedad;
use App\Rules\Ciudadano\ActivoCiudadanoRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegistrarSolicitudRequest extends FormRequest
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
            // REPRESENTANTE
            'tipo' => Str::upper(Str::squish($this->tipo)),
            'cedula' => Str::squish($this->cedula),
            'nombres' => Str::upper(Str::squish($this->nombres)),
            'apellidos' => Str::upper(Str::squish($this->apellidos)),
            'correo' => Str::squish($this->correo),
            // EMPRESA
            'nombre_empresa' => $this->nombre_empresa ? Str::upper(Str::squish(Str::transliterate($this->nombre_empresa))) : null,
            'tipo_rif' => Str::upper(Str::squish($this->tipo_rif)),
            'rif' => Str::replace('-', '', Str::squish($this->rif)),
            'razon_social' => $this->razon_social ? Str::upper(Str::squish(Str::transliterate($this->razon_social))) : null,
            'telefono_principal' => Str::squish($this->telefono_principal),
            'telefono_adicional' => Str::squish($this->telefono_adicional),
            'fax' => Str::squish($this->fax),
            'tipo_empresa' => Str::upper(Str::squish($this->tipo_empresa)),
            'tipo_sociedad' => Str::upper(Str::squish($this->tipo_sociedad)),
            'actividad_economica' => Str::upper(Str::squish($this->actividad_economica)),
            // MERCANTIL
            'oficina' => $this->oficina ? Str::upper(Str::squish(Str::transliterate($this->oficina))) : null,
            'no_documento' => Str::squish($this->no_documento),
            'no_tomo' => $this->no_tomo ? Str::upper(Str::squish(Str::transliterate($this->no_tomo))) : null,
            'no_folio' => $this->no_folio ? Str::upper(Str::squish(Str::transliterate($this->no_folio))) : null,
            'no_protocolo' => $this->no_protocolo ? Str::upper(Str::squish(Str::transliterate($this->no_protocolo))) : null,
            // DIRECCION FISCAL
            'av_calle_df' => $this->av_calle_df ? Str::upper(Str::squish(Str::transliterate($this->av_calle_df))) : null,
            'edif_casa_df' => $this->edif_casa_df ? Str::upper(Str::squish(Str::transliterate($this->edif_casa_df))) : null,
            'piso_nivel_df' => $this->piso_nivel_df ? Str::upper(Str::squish(Str::transliterate($this->piso_nivel_df))) : null,
            'apto_oficina_df' => $this->apto_oficina_df ? Str::upper(Str::squish(Str::transliterate($this->apto_oficina_df))) : null,
            'pto_ref_df' => $this->pto_ref_df ? Str::upper(Str::squish(Str::transliterate($this->pto_ref_df))) : null,
            'cod_postal_df' => Str::squish($this->cod_postal_df),
            // DIRECCION COMERCIAL
            'av_calle_dc' => $this->av_calle_dc ? Str::upper(Str::squish(Str::transliterate($this->av_calle_dc))) : null,
            'edif_casa_dc' => $this->edif_casa_dc ? Str::upper(Str::squish(Str::transliterate($this->edif_casa_dc))) : null,
            'piso_nivel_dc' => $this->piso_nivel_dc ? Str::upper(Str::squish(Str::transliterate($this->piso_nivel_dc))) : null,
            'apto_oficina_dc' => $this->apto_oficina_dc ? Str::upper(Str::squish(Str::transliterate($this->apto_oficina_dc))) : null,
            'pto_ref_dc' => $this->pto_ref_dc ? Str::upper(Str::squish(Str::transliterate($this->pto_ref_dc))) : null,
            'cod_postal_dc' => Str::squish($this->cod_postal_dc),
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
            $this->representanteRules(),
            $this->empresaRules(),
            $this->mercantilRules(),
            $this->direccionFiscalRules(),
            $this->direccionComercialRules(),
        );
    }

    /**
     * Reglas para representante legal
     */
    protected function representanteRules(): array
    {
        return [
            'tipo' => ['required', 'string', Rule::enum(TipoDocumentoEnum::class)],
            'cedula' => [
                'required',
                'string',
                'min:7',
                'max:12',
                'regex:/^[1-9][0-9]+$/i',
                new ActivoCiudadanoRule($this->tipo)
            ],
            'nombres' => 'required|string|min:3|max:255|regex:/^[\pLáéíóúÁÉÍÓÚñÑ\s]+$/i',
            'apellidos' => 'required|string|min:3|max:255|regex:/^[\pLáéíóúÁÉÍÓÚñÑ\s]+$/i',
            'correo' => ['required', 'email:rfc', 'max:255'],
        ];
    }

    /**
     * Reglas para empresa
     */
    protected function empresaRules(): array
    {
        return [
            'nombre_empresa' => 'required|string|min:10|max:255',
            'tipo_rif' => ['required', 'string', Rule::enum(TipoRifEnum::class)],
            'rif' => 'required|string|digits_between:1,9|regex:/^[1-9][0-9]+$/i',
            'razon_social' => 'required|string|min:10|max:255',
            'telefono_principal' => 'required|string|digits:11|regex:/^[0-9]+$/i',
            'telefono_adicional' => 'nullable|string|digits:11|regex:/^[0-9]+$/i',
            'fax' => 'nullable|string|digits:11|regex:/^[0-9]+$/i',
            'tipo_empresa' => ['required', 'string', Rule::exists(SiraTipoEmpresa::class, 'id_tipo_empresa')],
            'tipo_sociedad' => ['required', 'string', Rule::exists(SiraTipoSociedad::class, 'id_sociedad')],
            'actividad_economica' => [
                'required',
                'string',
                Rule::exists(SiraActividadEconomica::class, 'id_actividad')->where(function (Builder $query) {
                    $query->where('id_tipo_empresa', $this->tipo_empresa);
                })
            ],
        ];
    }

    /**
     * Reglas para registro mercantil
     */
    protected function mercantilRules(): array
    {
        return [
            'oficina' => 'required|string|min:10|max:255',
            'no_documento' => 'required|integer|min:1',
            'no_tomo' => 'required|string|min:1|max:255',
            'no_folio' => 'nullable|string|min:1|max:255',
            'no_protocolo' => 'nullable|string|min:1|max:255',
            'fecha_constitucion' => [
                'required',
                'string',
                Rule::date()->after(now()->subYears(200))->beforeToday()
            ],
            'fecha_inscripcion' => [
                'required',
                'string',
                Rule::date()->afterOrEqual(now()->parse($this->fecha_constitucion))->beforeToday()
            ],
            'fecha_actividad' => [
                'required',
                'string',
                Rule::date()->after(now()->parse($this->fecha_inscripcion))->beforeToday()
            ],
            'fecha_fiscal' => [
                'required',
                'string',
                Rule::date()->after(now()->parse($this->fecha_actividad))->before(now()->endOfYear())
            ],
        ];
    }

    /**
     * Reglas para dirección fiscal
     */
    protected function direccionFiscalRules(): array
    {
        return [
            'parroquia_df' => [
                'required',
                'string',
                Rule::exists(SiraParroquia::class, 'id_parroquia')
            ],
            'av_calle_df' => 'required|string|min:3|max:255',
            'edif_casa_df' => 'required|string|min:3|max:255',
            'piso_nivel_df' => 'required|string|min:1|max:255',
            'apto_oficina_df' => 'required|string|min:1|max:255',
            'pto_ref_df' => 'required|string|min:3|max:255',
            'cod_postal_df' => 'required|integer|digits_between:3,5',
        ];
    }

    /**
     * Reglas para dirección comercial
     */
    protected function direccionComercialRules(): array
    {
        return [
            'parroquia_dc' => [
                'required',
                'string',
                Rule::exists(SiraParroquia::class, 'id_parroquia')
            ],
            'av_calle_dc' => 'required|string|min:3|max:255',
            'edif_casa_dc' => 'required|string|min:3|max:255',
            'piso_nivel_dc' => 'required|string|min:1|max:255',
            'apto_oficina_dc' => 'required|string|min:1|max:255',
            'pto_ref_dc' => 'required|string|min:3|max:255',
            'cod_postal_dc' => 'required|integer|digits_between:3,5',
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
            // EMPRESA
            'nombre_empresa' => 'nombre de empresa',
            'tipo_rif' => 'tipo RIF',
            'razon_social' => 'razón social',
            'telefono_principal' => 'teléfono principal',
            'telefono_adicional' => 'teléfono adicional',
            'tipo_empresa' => 'tipo de empresa',
            'tipo_sociedad' => 'tipo de sociedad',
            'actividad_economica' => 'actividad económica',
            // MERCANTIL
            'no_documento' => 'número de documento',
            'no_tomo' => 'número de tomo',
            'no_folio' => 'número de folio',
            'no_protocolo' => 'número de protocolo',
            'fecha_inscripcion' => 'fecha de inscripción',
            'fecha_constitucion' => 'fecha de constitución',
            'fecha_actividad' => 'fecha inicio actividad',
            'fecha_fiscal' => 'fecha cierre fiscal',
            // DIRECCION FISCAL
            'parroquia_df' => 'parroquia',
            'av_calle_df' => 'avenida/calle',
            'edif_casa_df' => 'eficicio/casa',
            'piso_nivel_df' => 'piso/nivel',
            'apto_oficina_df' => 'apto/oficina/local',
            'pto_ref_df' => 'punto de referencia',
            'cod_postal_df' => 'código postal',
            // DIRECCION COMERCIAL
            'parroquia_dc' => 'parroquia',
            'av_calle_dc' => 'avenida/calle',
            'edif_casa_dc' => 'eficicio/casa',
            'piso_nivel_dc' => 'piso/nivel',
            'apto_oficina_dc' => 'apto/oficina/local',
            'pto_ref_dc' => 'punto de referencia',
            'cod_postal_dc' => 'código postal',
        ];
    }
}
