<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BibliotecaFormasController extends Controller
{
    public function index()
    {
        $categorias = [
            'Formas' => [
                'icono' => 'fas fa-file-invoice',
                'color' => 'success',
                'documentos' => [
                    ['titulo' => 'PLANILLA 14-04', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1521736998/f_14_04_solic_prest_dinero.pdf'],
                    ['titulo' => 'TITULO', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1521736429/f_14_04_solic_prest_dinero.pdf'],
                    ['titulo' => 'Forma 14-08', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1503516943/forma_14_08_3_2017.pdf'],
                    ['titulo' => 'Constancia de Orden de Pago (Forma 14-23)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1447277560/f_14_23_constancia_de_orden_de_pago.docx'],
                    ['titulo' => 'Registro Patronal de Asegurado (Forma 13-12)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436993697/formulario_13_12.pdf'],
                    ['titulo' => 'Solicitud de Declaración Jurada de Empresa Desaparecida (Forma 14-205)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436994277/forma14_205.pdf'],
                    ['titulo' => 'Solicitud de Convenio de Pago (Forma 14-134)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436994220/f_14_134.doc'],
                    ['titulo' => 'Constancia de Trabajo para el IVSS (Forma 14-100)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436994138/f_14_100.pdf'],
                    ['titulo' => 'Solicitud de Inscripción Continuación Facultativa y No Dependiente (Forma 14-196)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436993980/f_14_196_1_.doc'],
                    ['titulo' => 'Comprobante de consignación de datos (Forma 14-52)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1436993562/f_14_52_comprob_consig_datos.doc'],
                ]
            ],
            'Instructivo de Formas' => [
                'icono' => 'fas fa-book-open',
                'color' => 'info',
                'documentos' => [
                    ['titulo' => 'Solicitud de Prestaciones en Dinero (Forma 14-04)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1521485450/f_14_04_instructivo.pdf'],
                    ['titulo' => 'Solicitud de Convenio de Pago (Forma 14-134)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1437669175/instructivo_14_134.doc'],
                    ['titulo' => 'Constancia de Trabajo para el IVSS (Forma 14-100)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1437669096/instructivo_14_100.pdf'],
                    ['titulo' => 'Solicitud de Inscripción Continuación Facultativa y No Dependiente (Forma 14-196)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1437669027/instructivo_14_196_2_.doc'],
                    ['titulo' => 'Comprobante de consignación de datos (Forma 14-52)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1437668740/instructivof_14_52.pdf'],
                    ['titulo' => 'Instructivo Registro Patronal de Asegurado (Forma 13-12)', 'url' => 'http://www.ivss.gov.ve/documento/biblioteca/biblioteca_1437668818/instructivo_13_12.pdf'],
                ]
            ]
        ];

        return view('servicios_complementarios.biblioteca_formas', compact('categorias'));
    }
}
