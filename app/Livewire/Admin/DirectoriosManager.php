<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;
use App\Models\Directorio;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Parroquia;

class DirectoriosManager extends Component
{
    use WithPagination;

    public string $tipo = '';
    public string $search = '';
    public string $filtroEstado = '';

    // Modal Create / Edit
    public bool $modalOpen = false;
    public ?int $editingId = null;
    public ?int $id_estado = null;
    public ?int $id_municipio = null;
    public ?int $id_parroquia = null;
    public string $estado = '';
    public string $municipio = '';
    public string $parroquia = '';
    public string $nombre = '';
    public string $direccion = '';
    public string $telefono = '';

    // Colecciones dependientes
    public $municipios = [];
    public $parroquias = [];

    // Modal Delete
    public bool $deleteModalOpen = false;
    public ?int $deletingId = null;
    public string $deletingNombre = '';

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        return [
            'tipo' => 'required|in:farmacia,centro_salud,oficina_administrativa',
            'id_estado' => 'required|exists:nestado,idestado',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string|max:255',
        ];
    }

    protected $messages = [
        'id_estado.required' => 'Debe seleccionar un estado.',
        'nombre.required' => 'El nombre es obligatorio.',
        'direccion.required' => 'La dirección es obligatoria.',
    ];

    public function mount(string $tipo = '')
    {
        $this->tipo = $tipo ?: request('tipo', 'centro_salud');
        $this->filtroEstado = request('estado', '');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFiltroEstado()
    {
        $this->resetPage();
    }

    public function updatedIdEstado($value, \App\Actions\Admin\Directorios\ObtenerMunicipiosPorEstadoAction $action)
    {
        $this->id_municipio = null;
        $this->id_parroquia = null;
        $this->municipio = '';
        $this->parroquia = '';
        $this->parroquias = [];

        if ($value) {
            $estadoModel = Estado::find($value);
            $this->estado = $estadoModel ? $estadoModel->estado : '';
            $this->municipios = $action->execute((int) $value);
        } else {
            $this->estado = '';
            $this->municipios = [];
        }
    }

    public function updatedIdMunicipio($value, \App\Actions\Admin\Directorios\ObtenerParroquiasPorMunicipioAction $action)
    {
        $this->id_parroquia = null;
        $this->parroquia = '';

        if ($value) {
            $munModel = Municipio::find($value);
            $this->municipio = $munModel ? $munModel->municipio : '';
            $this->parroquias = $action->execute((int) $value);
        } else {
            $this->municipio = '';
            $this->parroquias = [];
        }
    }

    public function updatedIdParroquia($value)
    {
        if ($value) {
            $parrModel = Parroquia::find($value);
            $this->parroquia = $parrModel ? $parrModel->parroquia : '';
        } else {
            $this->parroquia = '';
        }
    }

    public function openCreateModal()
    {
        abort_if(!auth()->user()->can('directorios.crear'), 403, 'Acceso Denegado');
        $this->resetValidation();
        $this->editingId = null;
        $this->id_estado = null;
        $this->id_municipio = null;
        $this->id_parroquia = null;
        $this->estado = '';
        $this->municipio = '';
        $this->parroquia = '';
        $this->nombre = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->municipios = [];
        $this->parroquias = [];
        $this->modalOpen = true;
    }

    public function openEditModal(int $id, \App\Actions\Admin\Directorios\ObtenerMunicipiosPorEstadoAction $munAction, \App\Actions\Admin\Directorios\ObtenerParroquiasPorMunicipioAction $parrAction)
    {
        abort_if(!auth()->user()->can('directorios.editar'), 403, 'Acceso Denegado');
        $this->resetValidation();
        $directorio = Directorio::findOrFail($id);
        $this->editingId = $directorio->id;
        $this->tipo = $directorio->tipo;
        $this->id_estado = $directorio->id_estado;
        $this->id_municipio = $directorio->id_municipio;
        $this->id_parroquia = $directorio->id_parroquia;
        $this->estado = $directorio->estado;
        $this->municipio = $directorio->municipio ?? '';
        $this->parroquia = $directorio->parroquia ?? '';
        $this->nombre = $directorio->nombre;
        $this->direccion = $directorio->direccion;
        $this->telefono = $directorio->telefono ?? '';

        // Si no tenía id_estado asignado pero tenía el nombre del estado en texto:
        if (!$this->id_estado && $this->estado) {
            $estMatch = Estado::where('idpaisfk', 1)
                ->whereRaw('LOWER(estado) = ?', [mb_strtolower(trim($this->estado), 'UTF-8')])
                ->first();
            if ($estMatch) {
                $this->id_estado = $estMatch->idestado;
            }
        }

        if ($this->id_estado) {
            $this->municipios = $munAction->execute((int) $this->id_estado);
        } else {
            $this->municipios = [];
        }

        if ($this->id_municipio) {
            $this->parroquias = $parrAction->execute((int) $this->id_municipio);
        } else {
            $this->parroquias = [];
        }

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
        $this->validate();

        if ($this->id_estado) {
            $estModel = Estado::find($this->id_estado);
            $this->estado = $estModel ? $estModel->estado : $this->estado;
        }

        if ($this->id_municipio) {
            $munModel = Municipio::find($this->id_municipio);
            $this->municipio = $munModel ? $munModel->municipio : '';
        } else {
            $this->municipio = '';
        }

        if ($this->id_parroquia) {
            $parrModel = Parroquia::find($this->id_parroquia);
            $this->parroquia = $parrModel ? $parrModel->parroquia : '';
        } else {
            $this->parroquia = '';
        }

        $data = [
            'tipo' => $this->tipo,
            'estado' => $this->estado,
            'municipio' => $this->municipio ?: null,
            'parroquia' => $this->parroquia ?: null,
            'id_estado' => $this->id_estado,
            'id_municipio' => $this->id_municipio,
            'id_parroquia' => $this->id_parroquia,
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono ?: null,
        ];

        if ($this->editingId) {
            abort_if(!auth()->user()->can('directorios.editar'), 403, 'Acceso Denegado');
            $directorio = Directorio::findOrFail($this->editingId);
            $directorio->update($data);
            session()->flash('success', 'Locación actualizada exitosamente.');
        } else {
            abort_if(!auth()->user()->can('directorios.crear'), 403, 'Acceso Denegado');
            Directorio::create($data);
            session()->flash('success', 'Locación registrada exitosamente.');
        }

        $this->modalOpen = false;
        $this->dispatch('close-modal');
    }

    public function confirmDelete(int $id)
    {
        abort_if(!auth()->user()->can('directorios.eliminar'), 403, 'Acceso Denegado');
        $directorio = Directorio::findOrFail($id);
        $this->deletingId = $directorio->id;
        $this->deletingNombre = $directorio->nombre;
        $this->deleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->deleteModalOpen = false;
        $this->deletingId = null;
        $this->deletingNombre = '';
        $this->dispatch('close-modal');
    }

    public function delete()
    {
        abort_if(!auth()->user()->can('directorios.eliminar'), 403, 'Acceso Denegado');
        if ($this->deletingId) {
            $directorio = Directorio::findOrFail($this->deletingId);
            $directorio->delete();
            session()->flash('success', 'Locación eliminada exitosamente.');
        }

        $this->closeDeleteModal();
    }

    public function render()
    {
        abort_if(!auth()->user()->can('directorios.ver'), 403, 'Acceso Denegado');

        $query = Directorio::query();

        if ($this->tipo) {
            $query->where('tipo', $this->tipo);
        }

        if ($this->filtroEstado) {
            $query->where('estado', $this->filtroEstado);
        }

        if (trim($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('nombre', 'like', $term)
                  ->orWhere('direccion', 'like', $term)
                  ->orWhere('municipio', 'like', $term)
                  ->orWhere('parroquia', 'like', $term)
                  ->orWhere('telefono', 'like', $term);
            });
        }

        $directorios = $query->orderBy('estado')->orderBy('nombre')->paginate(15);

        // Lista de estados en caché
        $estadosList = Cache::rememberForever('estados_venezuela_list_admin', function () {
            return Estado::where('idpaisfk', 1)
                ->select('idestado', 'estado')
                ->orderBy('estado')
                ->get();
        });

        $titulo = 'Directorios';
        if ($this->tipo === 'farmacia') $titulo = 'Farmacias';
        if ($this->tipo === 'centro_salud') $titulo = 'Centros de Salud';
        if ($this->tipo === 'oficina_administrativa') $titulo = 'Oficinas Administrativas';

        return view('livewire.admin.directorios-manager', [
            'directorios' => $directorios,
            'estadosList' => $estadosList,
            'titulo' => $titulo,
        ])->layout('layouts.app', ['title' => $titulo]);
    }
}
