<?php

namespace App\Livewire\Publico;

use App\Models\DocumentoInstitucional;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app-public')]
#[Title('Contrataciones Públicas - IVSS')]
class ContratacionesPublicas extends Component
{
    public function render()
    {
        $seccionesConfig = [
            'Concursos' => ['icono' => 'fas fa-gavel', 'color' => 'primary'],
            'Adjudicaciones' => ['icono' => 'fas fa-award', 'color' => 'success'],
            'Compromiso de Responsabilidad Social' => ['icono' => 'fas fa-hands-helping', 'color' => 'warning'],
            'Requisitos' => ['icono' => 'fas fa-clipboard-list', 'color' => 'danger', 'tipo' => 'informativo'],
        ];

        $docsDb = DocumentoInstitucional::porSeccion(DocumentoInstitucional::SECCION_CONTRATACIONES)
            ->activos()
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        $secciones = [];

        foreach ($seccionesConfig as $nombre => $meta) {
            $secciones[$nombre] = [
                'icono' => $meta['icono'],
                'color' => $meta['color'],
                'tipo' => $meta['tipo'] ?? 'documentos',
                'documentos' => [],
            ];
        }

        foreach ($docsDb as $doc) {
            $cat = $doc->categoria ?: 'Concursos';
            if (!isset($secciones[$cat])) {
                $secciones[$cat] = [
                    'icono' => 'fas fa-folder',
                    'color' => 'primary',
                    'tipo' => 'documentos',
                    'documentos' => [],
                ];
            }

            $secciones[$cat]['documentos'][] = [
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

        return view('livewire.publico.contrataciones-publicas', compact('secciones'));
    }
}
