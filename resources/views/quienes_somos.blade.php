@extends('layouts.app-public')

@section('titulo', 'Quiénes Somos - IVSS')

@section('content')

<!-- HERO SECTION -->
<div class="position-relative overflow-hidden text-center bg-light" style="padding: 100px 0 60px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(220,53,69,0.9) 0%, rgba(139,0,0,0.95) 100%); z-index: 1;"></div>
    
    <!-- Imagen de fondo decorativa (opcional, si hay una disponible en el sistema) -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('img/fondo_sede.jpg') }}'); background-size: cover; background-position: center; opacity: 0.2; z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 100px; height: 100px;">
                    <img src="{{ asset('imagenes/ivss_logo_rojo.png') }}" alt="Logo IVSS" class="img-fluid p-2" onerror="this.src='https://via.placeholder.com/100?text=IVSS'">
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">¿Quiénes Somos?</h1>
                <p class="lead text-white-50 mb-0">Instituto Venezolano de los Seguros Sociales</p>
            </div>
        </div>
    </div>
    
    <!-- Curva inferior -->
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0; z-index: 2;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="display: block; width: calc(100% + 1.3px); height: 60px;">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" fill="#ffffff"></path>
        </svg>
    </div>
</div>

<!-- HISTORIA -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <div class="pe-lg-5">
                    <span class="text-danger fw-bold text-uppercase tracking-wide small mb-2 d-block"><i class="fas fa-landmark me-2"></i> Nuestro Origen</span>
                    <h2 class="fw-bold mb-4 text-dark">Historia del IVSS</h2>
                    <p class="text-muted text-justify mb-3">
                        El <strong>9 de octubre de 1944</strong>, se iniciaron las labores del Seguro Social, con la puesta en funcionamiento de los servicios para la cobertura de riesgos de enfermedades, maternidad, accidentes y patologías por accidentes, según lo establecido en el Reglamento General de la ley del Seguro Social Obligatorio, del 19 de febrero de 1944.
                    </p>
                    <p class="text-muted text-justify mb-3">
                        En 1946 se reformula esta Ley, dando origen a la creación del Instituto Venezolano de los Seguros Sociales, organismo con responsabilidad jurídica y patrimonio propio. Posteriormente, en 1966 se promulga la nueva Ley del Seguro Social totalmente reformada el año siguiente, ampliando los beneficios de asistencia médica integral y estableciendo las prestaciones a largo plazo (pensiones).
                    </p>
                    <p class="text-muted text-justify">
                        En la actualidad el Instituto Venezolano de los Seguros Sociales (I.V.S.S.), se encuentra en un proceso de adecuación de su estructura y sistemas a fines de atender las necesidades por la población trabajadora.
                    </p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative">
                    <!-- Decoración visual -->
                    <div class="bg-light p-5 text-center">
                        <i class="fas fa-history text-danger opacity-25" style="font-size: 8rem;"></i>
                        <h3 class="mt-4 fw-bold text-dark">1944</h3>
                        <p class="text-muted">Inicio de labores por la Seguridad Social</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MISIÓN, VISIÓN Y VALORES -->
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold text-dark">Nuestra Esencia</h2>
            <p class="text-muted">Principios que rigen nuestra labor diaria</p>
        </div>

        <div class="row g-4">
            <!-- Misión y Visión -->
            <div class="col-lg-6 d-flex flex-column gap-4">
                <div class="card border-0 shadow-sm rounded-4 h-100" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-bullseye fa-2x"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-0">Misión</h3>
                        </div>
                        <p class="text-muted mb-0" style="line-height: 1.8;">
                            El Instituto Venezolano de los Seguros Sociales es una institución pública, cuya razón de ser es brindar protección de la Seguridad Social a todos los beneficiarios en las contingencias de maternidad, vejez, sobrevivencia, enfermedad, accidentes, incapacidad, invalidez, nupcias, muerte, retiro y cesantía o paro forzoso, de manera oportuna y con calidad de excelencia en el servicio prestado, dentro del marco legal que lo regula.
                        </p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 h-100" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-eye fa-2x"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-0">Visión</h3>
                        </div>
                        <p class="text-muted mb-0" style="line-height: 1.8;">
                            El Instituto Venezolano de los Seguros Sociales, bajo la inspiración de la justicia social y de la equidad para toda la población, avanza hacia la conformación de la nueva estructura de la sociedad, garantizando el cumplimiento de los principios y normas de la Seguridad Social a todos los habitantes del país.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Valores -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: #ffffff;" data-aos="fade-left" data-aos-delay="300">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-gem fa-2x"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-0">Valores</h3>
                        </div>
                        <p class="text-muted mb-4">
                            Mantener un ambiente de armonía, colaboración y de gran calidad humana, incrementando así el espíritu de servicio, lealtad y solidaridad impulsando los siguientes valores:
                        </p>
                        
                        <ul class="list-unstyled mb-0 space-y-3">
                            <li class="d-flex mb-3">
                                <i class="fas fa-check-circle text-danger mt-1 me-3"></i>
                                <div><strong class="text-dark">RESPONSABILIDAD:</strong> <span class="text-muted">En nuestras acciones y trabajos encomendados para alcanzar los objetivos propuestos.</span></div>
                            </li>
                            <li class="d-flex mb-3">
                                <i class="fas fa-check-circle text-danger mt-1 me-3"></i>
                                <div><strong class="text-dark">RESPETO:</strong> <span class="text-muted">A nuestros compañeros de trabajo. Consideración y tolerancia.</span></div>
                            </li>
                            <li class="d-flex mb-3">
                                <i class="fas fa-check-circle text-danger mt-1 me-3"></i>
                                <div><strong class="text-dark">EXCELENCIA:</strong> <span class="text-muted">Para ser los mejores en todos los aspectos, con disposición hacia la mejora.</span></div>
                            </li>
                            <li class="d-flex mb-3">
                                <i class="fas fa-check-circle text-danger mt-1 me-3"></i>
                                <div><strong class="text-dark">LEALTAD:</strong> <span class="text-muted">Con la Institución.</span></div>
                            </li>
                            <li class="d-flex mb-3">
                                <i class="fas fa-check-circle text-danger mt-1 me-3"></i>
                                <div><strong class="text-dark">DISCIPLINA:</strong> <span class="text-muted">Para ser más eficientes en las actividades asignadas.</span></div>
                            </li>
                            <li class="d-flex mb-3">
                                <i class="fas fa-check-circle text-danger mt-1 me-3"></i>
                                <div><strong class="text-dark">ÉTICA:</strong> <span class="text-muted">Profesional en el servicio prestado a nuestra Institución.</span></div>
                            </li>
                            <li class="d-flex">
                                <i class="fas fa-check-circle text-danger mt-1 me-3"></i>
                                <div><strong class="text-dark">INTEGRIDAD:</strong> <span class="text-muted">Actuar con rectitud, honestidad, honradez y transparencia.</span></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- OBJETIVOS Y ATRIBUCIONES -->
