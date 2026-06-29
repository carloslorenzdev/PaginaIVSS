@extends('layouts.app-public')

@section('titulo', 'Trámites de Pensionados - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(26,60,110,0.9) 0%, rgba(13,31,56,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-file-signature text-primary fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Trámites</h1>
                <p class="lead text-white-50 mb-4 px-md-5">
                    Información detallada sobre procesos y solicitudes para pensionados
                </p>
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
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-start border-4 border-primary">
                    <h3 class="fw-bold mb-4 text-dark text-center">Trámites Disponibles</h3>

                    <p class="text-muted mb-5 text-center" style="font-size: 1.1rem; line-height: 1.8;">
                        A continuación, encontrarás los requisitos e información referente a las distintas gestiones que puedes realizar ante el IVSS. Despliega la opción de tu interés para conocer los detalles.
                    </p>

                    <!-- Acordeón de Trámites -->
                    <div class="accordion" id="accordionTramites">

                        <!-- Coordinación Bancaria -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingBanco">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBanco" aria-expanded="false" aria-controls="collapseBanco" style="font-size: 1.15rem;">
                                    <i class="fas fa-university text-primary me-3"></i> Coordinación Bancaria
                                </button>
                            </h2>
                            <div id="collapseBanco" class="accordion-collapse collapse" aria-labelledby="headingBanco" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="visibility: visible !important; opacity: 1 !important;">
                                    <p class="text-muted mb-3" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <strong style="color: #212529 !important;">Objetivo:</strong> Atender los requerimientos consignados por los pensionados en lo que respecta a las Activaciones de las Cuentas Bancarias, Reintegros de Cuentas Barridas y otros tipos de solicitudes.
                                    </p>
                                    <p class="text-dark fw-bold mb-2" style="opacity: 1 !important;">Requisitos para Trámites:</p>
                                    <ul class="text-muted mb-0" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Presentar cédula de Identidad.</li>
                                        <li>Libreta Bancaria (Actualizada y Legible).</li>
                                        <li>En caso de ser apoderado, poder notariado y presentar cédula de identidad del apoderado.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Solicitud de Prórroga -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingProrroga">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProrroga" aria-expanded="false" aria-controls="collapseProrroga" style="font-size: 1.15rem;">
                                    <i class="fas fa-calendar-plus text-primary me-3"></i> Solicitud de Prórroga de Prestaciones
                                </button>
                            </h2>
                            <div id="collapseProrroga" class="accordion-collapse collapse" aria-labelledby="headingProrroga" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="visibility: visible !important; opacity: 1 !important;">
                                    <p class="text-dark fw-bold mb-2" style="opacity: 1 !important;">Documentos que se deben presentar:</p>
                                    <ul class="text-muted mb-3" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Presentar cédula de identidad.</li>
                                        <li>Certificado de Incapacidad (Forma 14-73).</li>
                                        <li>Tarjeta de Control de Pago (Forma 14-88).</li>
                                    </ul>
                                    <p class="text-muted mb-0" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <strong style="color: #212529 !important;">Base Legal:</strong> Ley del Seguro Social y el Reglamento Artículo 10.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Indemnizaciones Diarias -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingIndemnizaciones">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIndemnizaciones" aria-expanded="false" aria-controls="collapseIndemnizaciones" style="font-size: 1.15rem;">
                                    <i class="fas fa-hand-holding-medical text-primary me-3"></i> Indemnizaciones Diarias
                                </button>
                            </h2>
                            <div id="collapseIndemnizaciones" class="accordion-collapse collapse" aria-labelledby="headingIndemnizaciones" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="visibility: visible !important; opacity: 1 !important;">
                                    <p class="text-muted mb-3" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <strong style="color: #212529 !important;">Definición:</strong> Son prestaciones dinerarias otorgadas en ocasión de una incapacidad temporal para el trabajo como consecuencia de un accidente común o laboral, maternidad, o enfermedad.
                                    </p>
                                    <p class="text-dark fw-bold mb-2" style="opacity: 1 !important;">Requisitos (Consignar en Centro Asistencial):</p>
                                    <ul class="text-muted mb-0" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Certificado de Incapacidad (14-73). (Reposo Validado).</li>
                                        <li>Comprobante de Consignación de Datos (14-52). (Emitido por la Empresa).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Convenios Internacionales -->
                        <div class="accordion-item border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingConvenios">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConvenios" aria-expanded="false" aria-controls="collapseConvenios" style="font-size: 1.15rem;">
                                    <i class="fas fa-handshake text-primary me-3"></i> Convenios Internacionales
                                </button>
                            </h2>
                            <div id="collapseConvenios" class="accordion-collapse collapse" aria-labelledby="headingConvenios" data-bs-parent="#accordionTramites" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="visibility: visible !important; opacity: 1 !important;">
                                    <p class="text-muted mb-3" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        Para el trámite de Solicitud de Pensión de los asegurados que han trabajado en países que tienen Convenio de Seguridad Social con Venezuela (Italia, Portugal, España, Uruguay y Ecuador):
                                    </p>
                                    <ul class="text-muted mb-0" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Copia de la Libreta Marina o del Ejército (si la posee) y Copia del Pasaporte.</li>
                                        <li>Partida de Nacimiento y Copia del Documento Nacional de Identidad.</li>
                                        <li>Constancia de Trabajo.</li>
                                        <li>Copia del Libro de Familia (solo para el caso de España).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-5">
                        <a href="{{ route('inicio') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">
                            <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

@endsection
