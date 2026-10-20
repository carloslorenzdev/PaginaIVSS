<?php

namespace App\Livewire\Publico;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app-public')]
#[Title('Contrataciones Públicas - IVSS')]
class ContratacionesPublicas extends Component
{
    public function render()
    {
        $secciones = [
            'Concursos' => [
                'icono' => 'fas fa-gavel',
                'color' => 'primary',
                'documentos' => [
                    ['titulo' => 'Llamado a Concurso 2025-2026', 'url' => 'http://www.ivss.gov.ve/imag/page/pagina_1630701052/pdf_llamado_a_concurso_2025_2026.pdf'],
                    ['titulo' => 'Llamado a Concurso 2020-2021', 'url' => 'http://www.ivss.gob.ve/imag/page/pagina_1599788871/llamado_a_concurso_2020_2021.pdf'],
                    ['titulo' => 'Concurso Planes de Formación del IVSS 2014', 'url' => 'http://www.ivss.gov.ve/contenido/Concurso-correspondiente-a-los-Planes-de-Formacion-del-IVSS-ano-2014'],
                ]
            ],
            'Adjudicaciones' => [
                'icono' => 'fas fa-award',
                'color' => 'success',
                'documentos' => []
            ],
            'Compromiso de Responsabilidad Social' => [
                'icono' => 'fas fa-hands-helping',
                'color' => 'warning',
                'documentos' => []
            ],
            'Requisitos' => [
                'icono' => 'fas fa-clipboard-list',
                'color' => 'danger',
                'tipo' => 'informativo'
            ]
        ];

        return view('livewire.publico.contrataciones-publicas', compact('secciones'));
    }
}
