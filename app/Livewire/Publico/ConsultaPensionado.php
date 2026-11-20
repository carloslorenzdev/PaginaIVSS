<?php

namespace App\Livewire\Publico;

use App\Actions\Consultas\ConsultarPensionadoNativoAction;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app-public')]
#[Title('Consulta de Pensionados - IVSS')]
class ConsultaPensionado extends Component
{
    public string $nacionalidad = 'V';
    public string $cedula = '';

    public ?array $pensionado = null;
    public ?string $errorMensaje = null;
    public bool $busquedaRealizada = false;
    public bool $mostrarCuentaCompleta = false;

    public function mount()
    {
        if (request()->has('cedula')) {
            $this->cedula = preg_replace('/[^0-9]/', '', (string)request('cedula'));
            if (request()->has('nacionalidad')) {
                $nac = strtoupper((string)request('nacionalidad'));
                if (in_array($nac, ['V', 'E'])) {
                    $this->nacionalidad = $nac;
                }
            }
            if (!empty($this->cedula)) {
                $action = app(ConsultarPensionadoNativoAction::class);
                $this->consultar($action);
            }
        }
    }

    public function updatedCedula($value): void
    {
        $this->cedula = preg_replace('/[^0-9]/', '', (string)$value);
    }

    public function consultar(ConsultarPensionadoNativoAction $action): void
    {
        $this->cedula = preg_replace('/[^0-9]/', '', (string)$this->cedula);

        $this->validate([
            'nacionalidad' => 'required|in:V,E',
            'cedula' => 'required|numeric|min:1',
        ], [
            'cedula.required' => 'Debe ingresar el número de cédula del causante.',
            'cedula.numeric' => 'La cédula debe contener exclusivamente números.',
        ]);

        $this->busquedaRealizada = true;
        $this->errorMensaje = null;
        $this->pensionado = null;
        $this->mostrarCuentaCompleta = false;

        try {
            $resultado = $action->execute([
                'nacionalidad' => $this->nacionalidad,
                'cedula' => $this->cedula,
            ]);

            if ($resultado['success'] ?? false) {
                $this->pensionado = $resultado['data'];
            } else {
                $this->errorMensaje = $resultado['message'] ?? 'No se encontró pensión asociada a la cédula consultada.';
            }
        } catch (\Throwable $e) {
            $this->errorMensaje = 'Ocurrió un error al procesar la consulta. Por favor intente más tarde.';
        }
    }

    public function toggleCuenta(): void
    {
        $this->mostrarCuentaCompleta = !$this->mostrarCuentaCompleta;
    }

    public function limpiar(): void
    {
        $this->reset([
            'cedula',
            'pensionado',
            'errorMensaje',
            'busquedaRealizada',
            'mostrarCuentaCompleta',
        ]);
        $this->nacionalidad = 'V';
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.publico.consulta-pensionado');
    }
}
