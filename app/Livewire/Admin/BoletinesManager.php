<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Boletin;
use App\Actions\Admin\Boletines\GuardarBoletinAction;
use App\Actions\Admin\Boletines\ActualizarBoletinAction;
use App\Actions\Admin\Boletines\EliminarBoletinAction;
use App\Actions\Admin\Boletines\TogglePublicacionBoletinAction;

#[Layout('layouts.app')]
#[Title('Boletines Informativos')]
class BoletinesManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';

    // Modal Create / Edit
    public bool $modalOpen = false;
    public ?int $editingId = null;
    public string $titulo = '';
    public string $fecha_publicacion = '';
    public $archivo_pdf = null;
    public ?string $currentPdf = null;
    public ?string $currentImage = null;

    // Modal Delete
    public bool $deleteModalOpen = false;
    public ?int $deletingId = null;
    public string $deletingTitulo = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        abort_if(!auth()->user()->can('boletines.crear'), 403, 'No tienes permiso para crear boletines.');
        $this->resetValidation();
        $this->editingId = null;
        $this->titulo = '';
        $this->fecha_publicacion = date('Y-m-d');
        $this->archivo_pdf = null;
        $this->currentPdf = null;
        $this->currentImage = null;
        $this->modalOpen = true;
    }

    public function openEditModal(int $id)
    {
        abort_if(!auth()->user()->can('boletines.editar'), 403, 'No tienes permiso para editar boletines.');
        $this->resetValidation();
        $boletin = Boletin::findOrFail($id);
        $this->editingId = $boletin->id;
        $this->titulo = $boletin->titulo;
        $this->fecha_publicacion = $boletin->fecha_publicacion ? $boletin->fecha_publicacion->format('Y-m-d') : date('Y-m-d');
        $this->archivo_pdf = null;
        $this->currentPdf = $boletin->archivo_pdf;
        $this->currentImage = $boletin->imagen_preview;
        $this->modalOpen = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->resetValidation();
        $this->dispatch('close-modal');
    }

    public function save(GuardarBoletinAction $guardarAction, ActualizarBoletinAction $actualizarAction)
    {
        $rules = [
            'titulo' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date',
            'archivo_pdf' => $this->editingId ? 'nullable|file|mimes:pdf|max:20480' : 'required|file|mimes:pdf|max:20480',
        ];

        $messages = [
            'titulo.required' => 'El título es obligatorio.',
            'fecha_publicacion.required' => 'La fecha de publicación es obligatoria.',
            'archivo_pdf.required' => 'Debe adjuntar el archivo PDF del boletín.',
            'archivo_pdf.mimes' => 'El archivo debe ser un documento en formato PDF.',
            'archivo_pdf.max' => 'El archivo PDF no debe exceder los 20MB.',
        ];

        $this->validate($rules, $messages);

        if ($this->editingId) {
            abort_if(!auth()->user()->can('boletines.editar'), 403, 'No tienes permiso para editar boletines.');
            $boletin = Boletin::findOrFail($this->editingId);
            $data = [
                'titulo' => $this->titulo,
                'fecha_publicacion' => $this->fecha_publicacion,
            ];
            if ($this->archivo_pdf) {
                $data['archivo_pdf'] = $this->archivo_pdf;
            }
            $actualizarAction->execute($boletin, $data);
            session()->flash('success', 'Boletín actualizado exitosamente.');
        } else {
            abort_if(!auth()->user()->can('boletines.crear'), 403, 'No tienes permiso para crear boletines.');
            $guardarAction->execute([
                'titulo' => $this->titulo,
                'fecha_publicacion' => $this->fecha_publicacion,
                'archivo_pdf' => $this->archivo_pdf,
            ]);
            session()->flash('success', 'Boletín subido exitosamente.');
        }

        $this->modalOpen = false;
    }

    public function togglePublicacion(int $id, TogglePublicacionBoletinAction $action)
    {
        abort_if(!auth()->user()->can('boletines.editar'), 403, 'No tienes permiso para cambiar el estado de publicación.');
        $boletin = Boletin::findOrFail($id);
        $action->execute($boletin);
        session()->flash('success', 'Estado del boletín actualizado.');
    }

    public function confirmDelete(int $id)
    {
        abort_if(!auth()->user()->can('boletines.eliminar'), 403, 'No tienes permiso para eliminar boletines.');
        $boletin = Boletin::findOrFail($id);
        $this->deletingId = $boletin->id;
        $this->deletingTitulo = $boletin->titulo;
        $this->deleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->deleteModalOpen = false;
        $this->deletingId = null;
        $this->deletingTitulo = '';
        $this->dispatch('close-modal');
    }

    public function delete(EliminarBoletinAction $action)
    {
        abort_if(!auth()->user()->can('boletines.eliminar'), 403, 'No tienes permiso para eliminar boletines.');
        if ($this->deletingId) {
            $boletin = Boletin::findOrFail($this->deletingId);
            $action->execute($boletin);
            session()->flash('success', 'Boletín eliminado exitosamente.');
        }
        $this->closeDeleteModal();
    }

    public function render()
    {
        abort_if(!auth()->user()->can('boletines.ver'), 403, 'No tienes permiso para ver boletines.');

        $query = Boletin::query();

        if (trim($this->search) !== '') {
            $s = '%' . trim($this->search) . '%';
            $query->where('titulo', 'like', $s)
                  ->orWhere('descripcion', 'like', $s);
        }

        $boletines = $query->orderBy('fecha_publicacion', 'desc')->paginate(10);

        return view('livewire.admin.boletines-manager', [
            'boletines' => $boletines,
        ]);
    }
}
