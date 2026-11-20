<?php

namespace App\Livewire\Publico;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Actions\Publico\ObtenerInicioDataAction;
use App\Actions\Consultas\ConsultarCuentaIndividualAction;
use App\Actions\Consultas\ConsultarPensionadoAction;
use App\Actions\Consultas\ConsultarOrdenPagoAction;

#[Layout('layouts.app-public')]
#[Title('IVSS | Instituto Venezolano de los Seguros Sociales')]
class Inicio extends Component
{
    // Propiedades Cuenta Individual
    public string $ci_nacionalidad = 'V';
    public string $ci_cedula = '';

    // Propiedades Consulta Pensionado
    public string $pen_nacionalidad = 'V';
    public string $pen_cedula = '';

    // Propiedades Orden de Pago
    public string $op_idEmpresa = '';
    public string $op_periodo = '';
    public string $op_tipoEmpresa = 'PR';

    public function updatedCiCedula($value): void
    {
        $this->ci_cedula = preg_replace('/[^0-9]/', '', (string)$value);
    }

    public function updatedPenCedula($value): void
    {
        $this->pen_cedula = preg_replace('/[^0-9]/', '', (string)$value);
    }

    public function mount()
    {
        // Período predeterminado para Orden de Pago (mes anterior o actual)
        $currentDate = now();
        if ($currentDate->day < 30) {
            $currentDate->subMonth();
        }
        $this->op_periodo = $currentDate->format('m/Y');
    }

    public function consultarCuentaIndividual(ConsultarCuentaIndividualAction $action)
    {
        $this->ci_cedula = preg_replace('/[^0-9]/', '', (string)$this->ci_cedula);

        $this->validate([
            'ci_nacionalidad' => 'required|in:V,E',
            'ci_cedula' => 'required|numeric|min:1',
        ], [
            'ci_cedula.required' => 'Debe ingresar el número de cédula.',
            'ci_cedula.numeric' => 'La cédula debe contener solo números.',
        ]);

        $result = $action->execute([
            'nacionalidad' => $this->ci_nacionalidad,
            'cedula' => $this->ci_cedula,
        ]);

        // Limpiar datos de la consulta para que la modal esté limpia al reabrirla
        $this->reset(['ci_cedula']);
        $this->ci_nacionalidad = 'V';
        $this->resetValidation();

        $this->dispatch('cerrar-modal', id: 'modalCuentaIndividual');

        if ($result['success'] ?? false) {
            $this->dispatch('abrir-ventana-html', html: $result['html']);
        } else {
            $this->dispatch('swal', 
                icon: 'error', 
                title: 'Error', 
                text: $result['message'] ?? 'No disponible en este momento, intente de nuevo más tarde.'
            );
        }
    }

    public function consultarPensionado()
    {
        $this->pen_cedula = preg_replace('/[^0-9]/', '', (string)$this->pen_cedula);

        $this->validate([
            'pen_nacionalidad' => 'required|in:V,E',
            'pen_cedula' => 'required|numeric|min:1',
        ], [
            'pen_cedula.required' => 'Debe ingresar la cédula del causante.',
            'pen_cedula.numeric' => 'La cédula debe contener solo números.',
        ]);

        $nac = $this->pen_nacionalidad;
        $ced = $this->pen_cedula;

        // Limpiar datos de la modal
        $this->reset(['pen_cedula']);
        $this->pen_nacionalidad = 'V';
        $this->resetValidation();

        $this->dispatch('cerrar-modal', id: 'modalConsultaPensionado');

        // Redirigir directamente al componente nativo de consulta de pensión
        return $this->redirect(route('consulta_pension', [
            'nacionalidad' => $nac,
            'cedula' => $ced,
        ]), navigate: true);
    }

    public function consultarOrdenPago(ConsultarOrdenPagoAction $action)
    {
        $this->validate([
            'op_idEmpresa' => 'required|string',
            'op_periodo' => 'required|string',
            'op_tipoEmpresa' => 'required|in:PR,PU,TU,AD',
        ], [
            'op_idEmpresa.required' => 'Ingrese el número patronal.',
            'op_periodo.required' => 'Seleccione el período de facturación.',
        ]);

        $result = $action->execute([
            'idEmpresa' => $this->op_idEmpresa,
            'periodo' => $this->op_periodo,
            'tipoEmpresa' => $this->op_tipoEmpresa,
        ]);

        $periodoConsultado = $this->op_periodo;

        // Limpiar datos de la consulta para que la modal esté limpia al reabrirla
        $this->reset(['op_idEmpresa']);
        $this->op_tipoEmpresa = 'PR';
        $this->resetValidation();

        $this->dispatch('cerrar-modal', id: 'modalOrdenPago');

        if ($result['success'] ?? false) {
            $base64Pdf = base64_encode($result['body']);
            $nombreArchivo = 'FacturaIVSS_Periodo' . str_replace('/', '-', $periodoConsultado) . '.pdf';
            
            $this->dispatch('abrir-pdf-base64', [
                'pdf' => $base64Pdf,
                'filename' => $nombreArchivo,
                'periodo' => $periodoConsultado
            ]);
        } else {
            $this->dispatch('swal', 
                icon: 'warning', 
                title: 'Atención', 
                text: $result['message'] ?? 'No se encontraron datos o hubo un error en la conexión.'
            );
        }
    }

    public function render(ObtenerInicioDataAction $action)
    {
        $data = $action->execute(
            request()->preview_carousel,
            request()->preview_section3_bg,
            request()->preview_section3_text
        );

        return view('livewire.publico.inicio', $data);
    }
}
