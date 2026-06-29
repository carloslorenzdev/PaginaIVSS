@extends('layouts.app-public')

@section('titulo', 'Pérdida Involuntaria de Empleo - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(220,53,69,0.9) 0%, rgba(139,0,0,0.95) 100%); z-index: 1;"></div>
    
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <i class="fas fa-user-injured text-danger fa-3x"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">Pérdida Involuntaria de Empleo</h1>
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
                <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-start border-4 border-danger mb-5">
                    
                    <h3 class="fw-bold mb-3 text-dark">Objetivo:</h3>
                    <p class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                        La Prestación Dineraria por Pérdida Involuntaria del Empleo tiene como objetivo, asegurarle al trabajador (a) que ha perdido involuntariamente su empleo y que son cotizantes al Régimen Prestacional de Empleo, una prestación dineraria durante un lapso de tiempo determinado.
                    </p>

                    <h3 class="fw-bold mb-3 text-dark border-top pt-4">¿Qué es la Prestación Dineraria?:</h3>
                    <p class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                        Es una indemnización porcentual calculada sobre los salarios notificados por el empleador ante el I.V.S.S., en los últimos doce (12) meses; que se le cancela a todo trabajador (a) que ha perdido involuntariamente su empleo, durante cinco (5) meses. Si el trabajador (a) cesante ingresa bajo relación de dependencia durante los cinco (5) meses de protección, se le cancelará únicamente el tiempo efectivo de cesantía.
                    </p>

                    <h3 class="fw-bold mb-3 text-dark border-top pt-4">Lapso para solicitar la Prestación Dineraria:</h3>
                    <p class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8;">
                        El trabajador (a) cesante podrá solicitar la Prestación Dineraria por Pérdida Involuntaria del Empleo, dentro de los Sesenta (60) días continuos siguientes a la terminación de la relación laboral. En caso de Demanda, Amparo Laboral, Procedimiento de Reenganche y Pago de Salarios Caídos, etc., igualmente deberá realizar dicha solicitud dentro del lapso de tiempo establecido.
                    </p>
                </div>

                <!-- Acordeón para subsecciones -->
                <div class="accordion" id="accordionPerdidaEmpleo">
                    
                    <!-- Deberes -->
                    <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                        <h2 class="accordion-header" id="headingDeberes">
                            <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDeberes" aria-expanded="false" aria-controls="collapseDeberes" style="font-size: 1.15rem;">
                                Deberes para optar a la Prestación Dineraria
                            </button>
                        </h2>
                        <div id="collapseDeberes" class="accordion-collapse collapse" aria-labelledby="headingDeberes" data-bs-parent="#accordionPerdidaEmpleo" style="visibility: visible !important; opacity: 1 !important;">
                            <div class="accordion-body bg-light rounded-bottom-4" style="opacity: 1 !important; visibility: visible !important;">
                                <ul class="text-muted" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                    <li>Estar afiliado al Régimen Prestacional de Empleo, en el Instituto Venezolano de los Seguros Sociales.</li>
                                    <li>Que el trabajador(a) cesante haya generado un mínimo de 52 cotizaciones, dentro de los veinticuatro (24) meses inmediatos anteriores a la cesantía.</li>
                                    <li>Que la relación de trabajo haya terminado por cualquiera de las Causas de la Terminación de la Relación de Trabajo.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Requisitos -->
                    <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                        <h2 class="accordion-header" id="headingRequisitos">
                            <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRequisitos" aria-expanded="false" aria-controls="collapseRequisitos" style="font-size: 1.15rem;">
                                Requisitos para Solicitar la Prestación Dineraria
                            </button>
                        </h2>
                        <div id="collapseRequisitos" class="accordion-collapse collapse" aria-labelledby="headingRequisitos" data-bs-parent="#accordionPerdidaEmpleo" style="visibility: visible !important; opacity: 1 !important;">
                            <div class="accordion-body bg-light rounded-bottom-4" style="opacity: 1 !important; visibility: visible !important;">
                                <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                    <li>Cédula de Identidad laminada vigente hasta con un año de vencimiento o Pasaporte Original, si es nacionalizado, deberá consignar la Cédula de Identidad de extranjero y la Gaceta Oficial.</li>
                                    <li>Constancia de Egreso del Trabajador.</li>
                                    <li>Original y copia de la Carta de Notificación e Despido, según sea el caso con mebrete, dirección y teléfono de la empresa, número de RIF, sello húmedo firmada por el Patrono o Empleador y por el trabajador cesante como recibido.</li>
                                    <li>Original y una copia de la Liquidación de Prestaciones Sociales, con membrete, dirección y teléfono de la empresa, firmada y sellada por el Patrono o Empleador, y por el trabajador en señal de conformidad.</li>
                                    <li>Original de la Constancia de Registro del Centro de Encuentro para la Educación y Trabajo (Ministerio del Poder Popular para el Proceso Social de Trabajo) debidamente firmada y on sello húmedo emitida por las Agencias de Empleo a nivel nacional.</li>
                                </ul>

                                <h5 class="fw-bold text-dark mt-4" style="opacity: 1 !important;">En caso de miembros de Cooperativas, deben adicionalmente presentar:</h5>
                                <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                    <li>Original y una copia de Acta Constitutiva de la Cooperativa suscrita por sus fundadores con la lista de Asociados que la constituyen, debidamente registrada con firma y sello del servicio Autónomo de Registros y Notarias (SAREN).</li>
                                    <li>Original y Copia de la participación y manifiesto de adhesión como Asociado a la Cooperativa debidamente firmada y sellada.</li>
                                    <li>Original y Copia del Acta de la Asamblea donde conste la pérdida de la condición de Asociado de la Cooperativa, debe estar registrada con firma y sello del Servicio Autónomo de Registros y Notarias (SAREN).</li>
                                    <li>Original y Copia del Documento donde conste la extinción de la Cooperativa si es el caso. El mismo deber ser emitido por el Servicio Nacional Integrado de Administración Aduanera y Tributaria (SENIAT).</li>
                                </ul>

                                <h5 class="fw-bold text-dark mt-4" style="opacity: 1 !important;">En los casos de Demanda Laboral, deben adicionalmente presentar:</h5>
                                <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                    <li><strong>Por vía Administrativa (inspectoría del Trabajo):</strong> Copia del Acta de Reclamo impuesto ante la Inspectoría del Trabajo o Procuraduría Laboral, esta debe estar firmada y sellada por la Inspectoría del Trabajo que recibe la demanda y debe tener el número de expediente asignado.</li>
                                    <li><strong>Por Demanda Judicial (Tribunales Laborales):</strong> Copia del Libelo de la Demanda y Auto de Admisón del Tribunal, Finiquito o Sentencia la Demanda.</li>
                                </ul>

                                <h5 class="fw-bold text-dark mt-4" style="opacity: 1 !important;">En los casos de cobro de la Prestación Dineraria a través de Apoderados, los requisitos básicos a consignar son:</h5>
                                <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                    <li>Poder Notariado en original y copia.</li>
                                    <li>Copia de la Solicitud realizada por el beneficiario.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Dónde hacer la solicitud -->
                    <div class="accordion-item mb-3 border-0 shadow-sm rounded-4">
                        <h2 class="accordion-header" id="headingDonde">
                            <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDonde" aria-expanded="false" aria-controls="collapseDonde" style="font-size: 1.15rem;">
                                Dónde hacer la solicitud de Prestación Dineraria por Pérdida Involuntaria de Empleo
                            </button>
                        </h2>
                        <div id="collapseDonde" class="accordion-collapse collapse" aria-labelledby="headingDonde" data-bs-parent="#accordionPerdidaEmpleo" style="visibility: visible !important; opacity: 1 !important;">
                            <div class="accordion-body bg-light rounded-bottom-4" style="opacity: 1 !important; visibility: visible !important;">
                                <p class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                    La Solicitud podrá ser tramitada en cualquiera de los cuarenta y ocho (48) Departamentos de Atención al Trabajador Cesante a Nivel Nacional, ubicados en las <a href="http://ivss.gob.ve/contenido/Oficinas-administrativas" target="_blank" class="text-danger fw-bold text-decoration-none">Oficinas Administrativas</a> del Instituto Venezolano de los Seguros Sociales IVSS.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Causas y Bases Legales -->
                    <div class="accordion-item mb-3 border-0 shadow-sm rounded-4" id="causas">
                        <h2 class="accordion-header" id="headingCausas">
                            <button class="accordion-button collapsed fw-bold text-dark bg-white rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCausas" aria-expanded="false" aria-controls="collapseCausas" style="font-size: 1.15rem;">
                                Causas de la Terminación de la Relación de Trabajo y Bases Legales (que dan derecho al pago)
                            </button>
                        </h2>
                        <div id="collapseCausas" class="accordion-collapse collapse" aria-labelledby="headingCausas" data-bs-parent="#accordionPerdidaEmpleo" style="visibility: visible !important; opacity: 1 !important;">
                            <div class="accordion-body bg-light rounded-bottom-4" style="opacity: 1 !important; visibility: visible !important;">
                                <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">SECTOR PÚBLICO</h5>
                                <ul class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                    <li><strong>Retiro de Funcionarios de Libre Nombramiento y Remoción, Cargos “99”.</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 1, numeral 2 y Artículo 4, numeral 6.</li>
                                    <li><strong>Retiro de Funcionarios de Carrera por Reducción de Personal por motivos económicos o tecnológicos.</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 1, numeral 2; Artículo 4 numeral 6 y Artículo 32, numeral 3, literal A.</li>
                                    <li><strong>Retiro de Funcionarios por reestructuración o reorganización administrativa.</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 32, numeral 3, literal B y Artículo 4, numeral 6.</li>
                                    <li><strong>Terminación de Contrato de Trabajo a tiempo determinado o por una obra determinada.</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 32, numeral 3, literal C y Artículo 4, numeral 6.</li>
                                    <li><strong>Retiro de Funcionarios de Carrera por sustitución de empleadores (as), no aceptada por el trabajador (a).</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 32, numeral 3, literal D y Artículo 4, numeral 6.</li>
                                    <li><strong>Retiro de Funcionarios de Carrera por Cierre o Supresión del empleador (a).</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 32, numeral 3, literal E y Artículo 4, numeral 6.</li>
                                    <li><strong>Terminación de Contrato de Trabajo por Renuncia Justificada del Trabajador(a), antes de su finalización.</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 1, numeral 2, Artículo 4, numeral 6 y Artículo 32, numeral 3, literal A, en concordancia con la Ley Orgánica del Trabajo, Artículo 103.</li>
                                </ul>

                                <h5 class="fw-bold text-dark mb-3" style="opacity: 1 !important;">SECTOR PRIVADO</h5>
                                <ul class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.8; color: #6c757d !important; opacity: 1 !important;">
                                    <li><strong>Despido Injustificado de Trabajadores(as).</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 1, numeral 2, en concordancia con el Artículo 32, numeral 3, literal A.</li>
                                    <li><strong>Despido de Trabajadores por Reducción de Personal por motivos económicos o tecnológicos.</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 1, numeral 2 y Artículo 32, numeral 3, literal A.</li>
                                    <li><strong>Despido de Trabajadores por reestructuración o reorganización administrativa.</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 32, numeral 3, literal B.</li>
                                    <li><strong>Terminación de Contrato de Trabajo a tiempo determinado o por una obra determinada.</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 32, numeral 3, literal C.</li>
                                    <li><strong>Despido de Trabajadores por sustitución de empleadores (as), no aceptada por el trabajador (a).</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 32, numeral 3, literal D.</li>
                                    <li><strong>Despido de Trabajadores por Quiebra o Cierre de las actividades económicas del empleador (a).</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 32, numeral 3, literal E.</li>
                                    <li><strong>Terminación de Contrato de Trabajo por Renuncia Justificada del Trabajador (a), antes de su finalización.</strong><br>Ley del Régimen Prestacional de Empleo, Artículo 1, numeral 2 y Artículo 32, numeral 3, literal A, en concordancia con la Ley Orgánica del Trabajo, Artículo 103.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('inicio') }}" class="btn btn-outline-danger rounded-pill px-4 py-2 fw-bold">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
                    </a>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
