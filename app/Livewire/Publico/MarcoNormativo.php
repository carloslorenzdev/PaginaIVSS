<?php

namespace App\Livewire\Publico;

use App\Models\DocumentoInstitucional;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app-public')]
#[Title('Marco Normativo - IVSS')]
class MarcoNormativo extends Component
{
    public function render()
    {
        $configCategorias = [
            'Decretos' => ['icono' => 'fas fa-balance-scale', 'color' => 'primary'],
            'Ley de Contrataciones' => ['icono' => 'fas fa-file-contract', 'color' => 'warning'],
            'Leyes Especiales' => ['icono' => 'fas fa-gavel', 'color' => 'danger'],
            'Leyes Orgánicas' => ['icono' => 'fas fa-landmark', 'color' => 'secondary'],
            'Providencias' => ['icono' => 'fas fa-stamp', 'color' => 'dark'],
            'Reglamentos' => ['icono' => 'fas fa-book', 'color' => 'primary'],
        ];

        // Obtener documentos de la BD
        $docsDb = DocumentoInstitucional::porSeccion(DocumentoInstitucional::SECCION_MARCO_NORMATIVO)
            ->activos()
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        $categorias = [];

        // Inicializar categorías estándar para preservar orden visual
        foreach ($configCategorias as $catNombre => $meta) {
            $categorias[$catNombre] = [
                'icono' => $meta['icono'],
                'color' => $meta['color'],
                'documentos' => [],
            ];
        }

        // Distribuir documentos
        foreach ($docsDb as $doc) {
            $cat = $doc->categoria ?: 'General';
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
                'tiene_archivo' => $doc->tiene_archivo,
                'reciente' => $doc->es_reciente,
            ];
        }

        return view('livewire.publico.marco-normativo', compact('categorias'));
    }
}
