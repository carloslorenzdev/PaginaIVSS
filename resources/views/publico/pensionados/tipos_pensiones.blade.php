@extends('layouts.app-public')

@section('titulo', 'Tipos de Pensiones - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(26,60,110,0.9) 0%, rgba(13,31,56,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-list-ul text-primary fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Tipos de Pensiones</h1>
                <p class="lead text-white-50 mb-4 px-md-5">
                    Conoce los requisitos y detalles de cada tipo de pensión
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
                    <h3 class="fw-bold mb-4 text-dark text-center">Clasificación de Pensiones</h3>

                    <p class="text-muted mb-5 text-center" style="font-size: 1.1rem; line-height: 1.8;">
                        El Instituto Venezolano de los Seguros Sociales contempla diferentes tipos de pensiones de acuerdo a la situación del asegurado o asegurada. A continuación, puedes desplegar cada una para conocer su definición y los documentos que debes presentar.
                    </p>

                    <!-- Acordeón de Pensiones -->
                    <div class="accordion" id="accordionPensiones">
                        
                        <!-- Pensión por Sobreviviente -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingSobreviviente">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSobreviviente" aria-expanded="false" aria-controls="collapseSobreviviente" style="font-size: 1.15rem;">
                                    <i class="fas fa-heart text-danger me-3"></i> Pensión por Sobreviviente
                                </button>
                            </h2>
                            <div id="collapseSobreviviente" class="accordion-collapse collapse" aria-labelledby="headingSobreviviente" data-bs-parent="#accordionPensiones" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="visibility: visible !important; opacity: 1 !important;">
                                    <p class="text-muted mb-4" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <strong style="color: #212529 !important;">Definición:</strong> Son prestaciones dinerarias causadas por el fallecimiento de una beneficiaria o un beneficiario de pensión de invalidez o vejez en todo caso y por el fallecimiento de una asegurada o un asegurado, siempre que tenga acreditadas no menos de setecientas cincuenta (750) cotizaciones semanales; o bien cumpla con los requisitos para tener derecho a una pensión de invalidez al momento de fallecer; o bien haya fallecido a causa de un accidente del trabajo o enfermedad profesional; o por un accidente común, siempre que la trabajadora o el trabajador para el día del accidente esté sujeto a la obligación del Seguro Social.
                                    </p>
                                    
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Documentos en caso de muerte de un Asegurado:</h5>
                                    <ul class="text-muted mb-4" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Planilla de Solicitud (Forma 14-04) dos (02) originales</li>
                                        <li>Constancia de Trabajo (Forma 14-100).</li>
                                        <li>Acta de Matrimonio</li>
                                        <li>Acta de Defunción</li>
                                        <li>Presentar cédula de Identidad del causante, solicitante y/o beneficiario (se validará en el SAIME).</li>
                                        <li>Partida de nacimiento si hay hijos menores de 14 años. Mayores de esta edad si son inválidos y hasta 18 años si cursan estudios regulares (consignar constancia de estudio).</li>
                                        <li>Informe médico de hijos incapacitados (Forma 14-08)</li>
                                    </ul>

                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Documentos en caso de muerte de un Pensionado:</h5>
                                    <ul class="text-muted mb-4" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Planilla de Solicitud (Forma 14-04) dos (02) originales</li>
                                        <li>Acta de Matrimonio</li>
                                        <li>Acta de Defunción</li>
                                        <li>Presentar cédula de Identidad del causante, solicitante y/o beneficiario (se validará en el SAIME).</li>
                                        <li>Partida de nacimiento si hay hijos menores de 14 años. Mayores de esta edad si son inválidos y hasta 18 años si cursan estudios regulares.</li>
                                        <li>Informe médico de hijos incapacitados (Forma 14-08)</li>
                                    </ul>

                                    <div class="alert alert-info border-info bg-white mb-0" role="alert" style="opacity: 1 !important;">
                                        <i class="fas fa-info-circle me-2 text-info"></i> <strong style="color: #212529 !important;">Notas:</strong> En caso de ser nacionalizado, anexar copia legible de la Gaceta Oficial. Los trámites pueden realizarse en cualquiera de las 48 Oficinas Administrativas sin importar su residencia.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pensión por Invalidez -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingInvalidez">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInvalidez" aria-expanded="false" aria-controls="collapseInvalidez" style="font-size: 1.15rem;">
                                    <i class="fas fa-wheelchair text-primary me-3"></i> Pensión por Invalidez
                                </button>
                            </h2>
                            <div id="collapseInvalidez" class="accordion-collapse collapse" aria-labelledby="headingInvalidez" data-bs-parent="#accordionPensiones" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="visibility: visible !important; opacity: 1 !important;">
                                    <p class="text-muted mb-4" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <strong style="color: #212529 !important;">Definición / Requisitos:</strong> Son prestaciones dinerarias otorgadas al asegurado por la pérdida de más de dos tercios (2/3) de su capacidad para trabajar a causa de una enfermedad o accidente, en forma presumible permanente o de larga duración.
                                    </p>
                                    
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Documentos a presentar:</h5>
                                    <ul class="text-muted mb-4" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Solicitud de Prestaciones en Dinero, forma 14-04 dos (02) originales.</li>
                                        <li>Constancia de Trabajo, forma 14-100</li>
                                        <li>Solicitud de Evaluación de Discapacidad, forma 14-08</li>
                                        <li>Evaluación de Incapacidad Residual</li>
                                        <li>Presentar cédula de Identidad</li>
                                        <li>Declaración de accidente, en caso de enfermedad común, forma 14-123 original</li>
                                    </ul>

                                    <div class="alert alert-info border-info bg-white mb-0" role="alert" style="opacity: 1 !important;">
                                        <i class="fas fa-info-circle me-2 text-info"></i> <strong style="color: #212529 !important;">Notas:</strong> El grado de incapacidad será determinado por la reglamentación especial del IVSS a través de la Comisión Evaluadora.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pensión por Vejez -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingVejez">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVejez" aria-expanded="false" aria-controls="collapseVejez" style="font-size: 1.15rem;">
                                    <i class="fas fa-blind text-warning me-3"></i> Pensión por Vejez
                                </button>
                            </h2>
                            <div id="collapseVejez" class="accordion-collapse collapse" aria-labelledby="headingVejez" data-bs-parent="#accordionPensiones" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="visibility: visible !important; opacity: 1 !important;">
                                    <p class="text-muted mb-4" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <strong style="color: #212529 !important;">Definición / Requisitos:</strong> El asegurado o asegurada después de haber cumplido 60 años de edad si es varón o 55 años si es mujer, tiene derecho a una pensión de vejez siempre y cuando cumpla con un mínimo de 750 cotizaciones.
                                    </p>
                                    
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Documentos a presentar:</h5>
                                    <ul class="text-muted mb-4" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Mínimo 750 cotizaciones.</li>
                                        <li>Presentar cédula de Identidad.</li>
                                        <li>Solicitud de Prestaciones en Dinero, forma 14-04 dos (02) Originales.</li>
                                        <li>Constancia de trabajo, forma 14-100 de los últimos 6 años trabajados.</li>
                                    </ul>

                                    <div class="alert alert-warning border-warning bg-white mb-0" role="alert" style="opacity: 1 !important;">
                                        <i class="fas fa-exclamation-triangle me-2 text-warning"></i> <strong style="color: #212529 !important;">Importante:</strong> Si el asegurado (60 años) o asegurada (55 años) no tiene las 750 cotizaciones, puede elegir esperar a cumplirlas o recibir de inmediato una indemnización única del 10% de la suma de los salarios correspondientes a sus cotizaciones.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pensión por Incapacidad -->
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                            <h2 class="accordion-header" id="headingIncapacidad">
                                <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIncapacidad" aria-expanded="false" aria-controls="collapseIncapacidad" style="font-size: 1.15rem;">
                                    <i class="fas fa-crutch text-success me-3"></i> Pensión por Incapacidad
                                </button>
                            </h2>
                            <div id="collapseIncapacidad" class="accordion-collapse collapse" aria-labelledby="headingIncapacidad" data-bs-parent="#accordionPensiones" style="visibility: visible !important; opacity: 1 !important;">
                                <div class="accordion-body bg-light rounded-bottom-4 py-4" style="visibility: visible !important; opacity: 1 !important;">
                                    <p class="text-muted mb-4" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <strong style="color: #212529 !important;">Definición:</strong> Son prestaciones dinerarias otorgadas en virtud de una enfermedad profesional o accidente de trabajo la cual disminuye al asegurado su capacidad para trabajar entre un 25% y hasta un 66,66%, originándose el derecho a la obtención de una pensión por incapacidad.
                                    </p>
                                    
                                    <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">Documentos a presentar:</h5>
                                    <ul class="text-muted mb-4" style="font-size: 1.05rem; color: #6c757d !important; opacity: 1 !important;">
                                        <li>Solicitud de Prestaciones en Dinero, forma 14-04 dos (02) originales.</li>
                                        <li>Constancia de Trabajo, forma 14-100</li>
                                        <li>Solicitud de Evaluación de Discapacidad, forma 14-08</li>
                                        <li>Evaluación de Incapacidad Residual</li>
                                        <li>Presentar cédula de Identidad</li>
                                        <li>Declaración de accidente, en caso de enfermedad común, forma 14-123 original</li>
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
