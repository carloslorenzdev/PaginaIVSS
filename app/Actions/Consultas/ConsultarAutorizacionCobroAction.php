<?php

namespace App\Actions\Consultas;

use Illuminate\Support\Facades\DB;

class ConsultarAutorizacionCobroAction
{
    /**
     * Mapeo de códigos de tipo de pensión a texto estándar.
     */
    protected array $tiposPension = [
        '01' => 'INVALIDEZ',
        '06' => 'INCAPACIDAD',
        '10' => 'VEJEZ',
        '12' => 'SOBREVIVIENTE',
    ];

    /**
     * Normalizar cédula al formato almacenado en Oracle (Letra + 9 dígitos con ceros a la izquierda).
     * Ejemplo: 'V', '284060' => 'V000284060'
     */
    public function normalizarCedula(string $nacionalidad, string|int $cedula): string
    {
        $nacionalidad = strtoupper(trim($nacionalidad));
        if (!in_array($nacionalidad, ['V', 'E', 'T'])) {
            $nacionalidad = 'V';
        }
        $soloNumero = preg_replace('/[^0-9]/', '', (string)$cedula);
        return $nacionalidad . str_pad($soloNumero, 9, '0', STR_PAD_LEFT);
    }

    /**
     * Consultar por número de planilla (ID).
     */
    public function consultarPorPlanilla(string $idPlanilla): ?array
    {
        $idPlanillaLimpia = strtoupper(trim($idPlanilla));

        $pension = DB::connection('oracle_consulta')
            ->table('PRESTACIONES.AUTORIZA_COBRO_PENSION')
            ->where('ID', $idPlanillaLimpia)
            ->first();

        if (!$pension) {
            return null;
        }

        $idPensionado = $pension->id_pensionado ?? $pension->ID_PENSIONADO ?? '';
        if ($idPensionado) {
            return $this->ejecutarConsultaAutorizacion($idPensionado);
        }

        return null;
    }

    /**
     * Consultar por código de verificación (o número de planilla).
     */
    public function consultarPorCodigoVerificacion(string $codigo): ?array
    {
        $codigoLimpio = trim($codigo);

        $pension = DB::connection('oracle_consulta')
            ->table('PRESTACIONES.AUTORIZA_COBRO_PENSION')
            ->where('CODIGO_VERIFICACION', $codigoLimpio)
            ->orWhere('ID', strtoupper($codigoLimpio))
            ->orderBy('FECHA', 'desc')
            ->first();

        if (!$pension) {
            return null;
        }

        $idPensionado = $pension->id_pensionado ?? $pension->ID_PENSIONADO ?? '';
        if ($idPensionado) {
            return $this->ejecutarConsultaAutorizacion($idPensionado);
        }

        return null;
    }

    /**
     * Consultar únicamente por cédula del pensionado y tipo de pensión,
     * utilizando la consulta oficial institucional.
     */
    public function consultarPorSolicitud(array $data): ?array
    {
        $ciPensionado = $this->normalizarCedula(
            $data['nacionalidad_solicitante'] ?? 'V',
            $data['cedula_solicitante'] ?? ''
        );

        $tipoPension = null;
        if (!empty($data['tipo_pension']) && $data['tipo_pension'] !== '0') {
            $tipoPension = $this->tiposPension[$data['tipo_pension']] ?? strtoupper(trim($data['tipo_pension']));
        }

        return $this->ejecutarConsultaAutorizacion($ciPensionado, $tipoPension);
    }

