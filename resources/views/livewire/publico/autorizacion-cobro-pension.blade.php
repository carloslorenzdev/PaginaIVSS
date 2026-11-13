<div>
    <!-- CABECERA INSTITUCIONAL ULTRA COMPACTA -->
    <div class="position-relative overflow-hidden text-center text-white py-3" style="background: linear-gradient(135deg, #c82333 0%, #8b0000 100%);">
        <div class="container position-relative">
            <div class="d-inline-flex align-items-center gap-2 mb-1 bg-white bg-opacity-15 text-white px-2 py-0-5 rounded-pill small" style="font-size: 0.72rem;">
                <i class="fas fa-file-contract text-warning"></i>
                <span>Dirección de Prestaciones • Forma 14-179</span>
            </div>
            <h1 class="h5 fw-bold mb-0 text-white">Actualización de Autorización de Cobro de Pensión</h1>
            <p class="text-white-50 small mb-0" style="font-size: 0.8rem;">Consulte o renueve su autorización de cobro ante el IVSS</p>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL COMPACTO -->
    <section class="py-3" style="background-color: #f4f6f9; min-height: 50vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-12" style="max-width: 580px;">

                    <!-- TARJETA FORMULARIO COMPACTA -->
                    <div class="card border-0 shadow-sm rounded-3 mb-3 overflow-hidden">
                        <div class="card-header bg-white border-bottom py-2 px-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-id-card text-danger small"></i>
                                <span class="fw-bold text-dark small">Datos de la Solicitud</span>
                            </div>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-0-5 rounded-pill" style="font-size: 0.7rem;">
                                Forma 14-179
                            </span>
                        </div>

                        <div class="card-body p-3">
                            <form wire:submit.prevent="consultar">
                                <div class="row g-2">
                                    <!-- Cédula del Pensionado -->
                                    <div class="col-sm-7 col-12">
                                        <label class="form-label fw-semibold text-dark mb-1" style="font-size: 0.78rem;">
                                            <i class="fas fa-user text-danger me-1"></i> Cédula del Pensionado:
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <select wire:model="nac_pensionado" class="form-select bg-light fw-bold text-center" style="max-width: 65px;">
                                                <option value="V">V-</option>
                                                <option value="E">E-</option>
                                                <option value="T">T-</option>
                                            </select>
                                            <input type="text" 
                                                wire:model="cedula_pensionado"
                                                class="form-control @error('cedula_pensionado') is-invalid @enderror" 
                                                placeholder="Ej: 3111307"
                                                maxlength="10"
                                                inputmode="numeric">
                                        </div>
                                        @error('cedula_pensionado')
                                            <div class="text-danger small mt-1" style="font-size: 0.72rem;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Tipo de Pensión -->
                                    <div class="col-sm-5 col-12">
                                        <label class="form-label fw-semibold text-dark mb-1" style="font-size: 0.78rem;">
                                            <i class="fas fa-tag text-danger me-1"></i> Tipo de Pensión:
                                        </label>
                                        <select wire:model="tipo_pension" class="form-select form-select-sm @error('tipo_pension') is-invalid @enderror">
                                            <option value="10">Vejez</option>
                                            <option value="01">Invalidez</option>
                                            <option value="06">Incapacidad</option>
                                            <option value="12">Sobreviviente</option>
                                        </select>
                                        @error('tipo_pension')
                                            <div class="text-danger small mt-1" style="font-size: 0.72rem;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Cédula del Autorizado -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-dark mb-1" style="font-size: 0.78rem;">
                                            <i class="fas fa-user-check text-success me-1"></i> Cédula del Autorizado:
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <select wire:model="nac_autorizado" class="form-select bg-light fw-bold text-center" style="max-width: 65px;">
                                                <option value="V">V-</option>
                                                <option value="E">E-</option>
                                                <option value="T">T-</option>
                                            </select>
                                            <input type="text" 
                                                wire:model="cedula_autorizado"
                                                class="form-control @error('cedula_autorizado') is-invalid @enderror" 
                                                placeholder="Ej: 30513975"
                                                maxlength="10"
                                                inputmode="numeric">
                                        </div>
                                        @error('cedula_autorizado')
                                            <div class="text-danger small mt-1" style="font-size: 0.72rem;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- BARRA DE ACCIONES (CONSULTAR, RENOVAR, LIMPIAR) -->
                                <div class="d-flex flex-wrap justify-content-center gap-2 pt-3 border-top mt-3">
                                    <button type="submit" wire:click="consultar" class="btn btn-danger btn-sm px-3 fw-semibold shadow-sm" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="consultar">
                                            <i class="fas fa-search me-1"></i> Consultar
                                        </span>
                                        <span wire:loading wire:target="consultar">
                                            <span class="spinner-border spinner-border-sm me-1" role="status"></span> Buscando...
                                        </span>
                                    </button>

                                    <button type="button" wire:click="renovar" class="btn btn-primary btn-sm px-3 fw-semibold shadow-sm" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="renovar">
                                            <i class="fas fa-sync-alt me-1"></i> Renovar
                                        </span>
                                        <span wire:loading wire:target="renovar">
                                            <span class="spinner-border spinner-border-sm me-1" role="status"></span> Renovando...
                                        </span>
                                    </button>

                                    <button type="button" wire:click="limpiar" class="btn btn-outline-secondary btn-sm px-3">
                                        <i class="fas fa-eraser me-1"></i> Limpiar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- MENSAJE DE ALERTA / ERROR -->
                    @if($errorMensaje)
                        <div class="alert alert-warning border-0 shadow-sm rounded-3 py-2 px-3 mb-3 d-flex align-items-center" role="alert">
                            <i class="fas fa-exclamation-triangle text-warning-emphasis me-2"></i>
                            <span class="small text-dark">{{ $errorMensaje }}</span>
                        </div>
                    @endif

                    <!-- TARJETA DE RESULTADO COMPACTA -->
                    @if($resultado)
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-3">
                            <!-- Cabecera de resultado -->
                            <div class="card-header p-2 px-3 text-white d-flex flex-wrap align-items-center justify-content-between gap-2" style="background: linear-gradient(135deg, #0d3b66 0%, #1d2d44 100%);">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-danger rounded-pill px-2 py-0-5 small">FORMA 14-179</span>
                                    <span class="fw-bold text-white small">Nº {{ $resultado['id'] }}</span>
                                    @if($esRenovacion)
                                        <span class="badge bg-info text-dark rounded-pill px-2 py-0-5" style="font-size: 0.7rem;">
                                            <i class="fas fa-sync-alt me-1"></i> RENOVACIÓN
                                        </span>
                                    @else
                                        <span class="badge bg-success bg-opacity-75 rounded-pill px-2 py-0-5" style="font-size: 0.7rem;">
                                            <i class="fas fa-check-circle me-1"></i> APROBADA
                                        </span>
                                    @endif
                                </div>

                                <a href="{{ route('autorizacion.pdf', $resultado['id']) }}" 
                                    target="_blank" 
                                    class="btn btn-danger btn-sm px-2 py-1 fw-semibold shadow-sm" style="font-size: 0.78rem;">
                                    <i class="fas fa-file-pdf me-1"></i> PDF Oficial
                                </a>
                            </div>

                            <div class="card-body p-3">
                                @if($esRenovacion)
                                    <div class="alert alert-success border-0 py-1 px-2 mb-2 rounded-2 small d-flex align-items-center gap-2" style="font-size: 0.75rem;">
                                        <i class="fas fa-check-circle text-success"></i>
                                        <span>Autorización habilitada y vigente para renovación automática.</span>
                                    </div>
                                @endif

                                <div class="row g-2 small">
                                    <!-- Datos Pensionado -->
                                    <div class="col-sm-6 col-12">
                                        <div class="bg-light rounded-2 p-2 h-100 border">
                                            <div class="fw-bold text-danger border-bottom pb-1 mb-1 d-flex align-items-center justify-content-between" style="font-size: 0.75rem;">
                                                <span><i class="fas fa-user me-1"></i> PENSIONADO</span>
                                                <span class="badge bg-secondary text-white">{{ $resultado['id_pensionado'] }}</span>
                                            </div>
                                            <div class="text-truncate fw-bold text-dark mb-1" title="{{ $resultado['nombre_pensionado'] }}">
                                                {{ $resultado['nombre_pensionado'] }}
                                            </div>
                                            <div class="text-muted text-truncate" style="font-size: 0.72rem;" title="{{ $resultado['direccion_pensionado'] }}">
                                                <i class="fas fa-map-marker-alt me-1"></i> {{ $resultado['direccion_pensionado'] ?: 'No registrada' }}
                                            </div>
                                            <div class="text-muted" style="font-size: 0.72rem;">
                                                <i class="fas fa-phone me-1"></i> {{ $resultado['telefono_pensionado'] ?: 'No registrado' }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Datos Autorizado -->
                                    <div class="col-sm-6 col-12">
                                        <div class="bg-light rounded-2 p-2 h-100 border">
                                            <div class="fw-bold text-success border-bottom pb-1 mb-1 d-flex align-items-center justify-content-between" style="font-size: 0.75rem;">
                                                <span><i class="fas fa-user-check me-1"></i> AUTORIZADO</span>
                                                <span class="badge bg-secondary text-white">{{ $resultado['id_autorizado'] }}</span>
                                            </div>
                                            <div class="text-truncate fw-bold text-dark mb-1" title="{{ $resultado['nombre_autorizado'] }}">
                                                {{ $resultado['nombre_autorizado'] }}
                                            </div>
                                            <div class="text-muted text-truncate" style="font-size: 0.72rem;" title="{{ $resultado['direccion_autorizado'] }}">
                                                <i class="fas fa-map-marker-alt me-1"></i> {{ $resultado['direccion_autorizado'] ?: 'No registrada' }}
                                            </div>
                                            <div class="text-muted" style="font-size: 0.72rem;">
                                                <i class="fas fa-phone me-1"></i> {{ $resultado['telefono_autorizado'] ?: 'No registrado' }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Datos Pensión -->
                                    <div class="col-12">
                                        <div class="bg-white rounded-2 p-2 border">
                                            <div class="row g-1 align-items-center text-center">
                                                <div class="col-3 border-end">
                                                    <span class="text-muted d-block" style="font-size: 0.68rem;">Tipo:</span>
                                                    <strong class="text-dark small">{{ $resultado['tipo_display'] }}</strong>
                                                </div>
                                                <div class="col-3 border-end">
                                                    <span class="text-muted d-block" style="font-size: 0.68rem;">Monto Mensual:</span>
                                                    <strong class="text-success small">Bs. {{ number_format((float)$resultado['monto_pension'], 2, ',', '.') }}</strong>
                                                </div>
                                                <div class="col-3 border-end">
                                                    <span class="text-muted d-block" style="font-size: 0.68rem;">Banco:</span>
                                                    <span class="text-dark fw-semibold text-truncate d-block small" title="{{ $resultado['nombre_banco'] }}">{{ $resultado['nombre_banco'] }}</span>
                                                </div>
                                                <div class="col-3">
                                                    <span class="text-muted d-block" style="font-size: 0.68rem;">Nº Cuenta:</span>
                                                    <code class="text-dark" style="font-size: 0.7rem;">{{ $resultado['nro_cuenta'] }}</code>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mensualidades -->
                                    <div class="col-12">
                                        <div class="bg-light rounded-2 p-2 border d-flex flex-wrap align-items-center justify-content-between gap-1">
                                            <span class="text-muted fw-semibold" style="font-size: 0.7rem;">MENSUALIDADES:</span>
                                            <div class="d-flex flex-wrap gap-1">
                                                @if(!empty($resultado['acumulado']))
                                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1" style="font-size: 0.7rem;">
                                                        {{ $resultado['acumulado'] }} {{ $resultado['ano_acumulado'] }}
                                                    </span>
                                                @endif
                                                @if(!empty($resultado['mes1']))
                                                    <span class="badge bg-white text-dark border px-2 py-1" style="font-size: 0.7rem;">
                                                        {{ $resultado['mes1'] }} {{ $resultado['ano1'] }}
                                                    </span>
                                                @endif
                                                @if(!empty($resultado['mes2']))
                                                    <span class="badge bg-white text-dark border px-2 py-1" style="font-size: 0.7rem;">
                                                        {{ $resultado['mes2'] }} {{ $resultado['ano2'] }}
                                                    </span>
                                                @endif
                                                @if(!empty($resultado['mes3']))
                                                    <span class="badge bg-white text-dark border px-2 py-1" style="font-size: 0.7rem;">
                                                        {{ $resultado['mes3'] }} {{ $resultado['ano3'] }}
                                                    </span>
                                                @endif
                                                @if(!empty($resultado['mes4']))
                                                    <span class="badge bg-white text-dark border px-2 py-1" style="font-size: 0.7rem;">
                                                        {{ $resultado['mes4'] }} {{ $resultado['ano4'] }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer con código y botones -->
                                <div class="mt-2 pt-2 border-top d-flex flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="small">
                                        <span class="text-muted d-block" style="font-size: 0.68rem;">CÓDIGO DE VERIFICACIÓN:</span>
                                        <span class="font-monospace fw-bold text-dark" style="font-size: 0.8rem;">{{ $resultado['codigo_verificacion'] }}</span>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('autorizacion.pdf', $resultado['id']) }}" 
                                            target="_blank" 
                                            class="btn btn-danger btn-sm px-3 fw-semibold">
                                            <i class="fas fa-file-pdf me-1"></i> Descargar PDF
                                        </a>
                                        <button type="button" 
                                            onclick="window.open('{{ route('autorizacion.pdf', $resultado['id']) }}', '_blank').print();" 
                                            class="btn btn-outline-dark btn-sm px-3">
                                            <i class="fas fa-print me-1"></i> Imprimir
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
</div>