<section class="py-5 bg-white">
    <div class="container py-4">
        
        <div class="row g-5">
            <!-- Objetivos -->
            <div class="col-lg-6" data-aos="fade-up">
                <h3 class="fw-bold text-dark mb-4 border-bottom border-danger pb-2 d-inline-block">Objetivos del IVSS</h3>
                
                <div class="d-flex flex-column gap-3">
                    <!-- General -->
                    <div class="p-4 bg-light rounded-4 shadow-sm border border-light">
                        <h5 class="fw-bold text-dark mb-3"><i class="fas fa-bullseye text-danger me-2"></i> Objetivo General</h5>
                        <ul class="text-muted mb-0 ps-3">
                            <li class="mb-2">Garantizar a la población económicamente activa y a los grupos más vulnerables la afiliación al Seguro Social.</li>
                            <li class="mb-2">Garantizar el otorgamiento de las prestaciones dinerarias a corto y largo plazo.</li>
                            <li>Garantizar atención médica integral a toda la población, contribuyendo al Sistema Público Nacional de Salud.</li>
                        </ul>
                    </div>
                    
                    <!-- Específicos -->
                    <div class="p-4 bg-light rounded-4 shadow-sm border border-light">
                        <h5 class="fw-bold text-dark mb-3"><i class="fas fa-list-ul text-danger me-2"></i> Objetivos Específicos</h5>
                        <ul class="text-muted mb-0 ps-3">
                            <li class="mb-2">Afiliar a Empleadores y Trabajadores al Seguro Social para alcanzar la justicia social.</li>
                            <li class="mb-2">Verificar el cumplimiento de los deberes formales y materiales.</li>
                            <li class="mb-2">Otorgar las prestaciones dinerarias para proteger a los asegurados en situaciones de vulnerabilidad.</li>
                            <li class="mb-2">Promover planes de Asistencia Médica Integral universal, solidaria y gratuita.</li>
                            <li>Aplicar tratamientos a pacientes con enfermedades crónicas y atención especializada.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Atribuciones -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <h3 class="fw-bold text-dark mb-4 border-bottom border-danger pb-2 d-inline-block">Atribuciones Principales</h3>
                
                <div class="p-4 bg-light rounded-4 shadow-sm h-100 border border-light">
                    <p class="text-muted text-justify mb-4">
                        El IVSS vela por la aplicación de las disposiciones legales y reglamentarias que rigen la materia de Seguridad Social en Venezuela.
                    </p>
                    <ul class="list-unstyled">
                        <li class="d-flex mb-3">
                            <i class="fas fa-caret-right text-danger mt-1 me-3"></i>
                            <span class="text-muted">Preparar estadísticas y realizar estudios para la aplicación progresiva del Seguro Social.</span>
                        </li>
                        <li class="d-flex mb-3">
                            <i class="fas fa-caret-right text-danger mt-1 me-3"></i>
                            <span class="text-muted">Recomendar reformas al Ejecutivo Nacional en los ramos pertinentes.</span>
                        </li>
                        <li class="d-flex mb-3">
                            <i class="fas fa-caret-right text-danger mt-1 me-3"></i>
                            <span class="text-muted">Organizar y poner en funcionamiento cajas regionales, sucursales y agencias.</span>
                        </li>
                        <li class="d-flex mb-3">
                            <i class="fas fa-caret-right text-danger mt-1 me-3"></i>
                            <span class="text-muted">Elaborar normas de control y fiscalización de los costos de operación médico-asistencial.</span>
                        </li>
                        <li class="d-flex">
                            <i class="fas fa-caret-right text-danger mt-1 me-3"></i>
                            <span class="text-muted">Ejercer el control del patrimonio de todos los ramos de los Seguros Sociales.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
    </div>
