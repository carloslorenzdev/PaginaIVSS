<?php

namespace App\Actions\Consultas;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConsultarCuentaIndividualAction
{
    public function execute(array $data): array
    {
        $nacionalidad = strtoupper(trim($data['nacionalidad'] ?? 'V'));
        $rawCedula = preg_replace('/[^0-9]/', '', (string)($data['cedula'] ?? ''));

        if (empty($rawCedula)) {
            return [
                'success' => false,
                'message' => 'Debe ingresar un número de cédula válido.'
            ];
        }

        $p_cedula = $nacionalidad . '-' . ltrim($rawCedula, '0');

        try {
            $pdo = DB::connection('oracle_consulta')->getPdo();

            // Garantizar formato de fecha compatible con vistas internas de SIRA
            $pdo->exec("ALTER SESSION SET NLS_DATE_FORMAT = 'DD/MM/YYYY'");

            $cursFicha = $pdo->getNewCursor();
            $cursCuenta = $pdo->getNewCursor();

            $procName = env('ORACLE_PROC_CUENTA_INDIVIDUAL', 'OBTENER_CUENTA_INDIVIDUAL_V2');
            $stmt = $pdo->prepare("BEGIN {$procName}(:p_cedula, :p_ficha, :p_cuenta); END;");
            $stmt->bindParam(':p_cedula', $p_cedula, \PDO::PARAM_STR);
            $stmt->bindParam(':p_ficha', $cursFicha, \PDO::PARAM_STMT);
            $stmt->bindParam(':p_cuenta', $cursCuenta, \PDO::PARAM_STMT);

            $stmt->execute();

            oci_execute($cursFicha);
            oci_execute($cursCuenta);

            $ficha = oci_fetch_array($cursFicha, OCI_ASSOC + OCI_RETURN_NULLS);

            if (!$ficha) {
                return [
                    'success' => false,
                    'message' => 'No se encontraron datos de cuenta individual para la cédula indicada.'
                ];
            }

            // Procesar cursor de cuenta (15 años + fila de resumen)
            $relacion_15_anios = [];
            $resumenRow = null;

            while ($row = oci_fetch_array($cursCuenta, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $tipo = strtoupper(trim($row['TIPO_FILA'] ?? ''));
                if ($tipo === 'ANIO') {
                    $relacion_15_anios[] = [
                        'anio' => (int)($row['ANO_COTIZADO'] ?? 0),
                        'semanas' => (int)($row['SEMANAS_COTIZADAS'] ?? 0),
                        'salario' => (float)($row['SALARIO_COTIZADO'] ?? 0),
                    ];
                } elseif ($tipo === 'RESUMEN') {
                    $resumenRow = $row;
                }
            }

            // Función auxiliar para formatear fechas
            $formatDate = function ($value) {
                if (empty($value)) {
                    return null;
                }
                try {
                    return Carbon::parse($value)->format('d/m/Y');
                } catch (\Throwable $e) {
                    return (string)$value;
                }
            };

            // Estructurar datos del Asegurado
            $asegurado = [
                'nacionalidad' => $nacionalidad,
                'cedula' => $rawCedula,
                'cedula_formateada' => $ficha['CEDULA'] ?? ($nacionalidad . '-' . number_format((int)$rawCedula, 0, '', '.')),
                'nombre_completo' => $ficha['NOMBRE_Y_APELLIDO'] ?? 'NO REGISTRADO',
                'nombres' => $ficha['NOMBRE_Y_APELLIDO'] ?? '',
                'apellidos' => '',
                'sexo' => $ficha['SEXO'] ?? 'NO REGISTRADO',
                'fecha_nacimiento' => $formatDate($ficha['FECHA_NACIMIENTO'] ?? null),
            ];

            // Estructurar datos de Afiliación
            $afiliacion = [
                'numero_patronal' => $ficha['NUMERO_PATRONAL'] ?? 'NO REGISTRA',
                'nombre_empresa' => $ficha['NOMBRE_EMPRESA'] ?? 'NO REGISTRA',
                'fecha_ingreso' => $formatDate($ficha['FECHA_INGRESO'] ?? $ficha['FECHA_PRIMERA_AFILIACION'] ?? null),
                'fecha_egreso' => !empty($ficha['FECHA_EGRESO']) ? $formatDate($ficha['FECHA_EGRESO']) : null,
                'ultimo_salario' => (float)($ficha['ULTIMO_SALARIO'] ?? 0),
                'estatus' => $ficha['ESTATUS_ASEGURADO'] ?? 'NO REGISTRA',
                'fecha_primera_afiliacion' => $formatDate($ficha['FECHA_PRIMERA_AFILIACION'] ?? null),
                'fecha_contingencia' => $formatDate($ficha['FECHA_CONTINGENCIA'] ?? null),
            ];

            // Acumulados totales
            $acumulados = [
                'semanas' => (int)($resumenRow['SEMANAS_ACUMULADAS'] ?? 0),
                'salarios' => (float)($resumenRow['SALARIOS_ACUMULADOS'] ?? 0),
            ];

            // Resumen de semanas
            $resumen_semanas = [
                'articulo_92' => (int)($resumenRow['ARTICULO_92'] ?? 0),
                'decreto_4269' => (int)($ficha['DECRETO_4269'] ?? 0),
                'ultimos_10' => (int)($resumenRow['ULTIMOS_10_ANOS'] ?? 0),
                'ultimos_4' => (int)($resumenRow['ULTIMOS_4_ANOS'] ?? 0),
                'ultimos_3' => (int)($resumenRow['ULTIMOS_3_ANOS'] ?? 0),
                'total' => (int)($resumenRow['TOTAL_SEMANAS_COTIZADAS'] ?? 0),
            ];

            // Promedios
            $promedios = [
                'mensual_10_anios' => (float)($resumenRow['PROMEDIO_MENSUAL_10'] ?? 0),
                'mensual_5_anios' => (float)($resumenRow['PROMEDIO_MENSUAL_5'] ?? 0),
                'semanal_100_cotiz' => (float)($resumenRow['PROMEDIO_SEMANAL_100'] ?? 0),
                'total_salarios' => (float)($resumenRow['TOTAL_SALARIOS_COTIZADOS'] ?? 0),
            ];

            $html = view('publico.cuenta-individual-resultado', compact(
                'asegurado',
                'afiliacion',
                'acumulados',
                'relacion_15_anios',
                'resumen_semanas',
                'promedios'
            ))->render();

            return [
                'success' => true,
                'html' => $html,
            ];

        } catch (\Throwable $e) {
            Log::error('Error en ConsultarCuentaIndividualAction: ' . $e->getMessage(), [
                'cedula' => $p_cedula,
                'trace' => $e->getTraceAsString(),
            ]);

            $errorMsg = $e->getMessage();
            if (str_contains($errorMsg, '20002') || str_contains($errorMsg, 'No existe asegurado')) {
                return [
                    'success' => false,
                    'message' => 'El ciudadano no se encuentra registrado como asegurado en el sistema.'
                ];
            }

            if (str_contains($errorMsg, '20001') || str_contains($errorMsg, 'Cedula invalida')) {
                return [
                    'success' => false,
                    'message' => 'El formato de cédula ingresado es inválido.'
                ];
            }

            if (str_contains($errorMsg, '20003')) {
                return [
                    'success' => false,
                    'message' => 'Cédula asociada a múltiples expedientes de asegurado.'
                ];
            }

            return [
                'success' => false,
                'message' => config('app.debug')
                    ? 'Error de conexión o procedimiento Oracle: ' . $e->getMessage()
                    : 'No fue posible consultar la cuenta individual en este momento. Por favor intente más tarde.'
            ];
        }
    }
}
