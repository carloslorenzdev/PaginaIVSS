<?php

namespace Database\Seeders;

use App\Models\DocumentoInstitucional;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DocumentosInstitucionalesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. PERMISOS
        $permisos = [
            'documentos.ver',
            'documentos.crear',
            'documentos.editar',
            'documentos.eliminar',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        $rolesAdmin = Role::whereIn('name', ['admin', 'Super Administrador', 'Administrador'])->get();
        foreach ($rolesAdmin as $role) {
            $role->givePermissionTo($permisos);
        }

        // 2. DOCUMENTOS: MARCO NORMATIVO
        $marcoNormativo = [
            'Decretos' => [
                'Gaceta Oficial 41.159',
                'Decreto 4269',
                'Decreto 5370',
                'Decreto 5316',
                'Decreto 7402',
                'Decreto 7401',
                'Decreto Gran Misión en Amor Mayor Venezuela',
            ],
            'Ley de Contrataciones' => [
                'Ley de Contrataciones Públicas',
            ],
            'Leyes Especiales' => [
                'Ley del Régimen Prestacional de Empleo',
                'Ley del Seguro Social',
            ],
            'Leyes Orgánicas' => [
                'Ley Organica del sistema de Seguridad Social',
            ],
            'Providencias' => [
                'Providencia Administrativa N°002',
                'Providencia Administrativa N°005',
            ],
            'Reglamentos' => [
                'Reglamento General de la Ley del Seguro Social',
                'Reglamento de la Ley del Régimen Prestacional de Empleo',
            ],
        ];

        $orden = 1;
        foreach ($marcoNormativo as $categoria => $docs) {
            foreach ($docs as $titulo) {
                DocumentoInstitucional::firstOrCreate(
                    [
                        'seccion' => DocumentoInstitucional::SECCION_MARCO_NORMATIVO,
                        'titulo' => $titulo,
                    ],
                    [
                        'categoria' => $categoria,
                        'descripcion' => 'Documento oficial regulatorio del IVSS.',
                        'archivo_path' => null,
                        'formato' => 'pdf',
                        'orden' => $orden++,
                        'activo' => true,
                    ]
                );
            }
        }

        // 3. DOCUMENTOS: CONTRATACIONES PÚBLICAS
        $contrataciones = [
            'Concursos' => [
                'Llamado a Concurso 2025-2026',
                'Llamado a Concurso 2020-2021',
                'Concurso Planes de Formación del IVSS 2014',
            ],
            'Adjudicaciones' => [
                'Cuadro Resumen de Adjudicaciones Recientes',
            ],
            'Compromiso de Responsabilidad Social' => [
                'Instructivo de Cumplimiento del Compromiso de Responsabilidad Social',
            ],
        ];

        foreach ($contrataciones as $categoria => $docs) {
            foreach ($docs as $titulo) {
                DocumentoInstitucional::firstOrCreate(
                    [
                        'seccion' => DocumentoInstitucional::SECCION_CONTRATACIONES,
                        'titulo' => $titulo,
                    ],
                    [
                        'categoria' => $categoria,
                        'descripcion' => 'Documento del proceso de contrataciones públicas del IVSS.',
                        'archivo_path' => null,
                        'formato' => 'pdf',
                        'orden' => $orden++,
                        'activo' => true,
                    ]
                );
            }
        }

        // 4. DOCUMENTOS: BIBLIOTECA DE FORMAS
        $formas = [
            'Formas' => [
                ['titulo' => 'Solicitud de Evaluación de Discapacidad Residual (Forma 14-08)', 'file' => 'forma_14_08_solicitud_evaluacion_discapacidad_residual.doc'],
                ['titulo' => 'Solicitud de Prestaciones en Dinero (Forma 14-04)', 'file' => 'f_14_04_solic_prest_dinero.pdf'],
                ['titulo' => 'Constancia de Orden de Pago (Forma 14-23)', 'file' => 'f_14_23_constancia_de_orden_de_pago.docx'],
                ['titulo' => 'Registro Patronal de Asegurado (Forma 13-12)', 'file' => 'formulario_13_12.pdf'],
                ['titulo' => 'Solicitud de Declaración Jurada de Empresa Desaparecida (Forma 14-205)', 'file' => 'forma14_205.pdf'],
                ['titulo' => 'Solicitud de Convenio de Pago (Forma 14-134)', 'file' => 'f_14_134.doc'],
                ['titulo' => 'Constancia de Trabajo para el IVSS (Forma 14-100)', 'file' => 'f_14_100.pdf'],
                ['titulo' => 'Solicitud de Inscripción Continuación Facultativa y No Dependiente (Forma 14-196)', 'file' => 'f_14_196_1_.doc'],
                ['titulo' => 'Comprobante de consignación de datos (Forma 14-52)', 'file' => 'f_14_52_comprob_consig_datos.doc'],
            ],
            'Instructivo de Formas' => [
                ['titulo' => 'Instructivo Solicitud de Evaluación de Discapacidad Residual (Forma 14-08)', 'file' => 'instructivo_14_08_solicitud_evaluacion_discapacidad_residual.pdf'],
                ['titulo' => 'Instructivo Solicitud de Prestaciones en Dinero (Forma 14-04)', 'file' => 'f_14_04_instructivo.pdf'],
                ['titulo' => 'Instructivo Solicitud de Convenio de Pago (Forma 14-134)', 'file' => 'instructivo_14_134.doc'],
                ['titulo' => 'Instructivo Constancia de Trabajo para el IVSS (Forma 14-100)', 'file' => 'instructivo_14_100.pdf'],
                ['titulo' => 'Instructivo Solicitud de Inscripción Continuación Facultativa y No Dependiente (Forma 14-196)', 'file' => 'instructivo_14_196_2_.doc'],
                ['titulo' => 'Instructivo Comprobante de consignación de datos (Forma 14-52)', 'file' => 'instructivof_14_52.pdf'],
                ['titulo' => 'Instructivo Registro Patronal de Asegurado (Forma 13-12)', 'file' => 'instructivo_13_12.pdf'],
            ],
        ];

        $storageFormasPath = storage_path('app/public/documentos/biblioteca_formas');

        foreach ($formas as $categoria => $docs) {
            foreach ($docs as $item) {
                $filename = $item['file'];
                $pathFisico = $storageFormasPath . DIRECTORY_SEPARATOR . $filename;
                $archivoPath = null;
                $tamano = null;
                $formato = pathinfo($filename, PATHINFO_EXTENSION);

                if (File::exists($pathFisico)) {
                    $archivoPath = 'documentos/biblioteca_formas/' . $filename;
                    $tamano = File::size($pathFisico);
                }

                DocumentoInstitucional::firstOrCreate(
                    [
                        'seccion' => DocumentoInstitucional::SECCION_BIBLIOTECA_FORMAS,
                        'titulo' => $item['titulo'],
                    ],
                    [
                        'categoria' => $categoria,
                        'descripcion' => 'Planilla oficial del trámite ante el IVSS.',
                        'archivo_path' => $archivoPath,
                        'archivo_nombre_original' => $filename,
                        'formato' => $formato ?: 'pdf',
                        'tamano_bytes' => $tamano,
                        'orden' => $orden++,
                        'activo' => true,
                    ]
                );
            }
        }
    }
}