</section>

<!-- POLÍTICAS Y ESTRATEGIAS -->
<section class="py-5 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #343a40 0%, #1a1e21 100%);">
    <div class="container py-4 position-relative" style="z-index: 2;">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Políticas y Estrategias</h2>
            <p class="text-white-50">Orientados hacia la eficiencia y la consolidación de la Seguridad Social</p>
        </div>

        <div class="row g-4">
            <!-- Políticas -->
            <div class="col-md-6" data-aos="fade-right">
                <div class="bg-white bg-opacity-10 backdrop-blur rounded-4 p-4 p-md-5 h-100 border border-white border-opacity-25">
                    <h4 class="fw-bold text-danger mb-4"><i class="fas fa-flag me-2"></i> Políticas</h4>
                    <ul class="text-white-50 mb-0 ps-3" style="line-height: 1.8;">
                        <li class="mb-3">Optimizar los procesos de afiliación y recaudación para disminuir la exclusión al Sistema de Seguridad Social.</li>
                        <li class="mb-3">Modernizar los procesos para el otorgamiento de prestaciones dinerarias de forma oportuna.</li>
                        <li>Promover la atención médica integral priorizando el nivel de atención primaria para el bienestar colectivo.</li>
                    </ul>
                </div>
            </div>
            
            <!-- Estrategias -->
            <div class="col-md-6" data-aos="fade-left">
                <div class="bg-white bg-opacity-10 backdrop-blur rounded-4 p-4 p-md-5 h-100 border border-white border-opacity-25">
                    <h4 class="fw-bold text-danger mb-4"><i class="fas fa-chess-knight me-2"></i> Estrategias</h4>
                    <ul class="text-white-50 mb-0 ps-3" style="line-height: 1.8;">
                        <li class="mb-2">Impulsar la simplificación de trámites y uso de tecnologías de información.</li>
                        <li class="mb-2">Fomentar herramientas que optimicen el otorgamiento de prestaciones.</li>
                        <li class="mb-2">Desarrollar programas de Asistencia Médica Integral.</li>
                        <li class="mb-2">Optimizar el suministro oportuno de medicamentos de alto costo.</li>
                        <li class="mb-2">Adecuar y fortalecer el mantenimiento de las infraestructuras físicas.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
