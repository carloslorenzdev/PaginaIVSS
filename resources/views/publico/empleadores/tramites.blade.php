@extends('layouts.app-public')

@section('titulo', 'Trámites del Empleador - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(25,135,84,0.9) 0%, rgba(0,100,0,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-folder-open text-success fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Trámites del Empleador</h1>
                <p class="lead text-white-50 mb-0">Requisitos y procedimientos oficiales para patronos públicos y privados.</p>
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
                                    <i class="fas fa-user-edit text-success me-3"></i> 1. Corrección de Datos del Empleador (Cambio de Representante Legal)
                                </button>
                            </h2>
                            <div id="collapseTramite1" class="accordion-collapse collapse" aria-labelledby="headingTramite1" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para Empleador (a) Público:</h5>
                                    <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Copia de la Gaceta Oficial del Nombramiento.</li>
                                        <li>Presentar Cédula de Identidad (Nuevo Representante Legal).</li>
                                    </ul>
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para Empleador (a) Privado:</h5>
                                    <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Presentar Registro de Información Fiscal (RIF).</li>
                                        <li>Presentar Cédula de Identidad (Nuevo Representante Legal).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Trámite 2 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite2">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite2" aria-expanded="false" aria-controls="collapseTramite2" style="font-size: 1.15rem;">
                                    <i class="fas fa-file-invoice text-success me-3"></i> 2. Actualización de Registro de Información Fiscal (RIF)
                                </button>
                            </h2>
                            <div id="collapseTramite2" class="accordion-collapse collapse" aria-labelledby="headingTramite2" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para Empleador (a) Público y Privado:</h5>
                                    <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Presentar Registro de Información Fiscal (RIF).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Trámite 3 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite3">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite3" aria-expanded="false" aria-controls="collapseTramite3" style="font-size: 1.15rem;">
                                    <i class="fas fa-building text-success me-3"></i> 3. Actualización de Razón Social del Empleador (a)
                                </button>
                            </h2>
                            <div id="collapseTramite3" class="accordion-collapse collapse" aria-labelledby="headingTramite3" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para Empleador (a) Público:</h5>
                                    <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Copia de la Publicación en la Gaceta Oficial.</li>
                                    </ul>
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para Empleador (a) Privado:</h5>
                                    <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Presentar Registro de Información Fiscal (RIF).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Trámite 4 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite4">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite4" aria-expanded="false" aria-controls="collapseTramite4" style="font-size: 1.15rem;">
                                    <i class="fas fa-map-marker-alt text-success me-3"></i> 4. Actualización de Domicilio Fiscal y/o Comercial
                                </button>
                            </h2>
                            <div id="collapseTramite4" class="accordion-collapse collapse" aria-labelledby="headingTramite4" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para Empleador (a) Público y Privado:</h5>
                                    <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Presentar Registro de Información Fiscal (RIF).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Trámite 5 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite5">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite5" aria-expanded="false" aria-controls="collapseTramite5" style="font-size: 1.15rem;">
                                    <i class="fas fa-calendar-alt text-success me-3"></i> 5. Corrección de Fecha de Constitución
                                </button>
                            </h2>
                            <div id="collapseTramite5" class="accordion-collapse collapse" aria-labelledby="headingTramite5" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para Empleador (a) Público:</h5>
                                    <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Copia de la Gaceta Oficial de Creación.</li>
                                    </ul>
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para Empleador (a) Privado:</h5>
                                    <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Copia del Registro Mercantil y/o Acta Constitutiva.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Trámite 6 -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite6">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite6" aria-expanded="false" aria-controls="collapseTramite6" style="font-size: 1.15rem;">
                                    <i class="fas fa-handshake text-success me-3"></i> 6. Solicitud de Convenio de Pago
                                </button>
                            </h2>
                            <div id="collapseTramite6" class="accordion-collapse collapse" aria-labelledby="headingTramite6" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <p class="text-muted mb-4" style="font-size: 1.1rem; color: #6c757d !important; opacity: 1 !important;">Las empresas afiliadas al Seguro Social que se encuentren en estado demora, podrán suscribir Convenios de Pago notariado, con el I.V.S.S. a fin de cancelar sus deudas por concepto de cotizaciones.</p>
                                    
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para la solicitud:</h5>
                                    <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Forma 14-134 (Solicitud de convenio de pago)</li>
                                        <li>Registro mercantil y sus actualizaciones (Copia)</li>
                                        <li>Copia de la última declaración del ISLR (con vista a la Original)</li>
                                        <li>Presentar cédula laminada (Copia)</li>
                                        <li>Presentar RIF del representante legal (Copia)</li>
                                        <li>Presentar RIF de la empresa (Copia)</li>
                                        <li>Poder notariado y presentar cédula laminada (en caso de apoderado) (Copia)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Trámite 7 -->
                        <div class="accordion-item border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingTramite7">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTramite7" aria-expanded="false" aria-controls="collapseTramite7" style="font-size: 1.15rem;">
                                    <i class="fas fa-route text-success me-3"></i> 7. Cambio de Dirección de la Empresa
                                </button>
                            </h2>
                            <div id="collapseTramite7" class="accordion-collapse collapse" aria-labelledby="headingTramite7" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="opacity: 1 !important; visibility: visible !important;">
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para Empleador (a) Público:</h5>
                                    <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Copia del Registro de Información Fiscal (RIF).</li>
                                        <li>Carta Explicativa / Oficio.</li>
                                    </ul>
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Requisitos para Empleador (a) Privado:</h5>
                                    <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Copia del Registro de Información Fiscal (RIF).</li>
                                        <li>Carta Explicativa / Oficio.</li>
                                        <li>Copia de recibo de servicio.</li>
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
