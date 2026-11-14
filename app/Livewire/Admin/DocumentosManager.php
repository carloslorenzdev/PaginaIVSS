<?php

namespace App\Livewire\Admin;

use App\Models\DocumentoInstitucional;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Gestor de Documentos Institucionales')]
class DocumentosManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $titulo = 'Documentos Institucionales';

    // Filtros
    public string $search = '';
    public string $filtroSeccion = '';
    public string $filtroCategoria = '';
    public string $filtroEstado = '';

    // Modal Crear / Editar
    public bool $modalOpen = false;
    public ?int $editingId = null;
    public string $seccion = DocumentoInstitucional::SECCION_MARCO_NORMATIVO;
    public string $categoria = '';
    public string $nuevaCategoria = '';
    public string $docTitulo = '';
    public ?string $descripcion = null;
    public $archivo = null;
    public ?string $currentArchivo = null;
    public ?string $currentNombreOriginal = null;
    public ?string $currentFormato = null;
    public int $orden = 0;
    public bool $activo = true;

    // Modal Eliminar
    public bool $deleteModalOpen = false;
    public ?int $deletingId = null;
    public string $deletingTitulo = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFiltroSeccion()
    {
        $this->filtroCategoria = '';
        $this->resetPage();
    }

    public function updatingFiltroCategoria()
    {
        $this->resetPage();
    }

    public function updatingFiltroEstado()
    {
        $this->resetPage();
    }

    public function openCreateModal(?string $seccionDefault = null)
    {
        abort_if(!auth()->user()->can('documentos.crear'), 403, 'No tienes permiso para crear documentos.');

        $this->resetValidation();
        $this->editingId = null;
        $this->seccion = $seccionDefault ?: ($this->filtroSeccion ?: DocumentoInstitucional::SECCION_MARCO_NORMATIVO);
        $this->categoria = '';
        $this->nuevaCategoria = '';
        $this->docTitulo = '';
        $this->descripcion = '';
        $this->archivo = null;
        $this->currentArchivo = null;
        $this->currentNombreOriginal = null;
        $this->currentFormato = null;
        $this->orden = (DocumentoInstitucional::where('seccion', $this->seccion)->max('orden') ?? 0) + 1;
        $this->activo = true;
        $this->modalOpen = true;
    }

    public function openEditModal(int $id)
    {
        abort_if(!auth()->user()->can('documentos.editar'), 403, 'No tienes permiso para editar documentos.');

        $this->resetValidation();
        $doc = DocumentoInstitucional::findOrFail($id);

        $this->editingId = $doc->id;
        $this->seccion = $doc->seccion;
        $this->categoria = $doc->categoria;
        $this->nuevaCategoria = '';
        $this->docTitulo = $doc->titulo;
        $this->descripcion = $doc->descripcion;
        $this->archivo = null;
        $this->currentArchivo = $doc->archivo_path;
        $this->currentNombreOriginal = $doc->archivo_nombre_original;
        $this->currentFormato = $doc->formato;
        $this->orden = $doc->orden;
        $this->activo = (bool)$doc->activo;
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
        if ($this->editingId) {
            abort_if(!auth()->user()->can('documentos.editar'), 403, 'No tienes permiso para editar documentos.');
        } else {
            abort_if(!auth()->user()->can('documentos.crear'), 403, 'No tienes permiso para crear documentos.');
        }

        // Si escribió una nueva categoría, darle prioridad
        $catFinal = !empty(trim($this->nuevaCategoria)) ? trim($this->nuevaCategoria) : trim($this->categoria);

        $rules = [
            'seccion' => 'required|string|max:60',
            'docTitulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'orden' => 'required|integer|min:0',
            'archivo' => $this->editingId ? 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar|max:51200' : 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar|max:51200',
        ];

        if (empty($catFinal)) {
            $this->addError('categoria', 'Debe seleccionar o escribir una categoría para el documento.');
            return;
        }

        $this->validate($rules, [
            'seccion.required' => 'Debe seleccionar una sección del portal.',
            'docTitulo.required' => 'El título del documento es obligatorio.',
            'archivo.mimes' => 'El formato debe ser PDF, Word (doc, docx), Excel (xls, xlsx) o Comprimido (zip, rar).',
            'archivo.max' => 'El archivo no debe exceder los 50MB.',
        ]);

        $data = [
            'seccion' => $this->seccion,
            'categoria' => $catFinal,
            'titulo' => trim($this->docTitulo),
            'descripcion' => trim($this->descripcion ?: ''),
            'orden' => $this->orden,
            'activo' => $this->activo,
        ];

        // Procesar subida de archivo
        if ($this->archivo) {
            $originalName = $this->archivo->getClientOriginalName();
            $formato = strtolower($this->archivo->getClientOriginalExtension());
            $tamano = $this->archivo->getSize();

            // Guardar en storage/app/public/documentos/{seccion}
            $path = $this->archivo->store('documentos/' . $this->seccion, 'public');

            // Si estaba editando y tenía archivo anterior físico, eliminarlo
            if ($this->editingId && $this->currentArchivo && Storage::disk('public')->exists($this->currentArchivo)) {
                Storage::disk('public')->delete($this->currentArchivo);
            }

            $data['archivo_path'] = $path;
            $data['archivo_nombre_original'] = $originalName;
            $data['formato'] = $formato;
            $data['tamano_bytes'] = $tamano;
        }

        if ($this->editingId) {
            $doc = DocumentoInstitucional::findOrFail($this->editingId);
            $doc->update($data);
            session()->flash('success', 'Documento actualizado correctamente.');
        } else {
            DocumentoInstitucional::create($data);
            session()->flash('success', 'Documento registrado y publicado con éxito.');
        }

        $this->closeModal();
    }

    public function toggleActivo(int $id)
    {
        abort_if(!auth()->user()->can('documentos.editar'), 403, 'No tienes permiso para modificar este documento.');

        $doc = DocumentoInstitucional::findOrFail($id);
        $doc->activo = !$doc->activo;
        $doc->save();

        session()->flash('success', 'El estado del documento ha sido modificado.');
    }

    public function confirmDelete(int $id)
    {
        abort_if(!auth()->user()->can('documentos.eliminar'), 403, 'No tienes permiso para eliminar documentos.');

        $doc = DocumentoInstitucional::findOrFail($id);
        $this->deletingId = $doc->id;
        $this->deletingTitulo = $doc->titulo;
        $this->deleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->deleteModalOpen = false;
        $this->deletingId = null;
        $this->deletingTitulo = '';
        $this->dispatch('close-modal');
    }

    public function delete()
    {
        abort_if(!auth()->user()->can('documentos.eliminar'), 403, 'No tienes permiso para eliminar documentos.');

        if (!$this->deletingId) {
            return;
        }

        $doc = DocumentoInstitucional::findOrFail($this->deletingId);

        // Si tiene archivo en storage, eliminarlo
        if ($doc->archivo_path && Storage::disk('public')->exists($doc->archivo_path)) {
            Storage::disk('public')->delete($doc->archivo_path);
        }

        $doc->delete();

        session()->flash('success', 'El documento ha sido eliminado satisfactoriamente.');
        $this->closeDeleteModal();
    }

    public function getCategoriasDisponiblesProperty(): array
    {
        $seccionActiva = $this->modalOpen ? $this->seccion : $this->filtroSeccion;

        if (!empty($seccionActiva)) {
            $estandar = DocumentoInstitucional::categoriasPorSeccion($seccionActiva);
            $bd = DocumentoInstitucional::where('seccion', $seccionActiva)
                ->distinct()
                ->pluck('categoria')
                ->filter()
                ->toArray();
            return array_values(array_unique(array_merge($estandar, $bd)));
        }

        return DocumentoInstitucional::distinct()->pluck('categoria')->filter()->toArray();
    }

    public function render()
    {
        $query = DocumentoInstitucional::query();

        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('titulo', 'ilike', $term)
                  ->orWhere('categoria', 'ilike', $term)
                  ->orWhere('descripcion', 'ilike', $term);
            });
        }

        if (!empty($this->filtroSeccion)) {
            $query->where('seccion', $this->filtroSeccion);
        }

        if (!empty($this->filtroCategoria)) {
            $query->where('categoria', $this->filtroCategoria);
        }

        if ($this->filtroEstado === 'activos') {
            $query->where('activo', true);
        } elseif ($this->filtroEstado === 'inactivos') {
            $query->where('activo', false);
        }

        $documentos = $query->orderBy('seccion')
                            ->orderBy('categoria')
                            ->orderBy('orden')
                            ->orderBy('id', 'desc')
                            ->paginate(15);

        // Contadores para las tarjetas de resumen
        $totales = [
            'total' => DocumentoInstitucional::count(),
            'marco' => DocumentoInstitucional::where('seccion', DocumentoInstitucional::SECCION_MARCO_NORMATIVO)->count(),
            'contrataciones' => DocumentoInstitucional::where('seccion', DocumentoInstitucional::SECCION_CONTRATACIONES)->count(),
            'formas' => DocumentoInstitucional::where('seccion', DocumentoInstitucional::SECCION_BIBLIOTECA_FORMAS)->count(),
        ];

        return view('livewire.admin.documentos-manager', [
            'titulo' => $this->titulo,
            'documentos' => $documentos,
            'totales' => $totales,
            'seccionesDisponibles' => DocumentoInstitucional::seccionesDisponibles(),
            'categoriasDisponibles' => $this->categoriasDisponibles,
        ]);
    }
}

