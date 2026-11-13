<div>
    <!-- HERO SECTION -->
    <div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(220,53,69,0.92) 0%, rgba(139,0,0,0.96) 100%); z-index: 1;"></div>
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.15; z-index: 0;"></div>

        <div class="container position-relative" style="z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 85px; height: 85px;">
                        <i class="fas fa-file-contract text-danger fa-2x"></i>
                    </div>
                    <h1 class="display-5 fw-bold text-white mb-2">Actualización de Autorización de Cobro de Pensión</h1>
                    <p class="lead text-white-50 mb-0 fs-6">Consulte su autorización y descargue la <strong>Forma 14-179</strong> oficial</p>
                </div>
            </div>
        </div>

        <!-- Curva inferior -->
        <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; z-index: 2;">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="display: block; width: calc(100% + 1.3px); height: 45px;">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" fill="#f8f9fa"></path>
            </svg>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="py-5" style="background-color: #f8f9fa; min-height: 60vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">

                    <!-- TARJETA FORMULARIO (Campos exactos a SolicitudAutorizacion.jsp con diseño moderno) -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-2 me-3">
                                    <i class="fas fa-file-signature fs-5"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">Datos de la Solicitud</h5>
                                    <small class="text-muted">Ingrese los datos para consultar y generar su autorización</small>
                                </div>
                            </div>
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-semibold">
                                Forma 14-179
                            </span>
                        </div>

                        <div class="card-body p-4">
                            <form wire:submit.prevent="consultar">
                                <div class="row g-3">
                                    <!-- Nacionalidad del Pensionado -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-dark small mb-1">
                                            Nacionalidad del Pensionado:
                                        </label>
                                        <select wire:model="nac_pensionado" class="form-select @error('nac_pensionado') is-invalid @enderror">
                                            <option value="V">Venezolano</option>
                                            <option value="E">Extranjero</option>
                                            <option value="T">Transeunte</option>
                                        </select>
                                        @error('nac_pensionado')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Cédula del Pensionado -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-dark small mb-1">
                                            Cédula del Pensionado:
                                        </label>
                                        <input type="text" 
                                            wire:model="cedula_pensionado"
                                            class="form-control @error('cedula_pensionado') is-invalid @enderror" 
                                            placeholder="Cédula del Pensionado"
                                            maxlength="10"
                                            inputmode="numeric">
                                        @error('cedula_pensionado')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Tipo de Pensión -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-dark small mb-1">
                                            Tipo de Pensión:
                                        </label>
                                        <select wire:model="tipo_pension" class="form-select @error('tipo_pension') is-invalid @enderror">
                                            <option value="01">Invalidez</option>
                                            <option value="06">Incapacidad</option>
                                            <option value="10">Vejez</option>
                                            <option value="12">Sobreviviente</option>
                                        </select>
                                        @error('tipo_pension')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Nacionalidad del Autorizado -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-dark small mb-1">
                                            Nacionalidad del Autorizado:
                                        </label>
                                        <select wire:model="nac_autorizado" class="form-select @error('nac_autorizado') is-invalid @enderror">
                                            <option value="V">Venezolano</option>
                                            <option value="E">Extranjero</option>
                                            <option value="T">Transeunte</option>
                                        </select>
                                        @error('nac_autorizado')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Cédula del Autorizado -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-dark small mb-1">
                                            Cédula del Autorizado:
                                        </label>
                                        <input type="text" 
                                            wire:model="cedula_autorizado"
                                            class="form-control @error('cedula_autorizado') is-invalid @enderror" 
                                            placeholder="Cédula del Autorizado"
                                            maxlength="10"
                                            inputmode="numeric">
                                        @error('cedula_autorizado')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Botones de Acción -->
                                    <div class="col-12 mt-4 text-center">
                                        <div class="d-inline-flex gap-2">
                                            <button type="submit" class="btn btn-danger px-4 py-2 rounded-3 fw-semibold shadow-sm" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="consultar">
                                                    <i class="fas fa-search me-2"></i> Consultar
                                                </span>
                                                <span wire:loading wire:target="consultar">
                                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                                    Consultando...
                                                </span>
                                            </button>
                                            <button type="button" wire:click="limpiar" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                                <i class="fas fa-eraser me-1"></i> Limpiar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- MENSAJE DE ALERTA -->
                    @if($errorMensaje)
                        <div class="alert alert-warning border-0 shadow-sm rounded-4 p-4 mb-4 d-flex align-items-start" role="alert">
                            <div class="bg-warning bg-opacity-25 text-warning-emphasis rounded-circle p-2 me-3 flex-shrink-0">
                                <i class="fas fa-exclamation-triangle fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1 text-dark">Aviso</h6>
                                <p class="mb-0 text-muted small">{{ $errorMensaje }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- TARJETA DE RESULTADO -->
                    @if($resultado)
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                            <div class="card-header bg-gradient p-4 text-white position-relative" style="background: linear-gradient(135deg, #0d3b66 0%, #1d2d44 100%);">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white rounded-3 p-2 me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-file-invoice text-danger fs-3"></i>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold">FORMA 14-179</span>
                                                <span class="badge bg-success bg-opacity-75 rounded-pill px-3 py-1">
                                                    <i class="fas fa-check-circle me-1"></i> APROBADA
                                                </span>
                                            </div>
                                            <h4 class="fw-bold mb-0 text-white">Planilla Nº {{ $resultado['id'] }}</h4>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="{{ route('autorizacion.pdf', $resultado['id']) }}" 
                                            target="_blank" 
                                            class="btn btn-danger btn-lg px-4 py-2 rounded-3 fw-bold shadow">
                                            <i class="fas fa-file-pdf me-2"></i> Descargar PDF
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <!-- Datos del Pensionado -->
                                    <div class="col-md-6">
                                        <div class="bg-light rounded-4 p-3 h-100 border">
                                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                                <i class="fas fa-user text-danger me-2"></i> Datos del Pensionado
                                            </h6>
                                            <div class="row g-2 small">
                                                <div class="col-sm-5 text-muted">Nombres y Apellidos:</div>
                                                <div class="col-sm-7 fw-bold text-dark">{{ $resultado['nombre_pensionado'] }}</div>

                                                <div class="col-sm-5 text-muted">Cédula de Identidad:</div>
                                                <div class="col-sm-7 fw-semibold text-dark">{{ $resultado['id_pensionado'] }}</div>

                                                <div class="col-sm-5 text-muted">Dirección:</div>
                                                <div class="col-sm-7 text-dark">{{ $resultado['direccion_pensionado'] ?: 'No registrada' }}</div>

                                                <div class="col-sm-5 text-muted">Teléfono:</div>
                                                <div class="col-sm-7 text-dark">{{ $resultado['telefono_pensionado'] ?: 'No registrado' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Datos del Autorizado -->
                                    <div class="col-md-6">
                                        <div class="bg-light rounded-4 p-3 h-100 border">
                                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                                <i class="fas fa-user-check text-success me-2"></i> Datos del Autorizado
                                            </h6>
                                            <div class="row g-2 small">
                                                <div class="col-sm-5 text-muted">Nombres y Apellidos:</div>
                                                <div class="col-sm-7 fw-bold text-dark">{{ $resultado['nombre_autorizado'] }}</div>

                                                <div class="col-sm-5 text-muted">Cédula de Identidad:</div>
                                                <div class="col-sm-7 fw-semibold text-dark">{{ $resultado['id_autorizado'] }}</div>

                                                <div class="col-sm-5 text-muted">Dirección:</div>
                                                <div class="col-sm-7 text-dark">{{ $resultado['direccion_autorizado'] ?: 'No registrada' }}</div>

                                                <div class="col-sm-5 text-muted">Teléfono:</div>
                                                <div class="col-sm-7 text-dark">{{ $resultado['telefono_autorizado'] ?: 'No registrado' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Datos de la Pensión -->
                                    <div class="col-12">
                                        <div class="bg-white rounded-4 p-3 border shadow-sm">
                                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                                <i class="fas fa-money-check-alt text-primary me-2"></i> Datos de la Pensión
                                            </h6>
                                            <div class="row g-3">
                                                <div class="col-md-3 col-6">
                                                    <small class="text-muted d-block">Tipo de Pensión</small>
                                                    <span class="fw-bold text-dark">{{ $resultado['tipo_display'] }}</span>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <small class="text-muted d-block">Monto Mensual</small>
                                                    <span class="fw-bold text-success fs-6">Bs. {{ number_format((float)$resultado['monto_pension'], 2, ',', '.') }}</span>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <small class="text-muted d-block">Entidad Bancaria</small>
                                                    <span class="fw-semibold text-dark">{{ $resultado['nombre_banco'] }}</span>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <small class="text-muted d-block">Número de Cuenta</small>
                                                    <code class="fw-bold text-dark">{{ $resultado['nro_cuenta'] }}</code>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <small class="text-muted d-block">Nº de Resolución</small>
                                                    <span class="fw-semibold text-dark">{{ $resultado['numero_resolucion'] ?: 'N/A' }}</span>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <small class="text-muted d-block">Razón Social</small>
                                                    <span class="fw-semibold text-dark">{{ $resultado['razon_social'] }}</span>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <small class="text-muted d-block">Lugar</small>
                                                    <span class="text-dark">{{ $resultado['lugar'] }}</span>
                                                </div>
                                                <div class="col-md-3 col-6">
                                                    <small class="text-muted d-block">Fecha</small>
                                                    <span class="text-dark">{{ !empty($resultado['fecha']) ? date('d/m/Y', strtotime($resultado['fecha'])) : '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mensualidades Autorizadas -->
                                    <div class="col-12">
                                        <div class="bg-light rounded-4 p-3 border">
                                            <h6 class="fw-bold text-dark mb-2 small text-uppercase">Mensualidades Autorizadas</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                @if(!empty($resultado['acumulado']))
                                                    <div class="bg-white border rounded-3 px-3 py-1 shadow-sm small">
                                                        <span class="text-muted me-1">Apertura:</span>
                                                        <strong class="text-primary">{{ $resultado['acumulado'] }} {{ $resultado['ano_acumulado'] }}</strong>
                                                    </div>
                                                @endif
                                                @if(!empty($resultado['mes1']))
                                                    <div class="bg-white border rounded-3 px-3 py-1 shadow-sm small">
                                                        <strong class="text-dark">{{ $resultado['mes1'] }} {{ $resultado['ano1'] }}</strong>
                                                    </div>
                                                @endif
                                                @if(!empty($resultado['mes2']))
                                                    <div class="bg-white border rounded-3 px-3 py-1 shadow-sm small">
                                                        <strong class="text-dark">{{ $resultado['mes2'] }} {{ $resultado['ano2'] }}</strong>
                                                    </div>
                                                @endif
                                                @if(!empty($resultado['mes3']))
                                                    <div class="bg-white border rounded-3 px-3 py-1 shadow-sm small">
                                                        <strong class="text-dark">{{ $resultado['mes3'] }} {{ $resultado['ano3'] }}</strong>
                                                    </div>
                                                @endif
                                                @if(!empty($resultado['mes4']))
                                                    <div class="bg-white border rounded-3 px-3 py-1 shadow-sm small">
                                                        <strong class="text-dark">{{ $resultado['mes4'] }} {{ $resultado['ano4'] }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Acciones y Código -->
                                <div class="mt-4 pt-3 border-top d-flex flex-wrap align-items-center justify-content-between gap-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-2 p-2 me-2">
                                            <i class="fas fa-barcode fs-5"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">CÓDIGO DE VERIFICACIÓN</small>
                                            <span class="font-monospace fw-bold text-dark fs-6">{{ $resultado['codigo_verificacion'] }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('autorizacion.pdf', $resultado['id']) }}" 
                                            target="_blank" 
                                            class="btn btn-danger px-4 py-2 rounded-3 fw-semibold shadow-sm">
                                            <i class="fas fa-file-pdf me-2"></i> Descargar Planilla (PDF)
                                        </a>
                                        <button type="button" 
                                            onclick="window.open('{{ route('autorizacion.pdf', $resultado['id']) }}', '_blank').print();" 
                                            class="btn btn-outline-dark px-3 py-2 rounded-3">
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
