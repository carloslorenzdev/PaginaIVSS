@extends('layouts.app-public')

@section('content')

    <!-- Section 1: Hero Boxed Carousel -->
    @php
        $carouselStyle = $configuraciones['carrusel_estilo'] ?? 'default';
        $carouselInterval = $configuraciones['carrusel_intervalo'] ?? 5000;
    @endphp
    
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" nonce="{{ app('csp-nonce') }}">
    
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
                    
                    <div class="p-4 rounded-4 shadow-sm consultas-tiuna-panel flex-fill position-relative" style="background-image: url('{{ !empty($configuraciones['bg_tiuna']) ? asset('storage/' . $configuraciones['bg_tiuna']) : asset('img/marcha-2.jpg') }}'); background-size: cover; background-position: center; border-radius: 1rem;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4 bg-dark" style="opacity: 0.6;"></div>
                        <div class="position-relative z-10 h-100 d-flex flex-column justify-content-center">
                            <h4 class="fw-black mb-3 text-white"><i class="fas fa-project-diagram text-danger me-2"></i> SISTEMA TIUNA</h4>
                            <p class="text-white-50 small mb-4">Plataforma de autoliquidación y gestión de trabajadores para empresas.</p>
                            <div class="d-flex gap-2 w-100">
                                <a href="{{ $configuraciones['url_tiuna'] ?? '#' }}" target="_blank" class="btn-ultimate btn-ultimate-red flex-fill d-flex align-items-center justify-content-center text-center px-2 py-2 fs-6 text-decoration-none">INGRESAR</a>
                                <a href="{{ $configuraciones['url_registro_tiuna'] ?? '#' }}" target="_blank" class="btn-ultimate btn-ultimate-outline border-white text-white flex-fill d-flex align-items-center justify-content-center text-center px-2 py-2 fs-6 text-decoration-none">REGISTRO</a>
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
    <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
      <div class="p-4 text-center position-relative">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
          <i class="fas fa-desktop fa-2x"></i>
        </div>

        <h4 id="modalSistemaEnLineaLabel" class="fw-bold text-dark mb-2">
          Sistema en Línea
        </h4>
        <p class="small text-muted mb-4">
          Gestión automatizada de trámites gubernamentales y servicios en línea.
        </p>

        <div class="d-flex flex-column text-start">
              <a href="{{ $configuraciones['url_sistema_estado_cuenta'] ?? '#' }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank"><i class="fas fa-file-invoice-dollar me-2"></i> Estado de Cuenta</a>
              <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalOrdenPago" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-money-check-alt me-2"></i> Orden de Pago</a>
              <a href="{{ $configuraciones['url_sistema_solvencias'] ?? '#' }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank"><i class="fas fa-certificate me-2"></i> Solvencias Electrónicas</a>
              <a href="{{ $configuraciones['url_sistema_indemnizaciones_diarias'] ?? '#' }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank"><i class="fas fa-hand-holding-medical me-2"></i> Indemnizaciones Diarias</a>
              <a href="{{ $configuraciones['url_sistema_verificacion_solvencia'] ?? '#' }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank"><i class="fas fa-check-circle me-2"></i> Verificación de Solvencia</a>
              <a href="{{ $configuraciones['url_sistema_indemnizaciones_unicas'] ?? '#' }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank"><i class="fas fa-hand-holding-usd me-2"></i> Indemnizaciones Únicas</a>
              <a href="{{ $configuraciones['url_sistema_sigesp_v3'] ?? '#' }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0" target="_blank"><i class="fas fa-laptop-code me-2"></i> Sigesp_v3</a>
              <a href="{{ $configuraciones['url_sistema_sigesp_v4'] ?? '#' }}" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0" target="_blank"><i class="fas fa-laptop-code me-2"></i> Sigesp_v4</a>
        </div>
      </div>
    </div>
  </div>
