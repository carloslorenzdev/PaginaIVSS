<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContratacionesPublicasController extends Controller
{
    public function index()
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
                'documentos' => [] // Actualmente vacío en el sistema viejo
            ],
            'Compromiso de Responsabilidad Social' => [
                'icono' => 'fas fa-hands-helping',
                'color' => 'warning',
                'documentos' => [] // Actualmente vacío en el sistema viejo
            ],
            'Requisitos' => [
                'icono' => 'fas fa-clipboard-list',
                'color' => 'danger',
                'tipo' => 'informativo'
            ]
        ];

        return view('servicios_complementarios.contrataciones_publicas', compact('secciones'));
    }
}
