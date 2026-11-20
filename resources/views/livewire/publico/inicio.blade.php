<div>

    <!-- Section 1: Hero Boxed Carousel -->
    @php
        $carouselStyle = $configuraciones['carrusel_estilo'] ?? 'default';
        $carouselInterval = $configuraciones['carrusel_intervalo'] ?? 5000;
        $fondoIvss = file_exists(public_path('imagenes/fondo-ivss.webp')) ? asset('imagenes/fondo-ivss.webp') : asset('imagenes/fondo-ivss.png');
    @endphp
    
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" nonce="{{ app('csp-nonce') }}">
    
    <section id="hero" class="hero-ultimate {{ $carouselStyle == 'cinematic' ? 'carousel-cinematic-style' : '' }} py-4" style="background-image: linear-gradient(rgba(243, 244, 246, 0.85), rgba(243, 244, 246, 0.85)), url('{{ $fondoIvss }}') !important; background-size: cover !important; background-position: center !important; background-attachment: fixed !important;">
        <div class="container">
            <div class="row g-4 h-100">
                <!-- Columna Izquierda: Carrusel (65% aprox) -->
                <div class="col-lg-8 h-100">
                    <div class="hero-container-boxed {{ $carouselStyle == '3d' ? 'carousel-3d-style' : '' }} h-100 shadow-lg border" style="border-radius: 1rem; overflow: hidden; height: 500px !important; box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; border-color: rgba(0,0,0,0.08) !important;">
                        <div id="heroCarousel" class="carousel slide h-100 {{ $carouselStyle == '3d' ? 'carousel-fade' : '' }}" data-bs-ride="carousel" data-bs-interval="{{ $carouselInterval }}">
                            <div class="carousel-inner h-100">
                                @forelse($carruseles as $index => $carrusel)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }} h-100 position-relative">
                                        @if($carrusel->enlace)
                                            <a href="{{ $carrusel->enlace }}" target="_blank" rel="noopener noreferrer" class="d-block w-100 h-100">
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
                                                        <span><i class="fas fa-clock me-1"></i> {{ \Carbon\Carbon::parse($carrusel->fecha_publicacion)->format('d/m/Y') }}</span>
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
                    <div class="p-4 rounded-4 shadow-lg border border-secondary consultas-tiuna-panel flex-fill position-relative" style="background-image: url('{{ !empty($configuraciones['bg_consultas']) ? asset('storage/' . $configuraciones['bg_consultas']) : asset('img/imagen.png') }}'); background-size: cover; background-position: center; border-radius: 1rem; box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4 bg-dark" style="opacity: 0.6;"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center">
                            <h4 class="fw-black mb-4 text-white"><i class="fas fa-search text-danger me-2"></i> CONSULTAS</h4>
                            <div class="list-group list-group-flush bg-transparent gap-2">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalCuentaIndividual" class="list-group-item list-group-item-action px-3 py-3 rounded-3 text-white d-flex justify-content-between align-items-center" style="background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <span><i class="fas fa-id-card-alt me-3 text-danger"></i> Cuenta Individual</span>
                                    <i class="fas fa-chevron-right text-white-50 small"></i>
                                </a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalConsultaPensionado" class="list-group-item list-group-item-action px-3 py-3 rounded-3 text-white d-flex justify-content-between align-items-center" style="background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <span><i class="fas fa-user-check me-3 text-danger"></i> Estatus de Pensionados</span>
                                    <i class="fas fa-chevron-right text-white-50 small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 rounded-4 shadow-lg border border-secondary consultas-tiuna-panel flex-fill position-relative" style="background-image: url('{{ !empty($configuraciones['bg_tiuna']) ? asset('storage/' . $configuraciones['bg_tiuna']) : asset('img/marcha-2.jpg') }}'); background-size: cover; background-position: center; border-radius: 1rem; box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4 bg-dark" style="opacity: 0.6;"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center">
                            <h4 class="fw-black mb-3 text-white"><i class="fas fa-project-diagram text-danger me-2"></i> SISTEMA TIUNA</h4>
                            <p class="text-white-50 small mb-4">Plataforma de autoliquidación y gestión de trabajadores para empresas.</p>
                            <div class="d-flex gap-2 w-100">
                                @if(($configuraciones['visible_url_tiuna'] ?? '1') !== '0')
                                <a href="{{ formatear_enlace($configuraciones['url_tiuna'] ?? '#') }}" target="_blank" rel="noopener noreferrer" class="btn-ultimate btn-ultimate-red flex-fill d-flex align-items-center justify-content-center text-center px-2 py-2 fs-6 text-decoration-none">INGRESAR</a>
                                @endif
                                @if(($configuraciones['visible_url_registro_tiuna'] ?? '1') !== '0')
                                <a href="{{ formatear_enlace($configuraciones['url_registro_tiuna'] ?? '#') }}" target="_blank" rel="noopener noreferrer" class="btn-ultimate btn-ultimate-outline border-white text-white flex-fill d-flex align-items-center justify-content-center text-center px-2 py-2 fs-6 text-decoration-none">REGISTRO</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Core Service Hub (Modernized Circles) -->
    <section id="servicios" class="service-hub-section" style="background-image: linear-gradient(rgba(243, 244, 246, 0.85), rgba(243, 244, 246, 0.85)), url('{{ $fondoIvss }}') !important; background-size: cover !important; background-position: center !important; background-attachment: fixed !important;">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <!-- 1. Afiliación -->
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="bg-white shadow-lg border rounded-4 p-4 text-center h-100 d-flex flex-column align-items-center transition-hover" style="box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; border-color: rgba(0,0,0,0.08) !important;">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-2">AFILIACIÓN</h5>
                        <p class="text-muted small mb-4 flex-fill mt-2">Planillas, TIUNA, asegurados y cuenta individual.</p>
                        <a href="#" class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalAfiliacion">VER LISTA</a>
                    </div>
                </div>

                <!-- 2. Cobranzas -->
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white shadow-lg border rounded-4 p-4 text-center h-100 d-flex flex-column align-items-center transition-hover" style="box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; border-color: rgba(0,0,0,0.08) !important;">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-coins"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-2">COBRANZAS</h5>
                        <p class="text-muted small mb-4 flex-fill mt-2">Recaudación, órdenes de pago y solvencias.</p>
                        <a href="#" class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalCobranzas">VER LISTA</a>
                    </div>
                </div>

                <!-- 3. Prestaciones -->
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white shadow-lg border rounded-4 p-4 text-center h-100 d-flex flex-column align-items-center transition-hover" style="box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; border-color: rgba(0,0,0,0.08) !important;">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-2">PRESTACIONES</h5>
                        <p class="text-muted small mb-4 flex-fill mt-2">Pensiones, reposos e indemnizaciones.</p>
                        <a href="#" class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalPrestaciones">VER LISTA</a>
                    </div>
                </div>

                <!-- 4. Pérdida de Empleo -->
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-white shadow-lg border rounded-4 p-4 text-center h-100 d-flex flex-column align-items-center transition-hover" style="box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; border-color: rgba(0,0,0,0.08) !important;">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-2">PÉRDIDA DE <br class="d-none d-xl-block">EMPLEO</h5>
                        <p class="text-muted small mb-4 flex-fill mt-2">Sistema SAPPIE e indemnización al parado.</p>
                        <a href="#" class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalPerdidaEmpleo">VER LISTA</a>
                    </div>
                </div>

                <!-- 5. Salud -->
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="bg-white shadow-lg border rounded-4 p-4 text-center h-100 d-flex flex-column align-items-center transition-hover" style="box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; border-color: rgba(0,0,0,0.08) !important;">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-2">SALUD</h5>
                        <p class="text-muted small mb-4 flex-fill mt-2">Historias médicas, morbilidad y alto costo.</p>
                        <a href="#" class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalSalud">VER LISTA</a>
                    </div>
                </div>

                <!-- 6. Servidor Público -->
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white shadow-lg border rounded-4 p-4 text-center h-100 d-flex flex-column align-items-center transition-hover" style="box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; border-color: rgba(0,0,0,0.08) !important;">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-2">SERVIDOR <br class="d-none d-xl-block">PÚBLICO</h5>
                        <p class="text-muted small mb-4 flex-fill mt-2">Autoservicio RRHH, clave, carnet QR y soporte.</p>
                        <a href="#" class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalServidorPublico">VER LISTA</a>
                    </div>
                </div>

                <!-- 7. Fiscalización -->
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white shadow-lg border rounded-4 p-4 text-center h-100 d-flex flex-column align-items-center transition-hover" style="box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; border-color: rgba(0,0,0,0.08) !important;">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h5 class="fw-bold text-dark mt-2">FISCALIZACIÓN</h5>
                        <p class="text-muted small mb-4 flex-fill mt-2">Control y seguimiento de auditorías patronales.</p>
                        <a href="#" class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalFiscalizacion">VER LISTA</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals for Section 2 (7 Áreas Internas) -->
        <!-- Modal 1: Afiliación -->
        <div class="modal fade" id="modalAfiliacion" tabindex="-1" aria-labelledby="modalAfiliacionLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-id-card fa-2x"></i>
                        </div>

                        <h4 id="modalAfiliacionLabel" class="fw-bold text-dark mb-2">
                            Afiliación
                        </h4>
                        <p class="small text-muted mb-4">
                            Sistemas y herramientas de afiliación para funcionarios y patronos.
                        </p>

                        <div class="d-flex flex-column text-start">
                            <a href="http://planillaselectronicas.ivss.int:28085/WsIvssTranscripWeb/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-file-invoice me-2"></i> Sistema de Planillas Electrónicas</a>
                            <a href="http://autorizadorregistro.ivss.int:28084/Funcionario/login.jsp" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-user-shield me-2"></i> Autorizador de Registro TIUNA</a>
                            <a href="http://registronodependientes.ivss.int/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-user-tie me-2"></i> Reg. NO Dependientes y Continuación Facultativa</a>
                            <a href="http://actualizacionasegurado.ivss.int:28081/Sacea/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-user-edit me-2"></i> Actualización de Estado de Asegurado (SACEA)</a>
                            <a href="javascript:void(0)" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalCuentaIndividual" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-id-card-alt me-2"></i> Consulta de Cuenta Individual</a>
                            <a href="http://cantidadempresas.ivss.int:28080/SACEOA/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-building me-2"></i> Empleadores por Oficina Administrativa (SACEOA)</a>
                            <a href="http://patronocedula.ivss.int:28081/consultasIntra/consultarEmpresaRepresentante.ivss" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-search-plus me-2"></i> Consulta de Empleadores por Cédula</a>
                            <a href="http://listadotrabajadores.ivss.int:28081/consultasIntra/consultarAsegurados.ivss" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-users me-2"></i> Trabajadores Activos por Empleador</a>
                            <a href="http://consultaempresa.ivss.int:28082/VerificarEmpresa" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-network-wired me-2"></i> Consulta Empresa TIUNA / SIRA</a>
                            <a href="http://administracionusuarios.ivss.int:28081/AdmUsuarios/" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-user-cog me-2"></i> Adm. de Usuarios (Afiliación)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 2: Cobranzas -->
        <div class="modal fade" id="modalCobranzas" tabindex="-1" aria-labelledby="modalCobranzasLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>

                        <h4 id="modalCobranzasLabel" class="fw-bold text-dark mb-2">
                            Cobranzas
                        </h4>
                        <p class="small text-muted mb-4">
                            Recaudación, órdenes de pago, convenios y solvencias patronales.
                        </p>

                        <div class="d-flex flex-column text-start">
                            <a href="http://cobranzas.ivss.int:28080/IVSSCobranzas/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-coins me-2"></i> Sistema de Gestión de Cobranzas</a>
                            <a href="http://recaudacion.ivss.int:8080/RecaudacionWeb/login.jsp" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-cash-register me-2"></i> Sistema de Recaudación</a>
                            <a href="javascript:void(0)" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalAvisoIntimacion" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-money-check-alt me-2"></i> Consulta de Orden de Pago</a>
                            <a href="http://empresas.ivss.int:28081/consultasIntra/consultarEmpresa.ivss" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-chart-line me-2"></i> Estado de Cuenta del Empleador</a>
                            <a href="http://constanciasolvencia.ivss.int:28080/CESolvencia/configuracion/Default.html" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-certificate me-2"></i> Verificación de Solvencias y Comprobantes</a>
                            <a href="http://registrosolvencias.ivss.int:28084/solvencia/login.jsp" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-clipboard-check me-2"></i> Sistema de Registro de Solvencias</a>
                            <a href="http://administracionusuarios.ivss.int:28081/AdmUsuarios/" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-user-lock me-2"></i> Adm. de Usuarios (Cobranzas)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 3: Prestaciones -->
        <div class="modal fade" id="modalPrestaciones" tabindex="-1" aria-labelledby="modalPrestacionesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-user-check fa-2x"></i>
                        </div>

                        <h4 id="modalPrestacionesLabel" class="fw-bold text-dark mb-2">
                            Prestaciones
                        </h4>
                        <p class="small text-muted mb-4">
                            Pensiones, reposos e indemnizaciones económicas.
                        </p>

                        <div class="d-flex flex-column text-start">
                            <a href="{{ route('consulta_pension') }}" wire:navigate class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-user-check me-2"></i> Consulta de Pensión</a>
                            <a href="http://pensionresolucion.ivss.int:28082/PensionadosResolucion/criterio_cons_pensiones_intranet.jsp" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-stamp me-2"></i> Consulta de Pensión con Resolución</a>
                            <a href="{{ route('autorizacion_cobro_pension') }}" wire:navigate class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-file-signature me-2"></i> Autorización Cobro Pensión (Forma 14-179)</a>
                            <a href="http://indemnizaciones.ivss.int:28083/IndemnizacionWeb/servicios" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-notes-medical me-2"></i> Consulta de Indemnizaciones Diarias</a>
                            <a href="http://reporteindemnizaciones.ivss.int:28083/ReporteIndemnizacion/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-chart-pie me-2"></i> Reporte de Indemnizaciones Diarias</a>
                            <a href="http://app04-1.ivss.int:28082/PrestacionesWeb" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-hand-holding-usd me-2"></i> Sistema de Prestaciones Dinerarias</a>
                            <a href="http://administracionusuarios.ivss.int:28081/AdmUsuarios/" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-users-cog me-2"></i> Adm. de Usuarios (Prestaciones)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 4: Pérdida de Empleo -->
        <div class="modal fade" id="modalPerdidaEmpleo" tabindex="-1" aria-labelledby="modalPerdidaEmpleoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-briefcase fa-2x"></i>
                        </div>

                        <h4 id="modalPerdidaEmpleoLabel" class="fw-bold text-dark mb-2">
                            Pérdida de Empleo
                        </h4>
                        <p class="small text-muted mb-4">
                            Atención al cesante e indemnizaciones por pérdida involuntaria del trabajo.
                        </p>

                        <div class="d-flex flex-column text-start">
                            <a href="http://sappie.ivss.int:28081/Sappie/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-briefcase me-2"></i> SAPPIE (Atención al Parado)</a>
                            <a href="http://administracionusuarios.ivss.int:28081/AdmUsuarios/" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-user-shield me-2"></i> Adm. de Usuarios (SAPPIE)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 5: Salud -->
        <div class="modal fade" id="modalSalud" tabindex="-1" aria-labelledby="modalSaludLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-heartbeat fa-2x"></i>
                        </div>

                        <h4 id="modalSaludLabel" class="fw-bold text-dark mb-2">
                            Salud
                        </h4>
                        <p class="small text-muted mb-4">
                            Indicadores, registros epidemiológicos y farmacias de alto costo.
                        </p>

                        <div class="d-flex flex-column text-start">
                            <a href="http://indicadoressalud.ivss.int/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-chart-line me-2"></i> Sistema de Indicadores de Salud</a>
                            <a href="http://morbilidad.ivss.int/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-hospital-user me-2"></i> Registro de Morbilidad Hospitalaria</a>
                            <a href="http://historiasmedicas.ivss.int:28083/Historias_Medicas/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-file-medical-alt me-2"></i> Sistema de Historias Médicas</a>
                            <a href="http://farmaciaaltocosto.ivss.int/site/" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-pills me-2"></i> Farmacia de Alto Costo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 6: Servidor Público -->
        <div class="modal fade" id="modalServidorPublico" tabindex="-1" aria-labelledby="modalServidorPublicoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-users-cog fa-2x"></i>
                        </div>

                        <h4 id="modalServidorPublicoLabel" class="fw-bold text-dark mb-2">
                            Servidor Público
                        </h4>
                        <p class="small text-muted mb-4">
                            Autoservicio para servidores públicos, credenciales y soporte DGI.
                        </p>

                        <div class="d-flex flex-column text-start">
                            <a href="http://rrhh.ivss.int:28081/Comprobante/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-file-invoice me-2"></i> Solicitud RRHH (Recibos / ARC)</a>
                            <a href="http://cambiodeclave.ivss.gov.ve/passwd/cambiar_clave.php" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-key me-2"></i> Cambio de Clave de Red</a>
                            <a href="http://w3.ivss.gob.ve/SIAR/" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-headset me-2"></i> Centro de Servicios SIAR (Mesa de Ayuda)</a>
                            <a href="http://w3.ivss.gob.ve/contenido/CATIVSS" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-piggy-bank me-2"></i> Caja de Ahorro (CATIVSS)</a>
                            <a href="https://carnet.ivss.int/login" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-qrcode me-2"></i> Sistema de Carnetización QR</a>
                            <a href="https://correo.ivss.gob.ve/" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-envelope-open-text me-2"></i> Correo Institucional Webmail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 7: Fiscalización -->
        <div class="modal fade" id="modalFiscalizacion" tabindex="-1" aria-labelledby="modalFiscalizacionLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-tasks fa-2x"></i>
                        </div>

                        <h4 id="modalFiscalizacionLabel" class="fw-bold text-dark mb-2">
                            Fiscalización
                        </h4>
                        <p class="small text-muted mb-4">
                            Control, seguimiento y registro de fiscalizaciones patronales.
                        </p>

                        <div class="d-flex flex-column text-start">
                            <a href="http://fiscalizacion.ivss.int" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0" target="_blank" rel="noopener noreferrer"><i class="fas fa-tasks me-2"></i> Sistema de Fiscalización</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>



        <!-- Modal Aviso de Intimación -->
        <div class="modal fade" id="modalAvisoIntimacion" tabindex="-1" aria-labelledby="modalAvisoIntimacionLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>

                        <h4 id="modalAvisoIntimacionLabel" class="fw-bold text-dark mb-2">
                            Aviso de Intimación
                        </h4>
                        <p class="small text-muted mb-4">
                            Información importante sobre el procedimiento de cobro e intimación tributaria.
                        </p>

                        <div class="p-3 rounded-3 bg-light text-muted small mb-4 border" style="line-height: 1.6; text-align: justify;">
                            El Instituto Venezolano de los Seguros Sociales, a través de Providencia Administrativa N° 002, de fecha 03 de Abril de 2017, publicada en la Gaceta Oficial de la República Bolivariana de Venezuela N° 41.159, de fecha 26 de Mayo de 2017, aprobó la incorporación del aviso previsto para el Procedimiento de Intimación contemplado en el Capítulo III, Sección Décima del Decreto con Rango, Valor y Fuerza de Ley del Código Orgánico Tributario, en las órdenes de pago libradas por este Instituto a través del Portal Web 
                            <a href="http://www.ivss.gob.ve" target="_blank" class="text-danger fw-bold text-decoration-none">www.ivss.gob.ve</a>.
                        </div>

                        <button type="button" 
                                class="btn btn-danger w-100 py-3 fw-bold rounded-pill shadow-sm text-uppercase" 
                                data-bs-dismiss="modal" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalOrdenPago">
                            Continuar a Orden de Pago
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Consulta Orden de Pago -->
        <div class="modal fade" id="modalOrdenPago" tabindex="-1" aria-labelledby="modalOrdenPagoLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-file-invoice-dollar fa-2x"></i>
                        </div>

                        <h4 id="modalOrdenPagoLabel" class="fw-bold text-dark mb-2">
                            Orden de Pago en Línea
                        </h4>
                        <p class="small text-muted mb-4">
                            Ingrese su número patronal para consultar y generar su factura digital en PDF.
                        </p>

                        <form wire:submit.prevent="consultarOrdenPago" id="formOrdenPago" class="text-start" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-2">Número de Empleador / Patronal</label>
                                <input type="text" wire:model="op_idEmpresa" class="form-control border rounded shadow-sm py-2" required placeholder="Ej. OOO111222">
                                @error('op_idEmpresa') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-2">Período de Facturación</label>
                                <select wire:model="op_periodo" class="form-select border rounded shadow-sm py-2" required>
                                    @php
                                        $currentDate = \Carbon\Carbon::now();
                                        if ($currentDate->day < 30) {
                                            $currentDate->subMonth();
                                        }
                                        
                                        for($i = 0; $i < 60; $i++) {
                                            $date = $currentDate->copy()->subMonths($i);
                                            $val = $date->format('m/Y');
                                            echo "<option value=\"{$val}\">{$val}</option>";
                                        }
                                    @endphp
                                </select>
                                @error('op_periodo') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-2">Tipo de Empresa o Patrono</label>
                                <select wire:model="op_tipoEmpresa" class="form-select border rounded shadow-sm py-2" required>
                                    <option value="PR">Privado</option>
                                    <option value="PU">Público Descentralizado</option>
                                    <option value="TU">Público Centralizado - Órgano Tutelar</option>
                                    <option value="AD">Público Centralizado - Órgano Adscrito</option>
                                </select>
                                @error('op_tipoEmpresa') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-pill shadow-sm text-uppercase" id="btnOrdenPago" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="consultarOrdenPago">Consultar</span>
                                <span wire:loading wire:target="consultarOrdenPago">
                                    <i class="fas fa-spinner fa-spin me-2"></i> Generando Orden de Pago...
                                </span>
                            </button>
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
                <div class="col-lg-3 col-md-6" data-aos="fade-up">
                    <a href="{{ route('farmacias') }}" wire:navigate class="d-block text-decoration-none h-100 rounded-4 overflow-hidden position-relative card-hover-scale" style="min-height: 220px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                        <div class="position-absolute w-100 h-100 bg-image-zoom" style="background-image: url('{{ !empty($configuraciones['bg_farmacias']) ? asset('storage/' . $configuraciones['bg_farmacias']) : asset('img/medical-aesthetic-1.png') }}'); background-size: cover; background-position: center;"></div>
                        <div class="position-absolute w-100 h-100 bg-dark" style="opacity: 0.6;"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center align-items-center text-white p-4 text-center">
                            <i class="fas fa-clinic-medical fs-1 mb-3 text-white"></i>
                            <h4 class="fw-black m-0 text-white" style="letter-spacing: 1px;">FARMACIAS DE ALTO COSTO</h4>
                        </div>
                    </a>
                </div>
                <!-- Centros de Salud -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <a href="{{ route('centros_salud') }}" wire:navigate class="d-block text-decoration-none h-100 rounded-4 overflow-hidden position-relative card-hover-scale" style="min-height: 220px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                        <div class="position-absolute w-100 h-100 bg-image-zoom" style="background-image: url('{{ !empty($configuraciones['bg_centros_salud']) ? asset('storage/' . $configuraciones['bg_centros_salud']) : asset('img/medical-aesthetic-2.png') }}'); background-size: cover; background-position: center;"></div>
                        <div class="position-absolute w-100 h-100 bg-dark" style="opacity: 0.6;"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center align-items-center text-white p-4 text-center">
                            <i class="fas fa-hospital fs-1 mb-3 text-white"></i>
                            <h4 class="fw-black m-0 text-white" style="letter-spacing: 1px;">CENTROS DE SALUD</h4>
                        </div>
                    </a>
                </div>
                <!-- Oficinas Administrativas -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('oficinas_administrativas') }}" wire:navigate class="d-block text-decoration-none h-100 rounded-4 overflow-hidden position-relative card-hover-scale" style="min-height: 220px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                        <div class="position-absolute w-100 h-100 bg-image-zoom" style="background-image: url('{{ !empty($configuraciones['bg_oficinas']) ? asset('storage/' . $configuraciones['bg_oficinas']) : asset('img/hero-innovation-bg.png') }}'); background-size: cover; background-position: center;"></div>
                        <div class="position-absolute w-100 h-100 bg-dark" style="opacity: 0.6;"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center align-items-center text-white p-4 text-center">
                            <i class="fas fa-building fs-1 mb-3 text-white"></i>
                            <h4 class="fw-black m-0 text-white" style="letter-spacing: 1px;">OFICINAS ADMINISTRATIVAS</h4>
                        </div>
                    </a>
                </div>
                <!-- Servicios al Funcionario -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalServiciosFuncionario" class="d-block text-decoration-none h-100 rounded-4 overflow-hidden position-relative card-hover-scale" style="min-height: 220px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                        <div class="position-absolute w-100 h-100 bg-image-zoom" style="background-image: url('{{ !empty($configuraciones['bg_servicios_funcionario']) ? asset('storage/' . $configuraciones['bg_servicios_funcionario']) : asset('img/Verificacion-1.png') }}'); background-size: cover; background-position: center;"></div>
                        <div class="position-absolute w-100 h-100 bg-dark" style="opacity: 0.6;"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center align-items-center text-white p-4 text-center">
                            <i class="fas fa-users-cog fs-1 mb-3 text-white"></i>
                            <h4 class="fw-black m-0 text-white" style="letter-spacing: 1px;">SERVICIOS AL<br>FUNCIONARIO</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal Servicios al Funcionario -->
        <div class="modal fade" id="modalServiciosFuncionario" tabindex="-1" aria-labelledby="modalServiciosFuncionarioLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>
                        
                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-users-cog fa-2x"></i>
                        </div>

                        <h4 id="modalServiciosFuncionarioLabel" class="fw-bold text-dark mb-2">
                            Servicios al Funcionario
                        </h4>
                        <p class="small text-muted mb-4">
                            Accesos directos para la gestión de recursos humanos y beneficios.
                        </p>

                        <div class="d-flex flex-column text-start">
                            @if(($configuraciones['visible_url_verificacion_constancia'] ?? '1') !== '0')
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalConstanciaTrabajo" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-check-double me-2"></i> Verificación de Constancia
                            </a>
                            @endif
                            @if(($configuraciones['visible_url_ingresa_correo'] ?? '1') !== '0')
                            <a href="{{ formatear_enlace($configuraciones['url_ingresa_correo'] ?? '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-envelope me-2"></i> Ingresa a tu Correo
                            </a>
                            @endif
                            @if(($configuraciones['visible_url_solicitudes_rrhh'] ?? '1') !== '0')
                            <a href="{{ formatear_enlace($configuraciones['url_solicitudes_rrhh'] ?? '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-file-alt me-2"></i> Solicitudes a RRHH
                            </a>
                            @endif
                            @if(($configuraciones['visible_url_consulta_prestaciones'] ?? '1') !== '0')
                            <a href="{{ formatear_enlace($configuraciones['url_consulta_prestaciones'] ?? '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-hand-holding-usd me-2"></i> Consulta de Prestaciones Sociales
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Constancia de Trabajo -->
        <div class="modal fade" id="modalConstanciaTrabajo" tabindex="-1" aria-labelledby="modalConstanciaTrabajoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>
                        
                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-file-contract fa-2x"></i>
                        </div>

                        <h4 id="modalConstanciaTrabajoLabel" class="fw-bold text-dark mb-2">
                            Constancias de Trabajo
                        </h4>
                        <p class="small text-muted mb-4">
                            Verifique la autenticidad de una constancia de trabajo.
                        </p>

                        <form id="formConstanciaTrabajo" class="text-start">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-2">NÚMERO DE CÉDULA</label>
                                <div class="input-group border rounded shadow-sm">
                                    <select name="nacionalidad_constancia" class="form-select border-0 bg-light text-muted fw-bold" style="max-width: 80px;" required>
                                        <option value="V">V.</option>
                                        <option value="E">E.</option>
                                    </select>
                                    <input type="number" name="cedula_constancia" class="form-control border-0" placeholder="Ej. 12345678" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-2">CÓDIGO</label>
                                <input type="text" name="codigo_constancia" class="form-control border rounded shadow-sm" placeholder="" required>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-pill shadow-sm text-uppercase" id="btnConsultarConstancia">
                                Consultar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Section 4: Grid Services (Legacy Transformation) -->
    <section class="py-5" style="background-image: linear-gradient(rgba(243, 244, 246, 0.85), rgba(243, 244, 246, 0.85)), url('{{ $fondoIvss }}') !important; background-size: cover !important; background-position: center !important; background-attachment: fixed !important;">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h6 class="text-danger fw-bold text-uppercase" style="letter-spacing: 2px;">Gestión IVSS</h6>
                  <h2 class="fw-black mb-5">Servicios Complementarios</h2>
              </div>
              
              <style>
                .grid-services {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 1.5rem;
                }
                .service-tile {
                    background: #fff;
                    border-radius: 12px;
                    padding: 1.5rem;
                    display: flex;
                    align-items: center;
                    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
                    border: 1px solid rgba(0,0,0,0.08) !important;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }
                .service-tile:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 15px rgba(0,0,0,0.1);
                }
                .service-tile .tile-icon {
                    width: 50px;
                    height: 50px;
                    border-radius: 10px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    margin-right: 1.25rem;
                    font-size: 1.5rem;
                    flex-shrink: 0;
                }
              </style>

              <div class="grid-services">
                  <!-- Constancias y Autorizaciones -->
                  <div class="service-tile" data-aos="fade-right">
                      <div class="tile-icon text-white" style="background-color: #8B00FF;"><i class="fas fa-file-signature"></i></div>
                      <div>
                          <h6 class="fw-bold mb-1">Constancias y Autorizaciones</h6>
                          <a href="#" class="text-muted small text-decoration-none fw-bold" data-bs-toggle="modal" data-bs-target="#modalConstancias">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                      </div>
                  </div>
                  <!-- Marco Normativo -->
                  <div class="service-tile" data-aos="fade-right" data-aos-delay="100">
                      <div class="tile-icon text-white" style="background-color: #32CD32;"><i class="fas fa-gavel"></i></div>
                      <div>
                          <h6 class="fw-bold mb-1">Marco Normativo</h6>
                          <a href="{{ route('marco_normativo') }}" wire:navigate class="text-muted small text-decoration-none fw-bold">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                      </div>
                  </div>
                  <!-- Biblioteca de Formas -->
                  <div class="service-tile" data-aos="fade-right" data-aos-delay="200">
                      <div class="tile-icon bg-info text-white"><i class="fas fa-book-open"></i></div>
                      <div>
                          <h6 class="fw-bold mb-1">Biblioteca de Formas</h6>
                          <a href="{{ route('biblioteca_formas') }}" wire:navigate class="text-muted small text-decoration-none fw-bold">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                      </div>
                  </div>
                  <!-- Contrataciones Públicas -->
                  <div class="service-tile" data-aos="fade-right" data-aos-delay="300">
                      <div class="tile-icon bg-primary text-white"><i class="fas fa-file-contract"></i></div>
                      <div>
                          <h6 class="fw-bold mb-1">Contrataciones Públicas</h6>
                          <a href="{{ route('contrataciones_publicas') }}" wire:navigate class="text-muted small text-decoration-none fw-bold">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                      </div>
                  </div>
                  <!-- RRHH -->
                  <div class="service-tile" data-aos="fade-right" data-aos-delay="400">
                      <div class="tile-icon bg-danger text-white"><i class="fas fa-users-cog"></i></div>
                      <div>
                          <h6 class="fw-bold mb-1">Recursos Humanos</h6>
                          <a href="#" class="text-muted small text-decoration-none fw-bold" data-bs-toggle="modal" data-bs-target="#modalServiciosFuncionario">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                      </div>
                  </div>
                  <!-- Boletín Informativo -->
                  <div class="service-tile" data-aos="fade-right" data-aos-delay="500">
                      <div class="tile-icon bg-success text-white"><i class="fas fa-newspaper"></i></div>
                      <div>
                          <h6 class="fw-bold mb-1">Boletín Informativo</h6>
                          <a href="{{ route('boletin_informativo') }}" wire:navigate class="text-muted small text-decoration-none fw-bold">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                      </div>
                  </div>
                  <!-- Revista -->
                  <div class="service-tile" data-aos="fade-right" data-aos-delay="600">
                      <div class="tile-icon bg-warning text-white"><i class="fas fa-bookmark"></i></div>
                      <div>
                          <h6 class="fw-bold mb-1">Revista Digital</h6>
                          <a href="{{ route('revista_digital') }}" wire:navigate class="text-muted small text-decoration-none fw-bold" >Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                      </div>
                  </div>
                  <!-- Verificaciones -->
                  <div class="service-tile" data-aos="fade-right" data-aos-delay="700">
                      <div class="tile-icon bg-secondary text-white"><i class="fas fa-check-double"></i></div>
                      <div>
                          <h6 class="fw-bold mb-1">Verificaciones</h6>
                          <a href="#" class="text-muted small text-decoration-none fw-bold" data-bs-toggle="modal" data-bs-target="#modalVerificaciones">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                      </div>
                  </div>
              </div>
          </div>
          
        <!-- Modal Verificaciones -->
        <div class="modal fade" id="modalVerificaciones" tabindex="-1" aria-labelledby="modalVerificacionesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>
                        
                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-check-double fa-2x"></i>
                        </div>

                        <h4 id="modalVerificacionesLabel" class="fw-bold text-dark mb-2">
                            Verificaciones
                        </h4>
                        <p class="small text-muted mb-4">
                            Verifique la autenticidad de constancias y autorizaciones.
                        </p>

                        <div class="d-flex flex-column text-start">
                            @if(($configuraciones['visible_url_verificacion_autorizacion'] ?? '1') !== '0')
                            <a href="{{ formatear_enlace($configuraciones['url_verificacion_autorizacion'] ?? '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-check-circle me-2"></i> Verificación de Autorización de Cobro de Pensión
                            </a>
                            @endif
                            @if(($configuraciones['visible_url_verificacion_pension'] ?? '1') !== '0')
                            <a href="{{ formatear_enlace($configuraciones['url_verificacion_pension'] ?? '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-blind me-2"></i> Constancia de Pensión
                            </a>
                            @endif
                            @if(($configuraciones['visible_url_verificacion_cotizacion'] ?? '1') !== '0')
                            <a href="{{ formatear_enlace($configuraciones['url_verificacion_cotizacion'] ?? '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-hourglass-half me-2"></i> Constancia de Cotización
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Constancias -->
        <div class="modal fade" id="modalConstancias" tabindex="-1" aria-labelledby="modalConstanciasLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="p-4 text-center position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>
                        
                        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
                            <i class="fas fa-file-signature fa-2x"></i>
                        </div>

                        <h4 id="modalConstanciasLabel" class="fw-bold text-dark mb-2">
                            Constancias
                        </h4>
                        <p class="small text-muted mb-4">
                            Descargue constancias y autorizaciones del sistema.
                        </p>

                        <div class="d-flex flex-column text-start">
                            @if(($configuraciones['visible_url_constancia_cotizaciones'] ?? '1') !== '0')
                            <a href="{{ formatear_enlace($configuraciones['url_constancia_cotizaciones'] ?? '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-hourglass-half me-2"></i> Cotizaciones
                            </a>
                            @endif
                            @if(($configuraciones['visible_url_constancia_pension'] ?? '1') !== '0')
                            <a href="{{ formatear_enlace($configuraciones['url_constancia_pension'] ?? '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-blind me-2"></i> Pensión
                            </a>
                            @endif
                            @if(($configuraciones['visible_url_constancia_autorizacion'] ?? '1') !== '0')
                            <a href="{{ route('autorizacion_cobro_pension') }}" wire:navigate class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-file-contract me-2"></i> Autorización de Cobro de Pensión
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

      </section>

    <!-- Section 5: Promociones / Alertas -->
    @php
        $alertaImg = \App\Models\Configuracion::where('clave', 'alerta_emergente_img')->value('valor');
        $alertaEnlace = \App\Models\Configuracion::where('clave', 'alerta_emergente_url')->value('valor');
        
        $promociones = \App\Models\Banner::latest()->get();
    @endphp

    @if($promociones->count() > 0)
    <section class="py-5" x-data="{ promoRuta: '', promoEnlace: '' }" style="background-image: linear-gradient(rgba(243, 244, 246, 0.85), rgba(243, 244, 246, 0.85)), url('{{ $fondoIvss }}') !important; background-size: cover !important; background-position: center !important; background-attachment: fixed !important;">
        <div class="container py-4">
            
            <!-- Contenedor con overflow horizontal (scroll simple estilo carrusel) -->
            <style>
                .carrusel-promociones::-webkit-scrollbar { height: 8px; }
                .carrusel-promociones::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
                .carrusel-promociones::-webkit-scrollbar-thumb { background: #dc3545; border-radius: 10px; }
                .carrusel-promociones::-webkit-scrollbar-thumb:hover { background: #c82333; }
            </style>
            
            <div class="d-flex overflow-auto gap-4 pb-4 carrusel-promociones" style="scroll-snap-type: x mandatory; scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
                @foreach($promociones as $promo)
                <div class="flex-shrink-0" style="width: 85%; max-width: 300px; scroll-snap-align: start;" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="rounded-4 overflow-hidden shadow-lg border hover-shadow transition-all position-relative" 
                         style="border-color: rgba(0,0,0,0.08) !important; box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; cursor: pointer;" 
                         @click="promoRuta = '{{ asset('storage/' . $promo->ruta_imagen) }}'; promoEnlace = '{{ $promo->enlace ?? '' }}'; (bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPromoDinamico'))).show();">
                        <img src="{{ asset('storage/' . $promo->ruta_imagen) }}" alt="{{ $promo->titulo }}" class="w-100 h-auto">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="bg-white text-danger rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; opacity: 0.9;">
                                <i class="fas fa-search-plus"></i>
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-2 text-muted small d-md-none">
                <i class="fas fa-arrows-alt-h me-1"></i> Desliza para ver más
            </div>
        </div>

        <!-- Modal Dinámico para Carrusel de Promociones -->
        <div class="modal fade" id="modalPromoDinamico" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 bg-transparent shadow-none" style="align-items: center;">
                    <div class="position-relative d-inline-block">
                        <button type="button" class="btn btn-light rounded-circle shadow position-absolute d-flex align-items-center justify-content-center" 
                                data-bs-dismiss="modal" aria-label="Close" 
                                style="width: 40px; height: 40px; top: -15px; right: -15px; z-index: 1050; opacity: 1; border: 1px solid #ddd;">
                            <i class="fas fa-times fs-5 text-dark"></i>
                        </button>
                        
                        <template x-if="promoEnlace">
                            <a :href="promoEnlace" target="_blank" rel="noopener noreferrer" class="d-block">
                                <img :src="promoRuta" class="img-fluid rounded-4 shadow-lg" style="max-height: 85vh; width: auto; max-width: 100%; object-fit: contain;">
                            </a>
                        </template>
                        
                        <template x-if="!promoEnlace">
                            <img :src="promoRuta" class="img-fluid rounded-4 shadow-lg" style="max-height: 85vh; width: auto; max-width: 100%; object-fit: contain;">
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Modal Emergente Promocional (Alerta Inicial) -->
    @if($alertaImg)
    <div class="modal fade" id="modalPromocional" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bg-transparent shadow-none" style="align-items: center;">
                <div class="position-relative d-inline-block">
                    <button type="button" class="btn btn-light rounded-circle shadow position-absolute d-flex align-items-center justify-content-center" 
                            data-bs-dismiss="modal" aria-label="Close" 
                            style="width: 40px; height: 40px; top: -15px; right: -15px; z-index: 1050; opacity: 1; border: 1px solid #ddd;">
                        <i class="fas fa-times fs-5 text-dark"></i>
                    </button>
                    @if($alertaEnlace)
                        <a href="{{ $alertaEnlace }}" target="_blank" rel="noopener noreferrer" class="d-block">
                    @endif
                    <img src="{{ asset('storage/' . $alertaImg) }}" class="img-fluid rounded-4 shadow-lg" loading="eager" fetchpriority="high" decoding="sync" style="max-height: 85vh; width: auto; max-width: 100%; object-fit: contain;">
                    @if($alertaEnlace)
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif


    <!-- Modal Consulta Cuenta Individual -->
    <div class="modal fade" id="modalCuentaIndividual" tabindex="-1" aria-labelledby="modalCuentaIndividualLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
          <div class="p-4 text-center position-relative">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
              <i class="fas fa-id-card fa-2x"></i>
            </div>

            <h4 id="modalCuentaIndividualLabel" class="fw-bold text-dark mb-2">
              Cuenta Individual
            </h4>
            <p class="small text-muted mb-4">
              Consulte su estado de cuenta individual ingresando su cédula y fecha de nacimiento.
            </p>

            <form wire:submit.prevent="consultarCuentaIndividual" id="formCuentaIndividual" class="text-start" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-2">Cédula del Asegurado</label>
                    <div class="input-group border rounded shadow-sm">
                        <select wire:model="ci_nacionalidad" class="form-select border-0 bg-light text-muted fw-bold" style="max-width: 80px;" required>
                            <option value="V">V.</option>
                            <option value="E">E.</option>
                        </select>
                        <input type="number" wire:model="ci_cedula" class="form-control border-0" placeholder="Ej. 12345678" required>
                    </div>
                    @error('ci_cedula') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-2">Fecha de Nacimiento</label>
                    <div class="row g-2">
                        <div class="col-4">
                            <select wire:model="ci_d1" class="form-select border rounded shadow-sm" required>
                                <option value="" disabled selected>Día</option>
                                @for($i=1; $i<=31; $i++)
                                    <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                            @error('ci_d1') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-4">
                            <select wire:model="ci_m1" class="form-select border rounded shadow-sm px-1" required>
                                <option value="" disabled selected>Mes</option>
                                @php
                                    $meses = [
                                        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                    ];
                                @endphp
                                @foreach($meses as $num => $nombre)
                                    <option value="{{ $num }}">{{ $nombre }}</option>
                                @endforeach
                            </select>
                            @error('ci_m1') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-4">
                            <select wire:model="ci_y1" class="form-select border rounded shadow-sm px-1" required>
                                <option value="" disabled selected>Año</option>
                                @for($i=date('Y'); $i>=1900; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('ci_y1') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-pill shadow-sm text-uppercase" id="btnConsultarCuenta" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="consultarCuentaIndividual">Consultar</span>
                    <span wire:loading wire:target="consultarCuentaIndividual"><i class="fas fa-spinner fa-spin me-2"></i> Consultando...</span>
                </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Consulta Pensionado -->
    <div class="modal fade" id="modalConsultaPensionado" tabindex="-1" aria-labelledby="modalConsultaPensionadoLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
          <div class="p-4 text-center position-relative">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
              <i class="fas fa-user-check fa-2x"></i>
            </div>

            <h4 id="modalConsultaPensionadoLabel" class="fw-bold text-dark mb-2">
              Estatus de Pensionado
            </h4>
            <p class="small text-muted mb-4">
              Consulte el estatus de su pensión ingresando su cédula y fecha de nacimiento.
            </p>

            <form wire:submit.prevent="consultarPensionado" id="formConsultaPensionado" class="text-start" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-2">Cédula del Asegurado</label>
                    <div class="input-group border rounded shadow-sm">
                        <select wire:model="pen_nacionalidad" class="form-select border-0 bg-light text-muted fw-bold" style="max-width: 80px;" required>
                            <option value="V">V.</option>
                            <option value="E">E.</option>
                        </select>
                        <input type="number" wire:model="pen_cedula" class="form-control border-0" placeholder="Ej. 12345678" required>
                    </div>
                    @error('pen_cedula') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-2">Fecha de Nacimiento</label>
                    <div class="row g-2">
                        <div class="col-4">
                            <select wire:model="pen_d1" class="form-select border rounded shadow-sm" required>
                                <option value="" disabled selected>Día</option>
                                @for($i=1; $i<=31; $i++)
                                    <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                            @error('pen_d1') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-4">
                            <select wire:model="pen_m1" class="form-select border rounded shadow-sm px-1" required>
                                <option value="" disabled selected>Mes</option>
                                @php
                                    $meses = [
                                        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                    ];
                                @endphp
                                @foreach($meses as $num => $nombre)
                                    <option value="{{ $num }}">{{ $nombre }}</option>
                                @endforeach
                            </select>
                            @error('pen_m1') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-4">
                            <select wire:model="pen_y1" class="form-select border rounded shadow-sm px-1" required>
                                <option value="" disabled selected>Año</option>
                                @for($i=date('Y'); $i>=1900; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('pen_y1') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-pill shadow-sm text-uppercase" id="btnConsultarPensionado" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="consultarPensionado">Consultar</span>
                    <span wire:loading wire:target="consultarPensionado"><i class="fas fa-spinner fa-spin me-2"></i> Consultando...</span>
                </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    </section>

    <!-- Section 6: News Feed -->
    <section id="noticias" class="py-5" style="background-image: linear-gradient(rgba(243, 244, 246, 0.85), rgba(243, 244, 246, 0.85)), url('{{ $fondoIvss }}') !important; background-size: cover !important; background-position: center !important; background-attachment: fixed !important;">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div data-aos="fade-right">
                    <h6 class="text-danger fw-bold">SALA DE PRENSA</h6>
                    <h2 class="fw-black">Últimas Noticias</h2>
                </div>
                <a href="{{ route('noticias.index') }}" wire:navigate class="btn-ultimate btn-ultimate-red text-decoration-none">VER TODAS</a>
            </div>
            
            <div class="row g-4">
                @foreach($noticias as $index => $noticia)
                    @php
                        $imagen = $noticia->medios->first() ? asset('storage/' . $noticia->medios->first()->ruta) : asset('img/imagen.jpg');
                    @endphp
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="news-card-ultimate h-100 shadow-lg border" style="box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; border-color: rgba(0,0,0,0.08) !important;">
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
                                <a href="{{ route('noticias.show', $noticia->slug) }}" wire:navigate class="text-danger fw-bold text-decoration-none small">LEER ARTÍCULO <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>