<div>
    <!-- CABECERA INSTITUCIONAL -->
    <div class="position-relative overflow-hidden text-center text-white" style="padding: 50px 0 35px 0; background: linear-gradient(135deg, rgba(220,53,69,0.95) 0%, rgba(139,0,0,0.98) 100%);">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.12; z-index: 0;"></div>

        <div class="container position-relative" style="z-index: 2;">
            <h1 class="h3 fw-bold text-white mb-2">Actualización de Autorización de Cobro de Pensión</h1>
            <p class="text-white-50 mb-0 fs-6">Consulte o renueve su autorización de cobro ante el IVSS</p>
        </div>

        <!-- Curva inferior suave -->
        <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; z-index: 2;">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="display: block; width: calc(100% + 1.3px); height: 25px;">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" fill="#f8f9fa"></path>
            </svg>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="py-5" style="background-color: #f8f9fa; min-height: 60vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10 col-12" style="max-width: 780px;">

                    <!-- TARJETA FORMULARIO -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">Datos de la Solicitud</h5>
                                    <span class="text-muted small">Ingrese los datos para consultar o tramitar la renovación</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form wire:submit.prevent="consultar">
                                <div class="row g-3">
                                    <!-- Cédula del Pensionado -->
                                    <div class="col-md-7 col-12">
                                        <label class="form-label fw-semibold text-dark mb-1">
                                            <i class="fas fa-user text-danger me-1"></i> Cédula del Pensionado:
                                        </label>
                                        <div class="input-group">
                                            <select wire:model="nac_pensionado" class="form-select bg-light fw-bold text-center" style="max-width: 80px;">
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
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Tipo de Pensión -->
                                    <div class="col-md-5 col-12">
                                        <label class="form-label fw-semibold text-dark mb-1">
                                            <i class="fas fa-tag text-danger me-1"></i> Tipo de Pensión:
                                        </label>
                                        <select wire:model="tipo_pension" class="form-select @error('tipo_pension') is-invalid @enderror">
                                            <option value="10">Vejez</option>
                                            <option value="01">Invalidez</option>
                                            <option value="06">Incapacidad</option>
                                            <option value="12">Sobreviviente</option>
                                        </select>
                                        @error('tipo_pension')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Cédula del Autorizado -->
                                    <div class="col-md-7 col-12">
                                        <label class="form-label fw-semibold text-dark mb-1">
                                            <i class="fas fa-user-check text-success me-1"></i> Cédula del Autorizado:
                                        </label>
                                        <div class="input-group">
                                            <select wire:model="nac_autorizado" class="form-select bg-light fw-bold text-center" style="max-width: 80px;">
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
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Nota institucional de apoyo -->
                                    <div class="col-md-5 col-12 d-flex align-items-end">
                                        <div class="p-2 px-3 rounded-3 bg-light border text-muted small w-100 d-flex align-items-center gap-2">
                                            <i class="fas fa-shield-alt text-danger fs-5"></i>
                                            <span style="font-size: 0.82rem;">Trámite oficial avalado por la Dirección de Prestaciones</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- BARRA DE ACCIONES (CONSULTAR, RENOVAR, LIMPIAR) -->
                                <div class="d-flex flex-wrap justify-content-center gap-3 pt-4 border-top mt-4">
                                    <button type="submit" wire:click="consultar" class="btn btn-danger px-4 py-2 fw-semibold shadow-sm" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="consultar">
                                            <i class="fas fa-search me-2"></i> Consultar
                                        </span>
                                        <span wire:loading wire:target="consultar">
                                            <span class="spinner-border spinner-border-sm me-2" role="status"></span> Consultando...
                                        </span>
                                    </button>

                                    <button type="button" wire:click="renovar" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="renovar">
                                            <i class="fas fa-sync-alt me-2"></i> Renovar
                                        </span>
                                        <span wire:loading wire:target="renovar">
                                            <span class="spinner-border spinner-border-sm me-2" role="status"></span> Renovando...
                                        </span>
                                    </button>

                                    <button type="button" wire:click="limpiar" class="btn btn-outline-secondary px-4 py-2">
                                        <i class="fas fa-eraser me-2"></i> Limpiar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- MENSAJE DE ALERTA / ERROR -->
                    @if($errorMensaje)
                        <div class="alert alert-warning border-0 shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center" role="alert">
                            <i class="fas fa-exclamation-triangle text-warning-emphasis fs-4 me-3"></i>
                            <div class="text-dark">{{ $errorMensaje }}</div>
                        </div>
                    @endif

                    <!-- TARJETA DE RESULTADO -->
                    @if($resultado)
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                            <!-- Cabecera de resultado -->
                            <div class="card-header p-3 px-4 text-white d-flex flex-wrap align-items-center justify-content-between gap-2" style="background: linear-gradient(135deg, #0d3b66 0%, #1d2d44 100%);">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-danger rounded-pill px-3 py-1">FORMA 14-179</span>
                                    <span class="fw-bold text-white fs-6">Nº {{ $resultado['id'] }}</span>
                                    @if($esRenovacion)
                                        <span class="badge bg-info text-dark rounded-pill px-3 py-1">
                                            <i class="fas fa-sync-alt me-1"></i> RENOVACIÓN VIGENTE
                                        </span>
                                    @else
                                        <span class="badge bg-success bg-opacity-75 rounded-pill px-3 py-1">
                                            <i class="fas fa-check-circle me-1"></i> APROBADA
                                        </span>
                                    @endif
                                </div>

                                <a href="{{ route('autorizacion.pdf', $resultado['id']) }}" 
                                    target="_blank" 
                                    class="btn btn-danger btn-sm px-3 py-2 fw-semibold shadow-sm">
                                    <i class="fas fa-file-pdf me-1"></i> Descargar PDF Oficial
                                </a>
                            </div>

                            <div class="card-body p-4">
                                @if($esRenovacion)
                                    <div class="alert alert-success border-0 p-3 mb-3 rounded-3 d-flex align-items-center gap-2">
                                        <i class="fas fa-check-circle text-success fs-5"></i>
                                        <div>
                                            <strong>Autorización habilitada y vigente para renovación automática.</strong>
                                            <div class="small text-muted">Puede descargar su planilla actualizada haciendo clic en el botón superior o inferior.</div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row g-3">
                                    <!-- Datos Pensionado -->
                                    <div class="col-md-6 col-12">
                                        <div class="bg-light rounded-3 p-3 h-100 border">
                                            <div class="fw-bold text-danger border-bottom pb-2 mb-2 d-flex align-items-center justify-content-between">
                                                <span><i class="fas fa-user me-1"></i> PENSIONADO</span>
                                                <span class="badge bg-secondary text-white">{{ $resultado['id_pensionado'] }}</span>
                                            </div>
                                            <div class="fw-bold text-dark fs-6 mb-1">
                                                {{ $resultado['nombre_pensionado'] }}
                                            </div>
                                            <div class="text-muted small mb-1">
                                                <i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $resultado['direccion_pensionado'] ?: 'No registrada' }}
                                            </div>
                                            <div class="text-muted small">
                                                <i class="fas fa-phone me-1 text-primary"></i> {{ $resultado['telefono_pensionado'] ?: 'No registrado' }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Datos Autorizado -->
                                    <div class="col-md-6 col-12">
                                        <div class="bg-light rounded-3 p-3 h-100 border">
                                            <div class="fw-bold text-success border-bottom pb-2 mb-2 d-flex align-items-center justify-content-between">
                                                <span><i class="fas fa-user-check me-1"></i> AUTORIZADO</span>
                                                <span class="badge bg-secondary text-white">{{ $resultado['id_autorizado'] }}</span>
                                            </div>
                                            <div class="fw-bold text-dark fs-6 mb-1">
                                                {{ $resultado['nombre_autorizado'] }}
                                            </div>
                                            <div class="text-muted small mb-1">
                                                <i class="fas fa-map-marker-alt me-1 text-success"></i> {{ $resultado['direccion_autorizado'] ?: 'No registrada' }}
                                            </div>
                                            <div class="text-muted small">
                                                <i class="fas fa-phone me-1 text-primary"></i> {{ $resultado['telefono_autorizado'] ?: 'No registrado' }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Datos Pensión -->
                                    <div class="col-12">
                                        <div class="bg-white rounded-3 p-3 border shadow-sm">
                                            <div class="row g-2 align-items-center text-center">
                                                <div class="col-md-3 col-6 border-end">
                                                    <span class="text-muted d-block small">Tipo de Contingencia:</span>
                                                    <strong class="text-dark">{{ $resultado['tipo_display'] }}</strong>
                                                </div>
                                                <div class="col-md-3 col-6 border-end">
                                                    <span class="text-muted d-block small">Monto Mensual:</span>
                                                    <strong class="text-success fs-6">Bs. {{ number_format((float)$resultado['monto_pension'], 2, ',', '.') }}</strong>
                                                </div>
                                                <div class="col-md-3 col-6 border-end">
                                                    <span class="text-muted d-block small">Entidad Bancaria:</span>
                                                    <span class="text-dark fw-semibold d-block text-truncate" title="{{ $resultado['nombre_banco'] }}">{{ $resultado['nombre_banco'] }}</span>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <span class="text-muted d-block small">Número de Cuenta:</span>
                                                    <code class="text-dark fw-bold small">{{ $resultado['nro_cuenta'] }}</code>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mensualidades -->
                                    <div class="col-12">
                                        <div class="bg-light rounded-3 p-3 border d-flex flex-wrap align-items-center justify-content-between gap-2">
                                            <span class="text-muted fw-bold small"><i class="fas fa-calendar-alt text-primary me-1"></i> MENSUALIDADES AUTORIZADAS:</span>
                                            <div class="d-flex flex-wrap gap-2">
                                                @if(!empty($resultado['acumulado']))
                                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2">
                                                        {{ $resultado['acumulado'] }} {{ $resultado['ano_acumulado'] }}
                                                    </span>
                                                @endif
                                                @if(!empty($resultado['mes1']))
                                                    <span class="badge bg-white text-dark border px-3 py-2">
                                                        {{ $resultado['mes1'] }} {{ $resultado['ano1'] }}
                                                    </span>
                                                @endif
                                                @if(!empty($resultado['mes2']))
                                                    <span class="badge bg-white text-dark border px-3 py-2">
                                                        {{ $resultado['mes2'] }} {{ $resultado['ano2'] }}
                                                    </span>
                                                @endif
                                                @if(!empty($resultado['mes3']))
                                                    <span class="badge bg-white text-dark border px-3 py-2">
                                                        {{ $resultado['mes3'] }} {{ $resultado['ano3'] }}
                                                    </span>
                                                @endif
                                                @if(!empty($resultado['mes4']))
                                                    <span class="badge bg-white text-dark border px-3 py-2">
                                                        {{ $resultado['mes4'] }} {{ $resultado['ano4'] }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer con código y botones -->
                                <div class="mt-4 pt-3 border-top d-flex flex-wrap align-items-center justify-content-between gap-3">
                                    <div>
                                        <span class="text-muted d-block small">CÓDIGO DE VERIFICACIÓN:</span>
                                        <span class="font-monospace fw-bold text-dark fs-6">{{ $resultado['codigo_verificacion'] }}</span>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('autorizacion.pdf', $resultado['id']) }}" 
                                            target="_blank" 
                                            class="btn btn-danger px-4 py-2 fw-semibold shadow-sm">
                                            <i class="fas fa-file-pdf me-2"></i> Descargar PDF Oficial
                                        </a>
                                        <button type="button" 
                                            onclick="window.open('{{ route('autorizacion.pdf', $resultado['id']) }}', '_blank').print();" 
                                            class="btn btn-outline-dark px-3 py-2">
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
