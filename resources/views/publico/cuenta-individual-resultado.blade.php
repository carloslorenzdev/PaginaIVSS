<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta Individual - IVSS</title>
    <!-- Favicon Local -->
    <link rel="icon" type="image/png" href="{{ asset('img/ivss-logo-rojo.png') }}">
    
    <!-- Estilos 100% Locales (Sin CDNs externos) -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cuenta-individual.css') }}" rel="stylesheet">
</head>
<body class="cuenta-individual-body">

    <div class="cuenta-container">
        <!-- Encabezado Institucional -->
        <div class="header-banner">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('img/ivss-logo-rojo.png') }}" alt="Logo IVSS" class="header-logo">
                <div>
                    <h1 class="page-title">Instituto Venezolano de los Seguros Sociales</h1>
                    <div class="page-subtitle">La Seguridad Social es tu derecho</div>
                </div>
            </div>
            <div class="text-end">
                <div style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.05rem; color: var(--ivss-dark);">CUENTA INDIVIDUAL</div>
                <div style="font-size: 0.7rem; color: var(--ivss-gray); font-weight: 600; text-transform: uppercase;">Dir. General de Afiliación y Prestaciones en Dinero</div>
            </div>
        </div>

        <!-- Datos del Asegurado -->
        <div class="section-title"><i class="fas fa-user me-2 text-red"></i>Datos del Asegurado</div>
        <table class="grid-table">
            <tbody>
                <tr>
                    <td class="label-cell" style="width: 25%;">Cédula de Identidad:</td>
                    <td class="value-cell">{{ $asegurado['cedula_formateada'] ?? ($asegurado['nacionalidad'] . '-' . number_format((int)$asegurado['cedula'], 0, '', '.')) }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Nombre y Apellido:</td>
                    <td class="value-cell">{{ $asegurado['nombre_completo'] ?? trim(($asegurado['nombres'] ?? '') . ' ' . ($asegurado['apellidos'] ?? '')) }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Sexo:</td>
                    <td class="value-cell">{{ $asegurado['sexo'] ?? 'NO REGISTRADO' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Fecha de Nacimiento:</td>
                    <td class="value-cell">{{ $asegurado['fecha_nacimiento'] ?? 'NO REGISTRA' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Número Patronal:</td>
                    <td class="value-cell text-red">{{ $afiliacion['numero_patronal'] ?? 'NO REGISTRA' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Nombre Empresa:</td>
                    <td class="value-cell">{{ $afiliacion['nombre_empresa'] ?? 'NO REGISTRA' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Fecha de Egreso:</td>
                    <td class="value-cell">{{ $afiliacion['fecha_egreso'] ?? 'NO REGISTRA' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Datos de Afiliación -->
        <div class="section-title"><i class="fas fa-briefcase me-2 text-red"></i>Datos de Afiliación</div>
        <table class="grid-table">
            <tbody>
                <tr>
                    <td class="label-cell" style="width: 25%;">Último Salario:</td>
                    <td class="value-cell text-red" style="width: 25%;">{{ number_format($afiliacion['ultimo_salario'] ?? 0, 2, ',', '.') }}</td>
                    <td class="label-cell" style="width: 25%;">Estatus del Asegurado:</td>
                    <td class="value-cell" style="width: 25%;">{{ $afiliacion['estatus'] ?? 'NO REGISTRA' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Fecha Primera Afiliación:</td>
                    <td class="value-cell">{{ $afiliacion['fecha_primera_afiliacion'] ?? 'NO REGISTRA' }}</td>
                    <td class="label-cell">Fecha Contingencia:</td>
                    <td class="value-cell">{{ $afiliacion['fecha_contingencia'] ?? 'NO REGISTRA' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Semanas y Salarios Acumulados desde la fecha de Inscripción -->
        <div class="section-title"><i class="fas fa-calculator me-2 text-red"></i>Semanas y Salarios Acumulados desde la fecha de Inscripción</div>
        <table class="grid-table">
            <tbody>
                <tr>
                    <td class="label-cell" style="width: 25%;">Semanas Acumuladas:</td>
                    <td class="value-cell" style="width: 25%;">{{ number_format($acumulados['semanas'] ?? 0, 0, ',', '.') }}</td>
                    <td class="label-cell" style="width: 25%;">Salarios Acumulados:</td>
                    <td class="value-cell" style="width: 25%;">{{ number_format($acumulados['salarios'] ?? 0, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Tabla de 15 años -->
        <div class="section-title text-center"><i class="fas fa-calendar-alt me-2 text-red"></i>Relación de Semanas y Salarios cotizados en los últimos 15 años</div>
        <table class="grid-table grid-table-dark">
            <thead>
                <tr>
                    <th>AÑO</th><th>SEM</th><th>SALARIO</th>
                    <th>AÑO</th><th>SEM</th><th>SALARIO</th>
                    <th>AÑO</th><th>SEM</th><th>SALARIO</th>
                    <th>AÑO</th><th>SEM</th><th>SALARIO</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $relacion = $relacion_15_anios ?? [];
                    $chunks = array_chunk($relacion, 4); 
                @endphp
                @forelse($chunks as $row)
                    <tr>
                        @foreach($row as $item)
                            <td class="fw-bold">{{ $item['anio'] }}</td>
                            <td>{{ $item['semanas'] }}</td>
                            <td>{{ number_format($item['salario'], 2, ',', '.') }}</td>
                        @endforeach
                        @for($i = count($row); $i < 4; $i++)
                            <td></td><td></td><td></td>
                        @endfor
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="py-2 text-muted">No hay registros de cotizaciones en los últimos 15 años</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Cantidad de Semanas Cotizadas -->
        <div class="section-title text-center"><i class="fas fa-list-ol me-2 text-red"></i>Cantidad de Semanas Cotizadas</div>
        <table class="grid-table grid-table-dark text-center">
            <thead>
                <tr>
                    <th style="width: 16%;">ARTICULO 92</th>
                    <th style="width: 16%;">DECRETO 4269</th>
                    <th style="width: 17%;">ÚLTIMOS 10 AÑOS</th>
                    <th style="width: 17%;">ÚLTIMOS 4 AÑOS</th>
                    <th style="width: 17%;">ÚLTIMOS 3 AÑOS</th>
                    <th style="width: 17%; background-color: var(--ivss-red);">TOTAL SEMANAS COTIZADAS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $resumen_semanas['articulo_92'] ?? 'NO APLICA' }}</td>
                    <td>{{ $resumen_semanas['decreto_4269'] ?? '' }}</td>
                    <td>{{ number_format($resumen_semanas['ultimos_10'] ?? 0, 0, ',', '.') }}</td>
                    <td>{{ number_format($resumen_semanas['ultimos_4'] ?? 0, 0, ',', '.') }}</td>
                    <td>{{ number_format($resumen_semanas['ultimos_3'] ?? 0, 0, ',', '.') }}</td>
                    <td class="fw-bold text-red fs-6">{{ number_format($resumen_semanas['total'] ?? 0, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Salarios de Cotización Promedio -->
        <div class="section-title text-center"><i class="fas fa-coins me-2 text-red"></i>Salarios de Cotización Promedio</div>
        <table class="grid-table grid-table-dark text-center">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <th colspan="2" style="width: 50%;">MENSUALES</th>
                    <th style="width: 25%;">SEMANALES</th>
                    <th style="width: 25%; background-color: var(--ivss-red);"></th>
                </tr>
                <tr>
                    <th style="width: 25%;">ÚLTIMOS 10 AÑOS</th>
                    <th style="width: 25%;">ÚLTIMOS 5 AÑOS</th>
                    <th style="width: 25%;">ÚLTIMOS 100 COTIZACIONES</th>
                    <th style="width: 25%; background-color: var(--ivss-red);">TOTAL SALARIOS COTIZADOS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ is_numeric($promedios['mensual_10_anios'] ?? null) && floor($promedios['mensual_10_anios']) == $promedios['mensual_10_anios'] ? number_format($promedios['mensual_10_anios'], 0, ',', '.') : number_format($promedios['mensual_10_anios'] ?? 0, 2, ',', '.') }}</td>
                    <td>{{ is_numeric($promedios['mensual_5_anios'] ?? null) && floor($promedios['mensual_5_anios']) == $promedios['mensual_5_anios'] ? number_format($promedios['mensual_5_anios'], 0, ',', '.') : number_format($promedios['mensual_5_anios'] ?? 0, 2, ',', '.') }}</td>
                    <td>{{ is_numeric($promedios['semanal_100_cotiz'] ?? null) && floor($promedios['semanal_100_cotiz']) == $promedios['semanal_100_cotiz'] ? number_format($promedios['semanal_100_cotiz'], 0, ',', '.') : number_format($promedios['semanal_100_cotiz'] ?? 0, 2, ',', '.') }}</td>
                    <td class="fw-bold text-red">{{ number_format($promedios['total_salarios'] ?? 0, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        
        <div class="timestamp">
            <span class="text-red fw-bold">Información Actualizada al: {{ now()->translatedFormat('d \d\e F \d\e\l Y \a \l\a\s h:i a') }}</span><br>
            <span style="color: var(--ivss-dark); font-weight: 600;">Información Sujeta a Revisión de Documentos Probatorios y de Carácter Completamente Gratuito</span>
        </div>

        <!-- Acciones: Imprimir / Cerrar -->
        <div class="footer-actions">
            <button onclick="window.print()" class="btn-ultimate-red me-2">
                <i class="fas fa-print me-2"></i> Imprimir
            </button>
            <button onclick="window.close()" class="btn btn-secondary px-4 rounded-pill" style="font-family: 'Outfit', sans-serif; font-weight: 600; font-size: 0.85rem;">
                <i class="fas fa-times me-2"></i> Cerrar
            </button>
        </div>
    </div>

</body>
</html>