</div>
        </div>

        <!-- Modal Ciudadanos -->
                        <div class="modal fade" id="modalCiudadanos" tabindex="-1" aria-labelledby="modalCiudadanosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
      <div class="p-4 text-center position-relative">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
          <i class="fas fa-user-circle fa-2x"></i>
        </div>

        <h4 id="modalCiudadanosLabel" class="fw-bold text-dark mb-2">
          Ciudadanos
        </h4>
        <p class="small text-muted mb-4">
          Consulta de estatus, constancias y requisitos para los ciudadanos.
        </p>

        <div class="d-flex flex-column text-start">
              <a href="{{ route('ciudadano.informacion') }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-info-circle me-2"></i> Información General</a>
              <a href="{{ route('ciudadano.beneficio') }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-heartbeat me-2"></i> Beneficio Médico Integral</a>
              <a href="{{ route('ciudadano.continuidad') }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-route me-2"></i> Continuidad Facultativa</a>
              <a href="{{ route('ciudadano.perdida') }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-user-injured me-2"></i> ¿Perdiste tu empleo?</a>
              <a href="{{ route('ciudadano.tramites') }}" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0"><i class="fas fa-file-signature me-2"></i> Trámites</a>
        </div>
      </div>
    </div>
  </div>
</div>
        </div>

        <!-- Modal Pensionados -->
                        <div class="modal fade" id="modalPensionados" tabindex="-1" aria-labelledby="modalPensionadosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
      <div class="p-4 text-center position-relative">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
          <i class="fas fa-users fa-2x"></i>
        </div>

        <h4 id="modalPensionadosLabel" class="fw-bold text-dark mb-2">
          Pensionados
        </h4>
        <p class="small text-muted mb-4">
          Verificación de pagos, constancias y fe de vida digital.
        </p>

        <div class="d-flex flex-column text-start">
              <a href="{{ route('pensionado.informacion') }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-info-circle me-2"></i> Información General</a>
              <a href="{{ route('pensionado.tipos_pensiones') }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-list-ul me-2"></i> Tipos de Pensiones</a>
              <a href="{{ route('pensionado.pensionados_exterior') }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-globe-americas me-2"></i> Pensionados en el Exterior</a>
              <a href="{{ route('pensionado.tramites') }}" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0"><i class="fas fa-file-signature me-2"></i> Trámites</a>
        </div>
      </div>
    </div>
  </div>
</div>
        </div>

        <!-- Modal Empleadores -->
                        <div class="modal fade" id="modalEmpleadores" tabindex="-1" aria-labelledby="modalEmpleadoresLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
      <div class="p-4 text-center position-relative">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="mx-auto mb-4 d-flex justify-content-center align-items-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 64px; height: 64px;">
          <i class="fas fa-building fa-2x"></i>
        </div>

        <h4 id="modalEmpleadoresLabel" class="fw-bold text-dark mb-2">
          Empleadores
        </h4>
        <p class="small text-muted mb-4">
          Solvencias, obligaciones y trámites en línea para patronos.
        </p>

        <div class="d-flex flex-column text-start">
              <a href="{{ route('empleador.informacion') }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-info-circle me-2"></i> Información General</a>
              <a href="{{ route('empleador.quien_es') }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-question-circle me-2"></i> ¿Quién es el Empleador(a)?</a>
              <a href="{{ route('empleador.tipos_empresas') }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-industry me-2"></i> Tipos de Empresas</a>
              <a href="{{ route('empleador.sistema_autoliquidacion') }}" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0"><i class="fas fa-laptop-house me-2"></i> Sistema Autoliquidación</a>
              <a href="{{ route('empleador.tramites') }}" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0"><i class="fas fa-folder-open me-2"></i> Trámites</a>
        </div>
      </div>
    </div>
  </div>
