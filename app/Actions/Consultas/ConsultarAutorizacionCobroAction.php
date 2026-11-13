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
                ->table('PRESTACIONES.USUARIO_PRESTACIONES')
                ->whereRaw('UPPER(TRIM(ID_USUARIO)) = UPPER(TRIM(?))', [$idUsuarioAut])
                ->select(['NOMBRE', 'CEDULA'])
                ->first() ?: []);
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
     * Obtiene los datos del expediente, contingencia y banco utilizando
     * el Query Builder / ORM de Laravel unificando la consulta institucional del programador.
     */
    protected function obtenerDatosExpediente(string $ciPensionado): array
    {
        // 1. Query Builder para Expedientes estándar (EXPEDIENTES_14105)
        $expediente = DB::connection('oracle_consulta')
            ->table('PRESTACIONES.COBRADOR_PENSION as cp')
            ->join('PRESTACIONES.EXPEDIENTES_14105 as e', 'e.NUMERO_EXPEDIENTE', '=', 'cp.NUMERO_EXPEDIENTE')
            ->leftJoin('SIRA.CIUDADANO as c_caus', 'c_caus.ID_CIUDADANO', '=', 'e.CEDULA_CAUSANTE')
            ->leftJoin('SIRA.CIUDADANO as c_cob', 'c_cob.ID_CIUDADANO', '=', 'cp.CEDULA_DEL_COBRADOR')
            ->join('PRESTACIONES.TIPOS_CONTINGENCIA as tc', 'tc.TIPO_DE_CONTINGENCIA', '=', 'e.TIPO_DE_CONTINGENCIA')
            ->join('PRESTACIONES.BANCO_PRESTACIONES as bp', 'bp.ID_BANCO', '=', 'e.ID_BANCO')
            ->join('PRESTACIONES.ESTATUS_PENSIONES as ep', 'ep.ID_ESTATUS', '=', 'e.ID_ESTATUS')
            ->where('e.CEDULA_CAUSANTE', $ciPensionado)
            ->select([
                'tc.DESCRIPCION_DE_CONTINGENCIA as tipo_de_pension',
                'e.CEDULA_CAUSANTE as cedula_causante',
                DB::raw("NVL(
                    NULLIF(REGEXP_REPLACE(TRIM(c_caus.PRIMER_NOMBRE || ' ' || c_caus.SEGUNDO_NOMBRE || ' ' || c_caus.PRIMER_APELLIDO || ' ' || c_caus.SEGUNDO_APELLIDO), ' +', ' '), ''),
                    CASE WHEN TRIM(e.CEDULA_CAUSANTE) = TRIM(cp.CEDULA_DEL_COBRADOR) THEN NVL(TRIM(cp.NOMBRE_COBRADOR), 'NO REGISTRADO') ELSE 'NO REGISTRADO' END
                ) as nombre_causante"),
                'bp.NOMBRE_BANCO as entidad_financiera',
                'e.NRO_CUENTA as numero_de_cuenta',
                'ep.DESCRIPCION as estatus_de_la_pension',
                DB::raw('NVL(e.MONTO_PENSION, 0) as monto_de_pension'),
                'e.NUMERO_RESOLUCION as numero_resolucion',
                'e.ORIGEN_DATA as origen_data',
            ])
            ->first();

        if ($expediente) {
            return (array)$expediente;
        }

        // 2. Query Builder para pensiones Amor Mayor (EXPEDIENTES_14105_CP)
        $expedienteCP = DB::connection('oracle_consulta')
            ->table('PRESTACIONES.EXPEDIENTES_14105_CP as e')
            ->leftJoin('SIRA.CIUDADANO as c_caus', 'c_caus.ID_CIUDADANO', '=', 'e.CEDULA_CAUSANTE')
            ->leftJoin('PRESTACIONES.TIPOS_CONTINGENCIA as tc', 'tc.TIPO_DE_CONTINGENCIA', '=', 'e.TIPO_DE_CONTINGENCIA')
            ->leftJoin('PRESTACIONES.BANCO_PRESTACIONES as bp', 'bp.ID_BANCO', '=', 'e.ID_BANCO')
            ->where('e.CEDULA_CAUSANTE', $ciPensionado)
            ->select([
                'tc.DESCRIPCION_DE_CONTINGENCIA as tipo_de_pension',
                'e.CEDULA_CAUSANTE as cedula_causante',
                DB::raw("NVL(
                    NULLIF(REGEXP_REPLACE(TRIM(c_caus.PRIMER_NOMBRE || ' ' || c_caus.SEGUNDO_NOMBRE || ' ' || c_caus.PRIMER_APELLIDO || ' ' || c_caus.SEGUNDO_APELLIDO), ' +', ' '), ''),
                    'NO REGISTRADO'
                ) as nombre_causante"),
                'bp.NOMBRE_BANCO as entidad_financiera',
                'bp.NRO_CUENTA as numero_de_cuenta',
                DB::raw("'ACTIVA' as estatus_de_la_pension"),
                DB::raw('NVL(e.MONTO_PENSION, 0) as monto_de_pension'),
                'e.NUMERO_RESOLUCION as numero_resolucion',
                'e.ORIGEN_DATA as origen_data',
            ])
            ->first();

        if ($expedienteCP) {
            return (array)$expedienteCP;
        }

        // 3. Query Builder de respaldo para cuentas bancarias en EXPEDIENTES_14105
        $expedienteDirecto = DB::connection('oracle_consulta')
            ->table('PRESTACIONES.EXPEDIENTES_14105 as e')
            ->leftJoin('PRESTACIONES.BANCO_PRESTACIONES as bp', 'bp.ID_BANCO', '=', 'e.ID_BANCO')
            ->where('e.CEDULA_CAUSANTE', $ciPensionado)
            ->select([
                'e.NUMERO_RESOLUCION as numero_resolucion',
                'e.MONTO_PENSION as monto_pension',
                'e.ORIGEN_DATA as origen_data',
                'bp.NOMBRE_BANCO as nombre_banco',
                'bp.NRO_CUENTA as nro_cuenta',
            ])
            ->first();

        return $expedienteDirecto ? (array)$expedienteDirecto : [];
    }
}

