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
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" fill="#f3f4f6"></path>
            </svg>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="py-5 bg-watermark-ivss" style="min-height: 70vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9 col-md-11 col-12">

                    <!-- TARJETA FORMULARIO DE CONSULTA -->
                    <div class="card border-0 shadow rounded-4 mb-4 overflow-hidden search-card-container" style="border: 1px solid rgba(0,0,0,0.06) !important;">
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
                                                wire:model.live="cedula"
                                                class="form-control @error('cedula') is-invalid @enderror" 
                                                placeholder="Ej: 123456 o 12345678"
                                                maxlength="10"
                                                inputmode="numeric"
                                                pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
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

                    <!-- ENLACE VOLVER A INICIO SI NO HAY RESULTADO -->
                    @if(!$pensionado)
                        <div class="text-center mt-2 mb-4">
                            <a href="{{ route('inicio') }}" wire:navigate class="btn btn-link text-secondary text-decoration-none fw-semibold">
                                <i class="fas fa-arrow-left me-1"></i> Volver a Inicio
                            </a>
                        </div>
                    @endif

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
                        @php
                            $estatusUpper = strtoupper($pensionado['estatus_pension'] ?? '');
                            $badgeClass = 'bg-success text-white';
                            $badgeIcon = 'fa-check-circle';

                            if (str_contains($estatusUpper, 'FALLECIDO') || str_contains($estatusUpper, 'SUSPENDID') || str_contains($estatusUpper, 'CANCELAD') || str_contains($estatusUpper, 'BLOQUEAD') || str_contains($estatusUpper, 'INACTIV')) {
                                $badgeClass = 'bg-danger text-white';
                                $badgeIcon = 'fa-exclamation-circle';
                            } elseif (str_contains($estatusUpper, 'TRAMITE') || str_contains($estatusUpper, 'REVISION') || str_contains($estatusUpper, 'PENDIENTE')) {
                                $badgeClass = 'bg-warning text-dark';
                                $badgeIcon = 'fa-clock';
                            }
                            $cedulaVisual = $pensionado['cedula_simple'] ?? ($nacionalidad . '-' . preg_replace('/[^0-9]/', '', $cedula));
                        @endphp
                        <div class="card border-0 shadow rounded-4 overflow-hidden mb-4" style="border: 1px solid rgba(0,0,0,0.06) !important;">
                            <!-- Cabecera de Resultado -->
                            <div class="card-header p-3 px-4 text-white d-flex flex-wrap align-items-center justify-content-between gap-3" style="background: linear-gradient(135deg, #0d3b66 0%, #1d2d44 100%);">
                                <div>
                                    <h4 class="fw-bold mb-1 text-white">Detalle del Pensionado</h4>
                                    <p class="text-white-50 small mb-0">Información general de la pensión registrada</p>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="badge bg-white rounded-pill px-3 py-2 fw-bold fs-6 shadow-sm" style="color: #0d3b66 !important;">
                                        Cédula: {{ $cedulaVisual }}
                                    </span>
                                    <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 fw-bold text-uppercase shadow-sm">
                                        <i class="fas {{ $badgeIcon }} me-1"></i> {{ $pensionado['estatus_pension'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <!-- BLOQUE 1: DATOS DEL CAUSANTE -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0 text-dark">Datos del Causante</h6>
                                    </div>
                                    <div class="p-3 bg-light rounded-4">
                                        <div class="row align-items-center g-3">
                                            <div class="col-md-7 col-12">
                                                <div class="text-muted small fw-semibold text-uppercase mb-1">Nombre del Causante</div>
                                                <div class="h5 fw-bold text-dark mb-0">{{ $pensionado['nombre_causante'] }}</div>
                                            </div>
                                            <div class="col-md-5 col-12 border-start-md">
                                                <div class="text-muted small fw-semibold text-uppercase mb-1">Cédula del Causante</div>
                                                <div class="h5 fw-bold text-secondary mb-0">{{ $cedulaVisual }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- BLOQUE 2: DETALLE DE LA PENSIÓN -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0 text-dark">Detalle de la Pensión</h6>
                                    </div>
                                    <div class="p-3 bg-light rounded-4">
                                        <div class="row align-items-center g-3">
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="text-muted small fw-semibold text-uppercase mb-1">Tipo de Pensión</div>
                                                <div class="h6 fw-bold text-dark mb-0">{{ $pensionado['tipo_pension'] }}</div>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-12">
                                                <div class="text-muted small fw-semibold text-uppercase mb-1">Estatus de la Pensión</div>
                                                <div class="h6 fw-bold text-dark mb-0">{{ $pensionado['estatus_pension'] }}</div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="amount-box-custom">
                                                    <div class="text-muted small fw-semibold text-uppercase mb-1">Monto de Pensión</div>
                                                    <div class="amount-val">{{ $pensionado['monto_formateado'] }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- BLOQUE 3: ENTIDAD FINANCIERA Y CUENTA BANCARIA -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-university"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0 text-dark">Entidad Financiera y Cuenta Bancaria</h6>
                                    </div>
                                    <div class="p-3 bg-light rounded-4">
                                        <div class="row align-items-center g-3">
                                            <div class="col-md-6 col-12">
                                                <div class="text-muted small fw-semibold text-uppercase mb-1">Entidad Financiera</div>
                                                <div class="h6 fw-bold text-dark mb-0">{{ $pensionado['entidad_financiera'] }}</div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <div class="text-muted small fw-semibold text-uppercase mb-1">Número de Cuenta</div>
                                                        <div class="account-number-mono mb-0">
                                                            @if($mostrarCuentaCompleta)
                                                                {{ $pensionado['numero_cuenta'] }}
                                                            @else
                                                                {{ $pensionado['numero_cuenta_enmascarado'] }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <button type="button" 
                                                        wire:click="toggleCuenta" 
                                                        class="btn btn-sm btn-outline-secondary rounded-circle p-2 ms-2" 
                                                        title="{{ $mostrarCuentaCompleta ? 'Ocultar dígitos' : 'Mostrar número completo' }}">
                                                        <i class="fas {{ $mostrarCuentaCompleta ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- BOTÓN VOLVER A INICIO -->
                                <div class="d-flex justify-content-end align-items-center pt-2">
                                    <a href="{{ route('inicio') }}" wire:navigate class="btn btn-outline-danger px-4 py-2 fw-semibold rounded-pill shadow-sm">
                                        <i class="fas fa-arrow-left me-2"></i> Volver a Inicio
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
