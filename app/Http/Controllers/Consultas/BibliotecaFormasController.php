<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BibliotecaFormasController extends Controller
{
    public function index()
    {
        $categorias = $this->obtenerCategorias();

        return view('servicios_complementarios.biblioteca_formas', compact('categorias'));
    }

    private function obtenerCategorias(): array
    {
        $raw = [
            'Formas' => [
                'icono' => 'fas fa-file-invoice',
                'color' => 'success',
                'documentos' => [
                    [
                        'titulo' => 'Solicitud de Evaluación de Discapacidad Residual (Forma 14-08)',
                        'archivo' => 'forma_14_08_solicitud_evaluacion_discapacidad_residual.doc',
                    ],
                    [
                        'titulo' => 'Solicitud de Prestaciones en Dinero (Forma 14-04)',
                        'archivo' => 'f_14_04_solic_prest_dinero.pdf',
                    ],
                    [
                        'titulo' => 'Constancia de Orden de Pago (Forma 14-23)',
                        'archivo' => 'f_14_23_constancia_de_orden_de_pago.docx',
                    ],
                    [
                        'titulo' => 'Registro Patronal de Asegurado (Forma 13-12)',
                        'archivo' => 'formulario_13_12.pdf',
                    ],
                    [
                        'titulo' => 'Solicitud de Declaración Jurada de Empresa Desaparecida (Forma 14-205)',
                        'archivo' => 'forma14_205.pdf',
                    ],
                    [
                        'titulo' => 'Solicitud de Convenio de Pago (Forma 14-134)',
                        'archivo' => 'f_14_134.doc',
                    ],
                    [
                        'titulo' => 'Constancia de Trabajo para el IVSS (Forma 14-100)',
                        'archivo' => 'f_14_100.pdf',
                    ],
                    [
                        'titulo' => 'Solicitud de Inscripción Continuación Facultativa y No Dependiente (Forma 14-196)',
                        'archivo' => 'f_14_196_1_.doc',
                    ],
                    [
                        'titulo' => 'Comprobante de consignación de datos (Forma 14-52)',
                        'archivo' => 'f_14_52_comprob_consig_datos.doc',
                    ],
                ]
            ],
            'Instructivo de Formas' => [
                'icono' => 'fas fa-book-open',
                'color' => 'info',
                'documentos' => [
                    [
                        'titulo' => 'Instructivo Solicitud de Evaluación de Discapacidad Residual (Forma 14-08)',
                        'archivo' => 'instructivo_14_08_solicitud_evaluacion_discapacidad_residual.pdf',
                    ],
                    [
                        'titulo' => 'Instructivo Solicitud de Prestaciones en Dinero (Forma 14-04)',
                        'archivo' => 'f_14_04_instructivo.pdf',
                    ],
                    [
                        'titulo' => 'Instructivo Solicitud de Convenio de Pago (Forma 14-134)',
                        'archivo' => 'instructivo_14_134.doc',
                    ],
                    [
                        'titulo' => 'Instructivo Constancia de Trabajo para el IVSS (Forma 14-100)',
                        'archivo' => 'instructivo_14_100.pdf',
                    ],
                    [
                        'titulo' => 'Instructivo Solicitud de Inscripción Continuación Facultativa y No Dependiente (Forma 14-196)',
                        'archivo' => 'instructivo_14_196_2_.doc',
                    ],
                    [
                        'titulo' => 'Instructivo Comprobante de consignación de datos (Forma 14-52)',
                        'archivo' => 'instructivof_14_52.pdf',
                    ],
                    [
                        'titulo' => 'Instructivo Registro Patronal de Asegurado (Forma 13-12)',
                        'archivo' => 'instructivo_13_12.pdf',
                    ],
                ]
            ]
        ];

        $carpetaBase = public_path('documentos' . DIRECTORY_SEPARATOR . 'formas');

        foreach ($raw as &$categoria) {
            foreach ($categoria['documentos'] as &$doc) {
                $nombreArchivo = $doc['archivo'];
                $baseName = pathinfo($nombreArchivo, PATHINFO_FILENAME);

                $archivoEncontrado = null;
                $rutaFisica = null;
                $posibles = [
                    $nombreArchivo,
                    $baseName . '.pdf',
                    $baseName . '.doc',
                    $baseName . '.docx',
                ];

                foreach ($posibles as $posible) {
                    $ruta = $carpetaBase . DIRECTORY_SEPARATOR . $posible;
                    if (file_exists($ruta) && !is_dir($ruta)) {
                        $archivoEncontrado = $posible;
                        $rutaFisica = $ruta;
                        break;
                    }
                }

                if ($archivoEncontrado && $rutaFisica) {
                    $doc['disponible'] = true;
                    $doc['url'] = asset('documentos/formas/' . $archivoEncontrado);
                    $doc['extension'] = strtolower(pathinfo($archivoEncontrado, PATHINFO_EXTENSION));

                    $diasModificacion = (time() - filemtime($rutaFisica)) / 86400;
                    $doc['reciente'] = $diasModificacion <= 30;
                } else {
                    $doc['disponible'] = false;
                    $doc['url'] = null;
                    $doc['extension'] = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
                    $doc['reciente'] = false;
                }
            }
        }
        unset($categoria, $doc);

        return $raw;
    }
}
