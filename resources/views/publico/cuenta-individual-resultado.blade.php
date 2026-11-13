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
                    <td class="label-cell">Cédula de Identidad</td>
                    <td class="value-cell">{{ $asegurado['cedula_formateada'] ?? ($asegurado['nacionalidad'] . '-' . number_format((int)$asegurado['cedula'], 0, '', '.')) }}</td>
                    <td class="label-cell">Nombre y Apellido</td>
                    <td class="value-cell" colspan="3">{{ $asegurado['nombre_completo'] ?? trim(($asegurado['nombres'] ?? '') . ' ' . ($asegurado['apellidos'] ?? '')) }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Sexo</td>
                    <td class="value-cell">{{ $asegurado['sexo'] ?? 'NO REGISTRADO' }}</td>
                    <td class="label-cell">Fecha Nacimiento</td>
                    <td class="value-cell">{{ $asegurado['fecha_nacimiento'] ?? 'NO REGISTRA' }}</td>
                    <td class="label-cell">Nro. Patronal</td>
                    <td class="value-cell text-red">{{ $afiliacion['numero_patronal'] ?? 'NO REGISTRA' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Nombre Empresa</td>
                    <td class="value-cell" colspan="3">{{ $afiliacion['nombre_empresa'] ?? 'NO REGISTRA' }}</td>
                    <td class="label-cell">Fecha Ingreso / Afiliación</td>
                    <td class="value-cell">{{ $afiliacion['fecha_ingreso'] ?? $afiliacion['fecha_primera_afiliacion'] ?? 'NO REGISTRA' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Datos de Afiliación -->
        <div class="section-title"><i class="fas fa-briefcase me-2 text-red"></i>Datos de Afiliación</div>
        <table class="grid-table">
            <tbody>
                <tr>
                    <td class="label-cell">Último Salario</td>
                    <td class="value-cell text-red">Bs. {{ number_format($afiliacion['ultimo_salario'] ?? 0, 2, ',', '.') }}</td>
                    <td class="label-cell">Estatus</td>
                    <td class="value-cell">{{ $afiliacion['estatus'] ?? 'NO REGISTRA' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Fecha 1ra Afiliación</td>
                    <td class="value-cell">{{ $afiliacion['fecha_primera_afiliacion'] ?? 'NO REGISTRA' }}</td>
                    <td class="label-cell">Fecha Contingencia</td>
                    <td class="value-cell">{{ $afiliacion['fecha_contingencia'] ?? 'NO REGISTRA' }}</td>
                </tr>
                <tr class="bg-red-light">
                    <td class="label-cell text-red">Semanas Acumuladas</td>
                    <td class="value-cell">{{ number_format($acumulados['semanas'] ?? 0, 0, ',', '.') }}</td>
                    <td class="label-cell text-red">Salarios Acumulados</td>
                    <td class="value-cell">Bs. {{ number_format($acumulados['salarios'] ?? 0, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Tabla de 15 años -->
        <div class="section-title text-center"><i class="fas fa-calendar-alt me-2 text-red"></i>Relación de Semanas y Salarios Cotizados (últimos 15 años)</div>
        <table class="grid-table grid-table-dark">
            <thead>
                <tr>
                    <th>Año</th><th>Sem</th><th>Salario (Bs.)</th>
                    <th>Año</th><th>Sem</th><th>Salario (Bs.)</th>
                    <th>Año</th><th>Sem</th><th>Salario (Bs.)</th>
                    <th>Año</th><th>Sem</th><th>Salario (Bs.)</th>
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

        <!-- Resúmenes -->
        <table style="width: 100%; margin-bottom: 0;">
            <tr>
                <td style="width: 49%; vertical-align: top; padding-right: 1%;">
                    <div class="section-title text-center" style="font-size: 0.8rem;">Cantidad de Semanas Cotizadas</div>
                    <table class="grid-table grid-table-dark text-center">
                        <thead>
                            <tr>
                                <th>Art. 92</th>
                                <th>Decr. 4269</th>
                                <th>Últ. 10</th>
                                <th>Últ. 4</th>
                                <th>Últ. 3</th>
                                <th style="background-color: var(--ivss-red);">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ ($resumen_semanas['articulo_92'] ?? 0) === 'PENDIENTE_REGLA' ? 0 : ($resumen_semanas['articulo_92'] ?? 0) }}</td>
                                <td>{{ $resumen_semanas['decreto_4269'] ?? 0 }}</td>
                                <td>{{ $resumen_semanas['ultimos_10'] ?? 0 }}</td>
                                <td>{{ $resumen_semanas['ultimos_4'] ?? 0 }}</td>
                                <td>{{ $resumen_semanas['ultimos_3'] ?? 0 }}</td>
                                <td class="fw-bold text-red fs-6">{{ $resumen_semanas['total'] ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width: 49%; vertical-align: top; padding-left: 1%;">
                    <div class="section-title text-center" style="font-size: 0.8rem;">Salarios de Cotización Promedio</div>
                    <table class="grid-table grid-table-dark text-center">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.2);">
                                <th colspan="2">Mensuales</th>
                                <th colspan="2">Semanales</th>
                            </tr>
                            <tr>
                                <th>Últ. 10</th>
                                <th>Últ. 5</th>
                                <th>Últ. 100</th>
                                <th style="background-color: var(--ivss-red);">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ number_format($promedios['mensual_10_anios'] ?? 0, 2, ',', '.') }}</td>
                                <td>{{ number_format($promedios['mensual_5_anios'] ?? 0, 2, ',', '.') }}</td>
                                <td>{{ number_format($promedios['semanal_100_cotiz'] ?? 0, 2, ',', '.') }}</td>
                                <td class="fw-bold">{{ number_format($promedios['total_salarios'] ?? 0, 2, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        
        <div class="timestamp">
            <span class="text-red"><i class="fas fa-info-circle me-1"></i> Información Actualizada al:</span> {{ now()->translatedFormat('d \d\e F \d\e\l Y \a \l\a\s h:i a') }}<br>
            Información Sujeta a Revisión de Documentos Probatorios y de Carácter Completamente Gratuito.
        </div>

        <!-- Acciones: Imprimir / Cerrar -->
        <div class="footer-actions">
            <button onclick="window.print()" class="btn-ultimate-red me-2">
                <i class="fas fa-print me-2"></i> Imprimir Planilla
            </button>
            <button onclick="window.close()" class="btn btn-secondary px-4 rounded-pill" style="font-family: 'Outfit', sans-serif; font-weight: 600; font-size: 0.85rem;">
                <i class="fas fa-times me-2"></i> Cerrar
            </button>
        </div>
    </div>

</body>
</html>
