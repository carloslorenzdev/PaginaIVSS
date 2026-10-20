<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\ChatbotConocimiento;
use App\Actions\Admin\Chatbot\CrearConocimientoAction;
use App\Actions\Admin\Chatbot\ActualizarConocimientoAction;
use App\Actions\Admin\Chatbot\EliminarConocimientoAction;

#[Layout('layouts.app')]
#[Title('Base de Conocimientos')]
class ChatbotConocimientoManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filtroActivo = 'todos'; // 'todos', 'activos', 'inactivos'

    // Form modal state
    public bool $modalOpen = false;
    public ?int $editingId = null;
    public string $pregunta = '';
    public string $palabras_clave = '';
    public string $respuesta = '';
    public bool $activo = true;

    // Delete modal state
    public bool $deleteModalOpen = false;
    public ?int $deletingId = null;
    public string $deletingPregunta = '';

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        return [
            'pregunta' => 'required|string|max:255',
            'palabras_clave' => 'required|string|max:255',
            'respuesta' => 'required|string',
            'activo' => 'boolean',
        ];
    }

    protected $messages = [
        'pregunta.required' => 'La pregunta o título es obligatorio.',
        'palabras_clave.required' => 'Debe ingresar al menos una palabra clave.',
        'respuesta.required' => 'La respuesta del bot es obligatoria.',
    ];

    public function mount()
    {
        // Si viene con parámetro ?pregunta=... desde preguntas sin respuesta
        if (request()->has('pregunta')) {
            $this->openCreateModal(request()->query('pregunta'));
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFiltroActivo()
    {
        $this->resetPage();
    }

    public function openCreateModal(?string $preguntaInicial = '')
    {
        abort_if(!auth()->user()->can('chatbot_conocimiento.crear'), 403, 'Acceso Denegado');
        $this->resetValidation();
        $this->editingId = null;
        $this->pregunta = $preguntaInicial ?? '';
        $this->palabras_clave = '';
        $this->respuesta = '';
        $this->activo = true;
        $this->modalOpen = true;
    }

    public function openEditModal(int $id)
    {
        abort_if(!auth()->user()->can('chatbot_conocimiento.editar'), 403, 'Acceso Denegado');
        $this->resetValidation();
        $item = ChatbotConocimiento::findOrFail($id);
        $this->editingId = $item->id;
        $this->pregunta = $item->pregunta;
        $this->palabras_clave = $item->palabras_clave;
        $this->respuesta = $item->respuesta;
        $this->activo = (bool)$item->activo;
        $this->modalOpen = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->resetValidation();
        $this->dispatch('close-modal');
    }

    public function save(CrearConocimientoAction $crearAction, ActualizarConocimientoAction $actualizarAction)
    {
        $validated = $this->validate();

        if ($this->editingId) {
            abort_if(!auth()->user()->can('chatbot_conocimiento.editar'), 403, 'Acceso Denegado');
            $conocimiento = ChatbotConocimiento::findOrFail($this->editingId);
            $actualizarAction->execute($conocimiento, $validated);
            session()->flash('success', 'Conocimiento actualizado exitosamente.');
        } else {
            abort_if(!auth()->user()->can('chatbot_conocimiento.crear'), 403, 'Acceso Denegado');
            $crearAction->execute($validated);
            session()->flash('success', 'Conocimiento agregado exitosamente.');
        }

        $this->closeModal();
    }

    public function toggleActivo(int $id)
    {
        abort_if(!auth()->user()->can('chatbot_conocimiento.editar'), 403, 'Acceso Denegado');
        $item = ChatbotConocimiento::findOrFail($id);
        $item->activo = !$item->activo;
        $item->save();
    }

    public function confirmDelete(int $id)
    {
        abort_if(!auth()->user()->can('chatbot_conocimiento.eliminar'), 403, 'Acceso Denegado');
        $item = ChatbotConocimiento::findOrFail($id);
        $this->deletingId = $item->id;
        $this->deletingPregunta = $item->pregunta;
        $this->deleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->deleteModalOpen = false;
        $this->deletingId = null;
        $this->deletingPregunta = '';
        $this->dispatch('close-modal');
    }

    public function delete(EliminarConocimientoAction $eliminarAction)
    {
        abort_if(!auth()->user()->can('chatbot_conocimiento.eliminar'), 403, 'Acceso Denegado');
        if ($this->deletingId) {
            $item = ChatbotConocimiento::findOrFail($this->deletingId);
            $eliminarAction->execute($item);
            session()->flash('success', 'Conocimiento eliminado exitosamente.');
        }
        $this->closeDeleteModal();
    }

    public function render()
    {
        abort_if(!auth()->user()->can('chatbot_conocimiento.ver'), 403, 'Acceso Denegado');

        $query = ChatbotConocimiento::query();

        if ($this->filtroActivo === 'activos') {
            $query->where('activo', true);
        } elseif ($this->filtroActivo === 'inactivos') {
            $query->where('activo', false);
        }

        if (trim($this->search) !== '') {
            $s = strtolower(trim($this->search));
            $query->where(function ($q) use ($s) {
                $q->whereRaw('LOWER(pregunta) LIKE ?', ["%{$s}%"])
                  ->orWhereRaw('LOWER(palabras_clave) LIKE ?', ["%{$s}%"])
                  ->orWhereRaw('LOWER(respuesta) LIKE ?', ["%{$s}%"]);
            });
        }

        $conocimientos = $query->orderBy('id', 'desc')->paginate(12);

        return view('livewire.admin.chatbot-conocimiento-manager', [
            'conocimientos' => $conocimientos,
        ]);
    }
}
