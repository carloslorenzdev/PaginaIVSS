<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Carrusel;
use App\Models\Configuracion;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
#[Title('Gestionar Carrusel')]
class CarruselManager extends Component
{
    public int $intervalo = 5000;

    // Editing
    public ?int $editingId = null;
    public string $editTitulo = '';
    public string $editEnlace = '';
    public int $editOrden = 1;

    // Deleting
    public bool $deleteModalOpen = false;
    public ?int $deletingId = null;

    public function mount()
    {
        $config = Configuracion::where('clave', 'carrusel_intervalo')->first();
        $this->intervalo = $config ? (int)$config->valor : 5000;
    }

    public function guardarVelocidad()
    {
        abort_if(!auth()->user()->can('carrusel.editar'), 403, 'No tienes permiso para editar el carrusel.');

        Configuracion::updateOrCreate(
            ['clave' => 'carrusel_intervalo'],
            ['valor' => (string)$this->intervalo]
        );

        session()->flash('success', 'Velocidad del carrusel actualizada exitosamente.');
    }

    public function startEdit(int $id)
    {
        abort_if(!auth()->user()->can('carrusel.editar'), 403, 'No tienes permiso para editar el carrusel.');

        $carrusel = Carrusel::findOrFail($id);
        $this->editingId = $carrusel->id;
        $this->editTitulo = $carrusel->titulo ?? '';
        $this->editEnlace = $carrusel->enlace ?? '';
        $this->editOrden = $carrusel->orden ?? 1;
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->resetValidation();
    }

    public function guardarEdicion()
    {
        abort_if(!auth()->user()->can('carrusel.editar'), 403, 'No tienes permiso para editar el carrusel.');

        $this->validate([
            'editTitulo' => 'nullable|string|max:255',
            'editEnlace' => 'nullable|url|max:255',
            'editOrden' => 'required|integer|min:0',
        ], [
            'editEnlace.url' => 'El enlace debe tener un formato de URL válido.',
            'editOrden.required' => 'El orden es obligatorio.',
        ]);

        if ($this->editingId) {
            $carrusel = Carrusel::findOrFail($this->editingId);
            $carrusel->update([
                'titulo' => $this->editTitulo ?: null,
                'enlace' => $this->editEnlace ?: null,
                'orden' => $this->editOrden,
            ]);
            session()->flash('success', 'Detalles del elemento actualizados exitosamente.');
        }

        $this->editingId = null;
    }

    public function confirmDelete(int $id)
    {
        abort_if(!auth()->user()->can('carrusel.eliminar'), 403, 'No tienes permiso para eliminar del carrusel.');
        $this->deletingId = $id;
        $this->deleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->deleteModalOpen = false;
        $this->deletingId = null;
        $this->dispatch('close-modal');
    }

    public function delete()
    {
        abort_if(!auth()->user()->can('carrusel.eliminar'), 403, 'No tienes permiso para eliminar del carrusel.');

        if ($this->deletingId) {
            $carrusel = Carrusel::findOrFail($this->deletingId);
            if ($carrusel->imagen_ruta && Storage::disk('public')->exists($carrusel->imagen_ruta)) {
                Storage::disk('public')->delete($carrusel->imagen_ruta);
            }
            $carrusel->delete();
            session()->flash('success', 'Elemento eliminado del carrusel exitosamente.');
        }

        $this->closeDeleteModal();
    }

    public function render()
    {
        abort_if(!auth()->user()->can('carrusel.ver'), 403, 'No tienes permiso para ver el carrusel.');

        $carruseles = Carrusel::orderBy('orden')->get();

        return view('livewire.admin.carrusel-manager', [
            'carruseles' => $carruseles,
        ]);
    }
}
