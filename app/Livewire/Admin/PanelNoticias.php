<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Lazy;
use App\Models\Noticia;
use App\Models\Visita;
use App\Actions\Admin\Noticias\EliminarNoticiaAction;
use App\Actions\Admin\Noticias\TogglePublicacionNoticiaAction;

#[Layout('layouts.app')]
#[Title('Panel Principal')]
class PanelNoticias extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filtroEstado = 'todos'; // todos, publicadas, borradores

    // Modal Eliminar
    public ?int $deletingId = null;
    public string $deletingTitulo = '';

    // Modal Aprobar
    public ?int $aprobarId = null;
    public string $aprobarTitulo = '';
    public string $aprobarResumen = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFiltroEstado()
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id)
    {
        abort_if(!auth()->user()->can('noticias.eliminar'), 403, 'No tienes permiso para eliminar noticias.');
        $noticia = Noticia::findOrFail($id);
        $this->deletingId = $noticia->id;
        $this->deletingTitulo = $noticia->titulo;
    }

    public function closeDeleteModal()
    {
        $this->deletingId = null;
        $this->deletingTitulo = '';
        $this->dispatch('close-modal');
    }

    public function delete(EliminarNoticiaAction $action)
    {
        abort_if(!auth()->user()->can('noticias.eliminar'), 403, 'No tienes permiso para eliminar noticias.');
        if ($this->deletingId) {
            $action->execute($this->deletingId);
            session()->flash('success', 'Noticia eliminada correctamente.');
        }
        $this->closeDeleteModal();
    }

    public function abrirAprobar(int $id)
    {
        abort_if(!auth()->user()->can('noticias.publicar'), 403, 'No tienes permiso para publicar noticias.');
        $noticia = Noticia::findOrFail($id);
        $this->aprobarId = $noticia->id;
        $this->aprobarTitulo = $noticia->titulo;
        $this->aprobarResumen = $noticia->resumen ?? '';
    }

    public function cerrarAprobar()
    {
        $this->aprobarId = null;
        $this->aprobarTitulo = '';
        $this->aprobarResumen = '';
        $this->dispatch('close-modal');
    }

    public function confirmarPublicacion(bool $montarCarrusel = false, string $tipoFecha = 'inmediata', ?string $fechaProgramada = null, ?int $noticiaId = null, ?TogglePublicacionNoticiaAction $action = null)
    {
        abort_if(!auth()->user()->can('noticias.publicar'), 403, 'No tienes permiso para publicar noticias.');

        $action = $action ?? app(TogglePublicacionNoticiaAction::class);
        $id = $noticiaId ?: $this->aprobarId;

        if ($id) {
            $data = [
                'montar_carrusel' => (bool)$montarCarrusel,
            ];
            if ($tipoFecha === 'programada' && !empty($fechaProgramada)) {
                $data['fecha_programada'] = $fechaProgramada;
            }
            $action->execute($id, $data);
            session()->flash('success', 'Noticia publicada correctamente.');
        }

        $this->cerrarAprobar();
    }

    public function despublicar(int $id, TogglePublicacionNoticiaAction $action)
    {
        abort_if(!auth()->user()->can('noticias.publicar'), 403, 'No tienes permiso para despublicar noticias.');
        $action->execute($id, []);
        session()->flash('success', 'Noticia enviada a borrador.');
    }

    public function render()
    {
        abort_if(!auth()->user()->can('admin.panel'), 403, 'No tienes permiso para ver el panel de administración.');

        // Eager load de la relación M:M actual `categorias` en lugar de la deprecada `categoria`
        $query = Noticia::with(['categorias', 'autor']);

        if (trim($this->search) !== '') {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('titulo', 'like', $term)
                  ->orWhere('resumen', 'like', $term)
                  ->orWhereHas('categorias', function ($cq) use ($term) {
                      $cq->where('nombre', 'like', $term);
                  });
            });
        }

        if ($this->filtroEstado === 'publicadas') {
            $query->where('publicado', true);
        } elseif ($this->filtroEstado === 'borradores') {
            $query->where('publicado', false);
        }

        $noticias = $query->orderBy('id', 'desc')->paginate(12);

        $publicadas    = Noticia::where('publicado', true)->count();
        $visitasHoy    = Visita::whereDate('fecha', today())->count();
        $visitasMes    = Visita::whereMonth('fecha', today()->month)->count();
        $visitasTotales = Visita::count();

        return view('livewire.admin.panel-noticias', [
            'noticias'       => $noticias,
            'publicadas'    => $publicadas,
            'visitasHoy'    => $visitasHoy,
            'visitasMes'    => $visitasMes,
            'visitasTotales' => $visitasTotales,
        ]);
    }
}