</div>
            </div>
        </div>


        </div>
    </section>



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
                        <form action="{{ route('consulta.ordenpago') }}" method="POST" id="formOrdenPago">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold text-uppercase small" style="color: #e0e0e0;">NÚMERO DE EMPLEADOR</label>
                                <input type="text" name="idEmpresa" class="form-control" required placeholder="Ingrese Número Patronal">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-uppercase small" style="color: #e0e0e0;">PERÍODO DE FACTURACIÓN</label>
                                <select name="periodo" class="form-select" required>
                                    @php
                                        // Generar periodos de facturación dinámicos
                                        // Si aún no hemos llegado al día 30 del mes actual, comenzamos desde el mes anterior
                                        $currentDate = \Carbon\Carbon::now();
                                        if ($currentDate->day < 30) {
                                            $currentDate->subMonth();
                                        }
                                        
                                        for($i = 0; $i < 60; $i++) { // 5 años hacia atrás
                                            $date = $currentDate->copy()->subMonths($i);
                                            $val = $date->format('m/Y');
                                            echo "<option value=\"{$val}\">{$val}</option>";
                                        }
                                    @endphp
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-uppercase small" style="color: #e0e0e0;">TIPO EMPRESA O PATRONO</label>
                                <select name="tipoEmpresa" class="form-select" required>
                                    <option value="PR">Privado</option>
                                    <option value="PU">Publico Descentralizado</option>
                                    <option value="TU">Publi. Centralizado - Orga. Tutelar</option>
                                    <option value="AD">Publi. Centralizado - Orga. Adscrito</option>
                                </select>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" id="btnOrdenPago" name="boton" value="Consultar" class="btn text-white px-4 py-2" style="background-color: #6384a8; border: 1px solid white; font-weight: bold;">
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
                <div class="col-lg-3 col-md-6" data-aos="fade-up">
                    <a href="{{ route('farmacias') }}" class="d-block text-decoration-none h-100 rounded-4 overflow-hidden position-relative card-hover-scale" style="min-height: 220px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
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
                    <a href="{{ route('centros_salud') }}" class="d-block text-decoration-none h-100 rounded-4 overflow-hidden position-relative card-hover-scale" style="min-height: 220px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
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
                    <a href="{{ route('oficinas_administrativas') }}" class="d-block text-decoration-none h-100 rounded-4 overflow-hidden position-relative card-hover-scale" style="min-height: 220px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
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
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalConstanciaTrabajo" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-check-double me-2"></i> Verificación de Constancia
                            </a>
                            <a href="{{ $configuraciones['url_ingresa_correo'] ?? '#' }}" target="_blank" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-envelope me-2"></i> Ingresa a tu Correo
                            </a>
                            <a href="{{ $configuraciones['url_solicitudes_rrhh'] ?? '#' }}" target="_blank" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-file-alt me-2"></i> Solicitudes a RRHH
                            </a>
                            <a href="{{ $configuraciones['url_consulta_prestaciones'] ?? '#' }}" target="_blank" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-hand-holding-usd me-2"></i> Consulta de Prestaciones Sociales
                            </a>
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
    <section class="py-5 bg-light">
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
                    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
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
                          <a href="{{ route('marco_normativo') }}" class="text-muted small text-decoration-none fw-bold">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                      </div>
                  </div>
                  <!-- Biblioteca de Formas -->
                  <div class="service-tile" data-aos="fade-right" data-aos-delay="200">
                      <div class="tile-icon bg-info text-white"><i class="fas fa-book-open"></i></div>
                      <div>
                          <h6 class="fw-bold mb-1">Biblioteca de Formas</h6>
                          <a href="{{ route('biblioteca_formas') }}" class="text-muted small text-decoration-none fw-bold">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                      </div>
                  </div>
                  <!-- Contrataciones Públicas -->
                  <div class="service-tile" data-aos="fade-right" data-aos-delay="300">
                      <div class="tile-icon bg-primary text-white"><i class="fas fa-file-contract"></i></div>
                      <div>
                          <h6 class="fw-bold mb-1">Contrataciones Públicas</h6>
                          <a href="{{ route('contrataciones_publicas') }}" class="text-muted small text-decoration-none fw-bold">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
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
                          <a href="{{ route('boletin_informativo') }}" class="text-muted small text-decoration-none fw-bold">Leer más <i class="fas fa-chevron-right ms-1"></i></a>
                      </div>
                  </div>
                  <!-- Revista -->
                  <div class="service-tile" data-aos="fade-right" data-aos-delay="600">
                      <div class="tile-icon bg-warning text-white"><i class="fas fa-bookmark"></i></div>
                      <div>
                          <h6 class="fw-bold mb-1">Revista Digital</h6>
                          <a href="{{ route('revista_digital') }}" class="text-muted small text-decoration-none fw-bold" >Leer más <i class="fas fa-chevron-right ms-1"></i></a>
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
                            <a href="{{ $configuraciones['url_verificacion_autorizacion'] ?? '#' }}" target="_blank" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-check-circle me-2"></i> Verificación de Autorización de Cobro de Pensión
                            </a>
                            <a href="{{ $configuraciones['url_verificacion_pension'] ?? '#' }}" target="_blank" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-blind me-2"></i> Constancia de Pensión
                            </a>
                            <a href="{{ $configuraciones['url_verificacion_cotizacion'] ?? '#' }}" target="_blank" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-hourglass-half me-2"></i> Constancia de Cotización
                            </a>
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
                            <a href="{{ $configuraciones['url_constancia_cotizaciones'] ?? '#' }}" target="_blank" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-hourglass-half me-2"></i> Cotizaciones
                            </a>
                            <a href="{{ $configuraciones['url_constancia_pension'] ?? '#' }}" target="_blank" class="btn btn-outline-danger border-0 border-bottom text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-blind me-2"></i> Pensión
                            </a>
                            <a href="{{ $configuraciones['url_constancia_autorizacion'] ?? '#' }}" target="_blank" class="btn btn-outline-danger border-0 text-start py-3 fw-bold rounded-0">
                                <i class="fas fa-file-contract me-2"></i> Autorización de Cobro de Pensión
                            </a>
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
    <section class="py-5" style="background-color: #f8f9fa;">
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
                    <div class="rounded-4 overflow-hidden shadow-sm hover-shadow transition-all position-relative" 
                         style="border: 2px solid #e0e0e0; cursor: pointer;" 
                         data-bs-toggle="modal" 
                         data-bs-target="#modalPromoDinamico"
                         data-ruta="{{ asset('storage/' . $promo->ruta_imagen) }}" 
                         data-enlace="{{ $promo->enlace ?? '' }}">
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
    </section>

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
                    
                    <a href="#" target="_blank" class="d-block" id="modalPromoDinamicoLink" style="display: none;">
                        <img src="" id="modalPromoDinamicoImgConEnlace" class="img-fluid rounded-4 shadow-lg" style="max-height: 85vh; width: auto; max-width: 100%; object-fit: contain;">
                    </a>
                    
                    <img src="" id="modalPromoDinamicoImgSinEnlace" class="img-fluid rounded-4 shadow-lg" style="max-height: 85vh; width: auto; max-width: 100%; object-fit: contain; display: none;">
                </div>
            </div>
        </div>
    </div>
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
                        <a href="{{ $alertaEnlace }}" target="_blank" class="d-block">
                    @endif
                    <img src="{{ asset('storage/' . $alertaImg) }}" class="img-fluid rounded-4 shadow-lg" style="max-height: 85vh; width: auto; max-width: 100%; object-fit: contain;">
                    @if($alertaEnlace)
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif


    <!-- Modal Consulta Cuenta Individual -->
                    <div class="modal fade" id="modalCuentaIndividual" tabindex="-1" aria-labelledby="modalCuentaIndividualLabel" aria-hidden="true">
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
          Ingrese su número de cédula para consultar su estado de cuenta individual.
        </p>

        <form id="formCuentaIndividual" data-url="{{ route('consulta.cuenta_individual') }}" class="text-start">
            @csrf
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold text-uppercase mb-2">Cédula del Asegurado</label>
                <div class="input-group border rounded shadow-sm">
                    <select name="nacionalidad" class="form-select border-0 bg-light text-muted fw-bold" style="max-width: 80px;" required>
                        <option value="V">V.</option>
                        <option value="E">E.</option>
                    </select>
                    <input type="number" name="cedula" class="form-control border-0" placeholder="Ej. 12345678" required>
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-pill shadow-sm text-uppercase" id="btnConsultarCuenta">
                Consultar
            </button>
        </form>
      </div>
    </div>
  </div>
