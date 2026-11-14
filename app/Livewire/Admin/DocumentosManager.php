<?php

namespace App\Livewire\Admin;

use App\Models\DocumentoInstitucional;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
    public string $filtroEstado = ''; // 'subidos', 'pendientes'

    // Array de archivos temporales asociados por ID [doc_id => UploadedFile]
    public array $archivos = [];

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFiltroSeccion()
    {
        $this->resetPage();
    }

    public function updatingFiltroEstado()
    {
        $this->resetPage();
    }

    /**
     * Captura el evento de carga del archivo por ID de documento
     */
    public function updated($property, $value)
    {
        if (str_starts_with($property, 'archivos.')) {
            $id = (int) str_replace('archivos.', '', $property);
            $this->guardarArchivoDocumento($id, $value);
        }
    }

    /**
     * Guarda el archivo seleccionado directamente en el documento correspondiente
     */
    public function guardarArchivoDocumento(int $id, $file)
    {
        if (auth()->check() && !auth()->user()->can('documentos.crear') && !auth()->user()->can('documentos.editar')) {
            abort(403, 'No tienes permiso para subir archivos.');
        }

        if (!$file || !is_object($file) || !method_exists($file, 'getClientOriginalName')) {
            return;
        }

        $doc = DocumentoInstitucional::findOrFail($id);

        $validator = Validator::make(
            ['archivo' => $file],
            ['archivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar|max:51200'],
            [
                'archivo.required' => 'Debe seleccionar un archivo.',
                'archivo.file' => 'El archivo no es válido.',
                'archivo.mimes' => 'Formato no permitido. Solo se aceptan archivos PDF, Word (doc, docx), Excel (xls, xlsx) o Comprimidos (zip, rar).',
                'archivo.max' => 'El archivo no debe exceder los 50MB.',
            ]
        );

        if ($validator->fails()) {
            $this->addError("archivos.{$id}", $validator->errors()->first('archivo'));
            return;
        }

        // Si ya tenía un archivo en el storage, eliminarlo
        if ($doc->archivo_path && Storage::disk('public')->exists($doc->archivo_path)) {
            Storage::disk('public')->delete($doc->archivo_path);
        }

        $originalName = $file->getClientOriginalName();
        $formato = strtolower($file->getClientOriginalExtension());
        $tamano = $file->getSize();

        // Guardar archivo en disco público dentro de la sección correspondiente
        $path = $file->store('documentos/' . $doc->seccion, 'public');

        $doc->update([
            'archivo_path' => $path,
            'archivo_nombre_original' => $originalName,
            'formato' => $formato,
            'tamano_bytes' => $tamano,
        ]);

        unset($this->archivos[$id]);

        session()->flash('success', "Archivo subido correctamente para '{$doc->titulo}'.");
    }

    /**
     * Remueve el archivo adjunto y devuelve el documento al estado pendiente
     */
    public function quitarArchivo(int $id)
    {
        if (auth()->check() && !auth()->user()->can('documentos.eliminar') && !auth()->user()->can('documentos.editar')) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        $doc = DocumentoInstitucional::findOrFail($id);

        if ($doc->archivo_path && Storage::disk('public')->exists($doc->archivo_path)) {
            Storage::disk('public')->delete($doc->archivo_path);
        }

        $doc->update([
            'archivo_path' => null,
            'archivo_nombre_original' => null,
            'formato' => null,
            'tamano_bytes' => null,
        ]);

        session()->flash('success', "Archivo removido para '{$doc->titulo}'. El documento figura como no subido.");
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

        if ($this->filtroEstado === 'subidos') {
            $query->whereNotNull('archivo_path');
        } elseif ($this->filtroEstado === 'pendientes') {
            $query->whereNull('archivo_path');
        }

        $documentos = $query->orderBy('seccion')
                            ->orderBy('categoria')
                            ->orderBy('orden')
                            ->orderBy('id', 'asc')
                            ->paginate(20);

        $totales = [
            'total' => DocumentoInstitucional::count(),
            'subidos' => DocumentoInstitucional::whereNotNull('archivo_path')->count(),
            'pendientes' => DocumentoInstitucional::whereNull('archivo_path')->count(),
            'marco' => DocumentoInstitucional::where('seccion', DocumentoInstitucional::SECCION_MARCO_NORMATIVO)->count(),
            'contrataciones' => DocumentoInstitucional::where('seccion', DocumentoInstitucional::SECCION_CONTRATACIONES)->count(),
            'formas' => DocumentoInstitucional::where('seccion', DocumentoInstitucional::SECCION_BIBLIOTECA_FORMAS)->count(),
        ];

        return view('livewire.admin.documentos-manager', [
            'titulo' => $this->titulo,
            'documentos' => $documentos,
            'totales' => $totales,
            'seccionesDisponibles' => DocumentoInstitucional::seccionesDisponibles(),
        ]);
    }
}
