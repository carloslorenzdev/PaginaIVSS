<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\ChatbotPreguntaSinRespuesta;

#[Layout('layouts.app')]
#[Title('Preguntas sin Respuesta')]
class PreguntasSinRespuestaManager extends Component
{
    use WithPagination;

    public bool $deleteModalOpen = false;
    public ?int $deletingId = null;
    public string $deletingPregunta = '';

    protected $paginationTheme = 'tailwind';

    public function confirmDelete(int $id)
    {
        abort_if(!auth()->user()->can('chatbot_preguntas.eliminar'), 403, 'Acceso Denegado');
        $item = ChatbotPreguntaSinRespuesta::findOrFail($id);
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

    public function delete()
    {
        abort_if(!auth()->user()->can('chatbot_preguntas.eliminar'), 403, 'Acceso Denegado');
        if ($this->deletingId) {
            $item = ChatbotPreguntaSinRespuesta::findOrFail($this->deletingId);
            $item->delete();
            session()->flash('success', 'Pregunta sin respuesta eliminada correctamente.');
        }
        $this->closeDeleteModal();
    }

    public function entrenarYRemover(int $id)
    {
        abort_if(!auth()->user()->can('chatbot_preguntas.eliminar'), 403, 'Acceso Denegado');
        $item = ChatbotPreguntaSinRespuesta::findOrFail($id);
        $pregunta = $item->pregunta;
        $item->delete();

        return $this->redirect(route('admin.chatbot.conocimiento.index', ['pregunta' => $pregunta]), navigate: true);
    }

    public function render()
    {
        abort_if(!auth()->user()->can('chatbot_preguntas.ver'), 403, 'Acceso Denegado');

        $preguntas = ChatbotPreguntaSinRespuesta::orderBy('id', 'desc')->paginate(15);

        return view('livewire.admin.preguntas-sin-respuesta-manager', [
            'preguntas' => $preguntas,
        ]);
    }
}
