<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarcoNormativoController extends Controller
{
    public function index()
    {
        $categorias = [
            'Decretos' => [
                'icono' => 'fas fa-balance-scale',
                'color' => 'primary',
                'documentos' => [
                    ['titulo' => 'Gaceta Oficial 41.159', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1503517208/gaceta_41159_decreto_providencia.pdf'],
                    ['titulo' => 'Decreto 4269', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436995554/decreto4269.pdf'],
                    ['titulo' => 'Decreto 5370', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436995508/decreto5370.pdf'],
                    ['titulo' => 'Decreto 5316', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436995461/decreto5316.pdf'],
                    ['titulo' => 'Decreto 7402', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436994808/decreto7402.pdf'],
                    ['titulo' => 'Decreto 7401', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436994742/decreto7401.pdf'],
                    ['titulo' => 'Decreto Gran Misión en Amor Mayor Venezuela', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436901813/amordecreto_2_.pdf'],
                ]
            ],
            'Ley de Contrataciones' => [
                'icono' => 'fas fa-file-contract',
                'color' => 'warning',
                'documentos' => [
                    ['titulo' => 'Ley de Contrataciones Públicas', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1437677138/ley_de_contrataciones.pdf'],
                ]
            ],
            'Leyes Especiales' => [
                'icono' => 'fas fa-gavel',
                'color' => 'danger',
                'documentos' => [
                    ['titulo' => 'Ley del Régimen Prestacional de Empleo', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436995730/ley_del_regimen_prestacional_de_empleo.pdf'],
                    ['titulo' => 'Ley del Seguro Social', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436995596/leydelsegurosocial.pdf'],
                ]
            ],
            'Leyes Orgánicas' => [
                'icono' => 'fas fa-landmark',
                'color' => 'secondary',
                'documentos' => [
                    ['titulo' => 'Ley Organica del sistema de Seguridad Social', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436996312/ley_organica_sss_3_.pdf'],
                ]
            ],
            'Providencias' => [
                'icono' => 'fas fa-stamp',
                'color' => 'dark',
                'documentos' => [
                    ['titulo' => 'Providencia Administrativa N°002', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1503515834/gaceta_providencia_002_17.pdf'],
                    ['titulo' => 'Providencia Administrativa N°005', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1503515588/providencia__n__005__19_de_junio_de_2017_.pdf'],
                ]
            ],
            'Reglamentos' => [
                'icono' => 'fas fa-book',
                'color' => 'primary',
                'documentos' => [
                    ['titulo' => 'Reglamento General de la Ley del Seguro Social', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436996411/reglamento_ley_ss.pdf'],
                ]
            ],
        ];

        return view('servicios_complementarios.marco_normativo', compact('categorias'));
    }
}
