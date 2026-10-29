<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Categoria;
use Illuminate\Support\Str;

#[Layout('layouts.app')]
#[Title('Categorías')]
class CategoriasManager extends Component
{
    use WithPagination;

    public string $search = '';

    // Modal Create/Edit
    public bool $modalOpen = false;
    public ?int $editingId = null;
    public string $nombre = '';
    public string $descripcion = '';
    public int $orden = 0;
    public bool $activa = true;

    // Modal Delete
    public bool $deleteModalOpen = false;
    public ?int $deletingId = null;
    public string $deletingNombre = '';
    public int $deletingNoticiasCount = 0;

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden' => 'nullable|integer|min:0',
            'activa' => 'boolean',
        ];
    }

    protected $messages = [
        'nombre.required' => 'El nombre de la categoría es obligatorio.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        abort_if(!auth()->user()->can('categorias.crear'), 403, 'Acceso Denegado');
        $this->resetValidation();
        $this->editingId = null;
        $this->nombre = '';
        $this->descripcion = '';
        $this->orden = (Categoria::max('orden') ?? 0) + 1;
        $this->activa = true;
        $this->modalOpen = true;
    }

    public function openEditModal(int $id)
    {
        abort_if(!auth()->user()->can('categorias.editar'), 403, 'Acceso Denegado');
        $this->resetValidation();
        $cat = Categoria::findOrFail($id);
        $this->editingId = $cat->id;
        $this->nombre = $cat->nombre;
        $this->descripcion = $cat->descripcion ?? '';
        $this->orden = (int)$cat->orden;
        $this->activa = (bool)$cat->activa;
        $this->modalOpen = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->resetValidation();
        $this->dispatch('close-modal');
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->editingId) {
            abort_if(!auth()->user()->can('categorias.editar'), 403, 'Acceso Denegado');
            $categoria = Categoria::findOrFail($this->editingId);
            $categoria->update([
                'nombre' => $this->nombre,
                'slug' => Str::slug($this->nombre),
                'descripcion' => $this->descripcion,
                'orden' => $this->orden ?? 0,
                'activa' => $this->activa ? 1 : 0,
            ]);
            \App\Services\AuditoriaService::registrar(
                'edicion',
                "Actualizó la categoría: '{$categoria->nombre}'",
                $categoria,
                ['nombre' => $categoria->nombre]
            );
            session()->flash('success', 'Categoría actualizada exitosamente.');
        } else {
            abort_if(!auth()->user()->can('categorias.crear'), 403, 'Acceso Denegado');
            $categoria = Categoria::create([
                'nombre' => $this->nombre,
                'slug' => Str::slug($this->nombre),
                'descripcion' => $this->descripcion,
                'orden' => $this->orden ?? 0,
                'activa' => $this->activa ? 1 : 0,
            ]);
            \App\Services\AuditoriaService::registrar(
                'creacion',
                "Creó la categoría: '{$categoria->nombre}'",
                $categoria,
                ['nombre' => $categoria->nombre]
            );
            session()->flash('success', 'Categoría creada exitosamente.');
        }

        $this->closeModal();
    }

    public function toggleActiva(int $id)
    {
        abort_if(!auth()->user()->can('categorias.editar'), 403, 'Acceso Denegado');
        $cat = Categoria::findOrFail($id);
        $cat->activa = !$cat->activa;
        $cat->save();
    }

    public function confirmDelete(int $id)
    {
        abort_if(!auth()->user()->can('categorias.eliminar'), 403, 'Acceso Denegado');
        $cat = Categoria::withCount('noticias')->findOrFail($id);
        $this->deletingId = $cat->id;
        $this->deletingNombre = $cat->nombre;
        $this->deletingNoticiasCount = $cat->noticias_count;
        $this->deleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->deleteModalOpen = false;
        $this->deletingId = null;
        $this->deletingNombre = '';
        $this->deletingNoticiasCount = 0;
        $this->dispatch('close-modal');
    }

    public function delete()
    {
        abort_if(!auth()->user()->can('categorias.eliminar'), 403, 'Acceso Denegado');
        if ($this->deletingId) {
            $cat = Categoria::withCount('noticias')->findOrFail($this->deletingId);
            if ($cat->noticias_count > 0) {
                session()->flash('error', 'No puedes eliminar una categoría que tiene noticias asociadas.');
                $this->closeDeleteModal();
                return;
            }
            $nombre = $cat->nombre;
            $catId = $cat->id;
            $cat->delete();
            \App\Services\AuditoriaService::registrar(
                'eliminacion',
                "Eliminó la categoría: '{$nombre}' (ID: {$catId})",
                null,
                ['id' => $catId, 'nombre' => $nombre]
            );
            session()->flash('success', 'Categoría eliminada exitosamente.');
        }
        $this->closeDeleteModal();
    }

    public function render()
    {
        abort_if(!auth()->user()->can('categorias.ver'), 403, 'Acceso Denegado');

        $query = Categoria::withCount('noticias');

        if (trim($this->search) !== '') {
            $s = strtolower(trim($this->search));
            $query->where(function ($q) use ($s) {
                $q->whereRaw('LOWER(nombre) LIKE ?', ["%{$s}%"])
                  ->orWhereRaw('LOWER(descripcion) LIKE ?', ["%{$s}%"]);
            });
        }

        $categorias = $query->orderBy('orden', 'asc')->paginate(12);

        return view('livewire.admin.categorias-manager', [
            'categorias' => $categorias,
        ]);
    }
}
