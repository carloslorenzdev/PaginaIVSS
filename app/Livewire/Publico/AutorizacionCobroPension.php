<?php

namespace App\Livewire\Publico;

use App\Actions\Consultas\ConsultarAutorizacionCobroAction;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app-public')]
#[Title('Autorización de Cobro de Pensión (Forma 14-179) - IVSS')]
class AutorizacionCobroPension extends Component
{
    #[Url]
    public string $tab = 'solicitud'; // 'solicitud' o 'verificar'

    // Formulario de Consulta / Emisión
    public string $nac_pensionado = 'V';
    public string $cedula_pensionado = '';
    public string $tipo_pension = '10';
    public string $nac_autorizado = 'V';
    public string $cedula_autorizado = '';

    // Formulario de Verificación de Autenticidad
    public string $codigo_verificacion = '';

    // Estados de resultado
    public ?array $resultado = null;
    public ?string $errorMensaje = null;
    public bool $busquedaRealizada = false;

    public function cambiarTab(string $tab): void
    {
        $this->tab = in_array($tab, ['solicitud', 'verificar']) ? $tab : 'solicitud';
        $this->resultado = null;
        $this->errorMensaje = null;
        $this->busquedaRealizada = false;
        $this->resetValidation();
    }

    public function limpiar(): void
    {
        $this->reset([
            'cedula_pensionado',
            'cedula_autorizado',
            'codigo_verificacion',
            'resultado',
            'errorMensaje',
            'busquedaRealizada'
        ]);
        $this->nac_pensionado = 'V';
        $this->nac_autorizado = 'V';
        $this->tipo_pension = '10';
        $this->resetValidation();
    }

    public function consultar(ConsultarAutorizacionCobroAction $action): void
    {
        $this->validate([
            'nac_pensionado' => 'required|in:V,E,T',
            'cedula_pensionado' => 'required|numeric|min:1',
            'tipo_pension' => 'required|string',
            'nac_autorizado' => 'required|in:V,E,T',
            'cedula_autorizado' => 'required|numeric|min:1',
        ], [
            'cedula_pensionado.required' => 'Ingrese la cédula del pensionado.',
            'cedula_pensionado.numeric' => 'La cédula del pensionado debe contener solo números.',
            'tipo_pension.required' => 'Seleccione el tipo de pensión.',
            'cedula_autorizado.required' => 'Ingrese la cédula del autorizado.',
            'cedula_autorizado.numeric' => 'La cédula del autorizado debe contener solo números.',
        ]);

        $this->busquedaRealizada = true;
        $this->errorMensaje = null;
        $this->resultado = null;

        try {
            $datos = $action->consultarPorSolicitud([
                'nacionalidad_solicitante' => $this->nac_pensionado,
                'cedula_solicitante' => $this->cedula_pensionado,
                'tipo_pension' => $this->tipo_pension,
                'nacionalidad_autorizado' => $this->nac_autorizado,
                'cedula_autorizado' => $this->cedula_autorizado,
            ]);

            if ($datos) {
                $this->resultado = $datos;
            } else {
                $this->errorMensaje = 'No se encontró ninguna autorización de cobro registrada con los datos suministrados. Por favor verifique los números de cédula e intente nuevamente.';
            }
        } catch (\Throwable $th) {
            $this->errorMensaje = 'Ocurrió un inconveniente al consultar la base de datos de prestaciones. Por favor intente más tarde.';
        }
    }

    public function verificar(ConsultarAutorizacionCobroAction $action): void
    {
        $this->validate([
            'codigo_verificacion' => 'required|string|min:4|max:30',
        ], [
            'codigo_verificacion.required' => 'Ingrese el código de verificación o número de planilla.',
        ]);

        $this->busquedaRealizada = true;
        $this->errorMensaje = null;
        $this->resultado = null;

        try {
            $datos = $action->consultarPorCodigoVerificacion($this->codigo_verificacion);

            if ($datos) {
                $this->resultado = $datos;
            } else {
                $this->errorMensaje = 'El código o número de planilla ingresado no corresponde a una autorización de cobro registrada en el sistema.';
            }
        } catch (\Throwable $th) {
            $this->errorMensaje = 'Error al verificar el documento en el sistema de prestaciones. Intente de nuevo más tarde.';
        }
    }

    public function render()
    {
        return view('livewire.publico.autorizacion-cobro-pension');
    }
}
