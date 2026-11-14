<?php

namespace App\Livewire\Publico;

use App\Models\DocumentoInstitucional;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app-public')]
#[Title('Biblioteca de Formas - IVSS')]
class BibliotecaFormas extends Component
{
    public function render()
    {
        $configCategorias = [
            'Formas' => ['icono' => 'fas fa-file-invoice', 'color' => 'success'],
            'Instructivo de Formas' => ['icono' => 'fas fa-book-open', 'color' => 'info'],
        ];

        $docsDb = DocumentoInstitucional::porSeccion(DocumentoInstitucional::SECCION_BIBLIOTECA_FORMAS)
            ->activos()
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        $categorias = [];

        foreach ($configCategorias as $catNombre => $meta) {
            $categorias[$catNombre] = [
                'icono' => $meta['icono'],
                'color' => $meta['color'],
                'documentos' => [],
            ];
        }

        foreach ($docsDb as $doc) {
            $cat = $doc->categoria ?: 'Formas';
            if (!isset($categorias[$cat])) {
                $categorias[$cat] = [
                    'icono' => 'fas fa-folder',
                    'color' => 'primary',
                    'documentos' => [],
                ];
            }

            $categorias[$cat]['documentos'][] = [
                'id' => $doc->id,
                'titulo' => $doc->titulo,
                'descripcion' => $doc->descripcion,
                'url' => $doc->url,
                'formato' => $doc->formato,
                'icono_formato' => $doc->icono_formato,
                'tamano' => $doc->tamano_formateado,
                'disponible' => $doc->tiene_archivo,
                'reciente' => $doc->es_reciente,
            ];
        }

        return view('livewire.publico.biblioteca-formas', compact('categorias'));
    }
}
