<div>
    <style>
        /* Estilos específicos para la vista de Consulta de Pensionados */
        .pension-header-gradient {
            background: linear-gradient(135deg, rgba(220,53,69,0.95) 0%, rgba(139,0,0,0.98) 100%);
        }

        .avatar-circle-ivss {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .amount-box-custom {
            background: linear-gradient(135deg, #f0f7ff 0%, #e6f0fa 100%);
            border: 1px solid #b8daff;
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            text-align: center;
        }

        .amount-box-custom .amount-val {
            font-size: 2rem;
            font-weight: 800;
            color: #0b2e59;
            letter-spacing: -0.5px;
        }

        .status-badge-active {
            background-color: #d1e7dd;
            color: #0f5132;
            font-weight: 700;
            padding: 0.5rem 1rem;
            border-radius: 50rem;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .account-number-mono {
            font-family: 'Courier New', Courier, monospace;
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: 1.5px;
            color: #212529;
        }

        @media print {
            header, footer, nav, .btn-print-hide, .pension-header-gradient, .search-card-container {
                display: none !important;
            }
            body, .main-wrapper {
                background: #FFFFFF !important;
            }
            .print-only-header {
                display: block !important;
                margin-bottom: 25px;
                border-bottom: 2px solid #dc3545;
                padding-bottom: 15px;
            }
            .card {
                border: 1px solid #dee2e6 !important;
                box-shadow: none !important;
            }
        }

        .print-only-header {
            display: none;
        }
    </style>

    <!-- CABECERA INSTITUCIONAL -->
    <div class="position-relative overflow-hidden text-center text-white pension-header-gradient" style="padding: 50px 0 35px 0;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.12; z-index: 0;"></div>

        <div class="container position-relative" style="z-index: 2;">
            <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-10 rounded-pill px-3 py-1 mb-3">
                <i class="fas fa-id-card me-2"></i>
                <span class="small fw-semibold text-uppercase tracking-wider">Dirección General de Prestaciones</span>
            </div>
            <h1 class="h3 fw-bold text-white mb-2">Consulta de Pensionados</h1>
            <p class="text-white-50 mb-0 fs-6">Verifica el estatus, monto y datos bancarios de la pensión por cédula del causante</p>
        </div>

        <!-- Curva inferior suave -->
        <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; z-index: 2;">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="display: block; width: calc(100% + 1.3px); height: 25px;">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" fill="#f8f9fa"></path>
            </svg>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="py-5" style="background-color: #f8f9fa; min-height: 65vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9 col-md-11 col-12">

                    <!-- ENCABEZADO EXCLUSIVO PARA IMPRESIÓN -->
                    <div class="print-only-header text-center">
                        <img src="{{ asset('img/membrete.webp') }}" alt="IVSS" style="max-height: 60px;" class="mb-3">
                        <h4 class="fw-bold mb-1">INSTITUTO VENEZOLANO DE LOS SEGUROS SOCIALES</h4>
                        <h6 class="text-secondary mb-0">COMPROBANTE DE CONSULTA DE PENSIÓN</h6>
                        <small class="text-muted">Fecha de Emisión: {{ now()->format('d/m/Y h:i A') }}</small>
                    </div>

                    <!-- TARJETA FORMULARIO DE CONSULTA -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden search-card-container">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="fas fa-search"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">Datos de Consulta</h5>
                                    <span class="text-muted small">Seleccione la nacionalidad e ingrese el número de cédula del causante</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form wire:submit.prevent="consultar">
                                <div class="row g-3">
                                    <!-- Nacionalidad y Cédula -->
                                    <div class="col-md-8 col-12">
                                        <label class="form-label fw-semibold text-dark mb-1">
                                            <i class="fas fa-user-check text-danger me-1"></i> Cédula del Causante:
                                        </label>
                                        <div class="input-group">
                                            <select wire:model="nacionalidad" class="form-select bg-light fw-bold text-center" style="max-width: 90px;">
                                                <option value="V">V-</option>
                                                <option value="E">E-</option>
                                            </select>
                                            <input type="text" 
                                                wire:model="cedula"
                                                class="form-control @error('cedula') is-invalid @enderror" 
                                                placeholder="Ej: 284060 o 80422762"
                                                maxlength="10"
                                                inputmode="numeric"
                                                autofocus>
                                        </div>
                                        @error('cedula')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Acciones del Formulario -->
                                    <div class="col-md-4 col-12 d-flex align-items-end gap-2">
                                        <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold shadow-sm" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="consultar">
                                                <i class="fas fa-search me-1"></i> Consultar
                                            </span>
                                            <span wire:loading wire:target="consultar">
                                                <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                            </span>
                                        </button>
                                        @if($busquedaRealizada || !empty($cedula))
                                            <button type="button" wire:click="limpiar" class="btn btn-outline-secondary py-2" title="Limpiar consulta">
                                                <i class="fas fa-eraser"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- MENSAJE DE ERROR O NO ENCONTRADO -->
                    @if($errorMensaje)
                        <div class="alert alert-warning border-0 shadow-sm rounded-4 p-4 mb-4 d-flex align-items-center" role="alert">
                            <div class="bg-warning bg-opacity-25 text-warning-emphasis rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
                                <i class="fas fa-info-circle fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Información de la Consulta</h6>
                                <div class="text-secondary small">{{ $errorMensaje }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- TARJETA DE RESULTADO DETALLADO -->
                    @if($pensionado)
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                            <!-- Cabecera de Resultado -->
                            <div class="card-header p-3 px-4 text-white d-flex flex-wrap align-items-center justify-content-between gap-2" style="background: linear-gradient(135deg, #0d3b66 0%, #1d2d44 100%);">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold">PENSIÓN IVSS</span>
                                    <span class="fw-bold text-white fs-6">Cédula: {{ $pensionado['cedula_formateada'] }}</span>
                                </div>
                                <div>
                                    <span class="status-badge-active">
                                        <i class="fas fa-check-circle"></i> {{ $pensionado['estatus_pension'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <!-- BLOQUE 1: DATOS DEL CAUSANTE -->
                                <div class="row align-items-center pb-4 mb-4 border-bottom">
                                    <div class="col-auto">
                                        <div class="avatar-circle-ivss">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-muted small fw-semibold text-uppercase">Nombre del Causante</div>
                                        <div class="h5 fw-bold text-dark mb-0">{{ $pensionado['nombre_causante'] }}</div>
                                    </div>
                                    <div class="col-md-auto col-12 mt-3 mt-md-0 text-md-end">
                                        <div class="text-muted small fw-semibold text-uppercase">Cédula de Identidad</div>
                                        <div class="fw-bold text-secondary">{{ $pensionado['cedula_formateada'] }}</div>
                                    </div>
                                </div>

                                <!-- BLOQUE 2: DETALLE DE LA PENSIÓN Y MONTO -->
                                <div class="row g-4 align-items-center pb-4 mb-4 border-bottom">
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                                <i class="fas fa-award"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small fw-semibold text-uppercase">Tipo de Pensión</div>
                                                <div class="fw-bold text-dark">{{ $pensionado['tipo_pension'] }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                                <i class="fas fa-shield-alt"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small fw-semibold text-uppercase">Estatus</div>
                                                <div class="fw-bold text-dark">{{ $pensionado['estatus_pension'] }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="amount-box-custom">
                                            <div class="text-muted small fw-semibold text-uppercase mb-1">Monto de la Pensión</div>
                                            <div class="amount-val">{{ $pensionado['monto_formateado'] }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- BLOQUE 3: ENTIDAD FINANCIERA Y CUENTA BANCARIA -->
                                <div class="p-3 bg-light rounded-4 mb-4">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-6 col-12 border-end-md">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-dark bg-opacity-10 text-dark rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                                    <i class="fas fa-university"></i>
                                                </div>
                                                <div>
                                                    <div class="text-muted small fw-semibold text-uppercase">Entidad Financiera</div>
                                                    <div class="fw-bold text-dark fs-6">{{ $pensionado['entidad_financiera'] }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="d-flex align-items-center justify-content-between px-2">
                                                <div>
                                                    <div class="text-muted small fw-semibold text-uppercase">Número de Cuenta</div>
                                                    <div class="account-number-mono">
                                                        @if($mostrarCuentaCompleta)
                                                            {{ $pensionado['numero_cuenta'] }}
                                                        @else
                                                            {{ $pensionado['numero_cuenta_enmascarado'] }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <button type="button" 
                                                    wire:click="toggleCuenta" 
                                                    class="btn btn-sm btn-outline-secondary rounded-circle p-2 ms-2 btn-print-hide" 
                                                    title="{{ $mostrarCuentaCompleta ? 'Ocultar dígitos' : 'Mostrar número completo' }}">
                                                    <i class="fas {{ $mostrarCuentaCompleta ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- BOTONES DE ACCIÓN (IMPRIMIR COMPROBANTE) -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pt-2 btn-print-hide">
                                    <button type="button" onclick="window.print()" class="btn btn-outline-dark px-4 py-2 fw-semibold rounded-pill">
                                        <i class="fas fa-print me-2"></i> Imprimir Comprobante
                                    </button>
                                    <a href="{{ route('inicio') }}" wire:navigate class="btn btn-link text-secondary text-decoration-none small">
                                        <i class="fas fa-arrow-left me-1"></i> Volver al Portal Interno
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
</div>
