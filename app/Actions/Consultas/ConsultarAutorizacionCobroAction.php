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
        $pension = DB::connection('oracle_consulta')
            ->table('PRESTACIONES.AUTORIZA_COBRO_PENSION')
            ->where('ID', strtoupper(trim($idPlanilla)))
            ->first();

        if (!$pension) {
            return null;
        }

        return $this->cargarDetallesCompletos((array)$pension);
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

        return $this->cargarDetallesCompletos((array)$pension);
    }

    /**
     * Consultar por formulario de solicitud:
     * - Nacionalidad y Cédula del Pensionado
     * - Nacionalidad y Cédula del Autorizado
     * - Tipo de Pensión (opcional)
     */
    public function consultarPorSolicitud(array $data): ?array
    {
        $ciPensionado = $this->normalizarCedula(
            $data['nacionalidad_solicitante'] ?? 'V',
            $data['cedula_solicitante'] ?? ''
        );

        $ciAutorizado = $this->normalizarCedula(
            $data['nacionalidad_autorizado'] ?? 'V',
            $data['cedula_autorizado'] ?? ''
        );

        $query = DB::connection('oracle_consulta')
            ->table('PRESTACIONES.AUTORIZA_COBRO_PENSION')
            ->where('ID_PENSIONADO', $ciPensionado)
            ->where('ID_AUTORIZADO', $ciAutorizado);

        // Si se indicó un tipo de pensión específico
        if (!empty($data['tipo_pension']) && $data['tipo_pension'] !== '0') {
            $tipoTexto = $this->tiposPension[$data['tipo_pension']] ?? strtoupper(trim($data['tipo_pension']));
            $query->where(function ($q) use ($tipoTexto, $data) {
                $q->where('TIPO_PENSION', $tipoTexto)
                  ->orWhere('TIPO_PENSION', $data['tipo_pension']);
            });
        }

        // Obtener la autorización más reciente
        $pension = $query->orderBy('FECHA', 'desc')->first();

        if (!$pension) {
            // Reintento: buscar solo por cédula de pensionado si el autorizado no coincide exactamente
            $pensionFallback = DB::connection('oracle_consulta')
                ->table('PRESTACIONES.AUTORIZA_COBRO_PENSION')
                ->where('ID_PENSIONADO', $ciPensionado)
                ->orderBy('FECHA', 'desc')
                ->first();

            if ($pensionFallback && trim($pensionFallback->id_autorizado) === $ciAutorizado) {
                $pension = $pensionFallback;
            }
        }

        if (!$pension) {
            return null;
        }

        return $this->cargarDetallesCompletos((array)$pension);
    }

    /**
     * Carga todos los datos asociados (Pensionado, Autorizado, Expediente/Banco, Autorizador)
     * unificando la consulta institucional del programador.
     */
    protected function cargarDetallesCompletos(array $pension): array
    {
        $idPensionado = $pension['id_pensionado'] ?? $pension['ID_PENSIONADO'] ?? '';
        $idAutorizado = $pension['id_autorizado'] ?? $pension['ID_AUTORIZADO'] ?? '';
        $idUsuarioAut = trim($pension['usuario_autorizador'] ?? $pension['USUARIO_AUTORIZADOR'] ?? '');

        // 1. Datos del Ciudadano Pensionado
        $pensionado = (array)(DB::connection('oracle_consulta')
            ->table('SIRA.CIUDADANO')
            ->where('ID_CIUDADANO', $idPensionado)
            ->first() ?: []);

        // 2. Datos del Ciudadano Autorizado
        $autorizado = (array)(DB::connection('oracle_consulta')
            ->table('SIRA.CIUDADANO')
            ->where('ID_CIUDADANO', $idAutorizado)
            ->first() ?: []);

        // 3. Consulta de Expediente, Banco y Pensión (Query unificado del programador)
        $datosExpediente = $this->obtenerDatosExpediente($idPensionado);

        // 4. Datos del Funcionario Autorizador
        $autorizador = null;
        if ($idUsuarioAut !== '') {
            $autorizador = (array)(DB::connection('oracle_consulta')
                ->selectOne(
                    "SELECT NOMBRE, CEDULA FROM PRESTACIONES.USUARIO_PRESTACIONES WHERE UPPER(TRIM(ID_USUARIO)) = UPPER(TRIM(:id))",
                    ['id' => $idUsuarioAut]
                ) ?: []);
        }

        // Formatear Nombres Completos
        $nombrePensionado = trim(
            ($pensionado['primer_nombre'] ?? $pensionado['PRIMER_NOMBRE'] ?? '') . ' ' .
            ($pensionado['segundo_nombre'] ?? $pensionado['SEGUNDO_NOMBRE'] ?? '') . ' ' .
            ($pensionado['primer_apellido'] ?? $pensionado['PRIMER_APELLIDO'] ?? '') . ' ' .
            ($pensionado['segundo_apellido'] ?? $pensionado['SEGUNDO_APELLIDO'] ?? '')
        );

        if (empty($nombrePensionado) && !empty($datosExpediente['nombre_causante'])) {
            $nombrePensionado = $datosExpediente['nombre_causante'];
        }

        $nombreAutorizado = trim(
            ($autorizado['primer_nombre'] ?? $autorizado['PRIMER_NOMBRE'] ?? '') . ' ' .
            ($autorizado['segundo_nombre'] ?? $autorizado['SEGUNDO_NOMBRE'] ?? '') . ' ' .
            ($autorizado['primer_apellido'] ?? $autorizado['PRIMER_APELLIDO'] ?? '') . ' ' .
            ($autorizado['segundo_apellido'] ?? $autorizado['SEGUNDO_APELLIDO'] ?? '')
        );

        // Transformación de Tipo de Pensión para vista
        $tipoPensionRaw = strtoupper($pension['tipo_pension'] ?? $pension['TIPO_PENSION'] ?? 'VEJEZ');
        $tipoDisplay = $tipoPensionRaw;
        if ($tipoPensionRaw === 'VEJEZ') {
            $tipoDisplay = 'TRABAJO';
        } elseif ($tipoPensionRaw === 'INCAPACIDAD' || $tipoPensionRaw === 'INVALIDEZ') {
            $tipoDisplay = 'DISCAPACIDAD';
        }

        $origenData = ($datosExpediente['origen_data'] ?? '') === 'MIGRACIONCP'
            ? 'AMOR MAYOR'
            : ($datosExpediente['origen_data'] ?? 'AMOR MAYOR');

        return [
            'id' => $pension['id'] ?? $pension['ID'],
            'lugar' => $pension['lugar'] ?? $pension['LUGAR'] ?? 'DISTRITO CAPITAL',
            'fecha' => $pension['fecha'] ?? $pension['FECHA'] ?? '',
            'estatus_registro' => $pension['estatus_registro'] ?? $pension['ESTATUS_REGISTRO'] ?? '',
            'codigo_verificacion' => $pension['codigo_verificacion'] ?? $pension['CODIGO_VERIFICACION'] ?? '',
            'renovable' => $pension['renovable'] ?? $pension['RENOVABLE'] ?? 'N',
            'tipo_pension' => $tipoPensionRaw,
            'tipo_display' => $tipoDisplay,

            // Pensionado
            'id_pensionado' => $idPensionado,
            'nombre_pensionado' => $nombrePensionado ?: 'NO REGISTRADO',
            'direccion_pensionado' => $pension['direccion_pensionado'] ?? $pension['DIRECCION_PENSIONADO'] ?? 'NO REGISTRADA',
            'telefono_pensionado' => $pension['telefono_pensionado'] ?? $pension['TELEFONO_PENSIONADO'] ?? 'NO REGISTRADO',

            // Autorizado
            'id_autorizado' => $idAutorizado,
            'nombre_autorizado' => $nombreAutorizado ?: 'NO REGISTRADO',
            'direccion_autorizado' => $pension['direccion_autorizado'] ?? $pension['DIRECCION_AUTORIZADO'] ?? 'NO REGISTRADA',
            'telefono_autorizado' => $pension['telefono_autorizado'] ?? $pension['TELEFONO_AUTORIZADO'] ?? 'NO REGISTRADO',

            // Pensión / Expediente
            'monto_pension' => $datosExpediente['monto_de_pension'] ?? $datosExpediente['monto_pension'] ?? 130,
            'numero_resolucion' => $datosExpediente['numero_resolucion'] ?? '',
            'razon_social' => $origenData,
            'nombre_banco' => $datosExpediente['entidad_financiera'] ?? $datosExpediente['nombre_banco'] ?? 'NO REGISTRADO',
            'nro_cuenta' => $datosExpediente['numero_de_cuenta'] ?? $datosExpediente['nro_cuenta'] ?? '00000000000000000000',
            'estatus_pension' => $datosExpediente['estatus_de_la_pension'] ?? 'ACTIVA',

            // Mensualidades autorizadas
            'acumulado' => $pension['acumulado'] ?? $pension['ACUMULADO'] ?? '',
            'ano_acumulado' => $pension['ano_acumulado'] ?? $pension['ANO_ACUMULADO'] ?? '',
            'mes1' => $pension['mes1'] ?? $pension['MES1'] ?? '',
            'ano1' => $pension['ano1'] ?? $pension['ANO1'] ?? '',
            'mes2' => $pension['mes2'] ?? $pension['MES2'] ?? '',
            'ano2' => $pension['ano2'] ?? $pension['ANO2'] ?? '',
            'mes3' => $pension['mes3'] ?? $pension['MES3'] ?? '',
            'ano3' => $pension['ano3'] ?? $pension['ANO3'] ?? '',
            'mes4' => $pension['mes4'] ?? $pension['MES4'] ?? '',
            'ano4' => $pension['ano4'] ?? $pension['ANO4'] ?? '',

            // Autorizador
            'usuario_autorizador' => $idUsuarioAut,
            'nombre_autorizador' => trim($autorizador['nombre'] ?? $autorizador['NOMBRE'] ?? 'CESAR RODRIGUEZ MARIA'),
            'cedula_autorizador' => trim($autorizador['cedula'] ?? $autorizador['CEDULA'] ?? '8906738'),
            'cargo_autorizador' => 'Aprobador Autorizado Cobro Pensión',
            'oficina_autorizador' => 'DIRECCIÓN DE PRESTACIONES',
        ];
    }

    /**
     * Ejecuta el query del programador unificado para obtener expediente, contingencia y banco.
     */
    protected function obtenerDatosExpediente(string $ciPensionado): array
    {
        // Query 1: Expedientes estándar (EXPEDIENTES_14105)
        $sqlProgramador = "SELECT
            TC.DESCRIPCION_DE_CONTINGENCIA AS TIPO_DE_PENSION,
            E.CEDULA_CAUSANTE,
            NVL(
                NULLIF(REGEXP_REPLACE(TRIM(C_CAUS.PRIMER_NOMBRE || ' ' || C_CAUS.SEGUNDO_NOMBRE || ' ' || C_CAUS.PRIMER_APELLIDO || ' ' || C_CAUS.SEGUNDO_APELLIDO), ' +', ' '), ''),
                CASE WHEN TRIM(E.CEDULA_CAUSANTE) = TRIM(CP.CEDULA_DEL_COBRADOR) THEN NVL(TRIM(CP.NOMBRE_COBRADOR), 'NO REGISTRADO') ELSE 'NO REGISTRADO' END
            ) AS NOMBRE_CAUSANTE,
            BP.NOMBRE_BANCO AS ENTIDAD_FINANCIERA,
            E.NRO_CUENTA AS NUMERO_DE_CUENTA,
            EP.DESCRIPCION AS ESTATUS_DE_LA_PENSION,
            NVL(E.MONTO_PENSION, 0) AS MONTO_DE_PENSION,
            E.NUMERO_RESOLUCION,
            E.ORIGEN_DATA
        FROM PRESTACIONES.COBRADOR_PENSION CP
        INNER JOIN PRESTACIONES.EXPEDIENTES_14105 E
            ON E.NUMERO_EXPEDIENTE = CP.NUMERO_EXPEDIENTE
        LEFT JOIN SIRA.CIUDADANO C_CAUS
            ON C_CAUS.ID_CIUDADANO = E.CEDULA_CAUSANTE
        LEFT JOIN SIRA.CIUDADANO C_COB
            ON C_COB.ID_CIUDADANO = CP.CEDULA_DEL_COBRADOR
        INNER JOIN PRESTACIONES.TIPOS_CONTINGENCIA TC
            ON TC.TIPO_DE_CONTINGENCIA = E.TIPO_DE_CONTINGENCIA
        INNER JOIN PRESTACIONES.BANCO_PRESTACIONES BP
            ON BP.ID_BANCO = E.ID_BANCO
        INNER JOIN PRESTACIONES.ESTATUS_PENSIONES EP
            ON EP.ID_ESTATUS = E.ID_ESTATUS
        WHERE E.CEDULA_CAUSANTE = :ci";

        $res = DB::connection('oracle_consulta')->selectOne($sqlProgramador, ['ci' => $ciPensionado]);
        if ($res) {
            return (array)$res;
        }

        // Query 2: Fallback para pensiones Amor Mayor (EXPEDIENTES_14105_CP)
        $sqlCP = "SELECT
            TC.DESCRIPCION_DE_CONTINGENCIA AS TIPO_DE_PENSION,
            E.CEDULA_CAUSANTE,
            NVL(
                NULLIF(REGEXP_REPLACE(TRIM(C_CAUS.PRIMER_NOMBRE || ' ' || C_CAUS.SEGUNDO_NOMBRE || ' ' || C_CAUS.PRIMER_APELLIDO || ' ' || C_CAUS.SEGUNDO_APELLIDO), ' +', ' '), ''),
                'NO REGISTRADO'
            ) AS NOMBRE_CAUSANTE,
            BP.NOMBRE_BANCO AS ENTIDAD_FINANCIERA,
            BP.NRO_CUENTA AS NUMERO_DE_CUENTA,
            'ACTIVA' AS ESTATUS_DE_LA_PENSION,
            NVL(E.MONTO_PENSION, 0) AS MONTO_DE_PENSION,
            E.NUMERO_RESOLUCION,
            E.ORIGEN_DATA
        FROM PRESTACIONES.EXPEDIENTES_14105_CP E
        LEFT JOIN SIRA.CIUDADANO C_CAUS
            ON C_CAUS.ID_CIUDADANO = E.CEDULA_CAUSANTE
        LEFT JOIN PRESTACIONES.TIPOS_CONTINGENCIA TC
            ON TC.TIPO_DE_CONTINGENCIA = E.TIPO_DE_CONTINGENCIA
        LEFT JOIN PRESTACIONES.BANCO_PRESTACIONES BP
            ON BP.ID_BANCO = E.ID_BANCO
        WHERE E.CEDULA_CAUSANTE = :ci";

        $resCP = DB::connection('oracle_consulta')->selectOne($sqlCP, ['ci' => $ciPensionado]);
        if ($resCP) {
            return (array)$resCP;
        }

        // Query 3: Respaldo legacy de EXPEDIENTES_14105 con JOIN directo a BANCO_PRESTACIONES
        $sqlDirecto = "SELECT 
            e.NUMERO_RESOLUCION, 
            e.MONTO_PENSION, 
            e.ORIGEN_DATA,
            bp.NOMBRE_BANCO,
            bp.NRO_CUENTA
        FROM PRESTACIONES.EXPEDIENTES_14105 e
        LEFT JOIN PRESTACIONES.BANCO_PRESTACIONES bp ON e.ID_BANCO = bp.ID_BANCO
        WHERE e.CEDULA_CAUSANTE = :ci
        UNION
        SELECT 
            e.NUMERO_RESOLUCION, 
            e.MONTO_PENSION, 
            e.ORIGEN_DATA,
            bp.NOMBRE_BANCO,
            bp.NRO_CUENTA
        FROM PRESTACIONES.EXPEDIENTES_14105_CP e
        LEFT JOIN PRESTACIONES.BANCO_PRESTACIONES bp ON e.ID_BANCO = bp.ID_BANCO
        WHERE e.CEDULA_CAUSANTE = :ci2";

        $resDirecto = DB::connection('oracle_consulta')->selectOne($sqlDirecto, [
            'ci' => $ciPensionado,
            'ci2' => $ciPensionado
        ]);

        return $resDirecto ? (array)$resDirecto : [];
    }
}
