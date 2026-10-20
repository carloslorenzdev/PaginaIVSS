<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Revista;
use App\Actions\Admin\Revistas\GuardarRevistaAction;
use App\Actions\Admin\Revistas\ActualizarRevistaAction;
use App\Actions\Admin\Revistas\EliminarRevistaAction;
use App\Actions\Admin\Revistas\TogglePublicacionRevistaAction;

#[Layout('layouts.app')]
#[Title('Revistas Digitales')]
class RevistasManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';

    // Modal Create / Edit
    public bool $modalOpen = false;
    public ?int $editingId = null;
    public string $titulo = '';
    public string $edicion = '';
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
        abort_if(!auth()->user()->can('revistas.crear'), 403, 'No tienes permiso para crear revistas.');
        $this->resetValidation();
        $this->editingId = null;
        $this->titulo = '';
        $this->edicion = '';
        $this->fecha_publicacion = date('Y-m-d');
        $this->archivo_pdf = null;
        $this->currentPdf = null;
        $this->currentImage = null;
        $this->modalOpen = true;
    }

    public function openEditModal(int $id)
    {
        abort_if(!auth()->user()->can('revistas.editar'), 403, 'No tienes permiso para editar revistas.');
        $this->resetValidation();
        $revista = Revista::findOrFail($id);
        $this->editingId = $revista->id;
        $this->titulo = $revista->titulo;
        $this->edicion = $revista->edicion ?? '';
        $this->fecha_publicacion = $revista->fecha_publicacion ? $revista->fecha_publicacion->format('Y-m-d') : date('Y-m-d');
        $this->archivo_pdf = null;
        $this->currentPdf = $revista->archivo_pdf;
        $this->currentImage = $revista->imagen_preview;
        $this->modalOpen = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->resetValidation();
        $this->dispatch('close-modal');
    }

    public function save(GuardarRevistaAction $guardarAction, ActualizarRevistaAction $actualizarAction)
    {
        $rules = [
            'titulo' => 'required|string|max:255',
            'edicion' => 'nullable|string|max:255',
            'fecha_publicacion' => 'required|date',
            'archivo_pdf' => $this->editingId ? 'nullable|file|mimes:pdf|max:20480' : 'required|file|mimes:pdf|max:20480',
        ];

        $messages = [
            'titulo.required' => 'El título es obligatorio.',
            'fecha_publicacion.required' => 'La fecha de publicación es obligatoria.',
            'archivo_pdf.required' => 'Debe adjuntar el archivo PDF de la revista.',
            'archivo_pdf.mimes' => 'El archivo debe ser un documento en formato PDF.',
            'archivo_pdf.max' => 'El archivo PDF no debe exceder los 20MB.',
        ];

        $this->validate($rules, $messages);

        if ($this->editingId) {
            abort_if(!auth()->user()->can('revistas.editar'), 403, 'No tienes permiso para editar revistas.');
            $revista = Revista::findOrFail($this->editingId);
            $data = [
                'titulo' => $this->titulo,
                'edicion' => $this->edicion ?: null,
                'fecha_publicacion' => $this->fecha_publicacion,
            ];
            if ($this->archivo_pdf) {
                $data['archivo_pdf'] = $this->archivo_pdf;
            }
            $actualizarAction->execute($revista, $data);
            session()->flash('success', 'Revista actualizada exitosamente.');
        } else {
            abort_if(!auth()->user()->can('revistas.crear'), 403, 'No tienes permiso para crear revistas.');
            $guardarAction->execute([
                'titulo' => $this->titulo,
                'edicion' => $this->edicion ?: null,
                'fecha_publicacion' => $this->fecha_publicacion,
                'archivo_pdf' => $this->archivo_pdf,
            ]);
            session()->flash('success', 'Revista subida exitosamente.');
        }

        $this->modalOpen = false;
        $this->dispatch('close-modal');
    }

    public function togglePublicacion(int $id, TogglePublicacionRevistaAction $action)
    {
        abort_if(!auth()->user()->can('revistas.editar'), 403, 'No tienes permiso para cambiar el estado de publicación.');
        $revista = Revista::findOrFail($id);
        $action->execute($revista);
        session()->flash('success', 'Estado de la revista actualizado.');
    }

    public function confirmDelete(int $id)
    {
        abort_if(!auth()->user()->can('revistas.eliminar'), 403, 'No tienes permiso para eliminar revistas.');
        $revista = Revista::findOrFail($id);
        $this->deletingId = $revista->id;
        $this->deletingTitulo = $revista->titulo;
        $this->deleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->deleteModalOpen = false;
        $this->deletingId = null;
        $this->deletingTitulo = '';
        $this->dispatch('close-modal');
    }

    public function delete(EliminarRevistaAction $action)
    {
        abort_if(!auth()->user()->can('revistas.eliminar'), 403, 'No tienes permiso para eliminar revistas.');
        if ($this->deletingId) {
            $revista = Revista::findOrFail($this->deletingId);
            $action->execute($revista);
            session()->flash('success', 'Revista eliminada exitosamente.');
        }
        $this->closeDeleteModal();
    }

    public function render()
    {
        abort_if(!auth()->user()->can('revistas.ver'), 403, 'No tienes permiso para ver revistas.');

        $query = Revista::query();

        if (trim($this->search) !== '') {
            $s = '%' . trim($this->search) . '%';
            $query->where('titulo', 'like', $s)
                  ->orWhere('edicion', 'like', $s)
                  ->orWhere('descripcion', 'like', $s);
        }

        $revistas = $query->orderBy('fecha_publicacion', 'desc')->paginate(10);

        return view('livewire.admin.revistas-manager', [
            'revistas' => $revistas,
        ]);
    }
}