</div>

    <!-- Modal Consulta Pensionado -->

        <!-- Modal Consulta Pensionado -->
                        <div class="modal fade" id="modalConsultaPensionado" tabindex="-1" aria-labelledby="modalConsultaPensionadoLabel" aria-hidden="true">
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

        <form id="formConsultaPensionado" data-url="{{ route('consulta.pensionado') }}" class="text-start">
            @csrf
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold text-uppercase mb-2">Cédula del Asegurado</label>
                <div class="input-group border rounded shadow-sm">
                    <select name="nacionalidad" class="form-select border-0 bg-light text-muted fw-bold" style="max-width: 80px;" required>
                        <option value="V">V.</option>
                        <option value="E">E.</option>
                    </select>
                    <input type="number" name="cedula" class="form-control border-0" placeholder="Ej. 12345678" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold text-uppercase mb-2">Fecha de Nacimiento</label>
                <div class="row g-2">
                    <div class="col-4">
                        <select name="d1" class="form-select border rounded shadow-sm" required>
                            <option value="" disabled selected>Día</option>
                            @for($i=1; $i<=31; $i++)
                                <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-4">
                        <select name="m1" class="form-select border rounded shadow-sm px-1" required>
                            <option value="" disabled selected>Mes</option>
                            @php
                                $meses = [1=>'ENE',2=>'FEB',3=>'MAR',4=>'ABR',5=>'MAY',6=>'JUN',7=>'JUL',8=>'AGO',9=>'SEP',10=>'OCT',11=>'NOV',12=>'DIC'];
                            @endphp
                            @foreach($meses as $num => $nombre)
                                <option value="{{ $num }}">{{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <select name="y1" class="form-select border rounded shadow-sm px-1" required>
                            <option value="" disabled selected>Año</option>
                            @for($i=date('Y'); $i>=1900; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-pill shadow-sm text-uppercase" id="btnConsultarPensionado">
                Consultar
            </button>
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

    <script src="{{ asset('js/custom.js') }}" nonce="{{ app('csp-nonce') }}"></script>
    <script nonce="{{ app('csp-nonce') }}">
        document.addEventListener('DOMContentLoaded', function() {
            @if($alertaImg)
            // Mostrar la alerta emergente siempre al abrir la página
            const modalPromocionalEl = document.getElementById('modalPromocional');
            if (modalPromocionalEl) {
                const modalPromocional = new bootstrap.Modal(modalPromocionalEl);
                modalPromocional.show();
            }
            @endif

            // Lógica para el modal dinámico del carrusel
            const modalPromoDinamicoEl = document.getElementById('modalPromoDinamico');
            if (modalPromoDinamicoEl) {
                modalPromoDinamicoEl.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const ruta = button.getAttribute('data-ruta');
                    const enlace = button.getAttribute('data-enlace');

                    const imgConEnlace = document.getElementById('modalPromoDinamicoImgConEnlace');
                    const imgSinEnlace = document.getElementById('modalPromoDinamicoImgSinEnlace');
                    const linkTag = document.getElementById('modalPromoDinamicoLink');

                    if (enlace && enlace.trim() !== '') {
                        imgConEnlace.src = ruta;
                        linkTag.href = enlace;
                        linkTag.style.display = 'block';
                        imgSinEnlace.style.display = 'none';
                    } else {
                        imgSinEnlace.src = ruta;
                        imgSinEnlace.style.display = 'block';
                        linkTag.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
