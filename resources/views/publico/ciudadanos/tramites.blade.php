@extends('layouts.app-public')

@section('titulo', 'Trámites del Ciudadano - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(25,135,84,0.9) 0%, rgba(13,66,41,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-folder-open text-success fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Trámites del Ciudadano</h1>
            </div>
        </div>
    </div>
    
    <!-- Curva inferior -->
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; z-index: 2;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="display: block; width: calc(100% + 1.3px); height: 60px;">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" fill="#f8f9fa"></path>
        </svg>
    </div>
</div>

<!-- CONTENIDO PRINCIPAL -->
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container py-4">
        
        <div class="row justify-content-center" data-aos="fade-up">
            <div class="col-lg-10">
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-start border-4 border-success mb-5">
                    
                    <h3 class="fw-bold mb-4 text-dark text-center">Información y Requisitos de Trámites:</h3>
                    
                    <!-- Acordeón de Trámites -->
                    <div class="accordion mt-4" id="accordionTramites">
                        
                        <!-- Trámite 1 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite1">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite1" aria-expanded="false" aria-controls="collapseTramite1" style="font-size: 1.15rem;">
                                    <i class="fas fa-user-edit text-success me-3"></i> Correción de Datos del Ciudadano
                                </button>
                            </h2>
                            <div id="collapseTramite1" class="accordion-collapse collapse" aria-labelledby="headingTramite1" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <p class="text-muted mb-4" style="font-size: 1.1rem; color: #6c757d !important; opacity: 1 !important;">En cualquiera de las Oficinas Administrativas del IVSS puedes realizar las siguientes Correcciones: Sexo, Edad, Nombre, apellidos, fecha de nacimiento, asociación de Cédula de venezolano y Extranjero.</p>
                                    
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos:</h5>
                                    <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Presentar cédula de identidad.</li>
                                        <li>En el caso de que el asegurado tenga otra nacionalidad distinta a la venezolana y tenga el número de extranjero, es necesario incluir copia de la gaceta oficial para verificar la nacionalización.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Trámite 2 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite2">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite2" aria-expanded="false" aria-controls="collapseTramite2" style="font-size: 1.15rem;">
                                    <i class="fas fa-hand-holding-usd text-success me-3"></i> Solicitud de Indemnizaciones Diarias
                                </button>
                            </h2>
                            <div id="collapseTramite2" class="accordion-collapse collapse" aria-labelledby="headingTramite2" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <p class="text-muted mb-4" style="font-size: 1.1rem; color: #6c757d !important; opacity: 1 !important;">Son prestaciones dinerarias otorgadas en ocasión de una incapacidad temporal para el trabajo como consecuencia de:</p>
                                    <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Un accidente común o laboral.</li>
                                        <li>De la maternidad.</li>
                                        <li>De una enfermedad profesional o común.</li>
                                    </ul>
                                    
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos:</h5>
                                    <p class="text-muted mb-3" style="font-size: 1.1rem; color: #6c757d !important; opacity: 1 !important;">El Asegurado debe consignar en el Centro Asistencial más cercano a su residencia (Oficina de Prestaciones) los siguientes requisitos:</p>
                                    <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Certificado de Incapacidad (14-73). (Reposo Validado)</li>
                                        <li>Comprobante de Consignación de Datos (14-52). (Emitido por la Empresa).</li>
                                    </ul>

                                    <div class="alert alert-success bg-white border-success text-success mb-0" role="alert" style="opacity: 1 !important;">
                                        <i class="fas fa-info-circle me-2"></i> Al asegurado se le entrega un Comprobante de trámite de pago de prestaciones, con el cual podrá obtener información del estatus de su reposo en fechas posteriores.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trámite 3 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite3">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite3" aria-expanded="false" aria-controls="collapseTramite3" style="font-size: 1.15rem;">
                                    <i class="fas fa-user-injured text-success me-3"></i> Prestación Dineraria por Pérdida Involutaria del Empleo (PIE)
                                </button>
                            </h2>
                            <div id="collapseTramite3" class="accordion-collapse collapse" aria-labelledby="headingTramite3" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <p class="text-muted mb-4" style="font-size: 1.1rem; color: #6c757d !important; opacity: 1 !important;">La Prestación Dineraria por Pérdida Involuntaria del Empleo tiene como objetivo asegurarle al trabajador (a) que ha perdido involuntariamente su empleo y que son cotizantes al Régimen Prestacional de Empleo, una prestación dineraria durante un lapso de tiempo determinado.</p>
                                    <p class="text-muted mb-4" style="font-size: 1.1rem; color: #6c757d !important; opacity: 1 !important;">Si desea ver toda la información detallada (deberes, requisitos, lugares de solicitud y bases legales), haga clic en el siguiente enlace.</p>
                                    <div class="text-center">
                                        <a href="{{ route('ciudadano.perdida') ?? '#' }}" class="btn btn-success rounded-pill px-4 fw-bold">Ir a Información Completa de PIE</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trámite 4 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite4">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite4" aria-expanded="false" aria-controls="collapseTramite4" style="font-size: 1.15rem;">
                                    <i class="fas fa-route text-success me-3"></i> Inscripción de Continuación Facultativa y Trabajador No Dependiente
                                </button>
                            </h2>
                            <div id="collapseTramite4" class="accordion-collapse collapse" aria-labelledby="headingTramite4" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <p class="text-muted mb-4" style="font-size: 1.1rem; color: #6c757d !important; opacity: 1 !important;">La continuación Facultativa y los Trabajadores No Dependientes permiten al asegurado continuar cotizando al Seguro Social para garantizar su pensión y beneficios, incluso sin estar vinculado laboralmente a una empresa u organización.</p>
                                    <p class="text-muted mb-4" style="font-size: 1.1rem; color: #6c757d !important; opacity: 1 !important;">Si desea consultar los requisitos y descargar las formas necesarias, haga clic en el siguiente enlace.</p>
                                    <div class="text-center">
                                        <a href="{{ route('ciudadano.continuidad') ?? '#' }}" class="btn btn-success rounded-pill px-4 fw-bold">Ir a Continuación Facultativa</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trámite 5 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite5">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite5" aria-expanded="false" aria-controls="collapseTramite5" style="font-size: 1.15rem;">
                                    <i class="fas fa-map-marked-alt text-success me-3"></i> Cambio de la Dirección de Habitación del Asegurado
                                </button>
                            </h2>
                            <div id="collapseTramite5" class="accordion-collapse collapse" aria-labelledby="headingTramite5" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para modificación de dirección de habitación del asegurado:</h5>
                                    <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Presentar cédula de identidad.</li>
                                        <li>Recibo de Pago de Servicio Público.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Trámite 6 -->
                        <div class="accordion-item border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite6">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite6" aria-expanded="false" aria-controls="collapseTramite6" style="font-size: 1.15rem;">
                                    <i class="fas fa-passport text-success me-3"></i> Cambio de Nacionalidad
                                </button>
                            </h2>
                            <div id="collapseTramite6" class="accordion-collapse collapse" aria-labelledby="headingTramite6" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <p class="text-muted mb-4" style="font-size: 1.1rem; color: #6c757d !important; opacity: 1 !important;">Para realizar dicho trámite debe dirigirse a la Oficina Administrativa del Instituto Venezolano de los Seguros Sociales, más cercana a su domicilio y presentar los siguientes requisitos:</p>
                                    
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos:</h5>
                                    <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Gaceta de Nacionalización.</li>
                                        <li>Presentar cédulas de Identidad (Venezolano y Extranjero).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-5">
                        <a href="{{ route('inicio') }}" class="btn btn-outline-success rounded-pill px-4 py-2 fw-bold">
                            <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
