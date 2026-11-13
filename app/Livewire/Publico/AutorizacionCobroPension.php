<?php

namespace App\Livewire\Publico;

use App\Actions\Consultas\ConsultarAutorizacionCobroAction;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app-public')]
#[Title('Actualización de Autorización de Cobro de Pensión - IVSS')]
class AutorizacionCobroPension extends Component
{
    // Campos de Solicitud (exactos al sistema institucional SolicitudAutorizacion.jsp)
    public string $nac_pensionado = 'V';
    public string $cedula_pensionado = '';
    public string $tipo_pension = '10';
    public string $nac_autorizado = 'V';
    public string $cedula_autorizado = '';

    // Estados de resultado
    public ?array $resultado = null;
    public ?string $errorMensaje = null;
    public bool $busquedaRealizada = false;

    public function limpiar(): void
    {
        $this->reset([
            'cedula_pensionado',
            'cedula_autorizado',
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
            'tipo_pension' => 'required|in:01,06,10,12',
            'nac_autorizado' => 'required|in:V,E,T',
            'cedula_autorizado' => 'required|numeric|min:1',
        ], [
            'cedula_pensionado.required' => 'Debe ingresar el número de cédula del Pensionado.',
            'cedula_pensionado.numeric' => 'La cédula del pensionado debe contener solo números.',
            'tipo_pension.required' => 'Debe ingresar el Tipo de Pensión.',
            'cedula_autorizado.required' => 'Debe ingresar el número de cédula del Autorizado.',
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
                $this->errorMensaje = 'No se encontró ninguna autorización de cobro de pensión con los datos suministrados.';
            }
        } catch (\Throwable $th) {
            $this->errorMensaje = 'Error al consultar la autorización en la base de datos de prestaciones. Intente más tarde.';
        }
    }

    public function render()
    {
        return view('livewire.publico.autorizacion-cobro-pension');
    }
}
