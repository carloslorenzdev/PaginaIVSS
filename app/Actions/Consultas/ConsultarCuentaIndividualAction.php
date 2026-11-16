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

            // Validar coincidencia de fecha de nacimiento si fue proporcionada
            if (!empty($data['d1']) && !empty($data['m1']) && !empty($data['y1'])) {
                $inD = (int)$data['d1'];
                $inM = (int)$data['m1'];
                $inY = (int)$data['y1'];

                $fechaBd = $this->descomponerFecha($ficha['FECHA_NACIMIENTO'] ?? null);

                if ($fechaBd) {
                    if ($fechaBd['d'] !== $inD || $fechaBd['m'] !== $inM || $fechaBd['y'] !== $inY) {
                        return [
                            'success' => false,
                            'message' => 'La fecha de nacimiento ingresada no coincide con los registros del asegurado.'
                        ];
                    }
                }
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
                $partes = $this->descomponerFecha($value);
                if ($partes) {
                    return sprintf('%02d/%02d/%04d', $partes['d'], $partes['m'], $partes['y']);
                }
                return (string)$value;
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
            $art92 = $resumenRow['ARTICULO_92'] ?? null;
            $art92Str = strtoupper(trim((string)$art92));
            if (empty($art92) || $art92 === 0 || $art92 === '0' || in_array($art92Str, ['NO APLICA', 'PENDIENTE_REGLA', 'PENDIENTE', 'NULL'])) {
                $art92 = 'NO APLICA';
            }

            $decr4269 = $ficha['DECRETO_4269'] ?? $resumenRow['DECRETO_4269'] ?? null;
            if (empty($decr4269) || $decr4269 === 0 || $decr4269 === '0') {
                $decr4269 = '';
            }

            $resumen_semanas = [
                'articulo_92' => $art92,
                'decreto_4269' => $decr4269,
                'ultimos_10' => (int)($resumenRow['ULTIMOS_10_ANOS'] ?? 0),
                'ultimos_4' => (int)($resumenRow['ULTIMOS_4_ANOS'] ?? 0),
                'ultimos_3' => (int)($resumenRow['ULTIMOS_3_ANOS'] ?? 0),
                'total' => (int)($resumenRow['TOTAL_SEMANAS_COTIZADAS'] ?? 0),
            ];

            // Promedios
            $promedios = [
                'mensual_10_anios' => $resumenRow['PROMEDIO_MENSUAL_10'] ?? 0,
                'mensual_5_anios' => $resumenRow['PROMEDIO_MENSUAL_5'] ?? 0,
                'semanal_100_cotiz' => $resumenRow['PROMEDIO_SEMANAL_100'] ?? 0,
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

    /**
     * Extrae día, mes y año de cualquier formato de fecha retornado por Oracle
     * evitando errores de interpretación entre formatos regionales (DD/MM/YYYY vs MM/DD/YYYY).
     */
    protected function descomponerFecha(mixed $rawDate): ?array
    {
        if (empty($rawDate)) {
            return null;
        }

        $rawDate = trim((string)$rawDate);

        // Formato DD/MM/YYYY o DD/MM/YY (opcionalmente con hora)
        if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})/', $rawDate, $m)) {
            $y = (int)$m[3];
            if ($y < 100) {
                $y += ($y > 30 ? 1900 : 2000);
            }
            return ['d' => (int)$m[1], 'm' => (int)$m[2], 'y' => $y];
        }

        // Formato YYYY-MM-DD o YYYY/MM/DD
        if (preg_match('/^(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})/', $rawDate, $m)) {
            return ['d' => (int)$m[3], 'm' => (int)$m[2], 'y' => (int)$m[1]];
        }

        // Formato DD-MM-YYYY o DD-MM-YY
        if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{2,4})/', $rawDate, $m)) {
            $y = (int)$m[3];
            if ($y < 100) {
                $y += ($y > 30 ? 1900 : 2000);
            }
            return ['d' => (int)$m[1], 'm' => (int)$m[2], 'y' => $y];
        }

        // Formato Oracle alfanumérico DD-MON-RR o DD-MON-YYYY (ej. 14-AUG-58 o 14-AGO-1958)
        $mesesTexto = [
            'JAN' => 1, 'FEB' => 2, 'MAR' => 3, 'APR' => 4, 'MAY' => 5, 'JUN' => 6,
            'JUL' => 7, 'AUG' => 8, 'SEP' => 9, 'OCT' => 10, 'NOV' => 11, 'DEC' => 12,
            'ENE' => 1, 'ABR' => 4, 'AGO' => 8, 'DIC' => 12
        ];
        if (preg_match('/^(\d{1,2})-([A-Za-z]{3})-(\d{2,4})/', $rawDate, $m)) {
            $monStr = strtoupper($m[2]);
            $mesNum = $mesesTexto[$monStr] ?? null;
            $y = (int)$m[3];
            if ($y < 100) {
                $y += ($y > 30 ? 1900 : 2000);
            }
            if ($mesNum) {
                return ['d' => (int)$m[1], 'm' => $mesNum, 'y' => $y];
            }
        }

        try {
            $c = Carbon::parse(str_replace('/', '-', $rawDate));
            return ['d' => (int)$c->day, 'm' => (int)$c->month, 'y' => (int)$c->year];
        } catch (\Throwable $e) {
            return null;
        }
    }
}