    /**
     * Ejecuta el query institucional unificado de Autorización de Cobro de Pensión.
     */
    public function ejecutarConsultaAutorizacion(string $cedulaPensionado, ?string $tipoPension = null): ?array
    {
        $sql = "
        WITH FILTRO AS (
            SELECT :cedula AS CEDULA FROM DUAL
        )
        SELECT 
            ACP.ID AS NUMERO_PLANILLA, 
            ACP.LUGAR, 
            TO_CHAR(ACP.FECHA, 'DD/MM/YYYY') AS FECHA, 
            ACP.RENOVABLE,
            REGEXP_REPLACE( 
                TRIM(P.PRIMER_NOMBRE || ' ' || P.SEGUNDO_NOMBRE || ' ' || P.PRIMER_APELLIDO || ' ' || P.SEGUNDO_APELLIDO), 
                ' +', ' ' 
            ) AS NOMBRE_PENSIONADO, 
            P.ID_CIUDADANO AS CEDULA_PENSIONADO, 
            ACP.DIRECCION_PENSIONADO, 
            ACP.TELEFONO_PENSIONADO, 
            EXP.MONTO_PENSION, 
            EXP.NUMERO_RESOLUCION AS RESOLUCION_NRO, 
            CASE WHEN EXP.ORIGEN_DATA = 'MIGRACIONCP' THEN 'AMOR MAYOR' ELSE EXP.ORIGEN_DATA END AS RAZON_SOCIAL, 
            CASE UPPER(TRIM(ACP.TIPO_PENSION)) 
                WHEN 'VEJEZ' THEN 'TRABAJO' 
                WHEN 'INCAPACIDAD' THEN 'DISCAPACIDAD' 
                WHEN 'INVALIDEZ' THEN 'DISCAPACIDAD' 
                ELSE ACP.TIPO_PENSION 
            END AS TIPO_PENSION, 
            BCO.NOMBRE_BANCO AS ENTIDAD_BANCARIA, 
            CASE WHEN BCO.CEDULA_CAUSANTE IS NOT NULL THEN NVL(TRIM(BCO.NRO_CUENTA), '00000000000000000000') END AS NUMERO_CUENTA, 
            REGEXP_REPLACE( 
                TRIM(A.PRIMER_NOMBRE || ' ' || A.SEGUNDO_NOMBRE || ' ' || A.PRIMER_APELLIDO || ' ' || A.SEGUNDO_APELLIDO), 
                ' +', ' ' 
            ) AS NOMBRE_AUTORIZADO, 
            A.ID_CIUDADANO AS CEDULA_AUTORIZADO, 
            ACP.DIRECCION_AUTORIZADO, 
            ACP.TELEFONO_AUTORIZADO, 
            ACP.ACUMULADO, 
            ACP.ANO_ACUMULADO, 
            ACP.MES1, 
            ACP.ANO1, 
            ACP.MES2, 
            ACP.ANO2, 
            ACP.MES3, 
            ACP.ANO3, 
            ACP.MES4, 
            ACP.ANO4, 
            NVL(U_AUT.NOMBRE, 'N/A') AS NOMBRE_AUTORIZADOR, 
            NVL(TO_CHAR(U_AUT.CEDULA), 'N/A') AS CEDULA_AUTORIZADOR, 
            'Aprobador Autorizado Cobro Pensión' AS CARGO_AUTORIZADOR, 
            'DIRECCIÓN DE PRESTACIONES' AS OFICINA_ADMINISTRATIVA, 
            ACP.CODIGO_VERIFICACION
        FROM ( 
            SELECT * FROM ( 
                SELECT ACP_ALL.* FROM PRESTACIONES.AUTORIZA_COBRO_PENSION ACP_ALL 
                INNER JOIN FILTRO F ON ACP_ALL.ID_PENSIONADO = F.CEDULA 
                WHERE ACP_ALL.ESTATUS_REGISTRO = 'APR' 
                  AND (
                    :tipo_pension IS NULL 
                    OR UPPER(TRIM(ACP_ALL.TIPO_PENSION)) = UPPER(TRIM(:tipo_pension))
                  )
                ORDER BY ACP_ALL.FECHA_AUTORIZADOR DESC NULLS LAST, ACP_ALL.FECHA DESC, ACP_ALL.ID DESC 
            ) WHERE ROWNUM = 1
        ) ACP
        INNER JOIN SIRA.CIUDADANO P ON P.ID_CIUDADANO = ACP.ID_PENSIONADO
        INNER JOIN SIRA.CIUDADANO A ON A.ID_CIUDADANO = ACP.ID_AUTORIZADO
        LEFT JOIN ( 
            SELECT CEDULA_CAUSANTE, NUMERO_RESOLUCION, MONTO_PENSION, ORIGEN_DATA FROM ( 
                SELECT CEDULA_CAUSANTE, NUMERO_RESOLUCION, MONTO_PENSION, ORIGEN_DATA FROM PRESTACIONES.EXPEDIENTES_14105 WHERE CEDULA_CAUSANTE = (SELECT CEDULA FROM FILTRO) 
                UNION 
                SELECT CEDULA_CAUSANTE, NUMERO_RESOLUCION, MONTO_PENSION, ORIGEN_DATA FROM PRESTACIONES.EXPEDIENTES_14105_CP WHERE CEDULA_CAUSANTE = (SELECT CEDULA FROM FILTRO) 
            ) WHERE ROWNUM = 1
        ) EXP ON EXP.CEDULA_CAUSANTE = ACP.ID_PENSIONADO
        LEFT JOIN ( 
            SELECT CEDULA_CAUSANTE, NOMBRE_BANCO, NRO_CUENTA FROM ( 
                SELECT E.CEDULA_CAUSANTE, BP.NOMBRE_BANCO, BP.NRO_CUENTA 
                FROM (SELECT CEDULA_CAUSANTE, ID_BANCO FROM PRESTACIONES.EXPEDIENTES_14105 WHERE CEDULA_CAUSANTE = (SELECT CEDULA FROM FILTRO) AND ROWNUM >= 1) E 
                INNER JOIN PRESTACIONES.BANCO_PRESTACIONES BP ON E.ID_BANCO = BP.ID_BANCO 
                UNION 
                SELECT E.CEDULA_CAUSANTE, BP.NOMBRE_BANCO, BP.NRO_CUENTA 
                FROM (SELECT CEDULA_CAUSANTE, ID_BANCO FROM PRESTACIONES.EXPEDIENTES_14105_CP WHERE CEDULA_CAUSANTE = (SELECT CEDULA FROM FILTRO) AND ROWNUM >= 1) E 
                INNER JOIN PRESTACIONES.BANCO_PRESTACIONES BP ON E.ID_BANCO = BP.ID_BANCO 
            ) WHERE ROWNUM = 1
        ) BCO ON BCO.CEDULA_CAUSANTE = ACP.ID_PENSIONADO
        LEFT JOIN PRESTACIONES.USUARIO_PRESTACIONES U_AUT ON UPPER(TRIM(U_AUT.ID_USUARIO)) = UPPER(TRIM(ACP.USUARIO_AUTORIZADOR))
        ";

        $row = DB::connection('oracle_consulta')->selectOne($sql, [
            'cedula' => $cedulaPensionado,
            'tipo_pension' => $tipoPension,
        ]);

        // Si con el filtro de tipo de pensión no devolvió nada, reintentar sin filtro de tipo de pensión
        if (!$row && $tipoPension !== null) {
            $row = DB::connection('oracle_consulta')->selectOne($sql, [
                'cedula' => $cedulaPensionado,
                'tipo_pension' => null,
            ]);
        }

        if (!$row) {
            return null;
        }

        return $this->mapearResultado($row);
    }

