@extends('layouts.app-public')

@section('content')

    <!-- Section 1: Hero Boxed Carousel -->
    @php
        $carouselStyle = $configuraciones['carrusel_estilo'] ?? 'default';
        $carouselInterval = $configuraciones['carrusel_intervalo'] ?? 5000;
    @endphp
    
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <section id="hero" class="hero-ultimate {{ $carouselStyle == 'cinematic' ? 'carousel-cinematic-style' : '' }} py-4">
        <div class="container">
            <div class="row g-4 h-100">
                <!-- Columna Izquierda: Carrusel (65% aprox) -->
                <div class="col-lg-8 h-100">
                    <div class="hero-container-boxed {{ $carouselStyle == '3d' ? 'carousel-3d-style' : '' }} h-100 shadow-sm" style="border-radius: 1rem; overflow: hidden; height: 500px !important;">
                        <div id="heroCarousel" class="carousel slide h-100 {{ $carouselStyle == '3d' ? 'carousel-fade' : '' }}" data-bs-ride="carousel" data-bs-interval="{{ $carouselInterval }}">
                            <div class="carousel-inner h-100">
                                @forelse($carruseles as $index => $carrusel)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }} h-100 position-relative">
                                        @if($carrusel->enlace)
                                            <a href="{{ $carrusel->enlace }}" target="_blank" class="d-block w-100 h-100">
                                        @endif
                                        
                                        <img src="{{ asset('storage/' . $carrusel->imagen_ruta) }}" class="hero-parallax-img w-100 h-100" style="object-fit: cover;" alt="Carrusel Image">
                                        
                                        @if($carrusel->titulo)
                                            <div class="position-absolute bottom-0 start-0 w-100 p-4 p-md-5 d-flex flex-column justify-content-end" style="background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%); height: 50%;">
                                                <div class="mb-2">
                                                    @if($carrusel->etiquetas)
                                                        @foreach(explode(',', $carrusel->etiquetas) as $etiqueta)
                                                            <span class="badge bg-primary me-2">{{ trim($etiqueta) }}</span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <h2 class="text-white fw-bold mb-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">{{ $carrusel->titulo }}</h2>
                                                <div class="d-flex align-items-center text-white-50">
                                                    @if($carrusel->fecha_publicacion)
                                                        <span class="me-4"><i class="fas fa-clock me-1"></i> {{ \Carbon\Carbon::parse($carrusel->fecha_publicacion)->format('d/m/Y') }}</span>
                                                    @endif
                                                    @if($carrusel->autor)
                                                        <span><i class="fas fa-user-circle me-1"></i> {{ $carrusel->autor }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        @if($carrusel->enlace)
                                            </a>
                                        @endif
                                    </div>
                                @empty
                                    <div class="carousel-item active h-100">
                                        <img src="{{ asset('img/hero-innovation-bg.png') }}" class="hero-parallax-img" alt="Default Hero" style="object-fit: cover; width: 100%; height: 100%;">
                                    </div>
                                    <div class="carousel-item h-100">
                                        <img src="{{ asset('img/medical-aesthetic-1.png') }}" class="hero-parallax-img" alt="Medical Aesthetic 1" style="object-fit: cover; width: 100%; height: 100%;">
                                    </div>
                                    <div class="carousel-item h-100">
                                        <img src="{{ asset('img/medical-aesthetic-2.png') }}" class="hero-parallax-img" alt="Medical Aesthetic 2" style="object-fit: cover; width: 100%; height: 100%;">
                                    </div>
                                @endforelse
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" style="z-index: 20;">
                                <span class="carousel-control-prev-icon bg-dark bg-opacity-25 rounded-circle p-3" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" style="z-index: 20;">
                                <span class="carousel-control-next-icon bg-dark bg-opacity-25 rounded-circle p-3" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Columna Derecha: Trámites Prioritarios (35% aprox) -->
                <div class="col-lg-4 h-100 d-flex flex-column gap-4" style="height: 500px !important;">
                    <div class="p-4 rounded-4 shadow-sm consultas-tiuna-panel flex-fill position-relative" style="background-image: url('{{ !empty($configuraciones['bg_consultas']) ? asset('storage/' . $configuraciones['bg_consultas']) : asset('img/imagen.png') }}'); background-size: cover; background-position: center; border-radius: 1rem;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4" style="background: rgba(0,34,68,0.8);"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center">
                            <h4 class="fw-black mb-4 text-white"><i class="fas fa-search text-danger me-2"></i> CONSULTAS</h4>
                            <div class="list-group list-group-flush bg-transparent gap-2">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCuentaIndividual" class="list-group-item list-group-item-action px-3 py-3 rounded-3 text-white d-flex justify-content-between align-items-center" style="background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <span><i class="fas fa-id-card-alt me-3 text-danger"></i> Cuenta Individual</span>
                                    <i class="fas fa-chevron-right text-white-50 small"></i>
                                </a>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalConsultaPensionado" class="list-group-item list-group-item-action px-3 py-3 rounded-3 text-white d-flex justify-content-between align-items-center" style="background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <span><i class="fas fa-user-check me-3 text-danger"></i> Estatus de Pensionados</span>
                                    <i class="fas fa-chevron-right text-white-50 small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 rounded-4 shadow-sm consultas-tiuna-panel flex-fill position-relative" style="background-image: url('{{ !empty($configuraciones['bg_tiuna']) ? asset('storage/' . $configuraciones['bg_tiuna']) : asset('img/marcha-2.jpg') }}'); background-size: cover; background-position: center; border-radius: 1rem;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4" style="background: rgba(0,34,68,0.85);"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center">
                            <h4 class="fw-black mb-3 text-white"><i class="fas fa-project-diagram text-danger me-2"></i> SISTEMA TIUNA</h4>
                            <p class="text-white-50 small mb-4">Plataforma de autoliquidación y gestión de trabajadores para empresas.</p>
                            <div class="d-flex gap-2 w-100">
                                <a href="{{ $configuraciones['url_tiuna'] ?? '#' }}" class="btn-ultimate btn-ultimate-red flex-fill text-center px-2 py-2 fs-6 text-decoration-none">INGRESAR</a>
                                <a href="{{ $configuraciones['url_registro_tiuna'] ?? '#' }}" class="btn-ultimate btn-ultimate-outline border-white text-white flex-fill text-center px-2 py-2 fs-6 text-decoration-none">REGISTRO</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Core Service Hub (Modernized Circles) -->
    <section id="servicios" class="service-hub-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-6" data-aos="fade-up">
                    <div class="bg-white shadow-sm rounded-4 p-4 text-center border-0 h-100 d-flex flex-column align-items-center transition-hover">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-2">SISTEMA <br>EN LÍNEA</h5>
                        <p class="text-muted small mb-4 flex-fill mt-2">Gestión automatizada de trámites gubernamentales.</p>
                        <a href="#" class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalSistemaEnLinea">VER LISTA</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white shadow-sm rounded-4 p-4 text-center border-0 h-100 d-flex flex-column align-items-center transition-hover">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-2">CIUDADANOS</h5>
                        <p class="text-muted small mb-4 flex-fill mt-2">Consulta de estatus y requisitos ciudadanos.</p>
                        <a href="#" class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalCiudadanos">VER LISTA</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white shadow-sm rounded-4 p-4 text-center border-0 h-100 d-flex flex-column align-items-center transition-hover">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-2">PENSIONADOS</h5>
                        <p class="text-muted small mb-4 flex-fill mt-2">Verificación de pagos y fe de vida digital.</p>
                        <a href="#" class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalPensionados">VER LISTA</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-white shadow-sm rounded-4 p-4 text-center border-0 h-100 d-flex flex-column align-items-center transition-hover">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-building"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-2">EMPLEADORES</h5>
                        <p class="text-muted small mb-4 flex-fill mt-2">Solvencias y obligaciones para patronos.</p>
                        <a href="#" class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalEmpleadores">VER LISTA</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals for Section 2 -->
        <!-- Modal Sistema En Linea -->
        <div class="modal fade" id="modalSistemaEnLinea" tabindex="-1" aria-labelledby="modalSistemaEnLineaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: #002244;">
                        <h5 class="modal-title" id="modalSistemaEnLineaLabel"><i class="fas fa-desktop me-2"></i> Sistema en Línea</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="list-group list-group-flush rounded">
                            <a href="{{ $configuraciones['url_sistema_estado_cuenta'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Estado de Cuenta</a>
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalOrdenPago" class="list-group-item list-group-item-action py-3 text-danger fw-bold">Orden de Pago</a>
                            <a href="{{ $configuraciones['url_sistema_solvencias'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Solvencias Electrónicas</a>
                            <a href="{{ $configuraciones['url_sistema_indemnizaciones_diarias'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Indemnizaciones Diarias</a>
                            <a href="{{ $configuraciones['url_sistema_verificacion_solvencia'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Verificación de Solvencia</a>
                            <a href="{{ $configuraciones['url_sistema_indemnizaciones_unicas'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Indemnizaciones Únicas</a>
                            <a href="{{ $configuraciones['url_sistema_sigesp_v3'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Sigesp_v3</a>
                            <a href="{{ $configuraciones['url_sistema_sigesp_v4'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Sigesp_v4</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ciudadanos -->
        <div class="modal fade" id="modalCiudadanos" tabindex="-1" aria-labelledby="modalCiudadanosLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalCiudadanosLabel"><i class="fas fa-user-circle me-2"></i> Ciudadanos</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="list-group list-group-flush rounded">
                            <a href="{{ $configuraciones['url_ciudadano_informacion'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Información General</a>
                            <a href="{{ $configuraciones['url_ciudadano_beneficio_medico'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Beneficio Médico Integral</a>
                            <a href="{{ $configuraciones['url_ciudadano_continuidad'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Continuidad Facultativa</a>
                            <a href="{{ $configuraciones['url_ciudadano_perdida_empleo'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">¿Perdiste tu empleo?</a>
                            <a href="{{ $configuraciones['url_ciudadano_tramites'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Trámites</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Pensionados -->
        <div class="modal fade" id="modalPensionados" tabindex="-1" aria-labelledby="modalPensionadosLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalPensionadosLabel"><i class="fas fa-users me-2"></i> Pensionados</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="list-group list-group-flush rounded">
                            <a href="{{ $configuraciones['url_pensionados_informacion'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Información General</a>
                            <a href="{{ $configuraciones['url_pensionados_tipos'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Tipos de Pensiones</a>
                            <a href="{{ $configuraciones['url_pensionados_exterior'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Pensionados en el Exterior</a>
                            <a href="{{ $configuraciones['url_pensionados_tramites'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Trámites</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Empleadores -->
        <div class="modal fade" id="modalEmpleadores" tabindex="-1" aria-labelledby="modalEmpleadoresLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalEmpleadoresLabel"><i class="fas fa-building me-2"></i> Empleadores</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="list-group list-group-flush rounded">
                            <a href="{{ $configuraciones['url_tiuna'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Tiuna Web</a>
                            <a href="{{ $configuraciones['url_registro_tiuna'] ?? '#' }}" class="list-group-item list-group-item-action py-3 text-danger fw-bold" target="_blank">Registro Tiuna</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Orden de Pago -->
        <div class="modal fade" id="modalOrdenPago" tabindex="-1" aria-labelledby="modalOrdenPagoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                    <div class="modal-header text-white" style="background-color: #4b74a1;">
                        <h5 class="modal-title fw-bold" id="modalOrdenPagoLabel">
                            <i class="fas fa-file-invoice-dollar me-2"></i> Orden de Pago en Línea
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" style="background-color: #4b74a1; color: white;">
                        <form action="http://autoliquidacionv2.ivss.gob.ve:28081/FacturaDigitalOnline/BrowseReport" method="POST" target="_blank">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-uppercase small" style="color: #e0e0e0;">NÚMERO DE EMPLEADOR</label>
                                <input type="text" name="IdEmpresa" class="form-control" required placeholder="Ingrese Número Patronal">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-uppercase small" style="color: #e0e0e0;">PERÍODO DE FACTURACIÓN</label>
                                <input type="text" name="periodo" class="form-control" required placeholder="Ej. 04/2026">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-uppercase small" style="color: #e0e0e0;">TIPO EMPRESA O PATRONO</label>
                                <select name="tipoEmpresa" class="form-select" required>
                                    <option value="PR">Privado</option>
                                    <option value="PU">Público</option>
                                </select>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn text-white px-4 py-2" style="background-color: #6384a8; border: 1px solid white; font-weight: bold;">
                                    Consultar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Bloque de Interacción de Servicios -->
    <section id="interaccion-servicios" class="py-5" style="background-color: #0a1f3d;">
        <div class="container py-4">
            <div class="row g-4 justify-content-center">
                <!-- Farmacias de Alto Costo -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <a href="{{ $configuraciones['url_farmacias'] ?? '#' }}" class="d-block text-decoration-none h-100 rounded-4 overflow-hidden position-relative card-hover-scale" style="min-height: 220px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                        <div class="position-absolute w-100 h-100 bg-image-zoom" style="background-image: url('{{ !empty($configuraciones['bg_farmacias']) ? asset('storage/' . $configuraciones['bg_farmacias']) : asset('img/medical-aesthetic-1.png') }}'); background-size: cover; background-position: center;"></div>
                        <div class="position-absolute w-100 h-100 overlay-red"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center align-items-center text-white p-4 text-center">
                            <i class="fas fa-clinic-medical fs-1 mb-3 text-white"></i>
                            <h4 class="fw-black m-0 text-white" style="letter-spacing: 1px;">FARMACIAS DE ALTO COSTO</h4>
                        </div>
                    </a>
                </div>
                <!-- Centros de Salud -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <a href="{{ $configuraciones['url_centros_salud'] ?? '#' }}" class="d-block text-decoration-none h-100 rounded-4 overflow-hidden position-relative card-hover-scale" style="min-height: 220px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                        <div class="position-absolute w-100 h-100 bg-image-zoom" style="background-image: url('{{ !empty($configuraciones['bg_centros_salud']) ? asset('storage/' . $configuraciones['bg_centros_salud']) : asset('img/medical-aesthetic-2.png') }}'); background-size: cover; background-position: center;"></div>
                        <div class="position-absolute w-100 h-100 overlay-red"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center align-items-center text-white p-4 text-center">
                            <i class="fas fa-hospital fs-1 mb-3 text-white"></i>
                            <h4 class="fw-black m-0 text-white" style="letter-spacing: 1px;">CENTROS DE SALUD</h4>
                        </div>
                    </a>
                </div>
                <!-- Oficinas Administrativas -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ $configuraciones['url_oficinas'] ?? '#' }}" class="d-block text-decoration-none h-100 rounded-4 overflow-hidden position-relative card-hover-scale" style="min-height: 220px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                        <div class="position-absolute w-100 h-100 bg-image-zoom" style="background-image: url('{{ !empty($configuraciones['bg_oficinas']) ? asset('storage/' . $configuraciones['bg_oficinas']) : asset('img/hero-innovation-bg.png') }}'); background-size: cover; background-position: center;"></div>
                        <div class="position-absolute w-100 h-100 overlay-red"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center align-items-center text-white p-4 text-center">
                            <i class="fas fa-building fs-1 mb-3 text-white"></i>
                            <h4 class="fw-black m-0 text-white" style="letter-spacing: 1px;">OFICINAS ADMINISTRATIVAS</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Grid Services (Legacy Transformation) -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h6 class="text-danger fw-bold text-uppercase" style="letter-spacing: 2px;">Gestión IVSS</h6>
                <h2 class="fw-black">Servicios Complementarios</h2>
            </div>
            
            <div class="grid-services">
                <!-- Constancias y Autorizaciones -->
                <div class="service-tile" data-aos="fade-right">
                    <div class="tile-icon text-white" style="background-color: #8B00FF;"><i class="fas fa-file-signature"></i></div>
                    <div>
                        <h6 class="fw-bold mb-0">Constancias y Autorizaciones</h6>
                        <a href="#" class="text-muted small text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalConstancias">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                    </div>
                </div>
                <!-- Marco Normativo -->
                <div class="service-tile" data-aos="fade-right" data-aos-delay="100">
                    <div class="tile-icon text-white" style="background-color: #32CD32;"><i class="fas fa-gavel"></i></div>
                    <div>
                        <h6 class="fw-bold mb-0">Marco Normativo</h6>
                        <a href="{{ $configuraciones['url_marco_normativo'] ?? '#' }}" class="text-muted small text-decoration-none" target="_blank">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                    </div>
                </div>
                <!-- Biblioteca de Formas -->
                <div class="service-tile" data-aos="fade-right" data-aos-delay="200">
                    <div class="tile-icon bg-info text-white"><i class="fas fa-book-open"></i></div>
                    <div>
                        <h6 class="fw-bold mb-0">Biblioteca de Formas</h6>
                        <a href="{{ $configuraciones['url_biblioteca_formas'] ?? '#' }}" class="text-muted small text-decoration-none" target="_blank">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                    </div>
                </div>
                <!-- Contrataciones Públicas -->
                <div class="service-tile" data-aos="fade-right" data-aos-delay="300">
                    <div class="tile-icon bg-primary text-white"><i class="fas fa-file-contract"></i></div>
                    <div>
                        <h6 class="fw-bold mb-0">Contrataciones Públicas</h6>
                        <a href="{{ $configuraciones['url_contrataciones_publicas'] ?? '#' }}" class="text-muted small text-decoration-none" target="_blank">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                    </div>
                </div>
                <!-- Farmapatria -->
                <div class="service-tile" data-aos="fade-right" data-aos-delay="400">
                    <div class="tile-icon bg-danger text-white"><i class="fas fa-clinic-medical"></i></div>
                    <div>
                        <h6 class="fw-bold mb-0">Farmapatria</h6>
                        <a href="{{ $configuraciones['url_farmapatria'] ?? '#' }}" class="text-muted small text-decoration-none" target="_blank">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                    </div>
                </div>
                <!-- Boletín Informativo -->
                <div class="service-tile" data-aos="fade-right" data-aos-delay="500">
                    <div class="tile-icon bg-success text-white"><i class="fas fa-newspaper"></i></div>
                    <div>
                        <h6 class="fw-bold mb-0">Boletín Informativo</h6>
                        <a href="{{ $configuraciones['url_boletin_informativo'] ?? '#' }}" class="text-muted small text-decoration-none" target="_blank">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                    </div>
                </div>
                <!-- Revista -->
                <div class="service-tile" data-aos="fade-right" data-aos-delay="600">
                    <div class="tile-icon bg-warning text-white"><i class="fas fa-bookmark"></i></div>
                    <div>
                        <h6 class="fw-bold mb-0">Revista Digital</h6>
                        <a href="{{ route('revista_digital') }}" class="text-muted small text-decoration-none">Ver más <i class="fas fa-chevron-right ms-1"></i></a>
                    </div>
                </div>
                <!-- Verificaciones -->
                <div class="service-tile" data-aos="fade-right" data-aos-delay="700">
                    <div class="tile-icon bg-secondary text-white"><i class="fas fa-check-double"></i></div>
                    <div>
                        <h6 class="fw-bold mb-0">Verificaciones</h6>
                        <a href="#" class="text-muted small text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalVerificaciones">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Modal Constancias -->
            <div class="modal fade" id="modalConstancias" tabindex="-1" aria-labelledby="modalConstanciasLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="modalConstanciasLabel"><i class="fas fa-file-signature me-2"></i> Constancias y Autorizaciones</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="list-group list-group-flush rounded">
                                <a href="{{ $configuraciones['url_constancia_cotizaciones'] ?? '#' }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3" target="_blank">
                                    <span class="fw-bold text-secondary"><i class="fas fa-file-alt text-danger me-2"></i> Cotizaciones</span>
                                    <i class="fas fa-external-link-alt text-muted small"></i>
                                </a>
                                <a href="{{ $configuraciones['url_constancia_pension'] ?? '#' }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3" target="_blank">
                                    <span class="fw-bold text-secondary"><i class="fas fa-file-invoice-dollar text-danger me-2"></i> Pensión</span>
                                    <i class="fas fa-external-link-alt text-muted small"></i>
                                </a>
                                <a href="{{ $configuraciones['url_constancia_autorizacion'] ?? '#' }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3" target="_blank">
                                    <span class="fw-bold text-secondary"><i class="fas fa-user-check text-danger me-2"></i> Autorizador Cobro de Pensión</span>
                                    <i class="fas fa-external-link-alt text-muted small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Verificaciones -->
            <div class="modal fade" id="modalVerificaciones" tabindex="-1" aria-labelledby="modalVerificacionesLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="modalVerificacionesLabel"><i class="fas fa-check-double me-2"></i> Verificaciones</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="list-group list-group-flush rounded">
                                <a href="{{ $configuraciones['url_verificacion_autorizacion'] ?? '#' }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3" target="_blank">
                                    <span class="fw-bold text-secondary"><i class="fas fa-check-circle text-danger me-2"></i> Verificación de Autorización de Cobro Pensión</span>
                                    <i class="fas fa-external-link-alt text-muted small"></i>
                                </a>
                                <a href="{{ $configuraciones['url_verificacion_pension'] ?? '#' }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3" target="_blank">
                                    <span class="fw-bold text-secondary"><i class="fas fa-file-signature text-danger me-2"></i> Constancia de Pensión</span>
                                    <i class="fas fa-external-link-alt text-muted small"></i>
                                </a>
                                <a href="{{ $configuraciones['url_verificacion_cotizacion'] ?? '#' }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3" target="_blank">
                                    <span class="fw-bold text-secondary"><i class="fas fa-file-contract text-danger me-2"></i> Constancia de Cotización</span>
                                    <i class="fas fa-external-link-alt text-muted small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Consulta Cuenta Individual -->
    <div class="modal fade" id="modalCuentaIndividual" tabindex="-1" aria-labelledby="modalCuentaIndividualLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #003366;">
                    <h5 class="modal-title fw-bold" id="modalCuentaIndividualLabel">
                        <i class="fas fa-id-card-alt me-2"></i> Cuenta Individual
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                    <!-- Formulario de Búsqueda -->
                    <form id="formCuentaIndividual" data-url="{{ route('consulta.cuenta_individual') }}" onsubmit="submitCuentaIndividual(event)">
                        @csrf
                        <div class="row align-items-end g-3 mb-4">
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-uppercase small text-dark">CÉDULA ASEGURADO</label>
                                <div class="input-group">
                                    <select name="nacionalidad_aseg" class="form-select" style="max-width: 80px;" required>
                                        <option value="V">V.</option>
                                        <option value="E">E.</option>
                                        <option value="T">T.</option>
                                    </select>
                                    <input type="number" name="cedula_aseg" class="form-control" placeholder="Ingrese el número de cédula" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn w-100 text-white" id="btnConsultarCuenta" style="background-color: #003366; font-weight: bold; height: 38px;">
                                    <i class="fas fa-search me-2"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Consulta Pensionado -->

        <!-- Modal Consulta Pensionado -->
        <div class="modal fade" id="modalConsultaPensionado" tabindex="-1" aria-labelledby="modalConsultaPensionadoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                    <div class="modal-header text-white" style="background-color: #3f6087;">
                        <h5 class="modal-title fw-bold" id="modalConsultaPensionadoLabel">
                            <i class="fas fa-user-check me-2"></i> Pensionados
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" style="background-color: #3f6087; color: white;">
                        <form id="formConsultaPensionado" data-url="{{ route('consulta.pensionado') }}" onsubmit="submitConsultaPensionado(event)">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold text-uppercase small" style="color: #e0e0e0;">CÉDULA ASEGURADO</label>
                                <div class="input-group">
                                    <select name="nacionalidad" class="form-select" style="max-width: 80px;" required>
                                        <option value="V">V.</option>
                                        <option value="E">E.</option>
                                    </select>
                                    <input type="number" name="cedula" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-uppercase small" style="color: #e0e0e0;">FECHA DE NACIMIENTO</label>
                                <div class="row g-2">
                                    <div class="col-3">
                                        <select name="d1" class="form-select" required>
                                            @for($i=1; $i<=31; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <select name="m1" class="form-select" required>
                                            @php
                                                $meses = [1=>'ENERO',2=>'FEBRERO',3=>'MARZO',4=>'ABRIL',5=>'MAYO',6=>'JUNIO',7=>'JULIO',8=>'AGOSTO',9=>'SEPTIEMBRE',10=>'OCTUBRE',11=>'NOVIEMBRE',12=>'DICIEMBRE'];
                                            @endphp
                                            @foreach($meses as $num => $nombre)
                                                <option value="{{ $num }}">{{ $nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <select name="y1" class="form-select" required>
                                            @for($i=date('Y'); $i>=1900; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn text-white px-4 py-2" id="btnConsultarPensionado" style="background-color: #6384a8; border: 1px solid white; font-weight: bold;">
                                    Consultar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Section 6: News Feed -->
    <section id="noticias" class="py-5 bg-light">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div data-aos="fade-right">
                    <h6 class="text-danger fw-bold">SALA DE PRENSA</h6>
                    <h2 class="fw-black">Últimas Noticias</h2>
                </div>
                <a href="{{ route('noticias.index') }}" class="btn-ultimate btn-ultimate-red">VER TODAS</a>
            </div>
            
            <div class="row g-4">
                @foreach($noticias as $index => $noticia)
                    @php
                        $imagen = $noticia->medios->first() ? asset('storage/' . $noticia->medios->first()->ruta) : asset('img/imagen.jpg');
                    @endphp
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="news-card-ultimate h-100">
                            <div class="news-thumb"><img src="{{ $imagen }}" alt="News"></div>
                            <div class="p-4">
                                <div class="mb-2">
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 small fw-bold">
                                        <i class="far fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($noticia->fecha_publicacion)->format('d/m/Y - h:i A') }}
                                    </span>
                                </div>
                                <h6 class="fw-bold mb-3">{{ Str::limit($noticia->titulo, 60) }}</h6>
                                <p class="text-muted small mb-4">{{ Str::limit(strip_tags($noticia->contenido), 100) }}</p>
                                <a href="{{ route('noticias.show', $noticia->slug) }}" class="text-danger fw-bold text-decoration-none small">LEER ARTÍCULO <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