    /**
     * Mapea el registro de la consulta al formato estandarizado que requiere la vista y el PDF.
     */
    protected function mapearResultado(object|array $row): array
    {
        $row = (object)$row;

        return [
            'id' => $row->numero_planilla ?? $row->NUMERO_PLANILLA ?? '',
            'lugar' => $row->lugar ?? $row->LUGAR ?? 'DISTRITO CAPITAL',
            'fecha' => $row->fecha ?? $row->FECHA ?? '',
            'renovable' => $row->renovable ?? $row->RENOVABLE ?? 'N',
            'estatus_registro' => 'APR',
            'codigo_verificacion' => $row->codigo_verificacion ?? $row->CODIGO_VERIFICACION ?? '',
            'tipo_pension' => $row->tipo_pension ?? $row->TIPO_PENSION ?? 'TRABAJO',
            'tipo_display' => $row->tipo_pension ?? $row->TIPO_PENSION ?? 'TRABAJO',

            // Pensionado
            'id_pensionado' => $row->cedula_pensionado ?? $row->CEDULA_PENSIONADO ?? '',
            'nombre_pensionado' => $row->nombre_pensionado ?? $row->NOMBRE_PENSIONADO ?? 'NO REGISTRADO',
            'direccion_pensionado' => $row->direccion_pensionado ?? $row->DIRECCION_PENSIONADO ?? 'NO REGISTRADA',
            'telefono_pensionado' => $row->telefono_pensionado ?? $row->TELEFONO_PENSIONADO ?? 'NO REGISTRADO',

            // Autorizado
            'id_autorizado' => $row->cedula_autorizado ?? $row->CEDULA_AUTORIZADO ?? '',
            'nombre_autorizado' => $row->nombre_autorizado ?? $row->NOMBRE_AUTORIZADO ?? 'NO REGISTRADO',
            'direccion_autorizado' => $row->direccion_autorizado ?? $row->DIRECCION_AUTORIZADO ?? 'NO REGISTRADA',
            'telefono_autorizado' => $row->telefono_autorizado ?? $row->TELEFONO_AUTORIZADO ?? 'NO REGISTRADO',

            // Datos Pensión / Expediente
            'monto_pension' => $row->monto_pension ?? $row->MONTO_PENSION ?? '130',
            'numero_resolucion' => $row->resolucion_nro ?? $row->RESOLUCION_NRO ?? '',
            'razon_social' => $row->razon_social ?? $row->RAZON_SOCIAL ?? 'AMOR MAYOR',
            'nombre_banco' => $row->entidad_bancaria ?? $row->ENTIDAD_BANCARIA ?? 'NO REGISTRADO',
            'nro_cuenta' => $row->numero_cuenta ?? $row->NUMERO_CUENTA ?? '00000000000000000000',
            'estatus_pension' => 'ACTIVA',

            // Mensualidades
            'acumulado' => $row->acumulado ?? $row->ACUMULADO ?? '',
            'ano_acumulado' => $row->ano_acumulado ?? $row->ANO_ACUMULADO ?? '',
            'mes1' => $row->mes1 ?? $row->MES1 ?? '',
            'ano1' => $row->ano1 ?? $row->ANO1 ?? '',
            'mes2' => $row->mes2 ?? $row->MES2 ?? '',
            'ano2' => $row->ano2 ?? $row->ANO2 ?? '',
            'mes3' => $row->mes3 ?? $row->MES3 ?? '',
            'ano3' => $row->ano3 ?? $row->ANO3 ?? '',
            'mes4' => $row->mes4 ?? $row->MES4 ?? '',
            'ano4' => $row->ano4 ?? $row->ANO4 ?? '',

            // Autorizador
            'nombre_autorizador' => trim($row->nombre_autorizador ?? $row->NOMBRE_AUTORIZADOR ?? 'CESAR RODRIGUEZ MARIA'),
            'cedula_autorizador' => trim($row->cedula_autorizador ?? $row->CEDULA_AUTORIZADOR ?? '8906738'),
            'cargo_autorizador' => $row->cargo_autorizador ?? $row->CARGO_AUTORIZADOR ?? 'Aprobador Autorizado Cobro Pensión',
            'oficina_autorizador' => $row->oficina_administrativa ?? $row->OFICINA_ADMINISTRATIVA ?? 'DIRECCIÓN DE PRESTACIONES',
        ];
    }
}
